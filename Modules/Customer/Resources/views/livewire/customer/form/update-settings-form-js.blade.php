<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Customer === undefined) App.Module.Customer = {};
            if (App.Module.Customer.View === undefined) App.Module.Customer.View = {};
            if (App.Module.Customer.View.Customer === undefined) App.Module.Customer.View.Customer = {};
            App.Module.Customer.View.Customer.Settings = App.View.View.extend({
                model: new App.Module.Customer.Model.Customer(),
                el: '#customerSettingsForm',
                attributes: {
                    id: 0,
                    elAlert: '#customer-settings-form-alert-success',
                    isModal: false,
                    isEdit: false,
                    parent: null
                },
                data: {
                    alert: null,
                    alreadySave: false,
                    alreadyRender: false
                },
                events: {
                    'change .form-input': 'changeField',
                    'change .form-textarea': 'changeField',
                    'click .toggle-checkbox': 'changeToggleCheckbox'
                },

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname[pathname.length-1] !== '') {
                        me.attributes.isEdit = (pathname[pathname.length-1] === 'edit');
                    } else {
                        me.attributes.isEdit = false;
                    }
                    me.attributes.id = (me.attributes.id === undefined) ? 0 : me.attributes.id;
                    me.setId(me.attributes.id);
                },

                afterRender: function () {
                    var me = this;

                    //Après le remplissage du formulaire
                    Livewire.on('customer-settings-form-mount', hydrate => {
                        if (me.model !== null) me.model.remove();
                        me.model = new App.Module.Customer.Model.Customer(hydrate);
                        if (hydrate !== null) {
                            if (me.attributes.parent !== null && me.attributes.parent !== undefined) {
                                delete hydrate.id;
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
                    Livewire.on('customer-settings-form-validate', request => {
                        if (me.attributes.parent === null || me.attributes.parent === undefined) {
                            me.saveModel();
                        } else {
                            me.attributes.parent.data.stateSettings = true;
                            me.attributes.parent.saveModel();
                        }
                    })
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
                    Livewire.emit('customer-settings-form-update', me.attributes.id, me.attributes.isModal, me.attributes.isEdit);
                },

                formSubmit: function () {
                    Livewire.emit('customer-submit-form');
                },

                triggerSuccess: function (result) {
                    Livewire.emit('customer-settings-form-success', result);
                },

                triggerErrors: function (errors) {
                    Livewire.emit('customer-settings-form-error', errors);
                },

                saveModel: function () {
                    console.log('là');
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
                                        title: "<?php echo __("customer::customer.Customer"); ?> - "
                                    }
                                });
                            }
                            console.log(r.data);
                            me.triggerSuccess(r.data);
                            me.data.alreadySave = false;
                        })
                        .fail(function (r) {
                            var errors = r.responseJSON.errors;
                            me.triggerErrors(errors)
                        });
                }
            });

            // new App.Module.Customer.View.Customer.Settings();
        });
    });
</script>