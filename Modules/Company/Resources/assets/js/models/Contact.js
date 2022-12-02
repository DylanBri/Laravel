'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Company === undefined) App.Module.Company = {};
        if (App.Module.Company.Model === undefined) App.Module.Company.Model = {};
        App.Module.Company.Model.Contact = App.Model.Model.extend({
            defaults: {
                id: null,
                'client_id' : '',
                'company_id' : '',
                'company_name': '',
                'firstname' : '',
                'lastname' : '',
                'phone' : '',
                'email' : '',
                'enabled' : 1,
                'suppressed' : 0
            },
            urlRoot: "/company/contact",
            parse: function (resp) {
                // TODO
                // resp.category = new App.Model.UserCategory(resp.userCategory);
                return resp;
            }
        });
    });
});