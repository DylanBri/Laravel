'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Log === undefined) App.Module.Log = {};
        if (App.Module.Log.Collection === undefined) App.Module.Log.Collection = {};
        if (App.Module.Log.Collection.Pageable === undefined) App.Module.Log.Collection.Pageable = {};
        App.Module.Log.Collection.Pageable.LogQueues = App.Collection.Pageable.Pageable.extend({
            model: App.Module.Log.Model.LogQueue,
            url: "/logQueue/list/pageable"
        });
    });
});