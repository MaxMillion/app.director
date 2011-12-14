Spine ?= require("spine")
$      = Spine.$

class AlbumEditView extends Spine.Controller
  
  elements:
    '.content'    : 'item'
    '.editAlbum'  : 'editEl'

  events:
    "click"       : "click"
    'keydown'     : 'saveOnEnter'
  
  template: (item) ->
    $('#editAlbumTemplate').tmpl item

  constructor: ->
    super
    Spine.bind('change:selectedAlbum', @proxy @change)
    Spine.bind('change:selectedGallery', @proxy @change)

  change: (item, mode) ->
    console.log 'Album::change'
    if item?.constructor.className is 'Album'
      @current = item
    else
      firstID = Gallery.selectionList(Gallery.record.id)[0]
      if Album.exists(firstID)
        @current = Album.find(firstID)
      else
        @current = false
        
    @render @current, mode

  render: (item, mode) ->
    console.log 'AlbumView::render'
    selection = Gallery.selectionList()

    unless selection?.length
      @item.html $("#noSelectionTemplate").tmpl({type: '<label><span class="disabled">Select or create an album!</span></label>'})
    else if selection?.length > 1
      @item.html $("#noSelectionTemplate").tmpl({type: '<label><span class="disabled">Multiple selection</span></label>'})
    else unless item
      unless Gallery.count()
        @item.html $("#noSelectionTemplate").tmpl({type: '<label><span class="disabled">Create a gallery!</span></label>'})
      else
        @item.html $("#noSelectionTemplate").tmpl({type: '<label><span class="disabled">Select a gallery!</span></label>'})
    else
      @item.html @template item
    @el

  save: (el) ->
    console.log 'AlbumView::save'
    if @current
      atts = el.serializeForm?() or @editEl.serializeForm()
      @current.updateChangedAttributes(atts)
      Gallery.updateSelection [@current.id]
      Spine.trigger('expose:sublistSelection', Gallery.record)

  saveOnEnter: (e) =>
    return if(e.keyCode != 13)
    @save @editEl

  click: (e) ->
    console.log 'click'
    
    e.stopPropagation()
    e.preventDefault()
    false

module?.exports = AlbumEditView