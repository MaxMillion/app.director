Spine ?= require("spine")
$      = Spine.$

class GalleriesList extends Spine.Controller

  @extend Spine.Controller.Drag
  
  events:
    'click .item'   : 'click'
    'dblclick .item': 'dblclick'
  
  constructor: ->
    super
    Spine.bind('change:selectedGallery', @proxy @exposeSelection)

  change: ->
    console.log 'GalleryList::change'
    Spine.trigger('show:albums')
        
  render: (items) ->
    console.log 'GalleryList::render'
    @html @template items
    @el

  select: (item) =>
    Gallery.current(item)
    @exposeSelection(item)
    Spine.trigger('change:toolbar', 'Gallery')
    Spine.trigger('gallery:activate')
    
  exposeSelection: (item) ->
    console.log 'GalleryList::exposeSelection'
    @deselect()
    if item
      el = @children().forItem(item)
      el.addClass("active")
      Spine.trigger('gallery:exposeSelection', item)
      Spine.trigger('change:toolbar')
        
  click: (e) ->
    console.log 'GalleryList::click'
    item = $(e.currentTarget).item()
    @select item
    e.stopPropagation()
    e.preventDefault()
    false

  dblclick: (e) ->
    console.log 'GalleryList::dblclick'
    @change()
    e.stopPropagation()
    e.preventDefault()
    false

module?.exports = GalleriesList