'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
        if (App.Module.Monitoring.Model === undefined) App.Module.Monitoring.Model = {};
        App.Module.Monitoring.Model.WorkSite = App.Model.Model.extend({
            defaults: {
                id: null,
                'client_id': '',
                'customer_id': '',
                'customer_name': '',
                'name': '',
                'notes': '',
                'cumul': 0,
                'address1': '',
                'address2': '',
                'city': '',
                'zip_code': '',
            },
            urlRoot: "/monitoring/work-site",
            parse: function (resp) {
                // TODO
                // resp.category = new App.Model.UserCategory(resp.userCategory);
                return resp;
            }
        });
    });
});