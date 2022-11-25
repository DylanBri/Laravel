'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Customer === undefined) App.Module.Customer = {};
        if (App.Module.Customer.Collection === undefined) App.Module.Customer.Collection = {};
        if (App.Module.Customer.Collection.Pageable === undefined) App.Module.Customer.Collection.Pageable = {};
        App.Module.Customer.Collection.Pageable.Customers = App.Collection.Pageable.Pageable.extend({
            model: App.Module.Customer.Model.Customer,
            url: "/customer/list/pageable"
        });
    });
});