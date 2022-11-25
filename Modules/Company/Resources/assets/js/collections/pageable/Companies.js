'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Company === undefined) App.Module.Company = {};
        if (App.Module.Company.Collection === undefined) App.Module.Company.Collection = {};
        if (App.Module.Company.Collection.Pageable === undefined) App.Module.Company.Collection.Pageable = {};
        App.Module.Company.Collection.Pageable.Companies = App.Collection.Pageable.Pageable.extend({
            model: App.Module.Company.Model.Company,
            url: "/company/list/pageable"
        });
    });
});