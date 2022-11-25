'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Company === undefined) App.Module.Company = {};
        if (App.Module.Company.Model === undefined) App.Module.Company.Model = {};
        App.Module.Company.Model.Payment = App.Model.Model.extend({
            defaults: {
                id: null,
                'client_id' : '',
                'customer_id' : '',
                'customer_name' : '',
                'company_id' : '',
                'company_name': '',
                'monitoring_id' : '',
                'monitoring_name': '',
                'name' : '',
                'payment_request_date' : '',
                'amount_ttc' : '',
                'is_staged' : 0,
                'is_done' : 0,
                'payment_date' : '',
                'payment_method' : '',
                'bank_name' : '',
                'enabled' : 1,
                'suppressed' : 0
            },
            urlRoot: "/company/payment",
            parse: function (resp) {
                // TODO
                // resp.category = new App.Model.UserCategory(resp.userCategory);
                return resp;
            }
        });
    });
});