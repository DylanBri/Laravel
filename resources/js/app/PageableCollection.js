'use strict';

Backbone['PageableCollection'] = window.PageableCollection;
if (App.Collection.Pageable === undefined) App.Collection.Pageable = {};
App.Collection.Pageable.Pageable = Backbone.PageableCollection;
_.extend(App.Collection.Pageable.Pageable.prototype, window.Backbone.Events, {
    model: App.Model.Model,
    withProfile: false,
    sync: function (method, model, options) {
        options.beforeSend = function (request) {
            if (localStorage.getItem('token') != null) {
                request.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
            }
        };
        options.data.filters = this.state.filters;
        return window.Backbone.sync(method, model, options);
    },

    state: {
        firstPage: 1,
        lastPage: null,
        currentPage: null,
        pageSize: 20,
        totalPages: null,
        totalRecords: null,
        sortKey: null,
        order: -1,
        filters: []
    },

    mode: "server",

    queryParams: {
        currentPage: "current_page",
        pageSize: "per_page",
        totalPages: null,
        totalRecords: "total",
        sortKey: "sort",
        order: "order",
        directions: {
            "-1": "asc",
            "1": "desc"
        }
    },

    parseState: function (resp, queryParams, state, options) {
        return {
            firstPage: 1,
            lastPage: parseInt(resp.last_page),
            currentPage: parseInt(resp.current_page),
            pageSize: parseInt(resp.per_page),
            totalPages: Math.round(parseInt(resp.total) / parseInt(resp.per_page)),
            totalRecords: parseInt(resp.total),
            sortKey: null,
            order: -1
        };
    },

    parseRecords: function(resp) {
        return resp.data;
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
    },

});