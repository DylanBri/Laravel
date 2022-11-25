'use strict';

App.Collection.Clients = App.Collection.Collection.extend({
    model: App.Model.Client,
    url: "/client/list"
});