(function (window, factory) {
  if (typeof define == 'function' && define.amd) {
    // AMD
    define(['jquery'], factory);
  } else if (typeof module == 'object' && module.exports) {
    // CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // browser global
    window.ScrollBalance = factory(window.jQuery);
  }
}(window, function factory ($) {
  'use strict';

  var INNER_CLASSNAME = 'scrollbalance-inner';
  
  function ScrollBalance(columns, options) {
    this.columns = columns;
    this.columnData = [];
    this.settings = $.extend({
      threshold: 100,
      minwidth: null
    }, options);

    this.balance_enabled = true;
    this.scrollTop = 0;
    this.setup();
  }

  ScrollBalance.prototype = {
    initialize: function () {
      var that = this;

      function columnHeight(col) {
        var inner = col.find('.' + INNER_CLASSNAME);
        return inner.height() + parseInt(col.css('borderTop') || 0) +
          parseInt(col.css('paddingTop') || 0) +
          parseInt(col.css('paddingBottom') || 0) +
          parseInt(col.css('borderBottom') || 0);
      }

      if (this.columns.length === 1) {
        this.containerHeight = this.columns.parent().height();
        this.containerTop = this.columns.parent().offset().top;
      } else {
        var height = 0;
        this.columns.each(function () {
          height = Math.max(height, columnHeight($(this)));
        });
        this.containerHeight = height;
        this.containerTop = this.columns.eq(0).offset().top;
      }

      this.columns.each(function (i) {
        var col = $(this);
        var inner = col.find('.' + INNER_CLASSNAME);

        if (!that.columnData[i]) {
          that.columnData[i] = {
            fixTop: 0
          };
        }
        var columnData = that.columnData[i];
        columnData.height = columnHeight(col);
        columnData.enabled = (that.containerHeight - columnData.height) >
          that.settings.threshold;

        columnData.fixLeft = col.offset().left + (parseInt(col.css('borderLeftWidth'), 10) || 0);

        columnData.minFixTop = Math.min(0, that.winHeight - columnData.height);
        columnData.maxFixTop = 0;

        if (that.balance_enabled && columnData.enabled) {
          inner.css({
            width: col.css('width'),
            padding: col.css('padding')
          });
          col.css({
            height: inner.css('height')
          });
        } else {
          inner.css({
            width: '',
            padding: ''
          });
          col.height('');
        }
        that.balance(col, columnData, true);
      });
    },
    resize: function (winWidth, winHeight) {
      this.winHeight = winHeight;

      if (this.settings.minwidth !== null) {
        this.balance_enabled = (winWidth >= this.settings.minwidth);
      }
      this.initialize();
    },
    scroll: function (scrollTop, scrollLeft) {
      var scrollDelta = scrollTop - this.scrollTop;
      this.scrollTop = scrollTop;
      this.scrollLeft = scrollLeft;
      this.balance_all(false, scrollDelta);
    },
    bind: function () {
      var that = this;
      $(window).on('resize.scrollbalance', function () {
        that.resize($(window).width(), $(window).height());
      });
      $(window).on('scroll.scrollbalance', function () {
        that.scroll($(window).scrollTop(), $(window).scrollLeft());
      });
      $(window).trigger('resize');
      $(window).trigger('scroll');
    },
    unbind: function () {
      $(window).off('resize.scrollbalance');
      $(window).off('scroll.scrollbalance');
    },
    disable: function () {
      this.balance_enabled = false;
      this.initialize();
    },
    enable: function () {
      this.balance_enabled = true;
      this.initialize();
    },
    teardown: function () {
      this.columns.each(function () {
        var col = $(this);
        var inner = col.find('.' + INNER_CLASSNAME);
        if (inner.data('sb-created')) {
          inner.children().appendTo(col);
          inner.remove();
        }
        col.css({
          position: '',
          height: ''
        });
      });
    },
    setup: function () {
      this.columns.each(function () {
        var col = $(this);
        var inner = col.find('.' + INNER_CLASSNAME);

        if (col.css('position') === 'static') {
          col.css('position', 'relative');
        }

        if (!inner.length) {
          inner = $('<div>').addClass(INNER_CLASSNAME)
            .append(col.children())
            .data('sb-created', true);
          col.html('').append(inner);
        }
      });
    },
    balance: function (col, columnData, force, scrollDelta) {
      var state;
      var fixTop = columnData.fixTop;
      if (scrollDelta === undefined) {
        scrollDelta = 0;
      }

      if (!columnData.enabled || !this.balance_enabled) {
        state = 'disabled';
      } else {
        var topBreakpoint = this.containerTop - columnData.fixTop;
        var bottomBreakpoint = this.containerTop + this.containerHeight -
          columnData.height - columnData.fixTop;

        if (this.scrollTop < topBreakpoint) {
          state = 'top';
        } else if (this.scrollTop > bottomBreakpoint) {
          state = 'bottom';
        } else {
          state = 'fixed';
          fixTop = columnData.fixTop - scrollDelta;
          fixTop = Math.max(columnData.minFixTop, Math.min(columnData.maxFixTop, fixTop));
        }
      }

      if (columnData.state !== state || columnData.fixTop !== fixTop || force) {
        var inner = col.find('.' + INNER_CLASSNAME);
        if (state === 'disabled') {
          inner.css({
            position: '',
            top: '',
            left: ''
          });
        } else if (state === 'fixed') {
          inner.css({
            position: 'fixed',
            top: fixTop,
            left: columnData.fixLeft - this.scrollLeft
          });
        } else {
          inner.css({
            position: 'absolute',
            top: (state === 'bottom' ? this.containerHeight - columnData.height : 0) + 'px',
            left: 0
          });
        }
        columnData.fixTop = fixTop;
        columnData.state = state;
      }
    },
    balance_all: function (force, scrollDelta) {
      for (var i = 0; i < this.columns.length; i++) {
        if (this.columnData[i]) {
          this.balance(this.columns.eq(i), this.columnData[i], force, scrollDelta);
        }
      }
    }
  };

  $.fn.scrollbalance = function (options) {
    var columns;
    if (options && options.childSelector) {
      columns = this.find(options.childSelector);
    } else {
      columns = this;
    }

    var scrollbalance = new ScrollBalance(columns, options);
    scrollbalance.initialize();
    scrollbalance.bind();

    this.data('scrollbalance', scrollbalance);
  };

  return ScrollBalance;
}));
