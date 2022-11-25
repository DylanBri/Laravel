'use strict';

if (App.Collection.Pageable === undefined) App.Collection.Pageable = {};
App.Collection.Pageable.Users = App.Collection.Pageable.Pageable.extend({
    model: App.Model.User,
    url: "/user/list/pageable"
});