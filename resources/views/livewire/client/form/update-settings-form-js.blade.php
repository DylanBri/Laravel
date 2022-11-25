<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.View.Client === undefined) App.View.Client = {};
            if (App.View.Client.Form === undefined) App.View.Client.Form = {};
            App.View.Client.Form.Settings = App.View.View.extend({
                model: new App.Model.Client(),
                el: '#clientSettingsForm',
                attributes: {
                    id: 0,
                    elAlert: '#client-settings-form-alert-success',
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

                    me.renderDatePicker('licence_expired_at');

                    //Après le remplissage du formulaire
                    Livewire.on('client-settings-form-mount', hydrate => {
                        me.$el.find("#licence_expired_at_show").val(moment(me.$el.find("#licence_expired_at").val()).format('L'));
                        if (me.model !== null) me.model.remove();
                        me.model = new App.Model.Client(hydrate);
                        if (hydrate !== null) {
                            if (me.attributes.parent !== null && me.attributes.parent !== undefined) {
                                me.attributes.parent.hydrateModel(hydrate)
                            }
                        }
                        if (me.attributes.parent !== null && me.attributes.parent !== undefined &&
                            me.attributes.parent.data.modal.$el.find('.modal-container').hasClass('hidden')) {
                            me.attributes.parent.data.stateSettings = true;
                            me.attributes.parent.toggleModal();
                        }
                    });

                    //Après la validation du formulaire
                    Livewire.on('client-settings-form-validate', request => {
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
                    Livewire.emit('client-settings-form-update', me.attributes.id, me.attributes.isModal);
                },

                formSubmit: function () {
                    Livewire.emit('submitForm');
                },

                triggerSuccess: function (result) {
                    Livewire.emit('client-settings-form-success', result);
                },

                triggerErrors: function (errors) {
                    Livewire.emit('client-settings-form-error', errors);
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
                                        title: "<?php echo __("client.List"); ?> - "
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
            // new App.View.Client.Form.Settings();
        });
    });
</script>