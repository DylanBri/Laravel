'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Customer === undefined) App.Module.Customer = {};
        if (App.Module.Customer.Model === undefined) App.Module.Customer.Model = {};
        App.Module.Customer.Model.Customer = App.Model.Model.extend({
            defaults: {
                id: null,
                'address_id': 0,
                'client_id': 0,
                'address_1': '',
                'address_2': '',
                'zip_code': '',
                'city': '',
                'country': 'FR',
                'name': '',
                'gender': '',
                'phone': '',
                'fax': ''
            },
            urlRoot: "/customer",
            parse: function (resp) {
                // TODO
                // resp.category = new App.Model.UserCategory(resp.userCategory);
                return resp;
            }
        });
    });
});