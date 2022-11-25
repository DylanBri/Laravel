'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
        if (App.Module.Monitoring.Collection === undefined) App.Module.Monitoring.Collection = {};
        App.Module.Monitoring.Collection.Lots = App.Collection.Collection.extend({
            model: App.Module.Monitoring.Model.Lot,
            url: "/monitoring/lot/list"
        });
    });
});