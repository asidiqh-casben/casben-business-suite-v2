/**
 * CASBEN Business Suite
 * Notifications Module
 *
 * @package CASBEN_Business_Suite
 */

(function ($) {

    'use strict';


    window.CASBEN = window.CASBEN || {};


    CASBEN.Notifications = {


        /**
         * Initialize notifications.
         */
        init: function () {

            this.bindEvents();

        },


        /**
         * Bind notification events.
         */
        bindEvents: function () {


            $(document).on(
                'click',
                '.casben-notice-dismiss',
                function () {

                    $(this)
                        .closest('.casben-notice')
                        .fadeOut(200, function () {

                            $(this).remove();

                        });

                }
            );


        },


        /**
         * Show notification.
         *
         * @param {string} message Message text.
         * @param {string} type Notice type.
         */
        show: function (message, type) {


            type = type || 'success';


            var notice = $(
                '<div class="casben-notice casben-notice-' + type + '">' +
                    '<span class="casben-notice-message">' +
                        message +
                    '</span>' +
                    '<button type="button" class="casben-notice-dismiss">' +
                        '&times;' +
                    '</button>' +
                '</div>'
            );


            $('.casben-notifications')
                .prepend(notice);


            notice.hide()
                .fadeIn(200);


            this.autoHide(notice);


        },


        /**
         * Success message.
         *
         * @param {string} message Message.
         */
        success: function (message) {

            this.show(
                message,
                'success'
            );

        },


        /**
         * Error message.
         *
         * @param {string} message Message.
         */
        error: function (message) {

            this.show(
                message,
                'error'
            );

        },


        /**
         * Automatically hide.
         *
         * @param {object} notice Notice element.
         */
        autoHide: function (notice) {


            setTimeout(
                function () {

                    notice.fadeOut(
                        300,
                        function () {

                            $(this).remove();

                        }
                    );

                },
                5000
            );


        }


    };


    $(function () {


        if (CASBEN.Notifications) {

            CASBEN.Notifications.init();

        }


    });


})(jQuery);