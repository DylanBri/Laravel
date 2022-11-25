<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
            if (App.Module.Monitoring.View === undefined) App.Module.Monitoring.View = {};
            if (App.Module.Monitoring.View.WorkSite === undefined) App.Module.Monitoring.View.WorkSite = {};
            App.Module.Monitoring.View.WorkSite.Settings = App.View.View.extend({
                model: new App.Module.Monitoring.Model.WorkSite(),
                el: '#workSiteSettingsForm',
                attributes: {
                    id: 0,
                    customerId: 0,
                    elAlert: '#work-site-settings-form-alert-success',
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
                    me.setId(me.attributes.id, me.attributes.customerId);
                },

                afterRender: function () {
                    var me = this;

                    me.renderAutocompleteCustomer();

                    //Après le remplissage du formulaire
                    Livewire.on('work-site-settings-form-mount', hydrate => {
                        if (me.model !== null) me.model.remove();
                        me.model = new App.Module.Monitoring.Model.WorkSite(hydrate);
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
                    Livewire.on('work-site-settings-form-validate', request => {
                        if (me.attributes.parent === null || me.attributes.parent === undefined) {
                            me.saveModel();
                        } else {
                            me.attributes.parent.data.stateSettings = true;
                            me.attributes.parent.saveModel();
                        }
                    })
                },

                renderAutocompleteCustomer: function () {
                    var me = this, elId = 'customer_name', elHidden = 'customer_id';
                    me.autocomplete('#' + elId, '/customer/list', {
                        minChars: 0,
                        transformResult: function(response) {
                            return {
                                suggestions: $.map(response, function (dataItem) {
                                    return {
                                        value: dataItem.name,
                                        data: dataItem.id
                                    };
                                })
                            };
                        },
                        onSelect: function (suggestion) {
                            // Already hidden in first
                            me.$el.find('#' + elHidden).val(suggestion.data);
                            me.changeFieldValue(elHidden, suggestion.data);
                            me.changeFieldValue(elId, suggestion.value);
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

                setId: function (id, customerId) {
                    var me = this;
                    me.attributes.id = (id === null || id === undefined)? 0 : id;
                    me.attributes.customerId = (customerId === null || customerId === undefined)? 0 : customerId;
                    if (!me.data.alreadyRender) {
                        me.data.alreadyRender = true;
                        me.render();
                    }

                    //Mise à jour des infos
                    Livewire.emit('work-site-settings-form-update', me.attributes.customerId, me.attributes.id, me.attributes.isModal, me.attributes.isEdit);
                },

                formSubmit: function () {
                    //Livewire.emit('submitForm');
                    Livewire.emit('work-site-submit-form');
                },

                triggerSuccess: function (result) {
                    Livewire.emit('work-site-settings-form-success', result);
                },

                triggerErrors: function (errors) {
                    Livewire.emit('work-site-settings-form-error', errors);
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
                                        title: "<?php echo __("monitoring::monitoring.WorkSite"); ?> - "
                                    }
                                });
                            }
                            me.triggerSuccess(r.data);
                            me.data.alreadySave = false;
                        })
                        .fail(function (r) {
                            var errors = r.responseJSON.errors;
                            me.triggerErrors(errors)
                        });
                }
            });

            // new App.Module.Monitoring.View.WorkSite.Settings();
        });
    });
</script>