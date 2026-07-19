/**
 * CASBEN Business Suite
 * Tables Module
 *
 * @package CASBEN_Business_Suite
 */

(function ($) {

    'use strict';

    window.CASBEN = window.CASBEN || {};

    CASBEN.Tables = {

        /**
         * Initialize tables.
         */
        init: function () {

            this.bindEvents();

        },

        /**
         * Register table events.
         */
        bindEvents: function () {

            // Select/Deselect all checkboxes.
            $(document).on(
                'change',
                '.casben-select-all',
                function () {

                    var checked = $(this).prop('checked');

                    $('.casben-row-select').prop(
                        'checked',
                        checked
                    );

                }
            );

        },

        /**
         * Get selected rows.
         *
         * @return {Array}
         */
        getSelected: function () {

            var rows = [];

            $('.casben-row-select:checked').each(function () {

                rows.push($(this).val());

            });

            return rows;

        },

        /**
         * Clear all selected rows.
         */
        clearSelection: function () {

            $('.casben-row-select').prop(
                'checked',
                false
            );

            $('.casben-select-all').prop(
                'checked',
                false
            );

        }

    };

    $(function () {

        if (CASBEN.Tables) {

            CASBEN.Tables.init();

        }

    });

})(jQuery);