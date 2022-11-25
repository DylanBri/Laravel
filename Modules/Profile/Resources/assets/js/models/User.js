'use strict';

document.addEventListener('DOMContentLoaded', e => {
    $(document).on('app.ready', function () {
        if (App.Module.Profile === undefined) App.Module.Profile = {};
        if (App.Module.Profile.Model === undefined) App.Module.Profile.Model = {};
        App.Module.Profile.Model.User = App.Model.Model.extend({
            defaults: {
                id: null,
                quality: "",
                name: "",
                address: "",
                address2: "",
                zip_code: "",
                city: "",
                region: "",
                country: "",
                email: "",
                phone: "",
                mobile: "",
                password: "",
                user_id: 0,
                category_id: 0,
                enabled: true,
                suppressed: false,
                user: null,
                category: null
            },
            urlRoot: "/user",
            parse: function (resp) {
                // TODO
                // resp.user = new App.Model.User(resp.user);
                // resp.category = new App.Model.UserCategory(resp.userCategory);
                return resp;
            }
        });
    });
});