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
            messageContainerClass: '.zt-framework-container-message'
        },
        /* Local settings */
        _settings: {
            defaultMessage: {
                /* HTML source */
                html: '',
                /* Options */
                options: {
                    /* Append or create new */

                    append: true,
                    /* Delay after close */

                    delayClose: 10000,
                    /* Child message ID */
                    childID: ''

                }
            }
        },
        /**
         * Init function
         * @returns {undefined}
         */
        _init: function () {
            this._addMessageContainer();
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
                $(target).hide('slow', function() {
                    $(this).remove();
                });
            } else {
                $(target).remove();
            }
        },
        /**
         * Raise message
         * @param {type} messageSettings
         * @returns {undefined}
         */
        raiseMessage: function (messageSettings) {
            /* Fix default settings is override */
            var mySettings = {};
            $.extend(true, mySettings, this._settings.defaultMessage);
            /* Merge setting with default setting */
            $.extend(true, mySettings, messageSettings);
            /* Append or override */
            if (mySettings.options.append) {
                this.append(this._elements.messageContainerId, mySettings.html);
            } else {
                this.replace(this._selectors.message, mySettings.html);
            }
            /* Hide message after a moment */
            if (mySettings.options.delayClose >= 0 && mySettings.childID !== '') {
                w.setTimeout(function() {
                    this.remove('#' + mySettings.options.childID, true);
                }, mySettings.options.delayClose);
            }
        }
    };

    /* Append to Zt JS Framework */
    z.ui = _ui;
    z.ui._init();

})(window, zt, zt.$);
