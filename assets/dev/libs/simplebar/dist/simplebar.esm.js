/**
 * SimpleBar.js - v3.0.0-beta.4
 * Scrollbars, simpler.
 * https://grsmto.github.io/simplebar/
 * 
 * Made by Adrien Denat from a fork by Jonathan Nicol
 * Under MIT License
 */

import 'core-js/modules/es6.regexp.replace';
import 'core-js/modules/es6.function.name';
import 'core-js/modules/es6.regexp.match';
import 'core-js/modules/web.dom.iterable';
import 'core-js/modules/es6.string.iterator';
import 'core-js/modules/es6.array.from';
import 'core-js/modules/es6.object.assign';
import scrollbarWidth from 'scrollbarwidth';
import throttle from 'lodash.throttle';
import ResizeObserver from 'resize-observer-polyfill';
import canUseDOM from 'can-use-dom';

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

var SimpleBar =
/*#__PURE__*/
function () {
  function SimpleBar(element, options) {
    var _this = this;

    _classCallCheck(this, SimpleBar);

    this.onScrollX = function () {
      if (!_this.scrollXTicking) {
        window.requestAnimationFrame(_this.scrollX);
        _this.scrollXTicking = true;
      }
    };

    this.onScrollY = function () {
      if (!_this.scrollYTicking) {
        window.requestAnimationFrame(_this.scrollY);
        _this.scrollYTicking = true;
      }
    };

    this.scrollX = function () {
      _this.showScrollbar('x');

      _this.positionScrollbar('x');

      _this.scrollXTicking = false;
    };

    this.scrollY = function () {
      _this.showScrollbar('y');

      _this.positionScrollbar('y');

      _this.scrollYTicking = false;
    };

    this.onMouseEnter = function () {
      _this.showScrollbar('x');

      _this.showScrollbar('y');
    };

    this.onMouseMove = function (e) {
      var bboxY = _this.trackY.getBoundingClientRect();

      var bboxX = _this.trackX.getBoundingClientRect();

      _this.mouseX = e.clientX;
      _this.mouseY = e.clientY;

      if (_this.isWithinBounds(bboxY)) {
        _this.showScrollbar('y');
      }

      if (_this.isWithinBounds(bboxX)) {
        _this.showScrollbar('x');
      }
    };

    this.onWindowResize = function () {
      _this.hideNativeScrollbar();
    };

    this.hideScrollbars = function () {
      var bboxY = _this.trackY.getBoundingClientRect();

      var bboxX = _this.trackX.getBoundingClientRect();

      if (!_this.isWithinBounds(bboxY)) {
        _this.scrollbarY.classList.remove('visible');

        _this.isVisible.y = false;
      }

      if (!_this.isWithinBounds(bboxX)) {
        _this.scrollbarX.classList.remove('visible');

        _this.isVisible.x = false;
      }
    };

    this.onMouseDown = function (e) {
      var bboxY = _this.scrollbarY.getBoundingClientRect();

      var bboxX = _this.scrollbarX.getBoundingClientRect();

      if (_this.isWithinBounds(bboxY)) {
        e.preventDefault();

        _this.onDrag(e, 'y');
      }

      if (_this.isWithinBounds(bboxX)) {
        e.preventDefault();

        _this.onDrag(e, 'x');
      }
    };

    this.drag = function (e) {
      var eventOffset, track, scrollEl;
      e.preventDefault();

      if (_this.currentAxis === 'y') {
        eventOffset = e.pageY;
        track = _this.trackY;
        scrollEl = _this.scrollContentEl;
      } else {
        eventOffset = e.pageX;
        track = _this.trackX;
        scrollEl = _this.contentEl;
      } // Calculate how far the user's mouse is from the top/left of the scrollbar (minus the dragOffset).


      var dragPos = eventOffset - track.getBoundingClientRect()[_this.offsetAttr[_this.currentAxis]] - _this.dragOffset[_this.currentAxis]; // Convert the mouse position into a percentage of the scrollbar height/width.


      var dragPerc = dragPos / track[_this.sizeAttr[_this.currentAxis]]; // Scroll the content by the same percentage.

      var scrollPos = dragPerc * _this.contentEl[_this.scrollSizeAttr[_this.currentAxis]];
      scrollEl[_this.scrollOffsetAttr[_this.currentAxis]] = scrollPos;
    };

    this.onEndDrag = function () {
      document.removeEventListener('mousemove', _this.drag);
      document.removeEventListener('mouseup', _this.onEndDrag);
    };

    this.el = element;
    this.flashTimeout;
    this.contentEl;
    this.scrollContentEl;
    this.dragOffset = {
      x: 0,
      y: 0
    };
    this.isEnabled = {
      x: true,
      y: true
    };
    this.isVisible = {
      x: false,
      y: false
    };
    this.scrollOffsetAttr = {
      x: 'scrollLeft',
      y: 'scrollTop'
    };
    this.sizeAttr = {
      x: 'offsetWidth',
      y: 'offsetHeight'
    };
    this.scrollSizeAttr = {
      x: 'scrollWidth',
      y: 'scrollHeight'
    };
    this.offsetAttr = {
      x: 'left',
      y: 'top'
    };
    this.handleSize = {
      x: 0,
      y: 0
    };
    this.globalObserver;
    this.mutationObserver;
    this.resizeObserver;
    this.currentAxis;
    this.scrollbarWidth;
    this.options = Object.assign({}, SimpleBar.defaultOptions, options);
    this.isRtl = this.options.direction === 'rtl';
    this.classNames = this.options.classNames;
    this.offsetSize = 20;
    this.recalculate = throttle(this.recalculate.bind(this), 1000);
    this.onMouseMove = throttle(this.onMouseMove.bind(this), 100);
    this.init();
  }

  _createClass(SimpleBar, [{
    key: "init",
    value: function init() {
      // Save a reference to the instance, so we know this DOM node has already been instancied
      this.el.SimpleBar = this;
      this.initDOM(); // We stop here on server-side

      if (canUseDOM) {
        // Calculate content size
        this.hideNativeScrollbar();
        this.render();
        this.initListeners();
      }
    }
  }, {
    key: "initDOM",
    value: function initDOM() {
      var _this2 = this;

      // make sure this element doesn't have the elements yet
      if (Array.from(this.el.children).filter(function (child) {
        return child.classList.contains(_this2.classNames.scrollContent);
      }).length) {
        // assume that element has his DOM already initiated
        this.trackX = this.el.querySelector(".".concat(this.classNames.track, ".horizontal"));
        this.trackY = this.el.querySelector(".".concat(this.classNames.track, ".vertical"));
        this.scrollContentEl = this.el.querySelector(".".concat(this.classNames.scrollContent));
        this.contentEl = this.el.querySelector(".".concat(this.classNames.content));
      } else {
        // Prepare DOM
        this.scrollContentEl = document.createElement('div');
        this.contentEl = document.createElement('div');
        this.scrollContentEl.classList.add(this.classNames.scrollContent);
        this.contentEl.classList.add(this.classNames.content);

        while (this.el.firstChild) {
          this.contentEl.appendChild(this.el.firstChild);
        }

        this.scrollContentEl.appendChild(this.contentEl);
        this.el.appendChild(this.scrollContentEl);
      }

      if (!this.trackX || !this.trackY) {
        var track = document.createElement('div');
        var scrollbar = document.createElement('div');
        track.classList.add(this.classNames.track);
        scrollbar.classList.add(this.classNames.scrollbar);

        if (!this.options.autoHide) {
          scrollbar.classList.add('visible');
        }

        track.appendChild(scrollbar);
        this.trackX = track.cloneNode(true);
        this.trackX.classList.add('horizontal');
        this.trackY = track.cloneNode(true);
        this.trackY.classList.add('vertical');
        this.el.insertBefore(this.trackX, this.el.firstChild);
        this.el.insertBefore(this.trackY, this.el.firstChild);
      }

      this.scrollbarX = this.trackX.querySelector(".".concat(this.classNames.scrollbar));
      this.scrollbarY = this.trackY.querySelector(".".concat(this.classNames.scrollbar));
      this.el.setAttribute('data-simplebar', 'init');
    }
  }, {
    key: "initListeners",
    value: function initListeners() {
      var _this3 = this;

      // Event listeners
      if (this.options.autoHide) {
        this.el.addEventListener('mouseenter', this.onMouseEnter);
      }

      this.el.addEventListener('mousedown', this.onMouseDown);
      this.el.addEventListener('mousemove', this.onMouseMove);
      this.contentEl.addEventListener('scroll', this.onScrollX);
      this.scrollContentEl.addEventListener('scroll', this.onScrollY); // Browser zoom triggers a window resize

      window.addEventListener('resize', this.onWindowResize); // MutationObserver is IE11+

      if (typeof MutationObserver !== 'undefined') {
        // create an observer instance
        this.mutationObserver = new MutationObserver(function (mutations) {
          mutations.forEach(function (mutation) {
            if (_this3.isChildNode(mutation.target) || mutation.addedNodes.length) {
              _this3.recalculate();
            }
          });
        }); // pass in the target node, as well as the observer options

        this.mutationObserver.observe(this.el, {
          attributes: true,
          childList: true,
          characterData: true,
          subtree: true
        });
      }

      this.resizeObserver = new ResizeObserver(this.recalculate);
      this.resizeObserver.observe(this.el);
    }
    /**
     * Recalculate scrollbar
     */

  }, {
    key: "recalculate",
    value: function recalculate() {
      this.render();
    }
  }, {
    key: "render",
    value: function render() {
      this.contentSizeX = this.contentEl[this.scrollSizeAttr['x']];
      this.contentSizeY = this.contentEl[this.scrollSizeAttr['y']] - (this.scrollbarWidth || this.offsetSize);
      this.trackXSize = this.trackX[this.sizeAttr['x']];
      this.trackYSize = this.trackY[this.sizeAttr['y']]; // Set isEnabled to false if scrollbar is not necessary (content is shorter than wrapper)

      this.isEnabled['x'] = this.trackXSize < this.contentSizeX;
      this.isEnabled['y'] = this.trackYSize < this.contentSizeY;
      this.resizeScrollbar('x');
      this.resizeScrollbar('y');
      this.positionScrollbar('x');
      this.positionScrollbar('y');
      this.toggleTrackVisibility('x');
      this.toggleTrackVisibility('y');
    }
    /**
     * Resize scrollbar
     */

  }, {
    key: "resizeScrollbar",
    value: function resizeScrollbar() {
      var axis = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'y';
      var scrollbar;
      var contentSize;
      var trackSize;

      if (!this.isEnabled[axis] && !this.options.forceVisible) {
        return;
      }

      if (axis === 'x') {
        scrollbar = this.scrollbarX;
        contentSize = this.contentSizeX;
        trackSize = this.trackXSize;
      } else {
        // 'y'
        scrollbar = this.scrollbarY;
        contentSize = this.contentSizeY;
        trackSize = this.trackYSize;
      }

      var scrollbarRatio = trackSize / contentSize; // Calculate new height/position of drag handle.

      this.handleSize[axis] = Math.max(~~(scrollbarRatio * trackSize), this.options.scrollbarMinSize);

      if (this.options.scrollbarMaxSize) {
        this.handleSize[axis] = Math.min(this.handleSize[axis], this.options.scrollbarMaxSize);
      }

      if (axis === 'x') {
        scrollbar.style.width = "".concat(this.handleSize[axis], "px");
      } else {
        scrollbar.style.height = "".concat(this.handleSize[axis], "px");
      }
    }
  }, {
    key: "positionScrollbar",
    value: function positionScrollbar() {
      var axis = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'y';
      var scrollbar;
      var scrollOffset;
      var contentSize;
      var trackSize;

      if (axis === 'x') {
        scrollbar = this.scrollbarX;
        scrollOffset = this.contentEl[this.scrollOffsetAttr[axis]]; // Either scrollTop() or scrollLeft().

        contentSize = this.contentSizeX;
        trackSize = this.trackXSize;
      } else {
        // 'y'
        scrollbar = this.scrollbarY;
        scrollOffset = this.scrollContentEl[this.scrollOffsetAttr[axis]]; // Either scrollTop() or scrollLeft().

        contentSize = this.contentSizeY;
        trackSize = this.trackYSize;
      }

      var scrollPourcent = scrollOffset / (contentSize - trackSize);
      var handleOffset = ~~((trackSize - this.handleSize[axis]) * scrollPourcent);

      if (this.isEnabled[axis] || this.options.forceVisible) {
        if (axis === 'x') {
          scrollbar.style.transform = "translate3d(".concat(handleOffset, "px, 0, 0)");
        } else {
          scrollbar.style.transform = "translate3d(0, ".concat(handleOffset, "px, 0)");
        }
      }
    }
  }, {
    key: "toggleTrackVisibility",
    value: function toggleTrackVisibility() {
      var axis = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'y';
      var track = axis === 'y' ? this.trackY : this.trackX;
      var scrollbar = axis === 'y' ? this.scrollbarY : this.scrollbarX;

      if (this.isEnabled[axis] || this.options.forceVisible) {
        track.style.visibility = 'visible';
      } else {
        track.style.visibility = 'hidden';
      } // Even if forceVisible is enabled, scrollbar itself should be hidden


      if (this.options.forceVisible) {
        if (this.isEnabled[axis]) {
          scrollbar.style.visibility = 'visible';
        } else {
          scrollbar.style.visibility = 'hidden';
        }
      }
    }
  }, {
    key: "hideNativeScrollbar",
    value: function hideNativeScrollbar() {
      // Recalculate scrollbarWidth in case it's a zoom
      this.scrollbarWidth = scrollbarWidth();
      this.scrollContentEl.style[this.isRtl ? 'paddingLeft' : 'paddingRight'] = "".concat(this.scrollbarWidth || this.offsetSize, "px");
      this.scrollContentEl.style.marginBottom = "-".concat(this.scrollbarWidth * 2 || this.offsetSize, "px");
      this.contentEl.style.paddingBottom = "".concat(this.scrollbarWidth || this.offsetSize, "px");

      if (this.scrollbarWidth !== 0) {
        this.contentEl.style[this.isRtl ? 'marginLeft' : 'marginRight'] = "-".concat(this.scrollbarWidth, "px");
      }
    }
    /**
     * On scroll event handling
     */

  }, {
    key: "showScrollbar",

    /**
     * Show scrollbar
     */
    value: function showScrollbar() {
      var axis = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'y';
      var scrollbar; // Scrollbar already visible

      if (this.isVisible[axis]) {
        return;
      }

      if (axis === 'x') {
        scrollbar = this.scrollbarX;
      } else {
        // 'y'
        scrollbar = this.scrollbarY;
      }

      if (this.isEnabled[axis]) {
        scrollbar.classList.add('visible');
        this.isVisible[axis] = true;
      }

      if (!this.options.autoHide) {
        return;
      }

      window.clearInterval(this.flashTimeout);
      this.flashTimeout = window.setInterval(this.hideScrollbars, this.options.timeout);
    }
    /**
     * Hide Scrollbar
     */

  }, {
    key: "onDrag",

    /**
     * on scrollbar handle drag
     */
    value: function onDrag(e) {
      var axis = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'y';
      // Preventing the event's default action stops text being
      // selectable during the drag.
      e.preventDefault();
      var scrollbar = axis === 'y' ? this.scrollbarY : this.scrollbarX; // Measure how far the user's mouse is from the top of the scrollbar drag handle.

      var eventOffset = axis === 'y' ? e.pageY : e.pageX;
      this.dragOffset[axis] = eventOffset - scrollbar.getBoundingClientRect()[this.offsetAttr[axis]];
      this.currentAxis = axis;
      document.addEventListener('mousemove', this.drag);
      document.addEventListener('mouseup', this.onEndDrag);
    }
    /**
     * Drag scrollbar handle
     */

  }, {
    key: "getScrollElement",

    /**
     * Getter for original scrolling element
     */
    value: function getScrollElement() {
      var axis = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'y';
      return axis === 'y' ? this.scrollContentEl : this.contentEl;
    }
    /**
     * Getter for content element
     */

  }, {
    key: "getContentElement",
    value: function getContentElement() {
      return this.contentEl;
    }
  }, {
    key: "removeListeners",
    value: function removeListeners() {
      // Event listeners
      if (this.options.autoHide) {
        this.el.removeEventListener('mouseenter', this.onMouseEnter);
      }

      this.scrollContentEl.removeEventListener('scroll', this.onScrollY);
      this.contentEl.removeEventListener('scroll', this.onScrollX);
      this.mutationObserver.disconnect();
      this.resizeObserver.disconnect();
    }
    /**
     * UnMount mutation observer and delete SimpleBar instance from DOM element
     */

  }, {
    key: "unMount",
    value: function unMount() {
      this.removeListeners();
      this.el.SimpleBar = null;
    }
    /**
     * Recursively walks up the parent nodes looking for this.el
     */

  }, {
    key: "isChildNode",
    value: function isChildNode(el) {
      if (el === null) return false;
      if (el === this.el) return true;
      return this.isChildNode(el.parentNode);
    }
    /**
     * Check if mouse is within bounds
     */

  }, {
    key: "isWithinBounds",
    value: function isWithinBounds(bbox) {
      return this.mouseX >= bbox.left && this.mouseX <= bbox.left + bbox.width && this.mouseY >= bbox.top && this.mouseY <= bbox.top + bbox.height;
    }
  }], [{
    key: "initHtmlApi",
    value: function initHtmlApi() {
      this.initDOMLoadedElements = this.initDOMLoadedElements.bind(this); // MutationObserver is IE11+

      if (typeof MutationObserver !== 'undefined') {
        // Mutation observer to observe dynamically added elements
        this.globalObserver = new MutationObserver(function (mutations) {
          mutations.forEach(function (mutation) {
            Array.from(mutation.addedNodes).forEach(function (addedNode) {
              if (addedNode.nodeType === 1) {
                if (addedNode.hasAttribute('data-simplebar')) {
                  !addedNode.SimpleBar && new SimpleBar(addedNode, SimpleBar.getElOptions(addedNode));
                } else {
                  Array.from(addedNode.querySelectorAll('[data-simplebar]')).forEach(function (el) {
                    !el.SimpleBar && new SimpleBar(el, SimpleBar.getElOptions(el));
                  });
                }
              }
            });
            Array.from(mutation.removedNodes).forEach(function (removedNode) {
              if (removedNode.nodeType === 1) {
                if (removedNode.hasAttribute('data-simplebar')) {
                  removedNode.SimpleBar && removedNode.SimpleBar.unMount();
                } else {
                  Array.from(removedNode.querySelectorAll('[data-simplebar]')).forEach(function (el) {
                    el.SimpleBar && el.SimpleBar.unMount();
                  });
                }
              }
            });
          });
        });
        this.globalObserver.observe(document, {
          childList: true,
          subtree: true
        });
      } // Taken from jQuery `ready` function
      // Instantiate elements already present on the page


      if (document.readyState === 'complete' || document.readyState !== 'loading' && !document.documentElement.doScroll) {
        // Handle it asynchronously to allow scripts the opportunity to delay init
        window.setTimeout(this.initDOMLoadedElements);
      } else {
        document.addEventListener('DOMContentLoaded', this.initDOMLoadedElements);
        window.addEventListener('load', this.initDOMLoadedElements);
      }
    } // Helper function to retrieve options from element attributes

  }, {
    key: "getElOptions",
    value: function getElOptions(el) {
      var options = Array.from(el.attributes).reduce(function (acc, attribute) {
        var option = attribute.name.match(/data-simplebar-(.+)/);

        if (option) {
          var key = option[1].replace(/\W+(.)/g, function (x, chr) {
            return chr.toUpperCase();
          });

          switch (attribute.value) {
            case 'true':
              acc[key] = true;
              break;

            case 'false':
              acc[key] = false;
              break;

            case undefined:
              acc[key] = true;
              break;

            default:
              acc[key] = attribute.value;
          }
        }

        return acc;
      }, {});
      return options;
    }
  }, {
    key: "removeObserver",
    value: function removeObserver() {
      this.globalObserver.disconnect();
    }
  }, {
    key: "initDOMLoadedElements",
    value: function initDOMLoadedElements() {
      document.removeEventListener('DOMContentLoaded', this.initDOMLoadedElements);
      window.removeEventListener('load', this.initDOMLoadedElements);
      Array.from(document.querySelectorAll('[data-simplebar]')).forEach(function (el) {
        if (!el.SimpleBar) new SimpleBar(el, SimpleBar.getElOptions(el));
      });
    }
  }, {
    key: "defaultOptions",
    get: function get() {
      return {
        autoHide: true,
        forceVisible: false,
        classNames: {
          content: 'simplebar-content',
          scrollContent: 'simplebar-scroll-content',
          scrollbar: 'simplebar-scrollbar',
          track: 'simplebar-track'
        },
        scrollbarMinSize: 25,
        scrollbarMaxSize: 0,
        direction: 'ltr',
        timeout: 1000
      };
    }
  }]);

  return SimpleBar;
}();

if (canUseDOM) {
  SimpleBar.initHtmlApi();
}

export default SimpleBar;
//# sourceMappingURL=simplebar.esm.js.map
