Spine ?= require("spine")
$      = Spine.$

class SidebarList extends Spine.Controller

  @extend Spine.Controller.Drag
  @extend Spine.Controller.KeyEnhancer
  
  elements:
    '.gal.item'               : 'item'
    '.expander'               : 'expander'

  events:
    'click'                           : 'show'
    "click      .gal.item"            : "click",
    "dblclick   .gal.item"            : "dblclick"
    "click      .alb.item"            : "clickAlb",
    "click      .expander"            : "expand"
    'dragstart  .sublist-item'        : 'dragstart'
    'dragenter  .sublist-item'        : 'dragenter'
    'dragleave  .sublist-item'        : 'dragleave'
    'drop       .sublist-item'        : 'drop'
    'dragend    .sublist-item'        : 'dragend'

  selectFirst: false
    
  contentTemplate: (items) ->
    $('#sidebarContentTemplate').tmpl(items)
    
  sublistTemplate: (items) ->
    $('#albumsSublistTemplate').tmpl(items)
    
  ctaTemplate: (item) ->
    $('#ctaTemplate').tmpl(item)
    
  constructor: ->
    super
    AlbumsPhoto.bind('change', @proxy @renderItemFromAlbumsPhoto)
    GalleriesAlbum.bind('change', @proxy @renderItemFromGalleriesAlbum)
    Album.bind('change', @proxy @renderItemFromAlbum)
    Spine.bind('render:galleryAllSublist', @proxy @renderAllSublist)
    Spine.bind('drag:timeout', @proxy @expandAfterTimeout)
    Spine.bind('expose:sublistSelection', @proxy @exposeSublistSelection)
    Spine.bind('gallery:exposeSelection', @proxy @exposeSelection)
    Spine.bind('gallery:activate', @proxy @activate)
    
  template: -> arguments[0]

  change: (item, mode, e) =>
    console.log 'SidebarList::change'
    
    ctrlClick = @isCtrlClick(e) if e
    unless ctrlClick
      switch mode
        when 'destroy'
          @current = false
        when 'edit'
          Spine.trigger('edit:gallery')
        when 'show'
          @current = item
#          Spine.trigger('show:albums')
          @navigate '/gallery/' + Gallery.record?.id
        when 'photo'
          @current = item
        when 'create'
          @current = item
          
    else
      @current = false
      switch mode
        when 'show'
          @navigate '/gallery/' + Gallery.record?.id + '/' + Album.record?.id
#          Spine.trigger('show:albums')
          
    @activate(@current)
        
  render: (galleries, gallery, mode) ->
    console.log 'SidebarList::render'
    # render a specific (activated) item
    if gallery and mode
      @updateOne gallery, mode
      @reorder gallery
    else if galleries
      @updateAll galleries
      
    
    @change gallery, mode
    
    if (!@current or @current.destroyed) and !(mode is 'update')
      unless @children(".active").length
        App.ready = true
        @children(":first").click()
  
  reorder: (item) ->
    id = item.id
    index = (id, list) ->
      for itm, i in list
        return i if itm.id is id
      i
    
    children = @children()
    oldEl = @children().forItem(item)
    idxBeforeSort =  @children().index(oldEl)
    idxAfterSort = index(id, Gallery.all().sort(Gallery.nameSort))
    newEl = $(children[idxAfterSort])
    if idxBeforeSort < idxAfterSort
      newEl.after oldEl
    else if idxBeforeSort > idxAfterSort
      newEl.before oldEl
    
  updateOne: (item, mode) ->
    switch mode
      when 'update'
        @updateTemplate item
      when 'create'
        @append @template item
      when 'destroy'
        @children().forItem(item, true).remove()
  
  updateAll: (items) ->
    @html @template items.sort(Gallery.nameSort)

  renderAllSublist: ->
    for gal in Gallery.records
      @renderOneSublist gal
  
  renderOneSublist: (gallery = Gallery.record) ->
    console.log 'SidebarList::renderOneSublist'
    return unless gallery
    filterOptions =
      key:'gallery_id'
      joinTable: 'GalleriesAlbum'
      sorted: true
    albums = Album.filterRelated(gallery.id, filterOptions)
    for album in albums
      album.count = AlbumsPhoto.filter(album.id, key: 'album_id').length
    albums.push {flash: 'no albums'} unless albums.length
    
    galleryEl = @children().forItem(gallery)
    gallerySublist = $('ul', galleryEl)
    gallerySublist.html @sublistTemplate(albums)
    
    @updateTemplate gallery
  
  activate: (gallery = Gallery.record) ->
    
    Gallery.current(gallery)
    
#    selectedAlbums = Gallery.selectionList()
#    if selectedAlbums.length is 1
#      first = Album.find(selectedAlbums[0]) if Album.exists(selectedAlbums[0])
#      if first and !first.destroyed
#        Album.current(first)
#      else
#        Album.current()
#    else
#      Album.current()
#        
#    selectedPhotos = Album.selectionList()
#    if selectedPhotos.length is 1
#      active = Photo.find(selectedPhotos[0]) if Photo.exists(selectedPhotos[0])
#      if active and !active.destroyed
#        Photo.current(active)
#      else
#        Photo.current()
#    else
#      Photo.current()
      
    @exposeSelection()
  
  updateTemplate: (gallery) ->
    galleryEl = @children().forItem(gallery)
    galleryContentEl = $('.item-content', galleryEl)
    tmplItem = galleryContentEl.tmplItem()
    tmplItem.tmpl = $( "#sidebarContentTemplate" ).template()
    tmplItem.update()
    # restore active
    @exposeSublistSelection gallery
    
  renderItemFromGalleriesAlbum: (ga, mode) ->
    gallery = Gallery.find(ga.gallery_id) if Gallery.exists(ga.gallery_id)
    @renderOneSublist gallery
    
  renderItemFromAlbum: (album) ->
    gas = GalleriesAlbum.filter(album.id, key: 'album_id')
    for ga in gas
      @renderItemFromGalleriesAlbum ga
      
  renderItemFromAlbumsPhoto: (ap) ->
    gas = GalleriesAlbum.filter(ap.album_id, key: 'album_id')
    for ga in gas
      @renderItemFromGalleriesAlbum ga
  
  exposeSelection: (item = Gallery.record) ->
    console.log 'SidebarList::exposeSelection'
    @deselect()
    @children().forItem(item).addClass("active") if item
    @exposeSublistSelection()
        
  exposeSublistSelection: ->
    console.log 'SidebarList::exposeSublistSelection'
    removeAlbumSelection = =>
      galleries = []
      galleries.push val for item, val of Gallery.records
      for item in galleries
        galleryEl = @children().forItem(item)
        albums = galleryEl.find('li')
        albums.removeClass('selected').removeClass('active')
        
    if Gallery.record
      removeAlbumSelection()
      galleryEl = @children().forItem(Gallery.record)
      albums = galleryEl.find('li')
      for id in Gallery.selectionList()
        album = Album.find(id) if Album.exists(id)
        if album
          albums.forItem(album).addClass('selected')
          if id is Album.record?.id
            album = Album.find(Album.record.id)
            albums.forItem(album).addClass('active')
    else
      removeAlbumSelection()

  clickAlb: (e) ->
    console.log 'SidebarList::albclick'
    albumEl = $(e.currentTarget)
    galleryEl = $(e.currentTarget).closest('li.gal')
    
    album = albumEl.item()
    gallery = galleryEl.item()
    
    unless @isCtrlClick(e)
      @navigate '/gallery/' + gallery.id + '/' + album.id
#      Gallery.current(gallery)
#      Album.current(album)

#      if App.hmanager.hasActive()
#        @openPanel('album', App.showView.btnAlbum)
      
      Gallery.updateSelection [album.id]
      @exposeSublistSelection Gallery.record
#      Spine.trigger('show:photos')
#      @change Gallery.record, 'photo', e
    else
#      Spine.trigger('show:allPhotos', true)
      @navigate '/photos/'
    
    e.stopPropagation()
    e.preventDefault()
    
  click: (e) ->
    console.log 'SidebarList::click'
    item = $(e.target).item()
#    alert item.id
#    @change item, 'show', e
    
#    Spine.trigger('change:toolbar', ['Gallery'])
#    App.contentManager.change(App.showView)
    @navigate '/gallery/' + item.id
    
#    e.stopPropagation()
#    e.preventDefault()

  dblclick: (e) ->
    console.log 'SidebarList::dblclick'
    item = $(e.target).item()
    @change item, 'edit', e
    
    e.stopPropagation()
    e.preventDefault()

  expandAfterTimeout: (e) ->
    clearTimeout Spine.timer
    el = $(e.target)
    closest = (el.closest('.item')) or []
    if closest.length
      expander = $('.expander', closest)
      if expander.length
        @expand(e, true)

  close: () ->
    
    
  expand: (e, force = false) ->
    parent = $(e.target).parents('li')
    gallery = parent.item()
    icon = $('.expander', parent)
    content = $('.sublist', parent)

    if force
      icon.toggleClass('expand', force)
    else
      icon.toggleClass('expand')
      
    if $('.expand', parent).length
      @renderOneSublist gallery
      @exposeSublistSelection()
      content.show()
    else
      content.hide()

    e.stopPropagation()
    e.preventDefault()

  show: (e) ->
    App.contentManager.change App.showView
    e.stopPropagation()
    e.preventDefault()
    
module?.exports = SidebarList