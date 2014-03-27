Spine   = require("spine")
$       = Spine.$
Recent  = require('models/recent')
Photo   = require('models/photo')
KeyEnhancer = require("plugins/key_enhancer")

require("plugins/tmpl")

class OverviewView extends Spine.Controller

#  @extend KeyEnhancer

  elements:
    '#overview-carousel'         : 'carousel'
    '.carousel-inner'            : 'content'
    '.carousel-inner .recents'   : 'items'
    '.carousel-inner .summary'   : 'summary'
    
  events:
    'click .item'         : 'showPhoto'
    'keyup'               : 'keyup'

  template: (photos) ->
    $("#overviewTemplate").tmpl
      photos: photos
      summary:
        galleries: Gallery.all()
        albums: Album.all()
        photos: Photo.all()

  toolsTemplate: (items) ->
    $("#toolsTemplate").tmpl items
    
  constructor: ->
    super
    # carousel options
    @options =
      interval: 2000
    @el.data current: Recent
    @max = 18
    @bind('render:toolbar', @proxy @renderToolbar)
    Spine.bind('show:overview', @proxy @show)
    
  parse: (json) ->
    recents = []
    for item in json
      recents.push item['Photo']
    Recent.refresh(recents, {clear:true})
    @render Recent.all()
    
  render: (tests) ->
    #validate fresh records against existing model collection
    items = []
    for test in tests
      items.push photo if photo = Photo.exists(test.id)
      
    @content.html @template items
    @refreshElements()
    @carousel.carousel @options
    @carousel.carousel 0
    @uri items
    
  thumbSize: (width = 70, height = 70) ->
    width: width
    height: height
    
  uri: (items) ->
    try
      Photo.uri @thumbSize(),
        (xhr, records) => @callback(xhr, items),
        items
    catch e
      console.log e
      alert "New photos found. \n\nRestarting Application!"
      User.redirect 'director_app'
  
  callback: (json, items) =>
    console.log 'PhotoList::callback'
    searchJSON = (id) ->
      for itm in json
        return itm[id] if itm[id]
        
    for item in items
      photo = item
      jsn = searchJSON photo.id
      photoEl = @items.children().forItem(photo)
      console.log 
      img = new Image
      img.element = photoEl
      if jsn
        img.src = jsn.src
      else
        img.src = '/img/nophoto.png'
      img.onload = @imageLoad
        
  imageLoad: ->
    css = 'url(' + @src + ')'
    $('.thumbnail', @element).css
      'backgroundImage': css
      'backgroundPosition': 'center, center'
    
  loadRecent: ->
    Recent.loadRecent(@max, @proxy @parse)
    
  activated: ->
    @loadRecent()
    @el.focus()
    
  show: ->
    App.trigger('canvas', @)
    
  showPhoto: (e) ->
    item = $(e.currentTarget).item()
    return unless item
    photo = Photo.exists(item.id)
    
    if photo
      photo.emptySelection()
      @navigate '/gallery', '/', photo.id
      
    false
  
  error: (xhr, statusText, error) ->
    console.log xhr
    @record.trigger('ajaxError', xhr, statusText, error)
    
  keyup: (e) ->
    code = e.charCode or e.keyCode
    
    console.log 'OverviewView:keyupCode: ' + code
    
    switch code
      when 32 #Space
        paused = @carousel.data('bs.carousel').paused
        if paused
          @carousel.carousel('next')
          @carousel.carousel('cycle')
        else
          @carousel.carousel('pause')
        e.preventDefault()
      when 39 #Right
        @carousel.carousel('next')
        e.preventDefault()
      when 37 #Left
        @carousel.carousel('prev')
        e.preventDefault()

module?.exports = OverviewView