'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Customer === undefined) App.Module.Customer = {};
        if (App.Module.Customer.Collection === undefined) App.Module.Customer.Collection = {};
        App.Module.Customer.Collection.Addresses = App.Collection.Collection.extend({
            model: App.Module.Customer.Model.Address,
            url: "/customer/address/list"
        });
    });
});