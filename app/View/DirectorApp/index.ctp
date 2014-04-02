<div id="loader" class="view">
  <div class="dialogue-wrap">
    <div class="dialogue">
      <div class="dialogue-content">
        <div class="bg transparent" style="line-height: 0.5em; text-align: center; color: #E1EEF7">
          <div class="status-symbol" style="z-index: 2;">
            <img src="/img/ajax-loader.gif" style="">
          </div>
          <div class="status-text"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="main" class="view vbox flex">
  <header id="title" class="">
    <div class="left" style="position: relative;">
      <h1 class="" style="line-height: 3em;"><a style="font-size: 3em;" href="/"><span class="chopin">Photo Director</span></a></h1>
      <span style="position: absolute; top: 10px; right: 67px;"><a href="http://glyphicons.com/" target="_blank" class="glyphicon-brand" title="GLYPHICONS is a library of precisely prepared monochromatic icons and symbols, created with an emphasis on simplicity and easy orientation.">GLYPHICONS.com</a></span>
    </div>
    <div id="login" class="right" style="margin: 15px 5px;"></div>
  </header>
  <div id="wrapper" class="hbox flex">
    <div id="sidebar" class="views bg-medium hbox vdraggable">
      <div class="vbox sidebar canvas bg-dark flex inner" style="display: none">
        <div class="search">
          <form class="form-search">
            <input class="search-query" type="search" placeholder="Search" results="0" incremental="true">
          </form>
        </div>
        <div class="originals hbox">
          <ul class="opt-ions flex">
            <li id="" class="splitter flickr disabled"></li>
          </ul>
        </div>
        <ul class="items vbox flex autoflow"></ul>
        <footer class="footer">
          <button class="opt-Refresh dark left">
            <i class="glyphicon glyphicon-repeat" style="line-height: 1.5em;"></i>
            <span></span>
          </button>
          <button class="opt-CreateGallery dark">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Gallery</span>
          </button>
          <button class="opt-CreateAlbum dark">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Album</span>
          </button>
        </footer>
      </div>
      <div class="vdivide draghandle"></div>
    </div>
    <div id="content" class="views bg-medium vbox flex">
      <div tabindex="1" id="show" class="view canvas bg-dark vbox flex fade">
        <div id="modal-action " class="modal fade"></div>
        <div  tabindex="3" id="modal-addAlbum" class="modal fade"></div>
        <div  tabindex="3" id="modal-addPhoto" class="modal fade"></div>
        <ul class="options hbox">
          <ul class="toolbarOne hbox nav"></ul>
          <li class="splitter disabled flex"></li>
          <ul class="toolbarTwo hbox nav"></ul>
        </ul>
        <div class="contents views vbox flex" style="height: 0;">
          <div class="header views">
            <div class="galleries view"></div>
            <div class="albums view"></div>
            <div class="photos view"></div>
            <div class="photo view"></div>
            <div class="overview view"></div>
          </div>
          <div class="view galleries content vbox flex data parent autoflow" style="">
            <div class="items fadein">Galleries</div>
          </div>
          <div class="view albums content vbox flex data parent autoflow fadeelement" style="margin-top: -24px;">
            <div class="hoverinfo fade"></div>
            <div class="items flex fadein">Albums</div>
          </div>
          <div class="view photos content vbox flex data parent autoflow fadeelement" style="margin-top: -24px;">
            <div class="hoverinfo fade"></div>
            <div class="items flex fadein" data-toggle="modal-gallery" data-target="#modal-gallery" data-selector="a">Photos</div>
          </div>
          <div class="view photo content vbox flex data parent autoflow fadeelement" style="margin-top: -24px;">
            <div class="hoverinfo fade"></div>
            <div class="items flex fadein">Photo</div>
          </div>
          <div id="slideshow" class="view content flex data parent autoflow">
            <div class="items flex" data-toggle="blueimp-gallery" data-target="#blueimp-gallery" data-selector="a.thumbnail"></div>
          </div>
        </div>
        <div id="views" class="settings bg-light hbox autoflow bg-medium">
          <div class="views canvas content vbox flex autoflow hdraggable" style="position: relative">
            <div class="hdivide draghandle">
              <span class="opt opt-CloseDraghandle glyphicon glyphicon-remove glyphicon glyphicon-white right" style="cursor: pointer;"></span>
            </div>
            <div id="ga" class="view flex autoflow" style="">
              <div class="editGallery">You have no Galleries!</div>
            </div>
            <div id="al" class="view flex autoflow" style="">
              <div class="editAlbum">
                <div class="content">No Albums found!</div>
              </div>
            </div>
            <div id="ph" class="view flex autoflow" style="">
              <div class="editPhoto">
                <div class="content">No Photo found!</div>
              </div>
            </div>
            <div id="fu" class="view hbox flex bg-dark" style="margin: 0px">
              <!-- The file upload form used as target for the file upload widget -->
              <form id="fileupload" class="vbox flex" action="uploads/image" method="POST" enctype="multipart/form-data">
                  <!-- Redirect browsers with JavaScript disabled to the origin page -->
                  <noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
                  <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                  <div class="vbox flex">
                    <!-- The table listing the files available for upload/download -->
                    <div class="footer fileupload-buttonbar" style="">
                      <div class="span6 left" style="margin: 10px;">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn dark fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Add files...</span>
                                <input type="file" name="files[]" multiple>
                            </span>
                            <button type="submit" class="dark start">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Start upload</span>
                            </button>
                            <button type="reset" class="dark cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span>Cancel upload</span>
                            </button>
                            <button type="button" class="dark delete">
                                <i class="glyphicon glyphicon-remove"></i>
                                <span>Clear List</span>
                            </button>
                            <!-- The loading indicator is shown during file processing -->
                            <span class="fileupload-loading"></span>
                        </div>
                        <!-- The global progress information -->
                        <div class="span3 fileupload-progress fade left" style="width: 260px; margin: 14px;">
                            <!-- The global progress bar -->
                            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width:0%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="vbox flex autoflow" style="">
                      <table role="presentation" class="table"><tbody class="files"></tbody></table>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div tabindex="1" id="overview" class="view content vbox flex data parent fade">
        <div class="carousel-background bg-medium flex">
<!--          The data-ride="carousel" attribute is used to mark a carousel as animating starting at page load.-->
<!--          We can't use it here, since it must be triggered via the controller-->
          <div id="overview-carousel" class="carousel slide" data-ride="">
            
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#overview-carousel" data-slide-to="0"></li>
              <li data-target="#overview-carousel" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner"></div>
            <!-- Controls -->
            <a class="left carousel-control" href="#overview-carousel" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#overview-carousel" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
          </div>
          <div class="xxl" style="color: rgba(156, 156, 156, 0.99);">
            Overview
          </div>
        </div>
      </div>
      <div id="missing" class="canvas view vbox flex fade">
        <ul class="options hbox">
          <ul class="toolbar hbox"></ul>
        </ul>
        <div class="content vbox flex autoflow"></div>
      </div>
      <div id="flickr" class="canvas view vbox flex fade">
        <ul class="options hbox">
          <li class="splitter flex"></li>
          <ul class="toolbar hbox nav"></ul>
          <li class="splitter flex"></li>
        </ul>
        <div class="content links vbox flex autoflow"></div>
      </div>
      
    </div>
  </div>
</div>
<!-- blueimp-gallery -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
  <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<!-- modal-dialogue -->
<div id="modal-view" class="modal fade"></div>
<!-- /.modal -->

<!-- Templates -->
<script id="flickrTemplate" type="text/x-jquery-tmpl">
  <a href='http://farm${farm}.static.flickr.com/${server}/${id}_${secret}_b.jpg' title="${title}" data-gallery>
    <img src='http://farm${farm}.static.flickr.com/${server}/${id}_${secret}_s.jpg'>
  </a>
</script>

<script id="flickrIntroTemplate" type="text/x-jquery-tmpl">
  <div class="dark xxl">
    <i class="glyphicon glyphicon-picture"></i>
    <span class="cover-header">flickr</span>
    <div class=" btn-primary xs">
      <a class="label recent ">flickr recent</a>
      <a class="label inter">flickr interesting</a>
    </div>
  </div>
</script>

<script id="addTemplate" type="text/x-jquery-tmpl">
  <div class="modal-dialog ${type}" style="width: 55%;">
    <div class="bg-dark content modal-content">
      <div class="modal-header">
        <h4 class="modal-title">${title}</h4>
      </div>
      <div class="modal-body autoflow">
        <div class="items flex fadein in"></div>
      </div>
      <div class="modal-footer">
        {{tmpl() "#footerTemplate"}}
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</script>


<script id="footerTemplate" type="text/x-jquery-tmpl">
  <button type="button" class="opt-Selection dark left {{if !contains}}disabled{{/if}}">Invert Selection</button>
  <button type="button" class="opt-AddExecute dark {{if disabled}}disabled{{/if}}">Add</button>
  <button type="button" class="opt- dark" data-dismiss="modal">Cancel</button>
</script>

<script id="modalActionTemplate" type="text/x-jquery-tmpl">
  <form>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <ul class="pager">
          <li class="refresh previous {{if min}}disabled{{/if}}"><a href="#">Refresh List</a></li>
        </ul>
        <h4 class="modal-title">${text}</h4>
      </div>
      <div class="modal-body autoflow">
        <div class="row">
          <div class="col-md-6 galleries">
            <div class="list-group">
            {{tmpl($item.data.galleries()) "#modalActionColTemplate"}}
            </div>
          </div>
          <div class="col-md-6 albums">
            <div class="list-group">
            {{tmpl($item.data.albums()) "#modalActionColTemplate"}}
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="opt-CreateGallery btn-default">New Gallery</button>
        <button type="button" class="opt-CreateAlbum btn-default" {{if type == 'Gallery'}}disabled{{/if}}>New Album</button>
        <button type="button" class="btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="copy btn-default">Copy</button>
        <label class="hide">
        <input type="checkbox" class="remove">remove original items when done</label>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </form>
</script>

<script id="modalActionColTemplate" type="text/x-jquery-tmpl">
  {{tmpl($item.data.items) "#modalActionContentTemplate"}}
</script>

<script id="modalActionContentTemplate" type="text/x-jquery-tmpl">
  <a class="list-group-item item" id="${id}">{{if name}}${name}{{else}}${title}{{/if}}</a>
</script>

<script id="modalSimpleTemplate" type="text/x-jquery-tmpl">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>${header}</h3>
      </div>
      <div class="modal-body">
        <p>${body}</p>
      </div>
      {{if info}}
      <div class="modal-header label-info">
        <div class="label label-info">${info}</div>
      </div>
      {{/if}}
      <div class="modal-footer">
        <button class="btn btnClose">Ok</button>
      </div>
    </div>
  </div>
</script>

<script id="modal2ButtonTemplate" type="text/x-jquery-tmpl">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>${header}</h3>
      </div>
      <div class="modal-body content">
        <ul class="items">
          ${body}
        </ul>
      </div>
      {{if info}}
      <div class="modal-header">
        <div class="label label-warning">${info}</div>
      </div>
      {{/if}}
      <div class="modal-footer">
        <button class="btn btnOk" data-dismiss="modal" aria-hidden="true">${button_1_text}</button>
        <button type="button" class="btn btnAlt">${button_2_text}</button>
      </div>
    </div>
  </div>
</script>

<script id="sidebarTemplate" type="text/x-jquery-tmpl">
  <li class="gal item data parent">
    <div class="item-header">
      <div class="expander"></div>
      {{tmpl "#sidebarContentTemplate"}}
    </div>
    <hr>
    <ul class="sublist" style=""></ul>
  </li>
</script>

<script id="sidebarContentTemplate" type="text/x-jquery-tmpl">
  <div class="item-content">
    <span class="name">{{if name}}${name}{{else}}${title}{{/if}}</span>
    <span class="gal cta">{{tmpl($item.data.details()) "#galleryDetailsTemplate"}}</span>
  </div>
</script>

<script id="sidebarFlickrTemplate" type="text/x-jquery-tmpl">
  <li class="gal item parent" title="">
    <div class="item-header">
      <div class="expander"></div>
        <div class="item-content">
          <span class="" style="color: rgba(255,255,255, 1); text-shadow: 0 -1px 0 rgba(0,0,0,0.9); font-size: 1.5em;">${name}</span>
        </div>
    </div>
    <hr>
    <ul class="sublist" style="">
      {{tmpl($item.data.sub) "#sidebarFlickrSublistTemplate"}}
    </ul>
  </li>
</script>

<script id="sidebarFlickrSublistTemplate" type="text/x-jquery-tmpl">
  <li class="sublist-item item item-content ${klass}">
    <span class="glyphicon glyphicon-${icon}"></span>
    <span class="">${name}</span>
  </li>
</script>

<script id="overviewHeaderTemplate" type="text/x-jquery-tmpl">
</script>

<script id="galleryDetailsTemplate" type="text/x-jquery-tmpl">
    <span>${aCount} </span><span style="font-size: 0.6em;"> (${iCount})</span>
</script>

<script id="galleriesTemplate" type="text/x-jquery-tmpl">
  <li class="item container fade in">
    <div class="ui-symbol ui-symbol-gallery center"></div>
    <div class="thumbnail">
      <div class="inner">
        {{tmpl($item.data.details()) "#galDetailsTemplate"}}
      </div>
    </div>
    <div class="glyphicon-set fade out" style="">
      <span class="delete glyphicon glyphicon-trash glyphicon-white right"></span>
      <span class="back glyphicon glyphicon-chevron-up glyphicon-white right"></span>
      <span class="zoom glyphicon glyphicon-folder-close glyphicon-white right"></span>
    </div>
    <div class="title">{{if name}}{{html name.substring(0, 15)}}{{else}}...{{/if}}</div>
  </li>
</script>

<script id="modalGalleriesActionTemplate" type="text/x-jquery-tmpl">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>${header}</h3>
  </div>
  <div class="modal-body content">
    <div class="container item btn-group" data-toggle="buttons">
      {{tmpl($item.data.body) "#galleryActionTemplate"}}
    </div>
  </div>
  <div class="modal-footer">
    {{if info}}
    <div class="left label label-warning">${info}</div>
    {{/if}}
    <button class="btn btnOk" data-dismiss="modal" aria-hidden="true">OK</button>
    <button type="button" class="btn btnAlt">Save changes</button>
  </div>
</script>

<script id="galleryActionTemplate" type="text/x-jquery-tmpl">
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option1">${name}
  </label>
</script>

<script id="defaultActionTemplate" type="text/x-jquery-tmpl">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>${header}</h3>
  </div>
  <div class="modal-body content">
  {{if body}}
    {{html body}}
  {{/if}}
  </div>
  {{if info}}
  <div class="modal-header">
    <div class="label label-warning">${info}</div>
  </div>
  {{/if}}
  <div class="modal-footer">
    <button class="btn btnOk" data-dismiss="modal" aria-hidden="true">OK</button>
    <button type="button" class="btn btnAlt">Save changes</button>
  </div>
</script>

<script id="missingViewTemplate" type="text/x-jquery-tmpl">
  <div class="dark xxl">
    <i class="glyphicon glyphicon-question-sign"></i>
    <span class="cover-header">404</span><span>Not Found Error</span>
    <div class=" btn-primary xs">
      <a class="label relocate">Proceed to Overview (or use TAB for sidebar)</a>
    </div>
  </div>
</script>

<script id="galDetailsTemplate" type="text/x-jquery-tmpl">
  <div style="">Albums: ${aCount}</div>
  <div style="font-size: 0.8em; font-style: oblique; ">Images: ${iCount}</div>
  {{if sCount}}
  <div class="opt-SlideshowPlay" style="">
    <span class="label label-default">
    <i class="glyphicon glyphicon-picture"></i><i class="glyphicon glyphicon-play"></i>
    ${sCount}
    </span>
  </div>
  <div style="font-size: 0.8em; font-style: oblique; ">(press space to play)</div>
  {{/if}}
</script>

<script id="editGalleryTemplate" type="text/x-jquery-tmpl">
  <div class="editGallery">
    <div class="galleryEditor">
      <label>
        <span class="enlightened">Gallery - Name</span>
      </label>
      <br>
      <input class="name" data-toggle="tooltip" placeholder="gallery name" data-placement="right" data-trigger="manual" data-title="Press Enter to save" data-content="${name}" type="text" name="name" value="${name}">
      <br>
      <br>
      <label>
        <span class="enlightened">Description</span>
      </label>
      <br>
      <textarea name="description">${description}</textarea>
    </div>
  </div>
</script>

<script id="albumsTemplate" type="text/x-jquery-tmpl">
  <li class="item fade in" draggable="true">
    <div class="ui-symbol ui-symbol-album center"></div>
    <div class="thumbnail"></div>
    <div class="glyphicon-set fade out" style="">
      <span class="downloading glyphicon glyphicon-download-alt glyphicon-white hide left fade"></span>
      <span class="zoom glyphicon glyphicon-folder-close glyphicon-white left"></span>
      <span class="back glyphicon glyphicon-chevron-up glyphicon-white left"></span>
      <span class="glyphicon delete glyphicon glyphicon-trash glyphicon-white right"></span>
    </div>
    <div class="title center">{{if title}}{{html title.substring(0, 15)}}{{else}}...{{/if}}</div>
  </li>
</script>

<script id="editAlbumTemplate" type="text/x-jquery-tmpl">
  <label class="">
    <span class="enlightened">Album Title</span>
  </label>
  <br>
  <input placeholder="album title" type="text" name="title" value="${title}" {{if newRecord}}autofocus{{/if}}>
  <br>
  <br>
  <label class="">
    <span class="enlightened">Description</span>
  </label>
  <br>
  <textarea name="description">${description}</textarea>
</script>

<script id="albumSelectTemplate" type="text/x-jquery-tmpl">
  <option {{if ((constructor.record) && (constructor.record.id == id))}}selected{{/if}} value="${id}">${title}</option>
</script>

<script id="headerGalleryTemplate" type="text/x-jquery-tmpl">
  <section class="top viewheader fadeelement">
    <h2>Gallery Overview</h2><span class="active cta right"><h2>Total: ${count}</h2></span>
  </section>
</script>

<script id="headerAlbumTemplate" type="text/x-jquery-tmpl">
  <section class="top viewheader fadeelement">
    {{if record}}
    Author:   <span class="label label-default">${author}</span>
    <br><br>
    <h2>Albums in Gallery: </h2>
    <label class="h2 chopin">{{if record.name}}${record.name}{{else}}no name{{/if}}</label>
      <span class="active cta {{if record}}active{{/if}} right"><h2>Total: {{if count}}${count}{{else}}0{{/if}}</h2></span>
    {{else}}
    <h2 class="">Master Albums
      <span class="active cta {{if record}}active{{/if}} right"><h2>Total: {{if count}}${count}{{else}}0{{/if}}</h2></span>
    </h2>
    {{/if}}
  </section>
  <section class="left">
    <span class="fadeelement breadcrumb">
      <li class="gal">
        <a href="#">Galleries</a>
      </li>
      <li class="alb active">Albums</li>
    </span>
  </section>
</script>

<script id="albumDetailsTemplate" type="text/x-jquery-tmpl">
  <span class="cta">${iCount}</span>
</script>

<script id="albumsSublistTemplate" type="text/x-jquery-tmpl">
  {{if flash}}
  <span class="author">${flash}</span>
  {{else}}
  <li class="sublist-item alb item data" title="move (Hold Cmd-Key to Copy)">
    <span class="glyphicon glyphicon-folder-close ui-symbol-album"></span>
    <span class="title center">{{if title}}{{html title.substring(0, 45)}}{{else}}...{{/if}}</span>
    <span class="cta">{{if count}}${count}{{else}}0{{/if}}</span>
  </li>
  {{/if}}
</script>

<script id="albumInfoTemplate" type="text/x-jquery-tmpl">
  <ul>
    <li class="name">
      <span class="left">#${order} {{if title}}${title}{{else}}no title{{/if}} </span>
      <span class="right"> {{tmpl($item.data.details()) "#albumDetailsTemplate"}}</span>
    </li>
  </ul>
</script>

<script id="photosDetailsTemplate" type="text/x-jquery-tmpl">
  Author:  <span class="label label-default">${author}</span>
  Gallery:  <span class="label label-{{if gallery}}default{{else}}warning{{/if}}">{{if gallery}}{{if gallery.name}}${gallery.name}{{else}}no name{{/if}}{{else}}not found{{/if}}</span>
  <br><br>
  <h2>Photos in Album: </h2>
  <label class="h2 chopin">{{if album.title}}${album.title}{{else}}no title{{/if}}</label>
  <span class="active cta right">
    <h2>Total: {{if iCount}}${iCount}{{else}}0{{/if}}</h2>
  </span>
  
</script>

<script id="photoDetailsTemplate" type="text/x-jquery-tmpl">
  Author:  <span class="label label-default">{{if author}}${author}{{/if}}</span>
  Gallery:  <span class="label label-{{if gallery}}default{{else}}warning{{/if}}">{{if gallery}}{{if gallery.name}}${gallery.name}{{else}}no name{{/if}}{{else}}not found{{/if}}</span>
  Album:  <span class="label label-{{if album}}default{{else}}warning{{/if}}">{{if album}}{{if album.title}}${album.title}{{else}}no title{{/if}}{{else}}not found{{/if}}</span>
  <br><br>
  <h2>Photo:  </h2>
  <label class="h2 chopin">
    {{if photo}}
    {{if photo.title}}${photo.title}{{else}}{{if photo.src}}${photo.src}{{else}}no title{{/if}}{{/if}}
    {{else}}
    deleted
    {{/if}}
  </label>
</script>

<script id="editPhotoTemplate" type="text/x-jquery-tmpl">
  <label class="">
    <span class="enlightened">Photo Title</span>
  </label>
  <br>
  <input placeholder="${src}" type="text" name="title" value="{{if title}}${title}{{else}}{{if src}}${src}{{/if}}{{/if}}" >
  <br>
  <br>
  <label class="">
    <span class="enlightened">Description</span>
  </label>
  <br>
  <textarea name="description">${description}</textarea>
</script>

<script id="photosTemplate" type="text/x-jquery-tmpl">
  <li  class="item data fade in" draggable="true">
    {{tmpl "#photosThumbnailTemplate"}}
    <div class="title center hide">{{if title}}${title.substring(0, 15)}{{else}}{{if src}}${src.substring(0, 15)}{{else}}no title{{/if}}{{/if}}</div>
  </li>
</script>

<script id="photosSlideshowTemplate" type="text/x-jquery-tmpl">
  <li  class="item data fade in">
    <a class="thumbnail image left"></a>
  </li>
</script>

<script id="photoTemplate" type="text/x-jquery-tmpl">
  <li class="item">
    {{tmpl "#photoThumbnailTemplate"}}
  </li>
</script>

<script id="photosThumbnailTemplate" type="text/x-jquery-tmpl">
  <div class="thumbnail image left"></div>
  <div class="glyphicon glyphicon-set fade out" style="">
    <span class="delete glyphicon glyphicon-trash glyphicon-white right"></span>
    <span class="back glyphicon glyphicon-chevron-up glyphicon-white right"></span>
    <span class="zoom glyphicon glyphicon-resize-full glyphicon-white right"></span>
  </div>
</script>

<script id="photoThumbnailTemplate" type="text/x-jquery-tmpl">
  <div class="thumbnail image left"></div>
  <div class="glyphicon glyphicon-set fade out" style="">
    <span class="delete glyphicon glyphicon-trash glyphicon-white right"></span>
    <span class="back glyphicon glyphicon-chevron-up glyphicon-white right"></span>
    <span class="resize glyphicon glyphicon-resize-full glyphicon-white"></span>
  </div>
  <div class="title center hide">{{if title}}${title.substring(0, 15)}{{else}}{{if src}}${src.substring(0, 15)}{{else}}no title{{/if}}{{/if}}</div>
</script>

<script id="photoThumbnailSimpleTemplate" type="text/x-jquery-tmpl">
  <div class="opt- thumbnail image left"></div>
</script>

<script id="headerPhotosTemplate" type="text/x-jquery-tmpl">
  <section class="top viewheader fadeelement">
    {{if album}}
      {{tmpl($item.data.album.details()) "#photosDetailsTemplate"}}
    {{else}}
    <h2>Master Photos
      <span class="active cta right"><h2>Total: {{if count}}${count}{{else}}0{{/if}}</h2></span>
    </h2>
    {{/if}}
  </section>
  <section class="left">
    <span class="fadeelement breadcrumb">
      <li class="gal">
        <a href="#">Galleries</a>
      </li>
      <li class="alb">
        <a href="#">Albums</a>
      </li>
      <li class="pho active">Photos</li>
    </span>
  </section>
</script>

<script id="headerPhotoTemplate" type="text/x-jquery-tmpl">
  <section class="fadeelement top viewheader">
    {{if album}}
      {{tmpl($item.data.album.details()) "#photosDetailsTemplate"}}
    {{else}}
      <h2>Master Photo</h2>
    {{/if}}
  </section>
  <section class="left">
    <span class="fadeelement breadcrumb">
      <li class="gal">
        <a href="#">Galleries</a>
      </li>
      <li class="alb">
        <a href="#">Albums</a>
      </li>
      <li class="pho">
        <a href="#">Photos</a>
      </li>
      <li class="active">{{if $item.data.item.src}}${$item.data.item.src}{{else}}deleted{{/if}}</li>
    </span>
  </section>
</script>

<script id="preloaderTemplate" type="text/x-jquery-tmpl">
  <div class="preloader">
    <div class="content">
      <div></div
    </div>
  </div>
</script>

<script id="photoInfoTemplate" type="text/x-jquery-tmpl">
  <ul>
    <li class=""><span class="">{{if title}}{{html title}}{{else}}${src}{{/if}}</span></li>
    <li class="tr">{{if model}}<span class="td">Model</span><span class="td">:</span><span class="td">${model}</span>{{/if}}</li>
    <li class="tr">{{if software}}<span class="td">Software</span><span class="td">:</span><span class="td">${software}</span>{{/if}}</li>
    <li class="tr">{{if exposure}}<span class="td">Exposure</span><span class="td">:</span><span class="td">${exposure}</span>{{/if}}</li>
    <li class="tr">{{if iso}}<span class="td">Iso</span><span class="td">:</span><span class="td">${iso}</span>{{/if}}</li>
    <li class="tr">{{if aperture}}<span class="td">Aperture</span><span class="td">:</span><span class="td">${aperture}</span>{{/if}}</li>
    <li class="tr">{{if captured}}<span class="td">Captured</span><span class="td">:</span><span class="td">${captured}</span>{{/if}}</li>
  </ul>
</script>

<script id="toolsTemplate" type="text/x-jquery-tmpl">
  {{if dropdown}}
    {{tmpl(itemGroup)  "#dropdownTemplate"}}
  {{else}}
  <li class="${klass}"{{if outerstyle}} style="${outerstyle}"{{/if}}{{if id}} id="${id}"{{/if}}>
    <{{if type}}${type} class="{{if icon}}symbol{{/if}} tb-name {{if innerklass}}${innerklass}{{/if}}"{{else}}button class="symbol dark {{if innerklass}}${innerklass}{{/if}}" {{if dataToggle}} data-toggle="${dataToggle}"{{/if}}{{/if}}
    {{if innerstyle}} style="${innerstyle}"{{/if}}
    {{if disabled}}disabled{{/if}}>
    {{if icon}}<i class="glyphicon glyphicon-${icon}  {{if iconcolor}}glyphicon glyphicon-${iconcolor}{{/if}}"></i>{{/if}}{{html name}}
    </{{if type}}${type}{{else}}button{{/if}}>
  </li>
  {{/if}}
</script>

<script id="dropdownTemplate" type="text/x-jquery-tmpl">
  <li class="dropdown" {{if id}} id="${id}"{{/if}} >
    <a class="dropdown-toggle" data-toggle="dropdown">
      {{html name}}
      <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
      {{tmpl(content) "#dropdownListItemTemplate"}}
    </ul>
  </li>
</script>

<script id="dropdownListItemTemplate" type="text/x-jquery-tmpl">
  {{if devider}}
  <li class="divider"></li>
  {{else}}
  <li><a {{if dataToggle}} data-toggle="${dataToggle}"{{/if}} class="${klass} {{if disabled}}disabled{{/if}}"><i class="glyphicon glyphicon-{{if icon}}${icon} {{if iconcolor}}glyphicon glyphicon-${iconcolor}{{/if}}{{/if}}"></i>${name}</a></li>
  {{/if}}
</script>

<script id="testTemplate" type="text/x-jquery-tmpl">
  {{if eval}}{{tmpl($item.data.eval()) "#testTemplate"}}{{/if}}
</script>

<script id="noSelectionTemplate" type="text/x-jquery-tmpl">
  {{html type}}
</script>

<script id="loginTemplate" type="text/x-jquery-tmpl">
  <button data-active="active..." data-loading="loading..." data-complete="completed..." class="dark clear logout" title="Group ${groupname}">
    <i class="glyphicon glyphicon-log-out"></i>
    <span>Logout ${name}</span>
  </button>
</script>

<script id="overviewTemplate" type="text/x-jquery-tmpl">
  <div class="item active">
    <img src="img/overview-background.png" style="width: 800px; height: 370px;">
    <div class="recents carousel-item">
      {{tmpl($item.data.photos) "#overviewPhotosTemplate"}}
    </div>
    <div class="carousel-caption">
      <h3>Recents</h3>
      <p>Last uploaded images</p>
    </div>  
  </div>
  <div class="item summary">
    <img src="img/overview-background.png" style="width: 800px; height: 370px;">
    <div class="carousel-item">
      {{tmpl($item.data.summary) "#overviewSummaryTemplate"}}
    </div>
    <div class="carousel-caption">
      <h3>Summary</h3>
    </div> 
  </div>
</script>

<script id="overviewPhotosTemplate" type="text/x-jquery-tmpl">
  <div class="item">
    {{tmpl "#photoThumbnailSimpleTemplate"}}
  </div>
</script>

<script id="overviewSummaryTemplate" type="text/x-jquery-tmpl">
  <table class="carousel table center">
    <tbody>
      <tr>
        <td>Galleries</td>
        <td>Albums</td>
        <td>Photos</td>
      </tr>
      <tr class="h1">
        <td>${Gallery.records.length}</td>
        <td>${Album.records.length}</td>
        <td>${Photo.records.length}</td>
      </tr>
    </tbody>
  </table>
</script>

<script id="fileuploadTemplate" type="text/x-jquery-tmpl">
  <span style="font-size: 0.6em;" class=" alert alert-success">
    <span style="font-size: 2.9em; font-family: cursive; margin-right: 20px;" class="alert alert-error">"</span>
    {{if album}}{{if album.title}}${album.title}{{else}}...{{/if}}{{else}}all photos{{/if}}
    <span style="font-size: 5em; font-family: cursive;  margin-left: 20px;" class="alert alert-block uploadinfo"></span>
  </span>
</script>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <p class="size">{%=o.formatFileSize(file.size)%}</p>
            {% if (!o.files.error) { %}
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar" style="width:0%;"></div></div>
            {% } %}
        </td>
        <td>
            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                <button class="dark start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="dark cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade dark">
        <td>
            <button class="dark delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="glyphicon glyphicon-remove"></i>
                <span></span>
            </button>
        </td>
        <td>
            <span class="preview">
                {% if (file.thumbnail_url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" class="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" class="{%=file.thumbnail_url?'gallery':''%}" download="{%=file.name%}">{%=file.name%}</a>
            </p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
    </tr>
{% } %}
</script>


