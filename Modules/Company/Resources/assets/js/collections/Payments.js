'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Company === undefined) App.Module.Company = {};
        if (App.Module.Company.Collection === undefined) App.Module.Company.Collection = {};
        App.Module.Company.Collection.Payments = App.Collection.Collection.extend({
            model: App.Module.Company.Model.Payment,
            url: "/company/payment/list"
        });
    });
});