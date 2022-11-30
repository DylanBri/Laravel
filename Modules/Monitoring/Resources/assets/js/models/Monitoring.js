'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
        if (App.Module.Monitoring.Model === undefined) App.Module.Monitoring.Model = {};
        App.Module.Monitoring.Model.Monitoring = App.Model.Model.extend({
            defaults: {
                id: null,
                'client_id': 0,
                'parent_id': null,
                /*
                'lot_id': '',
                'lot_name': '',
                'work_site_id': '',
                'work_site_name': '',
                */
                'work_site_lot_company_id': '',
                'name': '',
                'date': '',
                'lot_amount': 0,
                'total_market_amount': 0,
                'total_modify_market_amount': 0,
                'addition_market_amount': 0,
                'market_amount': 0,
                'modify_market_amount': 0,
                'tot_market_amount': 0,
                'rate_vat': 0,
                'deposit': 0,
                'account_percent': 0,
                'account': 0,
                'account_management_percent': 0,
                'account_management': 0,
                'bank_guarantee': 0,
                'retention_money_percent': 0,
                'retention_money': 0,
                'balance': 0,
                'doc_penality_percent': 0,
                'doc_penality': 0,
                'work_penality': 0,
                'progress' : 0,
                'balance_du' : 0,
                'deduction_previous_payment' : 0,
                'cumul_monitoring_previous' : 0,
                'amount_to_pay' : 0
            },
            urlRoot: "/monitoring",
            parse: function (resp) {
                // TODO
                // resp.category = new App.Model.UserCategory(resp.userCategory);
                return resp;
            }
        });
    });
});