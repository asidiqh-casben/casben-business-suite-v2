/**
 * CASBEN Business Suite
 * Dialog Module
 *
 * @package CASBEN_Business_Suite
 */

(function ($) {

    'use strict';


    window.CASBEN = window.CASBEN || {};


    CASBEN.Dialog = {


        /**
         * Initialize dialog.
         */
        init: function () {

            this.bindEvents();

        },


        /**
         * Bind events.
         */
        bindEvents: function () {


            $(document).on(
                'click',
                '[data-casben-confirm]',
                function (e) {


                    var message = $(this)
                        .data('casben-confirm');


                    if (
                        !CASBEN.Dialog.confirm(message)
                    ) {

                        e.preventDefault();

                    }


                }
            );


        },


        /**
         * Confirmation dialog.
         *
         * @param {string} message Dialog message.
         *
         * @return {boolean}
         */
        confirm: function (message) {


            if (!message) {

                message =
                    'Are you sure you want to continue?';

            }


            return window.confirm(message);


        },


        /**
         * Alert dialog.
         *
         * @param {string} message Alert message.
         */
        alert: function (message) {


            window.alert(message);


        }


    };


    $(function () {


        if (CASBEN.Dialog) {

            CASBEN.Dialog.init();

        }


    });


})(jQuery);