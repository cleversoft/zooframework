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
        /* Selector */
        _elements:{
            messageContainerId: '#zt-framework-container-message',
            messageContainerClass: '.zt-framework-container-message',
            ajaxOverlayId: '#zt-framework-ajax-overlay',
            ajaxOverlayClass: '.zt-framework-ajax-overlay'
        },
        /* Local settings */
        _settings: {
            messageAppear: 5000
        },
        /**
         * Init function
         * @returns {undefined}
         */
        _init: function () {
            this._addMessageContainer();
            this._addAjaxOverlay();
        },
        /**
         * Add message container
         * @returns {undefined}
         */
        _addMessageContainer: function () {
            var self = this;
            $(w.document).ready(function () {
                $('div' + self._elements.messageContainerId).remove();
                var $messageContainer = $('<div></div>');
                $messageContainer.attr('id', self._elements.messageContainerId.substr(1));
                $messageContainer.addClass(self._elements.messageContainerClass.substr(1));
                self.append('body', $messageContainer);
            });
        },
        /**
         * Add ajax overlay
         * @returns {undefined}
         */
        _addAjaxOverlay: function(){
             var self = this;
            $(w.document).ready(function () {
                $('div' + self._elements.ajaxOverlayId).remove();
                var $messageContainer = $('<div></div>');
                $messageContainer.attr('id', self._elements.ajaxOverlayId.substr(1));
                $messageContainer.addClass(self._elements.ajaxOverlayClass.substr(1));
                self.append('body', $messageContainer);
            });
        },
        /**
         * Show ajax overlay
         * @returns {undefined}
         */
        showAjaxOverlay: function(){
            $('div' + this._elements.ajaxOverlayId).fadeIn('slow');
        },
        /**
         * Hide ajax overlay
         * @returns {undefined}
         */
        hideAjaxOverlay: function(){
            $('div' + this._elements.ajaxOverlayId).fadeOut('slow');
        },
        /**
         * Replace HTML content inside element
         * @param {type} el
         * @param {type} html
         * @returns {undefined}
         */
        replace: function (el, html) {
            $(el).html(html);
        },
        /**
         * Append HTML at last element
         * @param {type} el
         * @param {type} html
         * @returns {undefined}
         */
        append: function (el, html) {
            $(el).append(html);
        },
        /**
         * 
         * @param {string} target
         * @param {boolean} animation
         * @returns {undefined}
         */
        remove: function(target, animation) {
            animation = (typeof animation === 'undefined') ? false : animation;
            /* Is animation present ? */
            if (animation) {
                $(target).fadeOut('slow', function() {
                    $(this).remove();
                });
            } else {
                $(target).remove();
            }
        },
        /**
         * Raise message
         * @param {type} message
         * @returns {undefined}
         */
        raiseMessage: function (message) {
            var self = this;
            this.append(this._elements.messageContainerId, message);
            w.setTimeout(function(){
               self.remove($(self._elements.messageContainerId).children().last(), true);
            }, this._settings.messageAppear);
            
        }
    };

    /* Append to Zt JS Framework */
    z.ui = _ui;
    z.ui._init();

})(window, zt, zt.$);
