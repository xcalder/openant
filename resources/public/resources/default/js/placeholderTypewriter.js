/*
 jQuery placeholderTypewriter plugin
 ===================================
 Author: Bjoern Diekert <https://github.com/bdiekert>
 Version: 1.0
 License: Unlicense <http://unlicense.org>
 */
(function ($) {
  "use strict";

  $.fn.placeholderTypewriter = function (options) {

    // Plugin Settings
    var settings = $.extend({
      delay: 50,
      pause: 1000,
      text: []
    }, options);

    // Type given string in placeholder
    function typeString($target, index, cursorPosition, callback) {

      // Get text
      var text = settings.text[index];

      // Get placeholder, type next character
      var placeholder = $target.attr('placeholder');
      $target.attr('placeholder', placeholder + text[cursorPosition]);

      // Type next character
      if (cursorPosition < text.length - 1) {
        setTimeout(function () {
          typeString($target, index, cursorPosition + 1, callback);
        }, settings.delay);
        return true;
      }

      // Callback if animation is finished
      callback();
    }

    // Delete string in placeholder
    function deleteString($target, callback) {

      // Get placeholder
      var placeholder = $target.attr('placeholder');
      var length = placeholder.length;

      // Delete last character
      $target.attr('placeholder', placeholder.substr(0, length - 1));

      // Delete next character
      if (length > 1) {
        setTimeout(function () {
          deleteString($target, callback)
        }, settings.delay);
        return true;
      }

      // Callback if animation is finished
      callback();
    }

    // Loop typing animation
    function loopTyping($target, index) {

      // Clear Placeholder
      $target.attr('placeholder', '');

      // Type string
      typeString($target, index, 0, function () {

        // Pause before deleting string
        setTimeout(function () {

          // Delete string
          deleteString($target, function () {
            // Start loop over
            loopTyping($target, (index + 1) % settings.text.length)
          })

        }, settings.pause);
      })

    }

    // Run placeholderTypewriter on every given field
    return this.each(function () {

      loopTyping($(this), 0);
    });

  };

}(jQuery));