'use strict';


App.View.View = window.Backbone.View;
_.extend(App.View.View.prototype, window.Backbone.Events, {
    module: '',
    translatePath: '',
    tplPath: '',
    lng: moment.locale(),
    model: null,
    template: null,
    attributes: {
        parent: null
    },

    initialize: function () {
        var me = this;
        if (localStorage.getItem('token') !== null && !My.auth) {
            /*require(['model' + '/User', 'model' + '/Profile'], function () {
                My.auth = true;
                My.User = new App.Model.User(JSON.parse(localStorage.getItem('user')));
                My.Profile = new App.Model.Profile(JSON.parse(localStorage.getItem('profile')));
                me.loadTranslation();
            });*/
        } else if (localStorage.getItem('token') === null) {
            App.Api.get("/session/reset");
            me.loadTranslation();
        } else {
            me.loadTranslation();
        }
    },

    afterInitialize: function () {
        this.render();
    },

    render: function () {
        var me = this;
        if (me.template !== null) {
            me.$el.append(me.template);
        }
        me.afterRender();
    },

    afterRender: function () {
    },

    loadTranslation: function () {
        var me = this;
        if (me.translatePath !== '') {
            App.Api.get("/translate", {
                'path': ((me.module !== '') ? me.module + ':' : '') + me.translatePath,
                'lng': me.lng
            }).done(function (r) {
                i18next.addResources(me.lng, me.translatePath, JSON.parse(r.data));
                me.afterInitialize();
            });
        } else {
            me.afterInitialize();
        }
    },

    t: function () {
        var args = Array.from(arguments), path = args[0];
        if (arguments.length > 1) {
            args.shift();
            return sprintf(i18next.t(this.translatePath + ":" + path), args);
        } else {
            return i18next.t(this.translatePath + ":" + path);
        }
    },

    showAlert: function ($alert, classType, message) {
        $alert.html($('#alertTpl').html());
        $alert.find('.alert').addClass(classType);
        $alert.find('.alert-body').html(message);
        $alert.alert();
    },

    autocomplete: function (elId, url, callback) {
        var me = this;
        callback['serviceUrl'] = url;
        callback['ajaxSettings'] = {
            timeout: 10000
        };
        callback['dataType'] = "json";
        callback['autoSelectFirst'] = true;
        callback['triggerSelectOnValidInput'] = false;
        callback['width'] = "flex";
        return me.$el.find(elId).autocomplete(callback);
    },

    renderDatePicker: function (elId) {
        var me = this;
        $.datepicker.setDefaults($.datepicker.regional[moment.locale()]);
        me.$el.find("#" + elId + "_show").datepicker({
            changeMonth: true,
            changeYear: true,
            altField: "#" + elId,
            altFormat: "yy-mm-dd 00:00:00"
        });
        me.$el.find("#" + elId + "_show").on('change', function () {
            me.model.setWithVerif(elId, me.$el.find("#" + elId).val());
            Livewire.emit('field-updated', elId, me.$el.find("#" + elId).val());
            if (me.attributes.parent !== null && me.attributes.parent !== undefined) {
                me.attributes.parent.setModel(elId, me.$el.find("#" + elId).val());
            }
        });
    },

    changeFieldValue: function (elId, value) {
        var me = this;
        if (me.model !== undefined && me.model !== null) {
            me.model.setWithVerif(elId, value);
            Livewire.emit('field-updated', elId, me.$el.find("#" + elId).val());
        }
        if (me.attributes.parent !== null && me.attributes.parent !== undefined) {
            me.attributes.parent.setModel(elId, value);
        }
    },

    confirmDelete: function ($e) {
        /*window.bootbox.confirm({
            message: this.t('txtDelete'),
            buttons: {
                confirm: {
                    label: this.t("btnConfirm"),
                    className: 'btn-primary'
                },
                cancel: {
                    label: this.t("btnCancel"),
                    className: 'btn-default'
                }
            },
            callback: function (confirm) {
                if (!confirm) {
                    $e.currentTarget.checked = !$e.currentTarget.checked
                }
            }
        });*/
    },

    removeView: function () {
        var me = this;
        me.undelegateEvents();
        me.stopListening();
        me.$el.removeData().unbind();
        me.$el.empty();
    }
});
