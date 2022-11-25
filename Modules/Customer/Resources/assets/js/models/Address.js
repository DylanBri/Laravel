'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Customer === undefined) App.Module.Customer = {};
        if (App.Module.Customer.Model === undefined) App.Module.Customer.Model = {};
        App.Module.Customer.Model.Address = App.Model.Model.extend({
            defaults: {
                id: null,
                'address1': '',
                'address2': '',
                'zip_code': '',
                'city': '',
                //'country': 'FR'
            },
            urlRoot: "/customer/address",
            parse: function (resp) {
                // TODO
                // resp.category = new App.Model.UserCategory(resp.userCategory);
                return resp;
            }
        });
    });
});