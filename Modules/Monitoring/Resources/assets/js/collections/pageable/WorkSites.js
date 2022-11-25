'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
        if (App.Module.Monitoring.Collection === undefined) App.Module.Monitoring.Collection = {};
        if (App.Module.Monitoring.Collection.Pageable === undefined) App.Module.Monitoring.Collection.Pageable = {};
        App.Module.Monitoring.Collection.Pageable.WorkSites = App.Collection.Pageable.Pageable.extend({
            model: App.Module.Monitoring.Model.WorkSite,
            url: "/monitoring/work-site/list/pageable"
        });
    });
});