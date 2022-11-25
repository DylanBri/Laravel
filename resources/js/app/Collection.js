'use strict';

App.Collection.Collection = window.Backbone.Collection;
_.extend(App.Collection.Collection.prototype, window.Backbone.Events, {
    model: App.Model.Model,

    state: {
        filters: []
    },

    sync: function (method, model, options) {
        options.beforeSend = function (request) {
            if (localStorage.getItem('token') != null) {
                request.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
            }
        };
        options.data = {
            'filters' : this.state.filters
        };
        return window.Backbone.sync(method, model, options);
    },

    clearFilters: function () {
        var me = this;
        me.state.filters = [];
        return this;
    },

    setFilters: function (newFilter) {
        var me = this;

        $.each(newFilter, function (ind, newFil) {
            $.each(me.state.filters, function (index, filter) {
                if (filter.field === newFil.field && filter.type === newFil.type) {
                    me.state.filters.splice(index);
                }
            });
            me.state.filters.push(newFil);
        });

        return this;
    }
});