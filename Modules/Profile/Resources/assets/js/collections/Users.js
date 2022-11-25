'use strict';

document.addEventListener('DOMContentLoaded', e => {
    $(document).on('app.ready', function () {
        if (App.Module.Profile === undefined) App.Module.Profile = {};
        if (App.Module.Profile.Collection === undefined) App.Module.Profile.Collection = {};
        App.Module.Profile.Collection.Users = App.Collection.Collection.extend({
            model: App.Module.Profile.Model.User,
            url: "/user/list"
        });
    });
});