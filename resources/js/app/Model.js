'use strict';

App.Model.Model = window.Backbone.Model;
_.extend(App.Model.Model.prototype, window.Backbone.Events, {
    sync: function (method, model, options) {
        options.beforeSend = function (request) {
            if (localStorage.getItem('token') != null) {
                request.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
            }
        };
        // request.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
        return window.Backbone.sync(method, model, options);
    },

    setWithVerif: function (property, value) {
        if (this.get(property) !== value) {
            this.set(property, value)
        }

        return this;
    },

    saveModel: function (callback) {
        var me = this,
            callback = (callback === undefined) ? {} : callback,
            done = function (r) {
                callback.hasOwnProperty('done') ? callback.done(r) : true
            };
        if (me.hasChanged()) {
            return me.save(me.changed)
                .done(function (r) {
                    done(r);
                    me.changed = {};
                })
                .fail(function (r) {
                    callback.hasOwnProperty('fail') ? callback.fail(r) : true
                })
                .always(function (r) {
                    callback.hasOwnProperty('always') ? callback.always(r) : true
                });
        } else {
            done();
        }
    },

    getPrevious: function (property) {
        return this.previousAttributes()[property];
    },
    
    remove: function () {
        this.set(this.idAttribute, null);
        this.destroy();
    }
})
;