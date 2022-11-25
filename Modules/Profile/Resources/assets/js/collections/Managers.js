'use strict';

document.addEventListener('DOMContentLoaded', e => {
    $(document).on('app.ready', function () {
        if (App.Module.Profile === undefined) App.Module.Profile = {};
        if (App.Module.Profile.Collection === undefined) App.Module.Profile.Collection = {};
        App.Module.Profile.Collection.Managers = App.Collection.Collection.extend({
            model: App.Module.Profile.Model.Manager,
            url: "/manager/list"
        });
    });
});