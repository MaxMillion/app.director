Spine           = require("spine")
$               = Spine.$
Model           = Spine.Model
Controller      = Spine.Controller
Photo           = require('models/photo')
AlbumsPhoto     = require('models/albums_photo')
ModalSimpleView = require("controllers/modal_simple_view")

require('plugins/uri')
require("plugins/tmpl")
Extender = require("plugins/controller_extender")

class SlideshowView extends Spine.Controller
  
  @extend Extender
  
  elements:
    '.items'           : 'itemsEl'
    '.thumbnail'       : 'thumb'
    
  events:
    'click .item'      : 'click'
    'hidden.bs.modal'  : 'hiddenmodal'
    'click .back'      : 'back'
    
    'keydown'          : 'keydown'
    
  template: (items) ->
    $("#photosSlideshowTemplate").tmpl items

  constructor: ->
    super
    @el.data('current',
      model: Gallery
      models: Album
    )
    @images = []
    @viewport = @el
    @thumbSize = 240
    
    @modalSimpleView = new ModalSimpleView
      el: $('#modal-view')
    
    @links = $('.thumbnail', @el)
    @defaults =
      index             : 0
      startSlideshow    : true
      slideshowInterval : 2000
      displayClass: 'blueimp-gallery-display'
      onopened: @proxy @onopenedGallery
      onclose:  @proxy @oncloseGallery
      onclosed: @proxy @onclosedGallery
    
    @bind('play', @proxy @play)
    Spine.bind('show:slideshow', @proxy @show)
    Spine.bind('slider:change', @proxy @size)
    Spine.bind('chromeless', @proxy @chromeless)
    Spine.bind('loading:done', @proxy @loadingDone)
    
  show: (params) ->
    App.showView.trigger('change:toolbarOne', ['SlideshowPackage', App.showView.initSlider])
    App.showView.trigger('change:toolbarTwo', ['Close'])
    App.showView.trigger('canvas', @)
    
  activated: ->
    list = []
    if @images.length
      list.update @images
    else
      list.update Gallery.activePhotos()

    @render list
    
  render: (items) ->
    console.log 'SlideshowView::render'
    unless items.length
      @itemsEl.html '<label class="invite">
        <span class="enlightened">This slideshow does not have images &nbsp;
        <p>Note: Select an album that contains images</p>
        </span>
        <button class="back dark large"><i class="glyphicon glyphicon-chevron-up"></i><span>&nbsp;Back</span></button>
        </label>'
    else
      @itemsEl.html @template items
      @uri items
      @refreshElements()
      @size(App.showView.sliderOutValue())
    
    @el
    
  loadingDone: ->
    return unless @isActive()
    @show()
       
  params: (width = @parent.thumbSize, height = @parent.thumbSize) ->
    width: width
    height: height
  
  uri: (items) ->
    console.log 'SlideshowView::uri'
    Photo.uri @params(),
      (xhr, record) => @callback(items, xhr),
      items
    
  # we have the image-sources, now we can load the thumbnail-images
  callback: (items, json) ->
    console.log 'SlideshowView::callback'
    searchJSON = (id) ->
      for itm in json
        return itm[id] if itm[id]
    for item, index in items
      jsn = searchJSON item.id
      if jsn
        ele = @itemsEl.children().forItem(item)
        img = new Image
        img.onload = @imageLoad
        img.that = @
        img.element = ele
        img.index = index
        img.items = items
        img.src = jsn.src
        $(img).addClass('hide')
  
  imageLoad: ->
    css = 'url(' + @src + ')'
    $('.thumbnail', @element).css
      'backgroundImage': css
      'backgroundPosition': 'center, center'
      'backgroundSize': '100%'
    .append @
    if @index is @items.length-1
      @that.loadModal @items
      
  modalParams: ->
    width: 600
    height: 451
    square: 2
    force: false
    
  # loading data-href for original images size (modalParams)
  loadModal: (items, mode='html') ->
    Photo.uri @modalParams(),
      (xhr, record) => @callbackModal(xhr, items),
      items
  
  callbackModal: (json, items) ->
    console.log 'Slideshow::callbackModal'
    
    searchJSON = (id) ->
      for itm in json
        return itm[id] if itm[id]
        
    for item in items
      jsn = searchJSON item.id
      if jsn
        el = @itemsEl.children().forItem(item)
        thumb = $('.thumbnail', el)
        thumb.attr
          'href'   : jsn.src
          'title'       : item.title or item.src
          'data-gallery': 'gallery'
    @trigger('slideshow:ready')
      
  size: (val=@thumbSize, bg='none') ->
    # 2*10 = border radius
    @thumb.css
      'height'          : val+'px'
      'width'           : val+'px'
      'backgroundSize'  : bg
    
  # Toggle fullscreen mode:
  toggleFullScreen: (activate) ->
  
    root = document.documentElement
    
    if activate or !(isActive = @fullScreenEnabled())
      if(root.webkitRequestFullScreen)
        root.webkitRequestFullScreen(window.Element.ALLOW_KEYBOARD_INPUT)
      else if(root.mozRequestFullScreen)
        root.mozRequestFullScreen()
    else
      (document.webkitCancelFullScreen || document.mozCancelFullScreen || $.noop).apply(document)
    @fullScreenEnabled()
      
  fullScreenEnabled: ->
    !!(window.fullScreen)
    
  slideshowable: ->
    @photos().length
    
  hidemodal: (e) ->
    console.log 'hidemodal'
    
  hiddenmodal: (e) ->
    @oncloseGallery()
    
  showmodal: (e) ->
    @itemsEl.empty()
    
  notify: ->
    @modalSimpleView.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    @modalSimpleView.el.one('hide.bs.modal', @proxy @hidemodal)
    @modalSimpleView.el.one('show.bs.modal', @proxy @showmodal)
    
    @modalSimpleView.show
      header: 'Empty Slideshow'
      body: 'Select one or more albums in order to present its content.'
      
  click: (e) ->
    options =
      index         : @thumb.index($(e.target))
      startSlideshow: false
    @play(options)
    
    e.stopPropagation()
    e.preventDefault()
    
  play: (options={index:0}, list=[]) ->
    unless @isActive()
      @images.update list
      console.log @images
      @one('slideshow:ready', @proxy @playSlideshow)
      @previousHash = location.hash
      @navigate '/slideshow/'
    else
      @previousHash = location.hash
      @playSlideshow(options)
      
  playSlideshow: (options) ->
    return if @galleryIsActive()
    options = $().extend({}, @defaults, options)
    @gallery = blueimp.Gallery(@thumb, options)
    
  onopenedGallery: (e) ->
    
  onclosedGallery: (e) ->
    
  oncloseGallery: (e) ->
    if @previousHash
      location.hash = @previousHash
      delete @previousHash
    else
      @parent.back()
    
  onclosedGallery: (e) ->
    @images = []
    
  galleryIsActive: ->
    $('#blueimp-gallery').hasClass(@defaults.displayClass)
    
  back: (e) ->
    if ph = localStorage.previousHash and localStorage.previousHash isnt location.hash
      location.hash = localStorage.previousHash
      delete localStorage.previousHash
    else
      @navigate '/galleries/'
    
  keydown: (e) ->
    code = e.charCode or e.keyCode
    
    console.log 'SlideshowView:keydownCode: ' + code
    
    switch code
      when 27 #Esc
        @back(e)
        e.preventDefault()
  
module?.exports = SlideshowView