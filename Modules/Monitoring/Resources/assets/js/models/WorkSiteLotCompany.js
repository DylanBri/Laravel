'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
        if (App.Module.Monitoring.Model === undefined) App.Module.Monitoring.Model = {};
        App.Module.Monitoring.Model.WorkSiteLotCompany = App.Model.Model.extend({
            defaults: {
                id: null,
                'client_id': '',
                'company_id': '',
                'company_name': '',
                'lot_id': '',
                'lot_name': '',
                'work_site_id': '',
                'work_site_name': '',
                //'customer_id': '',
                'monitoring_id': '',
                'name': '',
                'is_type': 0,
                'amount_ttc': 0,
                'cumul_payment': 0,
                'cumul_monitoring': 0,
            },
            urlRoot: "/monitoring/work-site-lot-company",
            parse: function (resp) {
                // TODO
                // resp.category = new App.Model.UserCategory(resp.userCategory);
                return resp;
            }
        });
    });
});