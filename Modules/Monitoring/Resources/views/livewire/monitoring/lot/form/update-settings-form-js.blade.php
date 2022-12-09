<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
            if (App.Module.Monitoring.View === undefined) App.Module.Monitoring.View = {};
            if (App.Module.Monitoring.View.Lot === undefined) App.Module.Monitoring.View.Lot = {};
            App.Module.Monitoring.View.Lot.Settings = App.View.View.extend({
                model: new App.Module.Monitoring.Model.Lot(),
                el: '#lotSettingsForm',
                attributes: {
                    id: 0,
                    elAlert: '#lot-settings-form-alert-success',
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
                    'change .form-textarea': 'changeField',
                    'click .toggle-checkbox': 'changeToggleCheckbox'
                },

                afterInitialize: function () {
                    var me = this;
                    me.attributes.id = (me.attributes.id === undefined) ? 0 : me.attributes.id;
                    me.setId(me.attributes.id);
                },

                afterRender: function () {
                    var me = this;

                    me.renderAutocompleteCompany();

                    //Après le remplissage du formulaire
                    Livewire.on('lot-settings-form-mount', hydrate => {
                        if (me.model !== null) me.model.remove();
                        me.model = new App.Module.Monitoring.Model.Lot(hydrate);
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
                    Livewire.on('lot-settings-form-validate', request => {
                        if (me.attributes.parent === null || me.attributes.parent === undefined) {
                            me.saveModel();
                        } else {
                            me.attributes.parent.data.stateSettings = true;
                            me.attributes.parent.saveModel();
                        }
                    })
                },

                renderAutocompleteCompany: function () {
                    var me = this, elId = 'company_name', elHidden = 'company_id';
                    me.autocomplete('#' + elId, '/company/list', {
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

                renderAutocompleteLot: function () {
                    var me = this, elId = 'company_name', elHidden = 'company_id';
                    me.autocomplete('#' + elId, '/company/list', {
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

                renderAutocompleteWorkSite: function () {
                    var me = this, elId = 'company_name', elHidden = 'company_id';
                    me.autocomplete('#' + elId, '/company/list', {
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

                setId: function (id) {
                    var me = this;
                    me.attributes.id = (id === null || id === undefined)? 0 : id;
                    if (!me.data.alreadyRender) {
                        me.data.alreadyRender = true;
                        me.render();
                    }

                    //Mise à jour des infos
                    Livewire.emit('lot-settings-form-update', me.attributes.id, me.attributes.isModal);
                },

                formSubmit: function () {
                    Livewire.emit('submitForm');
                },

                triggerSuccess: function (result) {
                    Livewire.emit('lot-settings-form-success', result);
                },

                triggerErrors: function (errors) {
                    Livewire.emit('lot-settings-form-error', errors);
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
                                        title: "<?php echo __("monitoring::monitoring.Lot"); ?> - "
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

            // new App.Module.Monitoring.View.Lot.Settings();
        });
    });
</script>