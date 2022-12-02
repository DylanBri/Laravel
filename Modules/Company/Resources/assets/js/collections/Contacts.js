'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Company === undefined) App.Module.Company = {};
        if (App.Module.Company.Collection === undefined) App.Module.Company.Collection = {};
        App.Module.Company.Collection.Contacts = App.Collection.Collection.extend({
            model: App.Module.Company.Model.Contact,
            url: "/company/contact/list"
        });
    });
});