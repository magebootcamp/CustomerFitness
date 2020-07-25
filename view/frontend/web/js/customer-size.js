/*
 * Copyright (c) MageBootcamp 2020.
 *
 * Created by MageBootcamp: The Ultimate Online Magento Course.
 * We are here to help you become a Magento PRO.
 * Watch and learn at https://magebootcamp.com.
 *
 * @author Daniel Donselaar
 */
define([
    'uiComponent',
    'jquery',
    'ko',
    'Magento_Customer/js/customer-data',
    'mage/translate'
], function (Component, $, ko, customerData, $t) {
    'use strict';

    /**
     * This component is responsible for retrieve customer sizes through an API
     */
    return Component.extend({
        /**
         * Configuration that is partly injected through $block->getJsLayout().
         */
        errorTimeout: 6000,
        customerSizesUri: null,
        sidebarForm: '#my-size-form',
        fields: [],
        showButton: ko.observable(false),
        error: ko.observable(''),

        /**
         * This functionality is executed on component load.
         */
        initialize: function () {
            this._super();
            var self = this;

            /** If a customer is logged in and there is no filter active we will show the button. */
            var customer = customerData.get('customer')()
            self.showButton(customer.fullname && !self.hasFilterActive())
        },

        /**
         * This will filter based on the customer sizes.
         */
        filter: function () {
            this.getCustomerSizes();
        },

        /**
         * This function will do an AJAX request and lookup the customer sizes.
         * If the customer does not have any sizes we will show an error.
         */
        getCustomerSizes: function () {
            var self = this;

            $.ajax({
                type: 'GET',
                url: this.customerSizesUri,
                success: function (Log) {
                    /** Fill the form fields with the response fitness log. */
                    self.fields.forEach(function (fieldName) {
                        $('#' + fieldName + '_from_number').val(Log[fieldName]);
                    });

                    /** Submit the form with the new sizes */
                    $(self.sidebarForm).submit();
                },
                error: function () {
                    /** Display the error and remove the error after some time. */
                    self.error($t("We can\'t find a size in your account"));
                    setTimeout(
                        function () {
                            self.error('')
                        },
                        self.errorTimeout
                    );
                }
            });
        },

        /**
         * Check if a filter is active
         *
         * @returns {*|boolean}
         */
        hasFilterActive: function () {
            var self = this;
            return this.fields.reduce(function (hasFilterActive, fieldName) {
                return hasFilterActive || self.hasUrlParam(fieldName);
            }, false);
        },

        /**
         * Check if a url param is set
         *
         * @param {string} name
         * @returns {boolean}
         */
        hasUrlParam: function (name) {
            return this.getUrlParam(name) > 0;
        },

        /**
         * Get an url param
         *
         * @param {string} name
         * @returns {number}
         */
        getUrlParam: function (name) {
            return parseFloat(new URL(location.href).searchParams.get(name));
        }
    });
});
