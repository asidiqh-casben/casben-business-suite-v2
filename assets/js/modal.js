/**
 * CASBEN Business Suite
 * Modal Module
 *
 * @package CASBEN_Business_Suite
 */

(function ($) {

    'use strict';


    window.CASBEN = window.CASBEN || {};


    CASBEN.Modal = {


        /**
         * Initialize.
         */
        init: function () {

            this.bindEvents();

        },


        /**
         * Bind modal events.
         */
        bindEvents: function () {


            // Open modal.
            $(document).on(
                'click',
                '[data-casben-modal]',
                function (e) {

                    e.preventDefault();

                    var target = $(this)
                        .data('casben-modal');


                    CASBEN.Modal.open(target);

                }
            );


            // Close modal.
            $(document).on(
                'click',
                '.casben-modal-close, .casben-modal-overlay',
                function (e) {

                    e.preventDefault();

                    CASBEN.Modal.close();

                }
            );


            // Escape key close.
            $(document).on(
                'keydown',
                function (e) {

                    if (e.key === 'Escape') {

                        CASBEN.Modal.close();

                    }

                }
            );


        },


        /**
         * Open modal.
         *
         * @param {string} target Modal selector.
         */
        open: function (target) {


            var $modal = $(target);


            if (!$modal.length) {

                return;

            }


            $('.casben-modal')
                .hide();


            $modal
                .fadeIn(200);


            $('body')
                .addClass(
                    'casben-modal-open'
                );


        },


        /**
         * Close modal.
         */
        close: function () {


            $('.casben-modal')
                .fadeOut(200);


            $('body')
                .removeClass(
                    'casben-modal-open'
                );


        }


    };


    $(function () {

        if (CASBEN.Modal) {

            CASBEN.Modal.init();

        }

    });


})(jQuery);