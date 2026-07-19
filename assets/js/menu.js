/**
 * CASBEN Business Suite
 * Menu Module
 *
 * @package CASBEN_Business_Suite
 */

(function ($) {

    'use strict';

    window.CASBEN = window.CASBEN || {};

    CASBEN.Menu = {

        /**
         * Initialize menu module.
         */
        init: function () {

            this.bindEvents();

        },

        /**
         * Register menu events.
         */
        bindEvents: function () {

            // Reserved for future menu interactions.

        }

    };

    /**
     * Auto initialize.
     */
    $(function () {

        if (CASBEN.Menu) {
            CASBEN.Menu.init();
        }

    });

})(jQuery);