'use strict';

document.addEventListener('DOMContentLoaded', e => {
    $(document).on('app.ready', function () {
        if (App.Module.Log === undefined) App.Module.Log = {};
        if (App.Module.Log.Model === undefined) App.Module.Log.Model = {};
        App.Module.Log.Model.LogQueue = App.Model.Model.extend({
            defaults: {
                'name': '',
                'action': '',
                'data': '',
                'log': '',
                'state': 0
            },
            urlRoot: "/logQueue",
            parse: function (resp) {
                // TODO
                // resp.client = new App.Model.Client(resp.client);
                return resp;
            }
        });
    });
});