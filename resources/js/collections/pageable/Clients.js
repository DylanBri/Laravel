'use strict';

if (App.Collection.Pageable === undefined) App.Collection.Pageable = {};
App.Collection.Pageable.Clients = App.Collection.Pageable.Pageable.extend({
    model: App.Model.Client,
    url: "/client/list/pageable"
});