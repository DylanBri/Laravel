'use strict';

App.Api = {
    ajax: function (url, data, method) {
        return Backbone.ajax({
            'url' : url,
            'method' : method,
            'data' : data,
            'dataType' : 'json',
            beforeSend: function(request){
                if (localStorage.getItem('token') != null) {
                    request.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
                }
            },
        });
    },

    get: function (url, data) {
        return this.ajax(url, data, 'get')
    },

    post: function (url, data) {
        return this.ajax(url, data, 'post')
    },

    patch: function (url, data) {
        return this.ajax(url, data, 'patch')
    },

    put: function (url, data) {
        return this.ajax(url, data, 'put')
    },

    delete: function (url, data) {
        return this.ajax(url, data, 'delete')
    },
};