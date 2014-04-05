Spine = require("spine")
$      = Spine.$
Controller = Spine.Controller

Controller.Drag =
  
  extended: ->
    
    Include =
      init: ->
        Spine.dragItem = null
        
      dragstart: (e, data) ->
        el = $(e.target)
        el.addClass('dragged')
        Spine.dragItem = {}
        Spine.dragItem.el = el
        Spine.dragItem.els = []
        Spine.dragItem.source = el.item()
        parentDataElement = $(e.target).closest('.parent.data')
        Spine.dragItem.origin = parentDataElement.data()?.tmplItem?.data or parentDataElement.data('current')?.model.record
        return unless Spine.dragItem.source #ignore other draggable nondata elements
        event = e.originalEvent
        event.dataTransfer?.effectAllowed = 'move'
        event.dataTransfer?.setData('text/html', Spine.dragItem);
        @trigger('drag:start', e, @)

      dragenter: (e, data) ->
        func =  => @trigger('drag:timeout', e, Spine.timer)
        clearTimeout Spine.timer
        Spine.timer = setTimeout(func, 1000)
        @trigger('drag:enter', e, @)
        
      dragover: (e, data) ->
        event = e.originalEvent
        event.stopPropagation()
        event.preventDefault()
        event.dataTransfer?.dropEffect = 'move'
        @trigger('drag:over', e, @)

      dragleave: (e, data) ->
        @trigger('drag:leave', e, @)

      dragend: (e, data) ->
        $(e.target).removeClass('dragged')
        @trigger('drag:end', e, @)

      drop: (e, data) ->
        clearTimeout Spine.timer
        event = e.originalEvent
        Spine.dragItem?.el.removeClass('dragged')
        @trigger('drag:drop', e, data)
        
    @include Include

module?.exports = Drag = Controller.Drag