'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
        if (App.Module.Monitoring.Model === undefined) App.Module.Monitoring.Model = {};
        App.Module.Monitoring.Model.Lot = App.Model.Model.extend({
            defaults: {
                id: null,
                'client_id': '',
                'name': '',
                'description': '',
            },
            urlRoot: "/monitoring/lot",
            parse: function (resp) {
                // TODO
                // resp.category = new App.Model.UserCategory(resp.userCategory);
                return resp;
            }
        });
    });
});