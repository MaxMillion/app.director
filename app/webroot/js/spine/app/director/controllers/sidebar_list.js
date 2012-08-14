var $, SidebarList;
var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; }, __hasProp = Object.prototype.hasOwnProperty, __extends = function(child, parent) {
  for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; }
  function ctor() { this.constructor = child; }
  ctor.prototype = parent.prototype;
  child.prototype = new ctor;
  child.__super__ = parent.prototype;
  return child;
};
if (typeof Spine === "undefined" || Spine === null) {
  Spine = require("spine");
}
$ = Spine.$;
SidebarList = (function() {
  __extends(SidebarList, Spine.Controller);
  SidebarList.extend(Spine.Controller.Drag);
  SidebarList.extend(Spine.Controller.KeyEnhancer);
  SidebarList.prototype.elements = {
    '.gal.item': 'item',
    '.expander': 'expander'
  };
  SidebarList.prototype.events = {
    'click': 'show',
    "click      .gal.item": "click",
    "dblclick   .gal.item": "dblclick",
    "click      .alb.item": "clickAlb",
    "click      .expander": "expand",
    'dragstart  .sublist-item': 'dragstart',
    'dragenter  .sublist-item': 'dragenter',
    'dragleave  .sublist-item': 'dragleave',
    'drop       .sublist-item': 'drop',
    'dragend    .sublist-item': 'dragend'
  };
  SidebarList.prototype.selectFirst = false;
  SidebarList.prototype.contentTemplate = function(items) {
    return $('#sidebarContentTemplate').tmpl(items);
  };
  SidebarList.prototype.sublistTemplate = function(items) {
    return $('#albumsSublistTemplate').tmpl(items);
  };
  SidebarList.prototype.ctaTemplate = function(item) {
    return $('#ctaTemplate').tmpl(item);
  };
  function SidebarList() {
    this.change = __bind(this.change, this);    SidebarList.__super__.constructor.apply(this, arguments);
    AlbumsPhoto.bind('change', this.proxy(this.renderItemFromAlbumsPhoto));
    GalleriesAlbum.bind('change', this.proxy(this.renderItemFromGalleriesAlbum));
    Album.bind('change', this.proxy(this.renderItemFromAlbum));
    Spine.bind('render:galleryAllSublist', this.proxy(this.renderAllSublist));
    Spine.bind('drag:timeout', this.proxy(this.expandAfterTimeout));
    Spine.bind('expose:sublistSelection', this.proxy(this.exposeSublistSelection));
    Spine.bind('gallery:exposeSelection', this.proxy(this.exposeSelection));
    Spine.bind('gallery:activate', this.proxy(this.activate));
  }
  SidebarList.prototype.template = function() {
    return arguments[0];
  };
  SidebarList.prototype.change = function(item, mode, e) {
    var ctrlClick, _ref, _ref2, _ref3;
    console.log('SidebarList::change');
    if (e) {
      ctrlClick = this.isCtrlClick(e);
    }
    if (!ctrlClick) {
      switch (mode) {
        case 'destroy':
          this.current = false;
          break;
        case 'edit':
          Spine.trigger('edit:gallery');
          break;
        case 'show':
          this.current = item;
          this.navigate('/gallery/' + ((_ref = Gallery.record) != null ? _ref.id : void 0));
          break;
        case 'photo':
          this.current = item;
          break;
        case 'create':
          this.current = item;
      }
    } else {
      this.current = false;
      switch (mode) {
        case 'show':
          this.navigate('/gallery/' + ((_ref2 = Gallery.record) != null ? _ref2.id : void 0) + '/' + ((_ref3 = Album.record) != null ? _ref3.id : void 0));
      }
    }
    return this.activate(this.current);
  };
  SidebarList.prototype.render = function(galleries, gallery, mode) {
    console.log('SidebarList::render');
    if (gallery && mode) {
      this.updateOne(gallery, mode);
      this.reorder(gallery);
    } else if (galleries) {
      this.updateAll(galleries);
    }
    this.change(gallery, mode);
    if ((!this.current || this.current.destroyed) && !(mode === 'update')) {
      if (!this.children(".active").length) {
        App.ready = true;
        return this.children(":first").click();
      }
    }
  };
  SidebarList.prototype.reorder = function(item) {
    var children, id, idxAfterSort, idxBeforeSort, index, newEl, oldEl;
    id = item.id;
    index = function(id, list) {
      var i, itm, _len;
      for (i = 0, _len = list.length; i < _len; i++) {
        itm = list[i];
        if (itm.id === id) {
          return i;
        }
      }
      return i;
    };
    children = this.children();
    oldEl = this.children().forItem(item);
    idxBeforeSort = this.children().index(oldEl);
    idxAfterSort = index(id, Gallery.all().sort(Gallery.nameSort));
    newEl = $(children[idxAfterSort]);
    if (idxBeforeSort < idxAfterSort) {
      return newEl.after(oldEl);
    } else if (idxBeforeSort > idxAfterSort) {
      return newEl.before(oldEl);
    }
  };
  SidebarList.prototype.updateOne = function(item, mode) {
    switch (mode) {
      case 'update':
        return this.updateTemplate(item);
      case 'create':
        return this.append(this.template(item));
      case 'destroy':
        return this.children().forItem(item, true).remove();
    }
  };
  SidebarList.prototype.updateAll = function(items) {
    return this.html(this.template(items.sort(Gallery.nameSort)));
  };
  SidebarList.prototype.renderAllSublist = function() {
    var gal, _i, _len, _ref, _results;
    _ref = Gallery.records;
    _results = [];
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      gal = _ref[_i];
      _results.push(this.renderOneSublist(gal));
    }
    return _results;
  };
  SidebarList.prototype.renderOneSublist = function(gallery) {
    var album, albums, filterOptions, galleryEl, gallerySublist, _i, _len;
    if (gallery == null) {
      gallery = Gallery.record;
    }
    console.log('SidebarList::renderOneSublist');
    if (!gallery) {
      return;
    }
    filterOptions = {
      key: 'gallery_id',
      joinTable: 'GalleriesAlbum',
      sorted: true
    };
    albums = Album.filterRelated(gallery.id, filterOptions);
    for (_i = 0, _len = albums.length; _i < _len; _i++) {
      album = albums[_i];
      album.count = AlbumsPhoto.filter(album.id, {
        key: 'album_id'
      }).length;
    }
    if (!albums.length) {
      albums.push({
        flash: 'no albums'
      });
    }
    galleryEl = this.children().forItem(gallery);
    gallerySublist = $('ul', galleryEl);
    gallerySublist.html(this.sublistTemplate(albums));
    return this.updateTemplate(gallery);
  };
  SidebarList.prototype.activate = function(gallery) {
    if (gallery == null) {
      gallery = Gallery.record;
    }
    Gallery.current(gallery);
    return this.exposeSelection();
  };
  SidebarList.prototype.updateTemplate = function(gallery) {
    var galleryContentEl, galleryEl, tmplItem;
    galleryEl = this.children().forItem(gallery);
    galleryContentEl = $('.item-content', galleryEl);
    tmplItem = galleryContentEl.tmplItem();
    tmplItem.tmpl = $("#sidebarContentTemplate").template();
    tmplItem.update();
    return this.exposeSublistSelection(gallery);
  };
  SidebarList.prototype.renderItemFromGalleriesAlbum = function(ga, mode) {
    var gallery;
    if (Gallery.exists(ga.gallery_id)) {
      gallery = Gallery.find(ga.gallery_id);
    }
    return this.renderOneSublist(gallery);
  };
  SidebarList.prototype.renderItemFromAlbum = function(album) {
    var ga, gas, _i, _len, _results;
    gas = GalleriesAlbum.filter(album.id, {
      key: 'album_id'
    });
    _results = [];
    for (_i = 0, _len = gas.length; _i < _len; _i++) {
      ga = gas[_i];
      _results.push(this.renderItemFromGalleriesAlbum(ga));
    }
    return _results;
  };
  SidebarList.prototype.renderItemFromAlbumsPhoto = function(ap) {
    var ga, gas, _i, _len, _results;
    gas = GalleriesAlbum.filter(ap.album_id, {
      key: 'album_id'
    });
    _results = [];
    for (_i = 0, _len = gas.length; _i < _len; _i++) {
      ga = gas[_i];
      _results.push(this.renderItemFromGalleriesAlbum(ga));
    }
    return _results;
  };
  SidebarList.prototype.exposeSelection = function(item) {
    if (item == null) {
      item = Gallery.record;
    }
    console.log('SidebarList::exposeSelection');
    this.deselect();
    if (item) {
      this.children().forItem(item).addClass("active");
    }
    return this.exposeSublistSelection();
  };
  SidebarList.prototype.exposeSublistSelection = function() {
    var album, albums, galleryEl, id, removeAlbumSelection, _i, _len, _ref, _ref2, _results;
    console.log('SidebarList::exposeSublistSelection');
    removeAlbumSelection = __bind(function() {
      var albums, galleries, galleryEl, item, val, _i, _len, _ref, _results;
      galleries = [];
      _ref = Gallery.records;
      for (item in _ref) {
        val = _ref[item];
        galleries.push(val);
      }
      _results = [];
      for (_i = 0, _len = galleries.length; _i < _len; _i++) {
        item = galleries[_i];
        galleryEl = this.children().forItem(item);
        albums = galleryEl.find('li');
        _results.push(albums.removeClass('selected').removeClass('active'));
      }
      return _results;
    }, this);
    if (Gallery.record) {
      removeAlbumSelection();
      galleryEl = this.children().forItem(Gallery.record);
      albums = galleryEl.find('li');
      _ref = Gallery.selectionList();
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        id = _ref[_i];
        if (Album.exists(id)) {
          album = Album.find(id);
        }
        _results.push(album ? (albums.forItem(album).addClass('selected'), id === ((_ref2 = Album.record) != null ? _ref2.id : void 0) ? (album = Album.find(Album.record.id), albums.forItem(album).addClass('active')) : void 0) : void 0);
      }
      return _results;
    } else {
      return removeAlbumSelection();
    }
  };
  SidebarList.prototype.clickAlb = function(e) {
    var album, albumEl, gallery, galleryEl;
    console.log('SidebarList::albclick');
    albumEl = $(e.currentTarget);
    galleryEl = $(e.currentTarget).closest('li.gal');
    album = albumEl.item();
    gallery = galleryEl.item();
    if (!this.isCtrlClick(e)) {
      this.navigate('/gallery/' + gallery.id + '/' + album.id);
      Gallery.updateSelection([album.id]);
      this.exposeSublistSelection(Gallery.record);
    } else {
      this.navigate('/photos/');
    }
    e.stopPropagation();
    return e.preventDefault();
  };
  SidebarList.prototype.click = function(e) {
    var item;
    console.log('SidebarList::click');
    item = $(e.target).item();
    return this.navigate('/gallery/' + item.id);
  };
  SidebarList.prototype.dblclick = function(e) {
    var item;
    console.log('SidebarList::dblclick');
    item = $(e.target).item();
    this.change(item, 'edit', e);
    e.stopPropagation();
    return e.preventDefault();
  };
  SidebarList.prototype.expandAfterTimeout = function(e) {
    var closest, el, expander;
    clearTimeout(Spine.timer);
    el = $(e.target);
    closest = (el.closest('.item')) || [];
    if (closest.length) {
      expander = $('.expander', closest);
      if (expander.length) {
        return this.expand(e, true);
      }
    }
  };
  SidebarList.prototype.close = function() {};
  SidebarList.prototype.expand = function(e, force) {
    var content, gallery, icon, parent;
    if (force == null) {
      force = false;
    }
    parent = $(e.target).parents('li');
    gallery = parent.item();
    icon = $('.expander', parent);
    content = $('.sublist', parent);
    if (force) {
      icon.toggleClass('expand', force);
    } else {
      icon.toggleClass('expand');
    }
    if ($('.expand', parent).length) {
      this.renderOneSublist(gallery);
      this.exposeSublistSelection();
      content.show();
    } else {
      content.hide();
    }
    e.stopPropagation();
    return e.preventDefault();
  };
  SidebarList.prototype.show = function(e) {
    App.contentManager.change(App.showView);
    e.stopPropagation();
    return e.preventDefault();
  };
  return SidebarList;
})();
if (typeof module !== "undefined" && module !== null) {
  module.exports = SidebarList;
}
