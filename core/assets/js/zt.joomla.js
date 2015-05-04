/**
 * Zt Joomla
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
    var _joomla = {
        /* Local settings */
        _settings: {},
        /**
         * Init function
         * @returns {undefined}
         */
        _init: function () {
        },
        userLogin: function (username, password) {
            z.ajax.request({
                data: {
                    zt_cmd: "ajax.add",
                    zt_namespace: "Zt",
                    zt_task: "userLogin",
                    username: username,
                    password: password

                }
            })
        }
    };

    /* Append to Zt JS Framework */
    z.joomla = _joomla;
    z.joomla._init();

})(window, zt, zt.$);