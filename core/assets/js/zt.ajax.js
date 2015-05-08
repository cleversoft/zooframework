/**
 * Zt Ajax
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
    /* Reject if Zt UI is not defined */
    if (typeof (z.ui) === 'undefined') {
        console.log('Error: Zt Javsacript Framework not available.');
        return false;
    }

    /* Local ajax class */
    var _ajax = {
        /* Local settings */
        _settings: {},
        /**
         * Init function
         * @returns {undefined}
         */
        _init: function () {
            this._settings = {
                url: z.settings.frontendUrl,
                type: "POST",
                data: {
                },
                success: function (data) {
                    console.log("Reponse data: ", data);
                    $.each(data, function (index, item) {
                        switch (item.type) {
                            case 'html':
                                z.ui.replace(item.data.target, item.data.html);
                                break;
                            case 'appendHtml':
                                z.ui.append(item.data.target, item.data.html);
                                break;
                            case 'exec':
                            case 'execute':
                                eval(item.data.toString());
                                break;
                            default:
                                break;
                        }
                        ;
                    });
                }
            };
            this._settings.data[z.settings.token] = 1;
        },
        /**
         * Ajax request manually
         * @param {type} data
         * @returns {jqXHR}
         */
        request: function (data) {
            var buffer = {};
            $.extend(true, buffer, this._settings);
            $.extend(true, buffer, (typeof (data) === 'undefined') ? {} : data);
            console.log("Ajax data: ", buffer);
            return $.ajax(buffer);
        },
        /**
         * Ajax request by form data
         * @param {type} formSelector
         * @param {type} data
         * @param {type} getArray
         * @returns {jqXHR}
         */
        formRequest: function (formSelector, data, getArray) {
            var $form = $(formSelector);
            var data = (typeof (data) === 'undefined') ? {} : data;
            var getArray = (typeof (getArray) === 'undefined') ? false : getArray;
            var formData = {};
            var arrayDetect = {};
            var arrayValue = {};
            if ($form.length > 0) {
                var $inputs = $form.find("input, texarea, select, button");
                $inputs.each(function () {
                    var $me = $(this);
                    var type = $me.attr('type');
                    var value = $me.val();
                    var name = $me.attr('name');
                    if (typeof (name) !== 'undefined') {
                        if (typeof (type) !== 'undefined') {
                            if (type === 'checkbox' || type === 'radio') {
                                /* Convert to boolean value if checkbox/radio value is empty */
                                if (value === '') {
                                    value = ($me.is(':checked')) ? true : false;
                                }
                            }
                        }
                        formData[name] = value;
                        if (getArray) {
                            arrayDetect[name] = (arrayDetect.hasOwnProperty(name)) ? arrayDetect[name] + 1 : 1;
                            if (!arrayValue.hasOwnProperty(name)) {
                                arrayValue[name] = [];
                            }
                            arrayValue[name].push(value);
                        }
                    }
                });
                if (getArray) {
                    /* If many fields has same name convert it to an array */
                    $.each(arrayDetect, function (index, value) {
                        if (value > 1) {
                            formData[index] = arrayValue[index];
                        }
                    });
                }
            }
            var buffer = {};
            $.extend(true, buffer, {data: formData});
            $.extend(true, buffer, data);
            return this.request(buffer);
        },
        /**
         * Form hook
         * @param {type} selector
         * @param {type} data
         * @param {type} getArray
         * @param {type} callback
         * @returns {undefined}
         */
        formHook: function (selector, data, getArray, callback) {
            var self = this;
            if($(selector).length <= 0){
                return false;
            }
            var data = (typeof (data) === 'undefined') ? {} : data;
            var getArray = (typeof (getArray) === 'undefined') ? false : getArray;
            var callback = (typeof (callback) === 'undefined') ? function(){} : callback;
            $(selector).off('submit');
            $(selector).on('submit', function () {
                self.formRequest(this, data, getArray).done(function(){
                    callback();
                });
                return false;
            });
        }
    };

    /* Append to Zt JS Framework */
    z.ajax = _ajax;
    z.ajax._init();

})(window, zt, zt.$);
