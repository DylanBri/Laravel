'use strict';

App.Model.Client = App.Model.Model.extend({
    defaults: {
        id: null,
        name: "",
        folder: "",
        address: "",
        address2: "",
        zip_code: "",
        city: "",
        country: "",
        email: "",
        phone: "",
        licence: "",
        licence_expired_at: "",
        socket_host: "",
        socket_port: "",
        enabled: true
    },
    urlRoot: "/client",
    parse: function (resp) {
        // TODO
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
    }
});