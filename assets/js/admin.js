/**
 * CASBEN Business Suite
 * Admin Core
 *
 * @package CASBEN_Business_Suite
 */

(function ($) {

    'use strict';

    /**
     * Global CASBEN namespace.
     */
    window.CASBEN = window.CASBEN || {};

    /**
     * Application Core.
     */
    CASBEN.App = {

        /**
         * Initialize application.
         */
        init: function () {

            this.cache();

            this.bindEvents();

            this.ready();

        },

        /**
         * Cache frequently used objects.
         */
        cache: function () {

            this.body = $('body');

            this.document = $(document);

            this.window = $(window);

        },

        /**
         * Register global events.
         */
        bindEvents: function () {

            // Reserved for future global events.

        },

        /**
         * Called after initialization.
         */
                ready: function () {

            console.log(
                'CASBEN Business Suite initialized.'
            );


            this.initModules();

        },


        /**
         * Initialize application modules.
         */
        initModules: function () {


            if (CASBEN.Forms) {

                CASBEN.Forms.init();

            }


            if (CASBEN.Tables) {

                CASBEN.Tables.init();

            }


            if (CASBEN.Modal) {

                CASBEN.Modal.init();

            }


            if (CASBEN.Dialog) {

                CASBEN.Dialog.init();

            }


            if (CASBEN.Notifications) {

                CASBEN.Notifications.init();

            }


            if (CASBEN.Dashboard) {

                CASBEN.Dashboard.init();

            }


        }

    };

    /**
     * Auto start.
     */
    $(function () {

        CASBEN.App.init();

    });

})(jQuery);