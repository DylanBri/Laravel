<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Company === undefined) App.Module.Company = {};
            if (App.Module.Company.View === undefined) App.Module.Company.View = {};
            if (App.Module.Company.View.Payment === undefined) App.Module.Company.View.Payment = {};
            App.Module.Company.View.Payment.Settings = App.View.View.extend({
                model: new App.Module.Company.Model.Payment(),
                el: '#paymentSettingsForm',
                attributes: {
                    id: 0,
                    elAlert: '#payment-settings-form-alert-success',
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
                    
                    me.renderDatePicker('payment_request_date');
                    me.renderDatePicker('payment_date');

                    me.renderAutocompleteCompany();
                    me.renderAutocompleteCustomer();
                    me.renderAutocompleteMonitoring();
                    me.renderAutocompleteWorkSite();

                    //Après le remplissage du formulaire
                    Livewire.on('payment-settings-form-mount', hydrate => {
                        me.$el.find("#payment_request_date_show").val(moment(me.$el.find("#payment_request_date").val()).format('L'));
                        me.$el.find("#payment_date_show").val(moment(me.$el.find("#payment_date").val()).format('L'));

                        if (me.model !== null) me.model.remove();
                        console.log(hydrate);
                        me.model = new App.Module.Company.Model.Payment(hydrate);
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
                    Livewire.on('payment-settings-form-validate', request => {
                        console.log('request', request);
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

                renderAutocompleteMonitoring: function () {
                    var me = this, elId = 'monitoring_name', elHidden = 'monitoring_id';
                    me.autocomplete('#' + elId, '/monitoring/list', {
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
                            console.log(suggestion);
                            me.$el.find('#' + elHidden).val(suggestion.data);
                            me.changeFieldValue(elHidden, suggestion.data);
                            me.changeFieldValue(elId, suggestion.value);
                        }
                    });
                },

                renderAutocompleteWorkSite: function () {
                    var me = this, elId = 'work_site_name', elHidden = 'work_site_id';
                    me.autocomplete('#' + elId, '/monitoring/work-site/list', {
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
                            console.log(suggestion);
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
                    Livewire.emit('payment-settings-form-update', me.attributes.id, me.attributes.isModal);
                },

                formSubmit: function () {
                    Livewire.emit('submitForm');
                },

                triggerSuccess: function (result) {
                    Livewire.emit('payment-settings-form-success', result);
                },

                triggerErrors: function (errors) {
                    Livewire.emit('payment-settings-form-error', errors);
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
                                        title: "<?php echo __("company::company.Payment"); ?> - "
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

            // new App.Module.Company.View.Payment.Settings();
        });
    });
</script>