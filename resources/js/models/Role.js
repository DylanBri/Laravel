'use strict';

App.Model.Role = App.Model.Model.extend({
    defaults: {
        id: null,
        name: ""
    },
    urlRoot: "/role",
    parse: function (resp) {
        // TODO
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
    }
});