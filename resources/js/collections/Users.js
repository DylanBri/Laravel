'use strict';

App.Collection.Users = App.Collection.Collection.extend({
    model: App.Model.User,
    url: "/user/list"
});