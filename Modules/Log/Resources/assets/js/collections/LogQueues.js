'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Log === undefined) App.Module.Log = {};
        if (App.Module.Log.Collection === undefined) App.Module.Log.Collection = {};
        App.Module.Log.Collection.LogQueues = App.Collection.Collection.extend({
            model: App.Module.Log.Model.LogQueue,
            url: "/logQueue/list"
        });
    });
});