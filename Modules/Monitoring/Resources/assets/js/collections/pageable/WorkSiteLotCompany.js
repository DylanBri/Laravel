'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
        if (App.Module.Monitoring.Collection === undefined) App.Module.Monitoring.Collection = {};
        if (App.Module.Monitoring.Collection.Pageable === undefined) App.Module.Monitoring.Collection.Pageable = {};
        App.Module.Monitoring.Collection.Pageable.WorkSiteLotCompany = App.Collection.Pageable.Pageable.extend({
            model: App.Module.Monitoring.Model.WorkSiteLotCompany,
            url: "/monitoring/work-site-lot-company/list/pageable"
        });
    });
});