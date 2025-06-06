
/*!
 * Nestable Vanilla JavaScript

 */


// (function (window, document) {

var hasTouch = 'ontouchstart' in window;

if (navigator.appVersion.indexOf("Win") !== -1) {
  hasTouch = false;
} else {
  hasTouch = 'ontouchstart' in window;
}

var hasPointerEvents = (function () {
  var el = document.createElement('div'),
    docEl = document.documentElement;
  if (!('pointerEvents' in el.style)) {
    return false;
  }
  el.style.pointerEvents = 'auto';
  el.style.pointerEvents = 'x';
  docEl.appendChild(el);
  var supports = window.getComputedStyle && window.getComputedStyle(el, '').pointerEvents === 'auto';
  docEl.removeChild(el);
  return !!supports;
})();

var eStart = hasTouch ? 'touchstart' : 'mousedown',
  eMove = hasTouch ? 'touchmove' : 'mousemove',
  eEnd = hasTouch ? 'touchend' : 'mouseup',
  eCancel = hasTouch ? 'touchcancel' : 'mouseup';

var defaults = {
  listNodeName: 'ol',
  itemNodeName: 'li',
  rootClass: 'dd',
  listClass: 'dd-list',
  itemClass: 'dd-item',
  dragClass: 'dd-dragel',
  handleClass: 'dd-handle',
  collapsedClass: 'dd-collapsed',
  placeClass: 'dd-placeholder',
  noDragClass: 'dd-nodrag',
  emptyClass: 'dd-empty',
  expandBtnHTML: '<button data-action="expand" type="button">Expand</button>',
  collapseBtnHTML: '<button data-action="collapse" type="button">Collapse</button>',
  group: 0,
  maxDepth: 100,
  threshold: 20,
  dropCallback: null
};


function Plugin(element, options) {
  this.w = window;
  this.el = element;
  this.options = Object.assign({}, defaults, options);
  this.init();
}

Plugin.prototype = {
  init: function () {
    var list = this;

    list.reset();

    list.el.setAttribute('data-nestable-group', this.options.group);

    list.placeEl = document.createElement('div');
    list.placeEl.className = list.options.placeClass;

    Array.from(list.el.querySelectorAll(list.options.itemNodeName)).forEach(function (el) {
      list.setParent(el);
    });

    list.el.addEventListener('click', function (e) {
      if (list.dragEl || (!hasTouch && e.button !== 0)) {
        return;
      }
      var target = e.target.closest('button'),
        action = target ? target.getAttribute('data-action') : null,
        item = target ? target.parentElement.closest(list.options.itemNodeName) : null;
      if (action === 'collapse') {
        list.collapseItem(item);
      }
      if (action === 'expand') {
        list.expandItem(item);
      }
    });

    var onStartEvent = function (e) {
      var handle = e.target;
      if (!handle.classList.contains(list.options.handleClass)) {
        if (handle.closest('.' + list.options.noDragClass)) {
          return;
        }
        handle = handle.closest('.' + list.options.handleClass);
      }
      if (!handle || list.dragEl || (!hasTouch && e.button !== 0) || (hasTouch && e.touches.length !== 1)) {
        return;
      }
      e.preventDefault();
      list.dragStart(hasTouch ? e.touches[0] : e);
    };

    var onMoveEvent = function (e) {
      if (list.dragEl) {
        e.preventDefault();
        list.dragMove(hasTouch ? e.touches[0] : e);
      }
    };

    var onEndEvent = function (e) {
      if (list.dragEl) {
        e.preventDefault();
        list.dragStop(hasTouch ? e.touches[0] : e);
      }
    };

    if (hasTouch) {
      list.el.addEventListener(eStart, onStartEvent, false);
      window.addEventListener(eMove, onMoveEvent, false);
      window.addEventListener(eEnd, onEndEvent, false);
      window.addEventListener(eCancel, onEndEvent, false);
    } else {
      list.el.addEventListener(eStart, onStartEvent);
      list.w.addEventListener(eMove, onMoveEvent);
      list.w.addEventListener(eEnd, onEndEvent);
    }
  },

  serialize: function () {
    var data,
      depth = 0,
      list = this;

    step = function (level, depth) {
      var array = [];
      var items = level.querySelectorAll(':scope > ' + list.options.itemNodeName);
      items.forEach(function (el) {
        var li = el,
          item = Object.assign({}, li.dataset),
          sub = li.querySelector(list.options.listNodeName);
        if (sub) {
          item.children = step(sub, depth + 1);
        }
        array.push(item);
      });
      return array;
    };

    data = step(list.el.querySelector(list.options.listNodeName), depth);
    return data;
  },

  reset: function () {
    this.mouse = {
      offsetX: 0,
      offsetY: 0,
      startX: 0,
      startY: 0,
      lastX: 0,
      lastY: 0,
      nowX: 0,
      nowY: 0,
      distX: 0,
      distY: 0,
      dirAx: 0,
      dirX: 0,
      dirY: 0,
      lastDirX: 0,
      lastDirY: 0,
      distAxX: 0,
      distAxY: 0
    };
    this.moving = false;
    this.dragEl = null;
    this.dragRootEl = null;
    this.dragDepth = 0;
    this.hasNewRoot = false;
    this.pointEl = null;
    this.sourceRoot = null;
  },

  expandItem: function (el) {
    el.classList.remove(this.options.collapsedClass);

    var expandButtonSelector = el.querySelector('[data-action="expand"]');

    if (expandButtonSelector) {
      expandButtonSelector.style.display = 'none';
    }

    var collapseButtonSelector = el.querySelector('[data-action="collapse"]');

    if (collapseButtonSelector) {
      collapseButtonSelector.style.display = 'inline-block';
    }
    var nodeListSelector = el.querySelector(this.options.listNodeName);

    if (nodeListSelector) {
      nodeListSelector.style.display = 'block';
    }
  },

  collapseItem: function (el) {
    var lists = el.querySelectorAll(this.options.listNodeName);
    if (lists.length) {
      el.classList.add(this.options.collapsedClass);
      el.querySelector('[data-action="collapse"]').style.display = 'none';
      el.querySelector('[data-action="expand"]').style.display = 'inline-block';
      el.querySelector(this.options.listNodeName).style.display = 'none';
    }
  },

  expandAll: function () {
    var list = this;
    Array.from(list.el.querySelectorAll(list.options.itemNodeName)).forEach(function (el) {
      list.expandItem(el);
    });
  },

  collapseAll: function () {
    var list = this;
    Array.from(list.el.querySelectorAll(list.options.itemNodeName)).forEach(function (el) {
      list.collapseItem(el);
    });
  },

  setParent: function (el) {

    if (el.querySelector(this.options.listNodeName)) {
      el.insertAdjacentHTML('afterbegin', this.options.expandBtnHTML);
      el.insertAdjacentHTML('afterbegin', this.options.collapseBtnHTML);
    }

    var expandButton = el.querySelector('[data-action="expand"]');
    if (expandButton) {
      expandButton.style.display = 'none';
    }
  },

  unsetParent: function (el) {
    el.classList.remove(this.options.collapsedClass);
    el.querySelectorAll('[data-action]').forEach(function (action) {
      action.remove();
    });
    el.querySelectorAll(this.options.listNodeName).forEach(function (list) {
      list.remove();
    });
  },

  dragStart: function (e) {
    var mouse = this.mouse,
      target = e.target,
      dragItem = target.closest(this.options.itemNodeName);

    this.sourceRoot = target.closest('.' + this.options.rootClass);
    this.placeEl.style.height = dragItem.offsetHeight + 'px';

    mouse.offsetX = e.offsetX !== undefined ? e.offsetX : e.pageX - target.getBoundingClientRect().left;
    mouse.offsetY = e.offsetY !== undefined ? e.offsetY : e.pageY - target.getBoundingClientRect().top;
    mouse.startX = mouse.lastX = e.pageX;
    mouse.startY = mouse.lastY = e.pageY;

    this.dragRootEl = this.el;

    this.dragEl = document.createElement(this.options.listNodeName);
    this.dragEl.className = this.options.listClass + ' ' + this.options.dragClass;
    this.dragEl.style.width = dragItem.offsetWidth + 'px';

    dragItem.insertAdjacentElement('afterend', this.placeEl);
    dragItem.parentNode.removeChild(dragItem);
    this.dragEl.appendChild(dragItem);

    document.body.appendChild(this.dragEl);
    this.dragEl.style.left = e.pageX - mouse.offsetX + 'px';
    this.dragEl.style.top = e.pageY - mouse.offsetY + 'px';

    var i, depth,
      items = this.dragEl.querySelectorAll(this.options.itemNodeName);
    for (i = 0; i < items.length; i++) {
      depth = items[i].closest(this.options.listNodeName).length;
      if (depth > this.dragDepth) {
        this.dragDepth = depth;
      }
    }
  },

  dragStop: function (e) {
    var el = this.dragEl.querySelector(this.options.itemNodeName);
    el.parentNode.removeChild(el);
    this.placeEl.replaceWith(el);

    this.dragEl.remove();
    this.el.dispatchEvent(new Event('change'));

    var parentItem = el.parentElement.parentElement;
    var parentId = null;
    if (parentItem && !parentItem.classList.contains(this.options.rootClass)) {
      parentId = parentItem.dataset.id;
    }

    if (typeof this.options.dropCallback === 'function') {
      var details = {
        sourceId: el.dataset.id,
        destId: parentId,
        sourceEl: el,
        destParent: parentItem,
        destRoot: el.closest('.' + this.options.rootClass),
        sourceRoot: this.sourceRoot
      };
      this.options.dropCallback.call(this, details);
    }

    if (this.hasNewRoot) {
      this.dragRootEl.dispatchEvent(new Event('change'));
    }
    this.reset();
  },

  dragMove(e) {
    var list, parent, prev, next, depth,
      opt = this.options,
      mouse = this.mouse;

    this.dragEl.style.left = e.pageX - mouse.offsetX + 'px';
    this.dragEl.style.top = e.pageY - mouse.offsetY + 'px';

    // mouse position last events
    mouse.lastX = mouse.nowX;
    mouse.lastY = mouse.nowY;
    // mouse position this events
    mouse.nowX = e.pageX;
    mouse.nowY = e.pageY;
    // distance mouse moved between events
    mouse.distX = mouse.nowX - mouse.lastX;
    mouse.distY = mouse.nowY - mouse.lastY;
    // direction mouse was moving
    mouse.lastDirX = mouse.dirX;
    mouse.lastDirY = mouse.dirY;
    // direction mouse is now moving (on both axis)
    mouse.dirX = mouse.distX === 0 ? 0 : mouse.distX > 0 ? 1 : -1;
    mouse.dirY = mouse.distY === 0 ? 0 : mouse.distY > 0 ? 1 : -1;
    // axis mouse is now moving on
    var newAx = Math.abs(mouse.distX) > Math.abs(mouse.distY) ? 1 : 0;

    // do nothing on the first move
    if (!mouse.moving) {
      mouse.dirAx = newAx;
      mouse.moving = true;
      return;
    }

    // calc distance moved on this axis (and direction)
    if (mouse.dirAx !== newAx) {
      mouse.distAxX = 0;
      mouse.distAxY = 0;
    } else {
      mouse.distAxX += Math.abs(mouse.distX);
      if (mouse.dirX !== 0 && mouse.dirX !== mouse.lastDirX) {
        mouse.distAxX = 0;
      }
      mouse.distAxY += Math.abs(mouse.distY);
      if (mouse.dirY !== 0 && mouse.dirY !== mouse.lastDirY) {
        mouse.distAxY = 0;
      }
    }
    mouse.dirAx = newAx;

    /**
     * move horizontal
     */
    if (mouse.dirAx && mouse.distAxX >= opt.threshold) {
      // reset move distance on x-axis for a new phase
      mouse.distAxX = 0;
      prev = this.placeEl.previousElementSibling;
      // increase horizontal level if the previous sibling exists and is not collapsed
      if (mouse.distX > 0 && prev && !prev.classList.contains(opt.collapsedClass)) {
        // cannot increase the level when the item above is collapsed
        list = prev.querySelector(opt.listNodeName + ':last-child');
        // check if the depth limit has reached
        depth = this.placeEl.closest(opt.listNodeName).parentElement.querySelectorAll(opt.listNodeName).length;
        if (depth + this.dragDepth <= opt.maxDepth) {
          // create a new sub-level if one doesn't exist
          if (!list) {
            list = document.createElement(opt.listNodeName);
            list.classList.add(opt.listClass);
            list.appendChild(this.placeEl);
            prev.appendChild(list);
            this.setParent(prev);
          } else {
            // else append to the next level up
            list = prev.querySelector(opt.listNodeName + ':last-child');
            list.appendChild(this.placeEl);
          }
        }
      }
      // decrease horizontal level
      if (mouse.distX < 0) {
        // we can't decrease a level if an item precedes the current one
        next = this.placeEl.nextElementSibling;
        if (!next) {
          parent = this.placeEl.parentElement;
          this.placeEl.closest(opt.itemNodeName)?.after(this.placeEl);
          if (!parent.children.length) {
            this.unsetParent(parent.parentElement);
          }
        }
      }
    }

    var isEmpty = false;

    if (!hasPointerEvents) {
      // find the list item under the cursor
      this.dragEl.style.visibility = 'hidden';
    }

    this.pointEl = document.elementFromPoint(e.pageX - window.pageXOffset, e.pageY - window.pageYOffset);

    if (!hasPointerEvents) {
      this.dragEl.style.visibility = 'visible';
    }

    if (this.pointEl?.classList.contains(opt.handleClass)) {
      this.pointEl = this.pointEl.closest(opt.itemNodeName);
    }

    if (this.pointEl?.classList.contains(opt.emptyClass)) {
      isEmpty = true;
    } else if (!this.pointEl || !this.pointEl.classList.contains(opt.itemClass)) {
      return;
    }



    // find the parent list of the item under the cursor
    var pointElRoot = this.pointEl.closest('.' + opt.rootClass);
    var isNewRoot = this.dragRootEl.dataset.nestableId !== pointElRoot.dataset.nestableId;

    /**
     * move vertical
     */
    if (!mouse.dirAx || isNewRoot || isEmpty) {
      // check if groups match if dragging over a new root
      if (isNewRoot && opt.group !== pointElRoot.dataset.nestableGroup) {
        return;
      }
      // check depth limit
      depth = this.dragDepth - 1 + this.pointEl.closest(opt.listNodeName).parentElement.querySelectorAll(opt.listNodeName).length;
      if (depth > opt.maxDepth) {
        return;
      }

      //check if before or not
      var before = e.pageY < (getOffsetTop(this.pointEl) + this.pointEl.offsetHeight / 2);


      parent = this.placeEl.parentElement;
      // if empty, create a new list to replace the empty placeholder
      if (isEmpty) {
        list = document.createElement(opt.listNodeName);
        list.classList.add(opt.listClass);
        list.appendChild(this.placeEl);
        this.pointEl.replaceWith(list);
      } else if (before) {
        this.pointEl.before(this.placeEl);
      } else {
        this.pointEl.after(this.placeEl);
      }
      if (!parent.children.length) {
        this.unsetParent(parent.parentElement);
      }
      if (!this.dragRootEl.querySelectorAll(opt.itemNodeName).length) {
        this.dragRootEl.innerHTML += '<div class="' + opt.emptyClass + '"></div>';
      }
      // parent root list has changed
      if (isNewRoot) {
        this.dragRootEl = pointElRoot;
        this.hasNewRoot = this.el !== this.dragRootEl;
      }
    }
  }


};




function Nestable(element, params) {

  var lists = document.querySelectorAll(element);
  var retval = lists;

  lists.forEach(function (list) {
    var plugin = list.nestable;

    if (!plugin) {
      list.nestable = new Plugin(list, params);
      list.dataset.nestableId = new Date().getTime();
    } else {
      if (typeof params === 'string' && typeof plugin[params] === 'function') {
        retval = plugin[params]();
      }
    }
  });

  return retval || lists;
}


function getOffsetTop(element) {
  var offsetTop = 0;
  while (element) {
    offsetTop += element.offsetTop;
    element = element.offsetParent;
  }
  return offsetTop;
}


let nestableOutput = { result: '', message: '' };

function nestableWithData(nestableSelector = '#nestable', outputFunction = 'updateNestableOutput', expandCollapsedSelector = '#nestable-expand-collapse', initialLoad = false) {

  Nestable(nestableSelector, { group: 1 });


  document.querySelector(nestableSelector)?.addEventListener('change', function (e) {


    nestableOutput.result = Nestable(nestableSelector, 'serialize');

    // console.log(nestableOutput);
    // Check if the function exists
    if (typeof window[outputFunction] === 'function') {
      // Call the global function
      window[outputFunction](nestableOutput);
    } else {
      console.error('Function does not exist:', outputFunction);
    }

  });

  if (initialLoad) {

    document.querySelector(nestableSelector)?.dispatchEvent(new Event('change'));

  }

  document.querySelector(expandCollapsedSelector)?.addEventListener('click', function (e) {
    var target = e.target;

    var action = target.getAttribute('data-action');

    if (action === 'expand-all') {
      document.querySelectorAll('.dd').forEach(function (el) {
        el.nestable.expandAll();
      });
    }
    if (action === 'collapse-all') {
      document.querySelectorAll('.dd').forEach(function (el) {
        el.nestable.collapseAll();
      });
    }
  });

}





// })(window, document);

