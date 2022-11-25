<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Profile === undefined) App.Module.Profile = {};
            if (App.Module.Profile.View === undefined) App.Module.Profile.View = {};
            App.Module.Profile.View.Settings = App.View.View.extend({
                model: new App.Module.Profile.Model.User(),
                el: '#userSettingsForm',
                attributes: {
                    id: 0,
                    elAlert: '#user-settings-form-alert-success',
                    isModal: false,
                    parent: null
                },
                data: {
                    alert: null,
                    alreadySave: false,
                    alreadyRender: false
                },
                events: {
                    'change .form-input': 'changeField',
                    'click .toggle-checkbox': 'changeToggleCheckbox'
                },

                afterInitialize: function () {
                    var me = this;
                    me.attributes.id = (me.attributes.id === undefined) ? 0 : me.attributes.id;
                    me.setId(me.attributes.id);
                },

                afterRender: function () {
                    var me = this;

                    //Après le remplissage du formulaire
                    Livewire.on('user-settings-form-mount', hydrate => {
                        if (me.model !== null) me.model.remove();
                        switch (me.attributes.type) {
                            case 'supadm':
                                me.model = new App.Module.Profile.Model.SuperAdmin(hydrate);
                                break;
                            case 'admin':
                                me.model = new App.Module.Profile.Model.Administrator(hydrate);
                                break;
                            case 'manager':
                                me.model = new App.Module.Profile.Model.Manager(hydrate);
                                break;
                            case 'user':
                                me.model = new App.Module.Profile.Model.User(hydrate);
                                break;
                            default:
                        }
                        if (hydrate !== null) {
                            if (me.attributes.parent !== null && me.attributes.parent !== undefined) {
                                me.attributes.parent.hydrateModel(hydrate, true)
                            }
                        }
                        if (me.attributes.parent !== null && me.attributes.parent !== undefined &&
                            me.attributes.parent.data.modal.$el.find('.modal-container').hasClass('hidden')) {
                            me.attributes.parent.data.stateSettings = true;
                            me.attributes.parent.toggleModal();
                        }
                    });

                    //Après la validation du formulaire
                    Livewire.on('user-settings-form-validate', request => {
                        if (me.attributes.parent === null || me.attributes.parent === undefined) {
                            me.saveModel();
                        } else {
                            me.attributes.parent.data.stateSettings = true;
                            me.attributes.parent.saveModel();
                        }
                    });
                },

                changeField: function (e) {
                    var me = this;
                    me.changeFieldValue(e.currentTarget.id, $(e.currentTarget).val());
                },

                changeToggleCheckbox: function (e) {
                    var me = this;
                    me.changeFieldValue(e.currentTarget.id, e.currentTarget.checked);
                },

                setId: function (id) {
                    var me = this;
                    me.attributes.id = (id === null || id === undefined)? 0 : id;
                    if (!me.data.alreadyRender) {
                        me.data.alreadyRender = true;
                        me.render();
                    }

                    //Mise à jour des infos
                    Livewire.emit('user-settings-form-update',me.attributes.id, me.attributes.type, me.attributes.isModal);
                },

                formSubmit: function () {
                    Livewire.emit('submitForm');
                },

                triggerSuccess: function (result) {
                    Livewire.emit('user-settings-form-success', result);
                },

                triggerErrors: function (errors) {
                    Livewire.emit('user-settings-form-error', errors);
                },

                saveModel: function () {
                    var me = this;
                    if (me.data.alreadySave) return;
                    me.data.alreadySave = true;
                    me.$el.find('input[type=submit]').prop('disabled', true);

                    me.model.save({'_token': me.$el.find('[name=_token]').val()})
                        .done(function (r) {
                            if (me.data.alert === null) {
                                me.data.alert = new App.View.Component.Alert({
                                    el: me.attributes.elAlert,
                                    attributes: {
                                        title: "<?php echo __("user.List"); ?> - "
                                    }
                                });
                            } else {
                                me.data.alert.closeAlert();
                                me.data.alert.render();
                            }
                            me.triggerSuccess(r.data);
                            me.data.alreadySave = false;
                        })
                        .fail(function (r) {
                            var errors = r.responseJSON.errors;
                            me.triggerErrors(errors);
                        });
                }
            });
            // new App.Module.Profile.View.Settings();
        });
    });
</script>