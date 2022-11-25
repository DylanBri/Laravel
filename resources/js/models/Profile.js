'use strict';

App.Model.Profile = App.Model.Model.extend({
    defaults: {
        client_id: 0,
        user_id: 0,
        role_id: 0,
        // holding_id: 0,
        // company_id: 0,
        // office_id: 0,
        is_first: 1,
        client: null,
        user: null,
        role: null
    },
    urlRoot: "/profile",
    parse: function (resp) {
        // TODO
        // resp.client = new App.Model.Client(resp.client);
        // resp.user = new App.Model.Client(resp.user);
        // resp.role = new App.Model.Client(resp.role);
        return resp;
    }
});