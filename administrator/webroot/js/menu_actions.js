(function ($) {
  'use strict';

  var defaults = {};

  function Menu (element, options) {
    this.$el = $(element);
    this.opt = $.extend(true, {}, defaults, options);

    this.init(this);
  }

  Menu.prototype = {
    init: function (self) {
      $(document).on('click', function (e) {
        var $target = $(e.target);

        if ($target.closest(self.$el.data('menu-toggle'))[0]) {
          $target = $target.closest(self.$el.data('menu-toggle'));

          self.$el
            .css(self.calcPosition($target))
            .toggleClass('show');

          e.preventDefault();
        } else if (!$target.closest(self.$el)[0]){
          self.$el.removeClass('show');
        }
      });
    },

    calcPosition: function ($target) {
      var windowWidth, targetOffset, position;

      windowWidth = $(window).width();
      targetOffset = $target.offset();
      
      var btnTop = parseInt($target.css("top"));

      position = {
        top: btnTop + $target.outerHeight()
      };

      if (targetOffset.left > windowWidth / 2) {
        this.$el
          .addClass('menuactions--right')
          .removeClass('menuactions--left');

        position.right = (windowWidth - targetOffset.left) - ($target.outerWidth());
        position.left = 'auto';
      } else {
        this.$el
          .addClass('menuactions--left')
          .removeClass('menuactions--right');

        position.left = targetOffset.left + ($target.outerWidth() / 2);
        position.right = 'auto';
      }

      return position;
    }
  };

  $.fn.menu_actions = function (options) {
    return this.each(function() {
      if (!$.data(this, 'menu')) {
        $.data(this, 'menu', new Menu(this, options));
      }
    });
  };
})(window.jQuery);
