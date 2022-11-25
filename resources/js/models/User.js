'use strict';

App.Model.User = App.Model.Model.extend({
    defaults: {
        id: null,
        name: "",
        email: "",
        email_verified_at: "",
        password: "",
        two_factor_secret: "",
        two_factor_recovery_codes: "",
        remember_token: "",
        current_team_id: "",
        profile_photo_path: ""
    },
    urlRoot: "/user",
    parse: function (resp) {
        // TODO
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
    }
});