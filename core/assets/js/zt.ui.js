/**
 * Zt Ui
 * @param {type} w
 * @param {type} z
 * @param {type} $
 * @returns {undefined}
 */
(function (w, z, $) {
    /* Reject if zt is not defined */
    if (typeof (z) === 'undefined') {
        console.log('Error: Zt Javsacript Framework not available.');
        return false;
    }

    /* Local ajax class */
    var _ui = {
        /* Local settings */
        _settings: {},
        /**
         * Init function
         * @returns {undefined}
         */
        _init: function () {
        },
        /**
         * Replace HTML content inside element
         * @param {type} el
         * @param {type} html
         * @returns {undefined}
         */
        replace: function(el, html){
            $(el).html(html);
        },
        /**
         * Append HTML at last element
         * @param {type} el
         * @param {type} html
         * @returns {undefined}
         */
        append: function(el, html){
            $(el).append(html);
        },
        /**
         * Raise message
         * @param {type} messageSettings
         * @returns {undefined}
         */
        raiseMessage: function(messageSettings){
        }
    };

    /* Append to Zt JS Framework */
    z.ui = _ui;
    z.ui._init();
    
})(window, zt, zt.$);
