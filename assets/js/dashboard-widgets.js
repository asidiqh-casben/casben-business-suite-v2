/**
 * CASBEN Business Suite
 * Dashboard Widgets Module
 *
 * @package CASBEN_Business_Suite
 */

(function ($) {

    'use strict';


    window.CASBEN = window.CASBEN || {};


    CASBEN.Dashboard = {


        /**
         * Initialize dashboard.
         */
        init: function () {

            this.bindEvents();
            this.refreshWidgets();

        },


        /**
         * Register dashboard events.
         */
        bindEvents: function () {


            $(document).on(
                'click',
                '.casben-widget-refresh',
                function (e) {

                    e.preventDefault();

                    CASBEN.Dashboard.refreshWidgets();

                }
            );


        },


        /**
         * Refresh dashboard widgets.
         */
        refreshWidgets: function () {


            $('.casben-dashboard-widget')
                .each(function () {

                    var $widget = $(this);


                    /*
                     * Future AJAX loading will be added here.
                     *
                     * Example:
                     * Customers count
                     * Products count
                     * Invoice totals
                     * FBR status
                     */


                });


        },


        /**
         * Update widget value.
         *
         * @param {string} selector Widget selector.
         * @param {string|number} value Widget value.
         */
        updateValue: function (
            selector,
            value
        ) {


            $(selector)
                .text(value);


        }


    };


    $(function () {


        if (CASBEN.Dashboard) {

            CASBEN.Dashboard.init();

        }


    });


})(jQuery);