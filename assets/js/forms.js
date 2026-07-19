/**
 * CASBEN Business Suite
 * Forms Module
 *
 * @package CASBEN_Business_Suite
 */

(function ($) {

    'use strict';

    window.CASBEN = window.CASBEN || {};

    CASBEN.Forms = {

        /**
         * Initialize forms.
         */
        init: function () {

            this.bindEvents();

        },

        /**
         * Register form events.
         */
        bindEvents: function () {

            // Auto trim text inputs.
            $(document).on(
                'blur',
                'input[type="text"], textarea',
                function () {

                    $(this).val(
                        $.trim($(this).val())
                    );

                }
            );

        },

        /**
         * Reset a form.
         *
         * @param {HTMLElement} form Form element.
         */
        reset: function (form) {

            form.reset();

        },

        /**
         * Disable a form.
         *
         * @param {HTMLElement} form Form element.
         */
        disable: function (form) {

            $(form)
                .find(':input')
                .prop('disabled', true);

        },

        /**
         * Enable a form.
         *
         * @param {HTMLElement} form Form element.
         */
        enable: function (form) {

            $(form)
                .find(':input')
                .prop('disabled', false);

        }

    };

    $(function () {

        if (CASBEN.Forms) {
            CASBEN.Forms.init();
        }

    });

})(jQuery);