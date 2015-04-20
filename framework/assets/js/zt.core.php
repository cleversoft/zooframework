/**     
 * @param {object} w Window pointer
 * @param {object} $ jQuery pointer
 * @returns {undefined}
 */
(function (w, $) {

    if (typeof w.zt === 'undefined') {
        /* Local zo2 definition */
        var _zt = {
            /* Common settings */
            settings: {
                /* Zt current version */
                version: "<?php echo ZTVERSION; ?>",
                /* Joomla! URL root */
                frontendUrl: "<?php echo rtrim(JUri::root(), '/') . '/ '; ?>",
                backendUrl: "<?php echo rtrim(JUri::root(), '/') . '/administrator/'; ?>",
                /* Joomla! security torken */
                token: "<?php echo JSession::getFormToken(); ?>"
            },
            /* Internal jQuery/Zepto framework */
            $: $
        };
        /* Provide global zt object */
        w.zt = _zt;
    }

})(window, jQuery);
