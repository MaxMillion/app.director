Spine = require("spine")
$     = Spine.$

require("plugins/tmpl")

class SidebarFlickr extends Spine.Controller

  elements:
    '.items'                : 'items'
    '.inner'                : 'inner'
    '.expander'             : 'expander'

  events:
    'click      .expander'        : 'expand'
    'click'                       : 'expand'
    'click      .optFlickrRecent' : 'navRecent'
    'click      .optFlickrInter'  : 'navInter'

  template: (items) ->
    $("#sidebarFlickrTemplate").tmpl(items)

  constructor: ->
    super
    @render()

  render: ->
    items = 
      name: 'Flickr'
      sub: [
        name: 'Recent Photos'
        klass: 'optFlickrRecent'
        icon: 'picture'
      ,
        name: 'Interesting Stuff'
        klass: 'optFlickrInter'
        icon: 'picture'
      ]
      
    @html @template(items)

  expand: (e) ->
    parent = $(e.target).parents('li')
    icon = $('.expander', parent)
    content = $('.sublist', parent)

    icon.toggleClass('open')
      
    if content.is(':visible') then content.hide() else content.show()

    e.stopPropagation()
    e.preventDefault()
    
  renderSublist: (gallery = Gallery.record) ->
    console.log 'SidebarList::renderOneSublist'
    return unless gallery
    filterOptions =
      key:'gallery_id'
      joinTable: 'GalleriesAlbum'
      sorted: true
    albums = Album.filterRelated(gallery.id, filterOptions)
    for album in albums
      album.count = AlbumsPhoto.filter(album.id, key: 'album_id').length
    albums.push {flash: ' '} unless albums.length
    
    galleryEl = @children().forItem(gallery)
    gallerySublist = $('ul', galleryEl)
    gallerySublist.html @sublistTemplate(albums)
    
    @updateTemplate gallery

  navRecent: (e) ->
    @navigate '/flickr', 'recent/1'
    
    e.stopPropagation()
    e.preventDefault()

  navInter: (e) ->
    @navigate '/flickr', 'inter/1'
    
    e.stopPropagation()
    e.preventDefault()

module?.exports = SidebarFlickr