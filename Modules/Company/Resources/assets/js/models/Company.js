'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    $(document).on('app.ready', function () {
        if (App.Module.Company === undefined) App.Module.Company = {};
        if (App.Module.Company.Model === undefined) App.Module.Company.Model = {};
        App.Module.Company.Model.Company = App.Model.Model.extend({
            defaults: {
                id: null,
                'address_id': 0,
                'title' : '', 
                'name': '',
                'address_1': '',
                'address_2': '',
                'zip_code': '',
                'city': '',
                'country': 'FR',
                'phone': '',
                'supervisor': '',
                'siret': '',
                'classification': '',
                'code_ape': '',
                'email': '',
                'insurance': '',
                'client_id': 0,
                'enabled': 1,
                'suppressed': 0
            },
            urlRoot: "/company",
            parse: function (resp) {
                // TODO
                // resp.category = new App.Model.UserCategory(resp.userCategory);
                return resp;
            }
        });
    });
});