'use strict';

document.addEventListener('DOMContentLoaded', e => {
    $(document).on('app.ready', function () {
        if (App.Module.Profile === undefined) App.Module.Profile = {};
        if (App.Module.Profile.Collection === undefined) App.Module.Profile.Collection = {};
        if (App.Module.Profile.Collection.Pageable === undefined) App.Module.Profile.Collection.Pageable = {};
        App.Module.Profile.Collection.Pageable.Users = App.Collection.Pageable.Pageable.extend({
            model: App.Module.Profile.Model.User,
            url: "/user/list/pageable"
        });
    });
});