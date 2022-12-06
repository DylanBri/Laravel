<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Company === undefined) App.Module.Company = {};
            if (App.Module.Company.View === undefined) App.Module.Company.View = {};
            if (App.Module.Company.View.Contact === undefined) App.Module.Company.View.Contact = {};
            App.Module.Company.View.Contact.Settings = App.View.View.extend({
                model: new App.Module.Company.Model.Contact(),
                el: '#contactSettingsForm',
                attributes: {
                    companyId: 0,
                    id: 0,
                    elAlert: '#contact-settings-form-alert-success',
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
                    me.setId(me.attributes.id, me.attributes.companyId);
                },

                afterRender: function () {
                    var me = this;

                    me.renderAutocompleteCompany();

                    //Après le remplissage du formulaire
                    Livewire.on('contact-settings-form-mount', hydrate => {
                        if (me.model !== null) me.model.remove();
                        me.model = new App.Module.Company.Model.Contact(hydrate);
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
                    Livewire.on('contact-settings-form-validate', request => {
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

                changeField: function (e) {
                    var me = this;
                    me.changeFieldValue(e.currentTarget.id, $(e.currentTarget).val());
                },

                changeToggleCheckbox: function (e) {
                    var me = this;
                    me.changeFieldValue(e.currentTarget.id, e.currentTarget.checked);
                },

                setId: function (id, companyId) {
                    var me = this;
                    me.attributes.id = (id === null || id === undefined)? 0 : id;
                    me.attributes.companyId = (companyId === null || companyId === undefined)? 0 : companyId;
                    if (!me.data.alreadyRender) {
                        me.data.alreadyRender = true;
                        me.render();
                    }
                    console.log(companyId);

                    //Mise à jour des infos
                    Livewire.emit('contact-settings-form-update', me.attributes.companyId, me.attributes.id, me.attributes.isModal);
                },

                formSubmit: function () {
                    Livewire.emit('contactSubmitForm');
                },

                triggerSuccess: function (result) {
                    Livewire.emit('contact-settings-form-success', result);
                },

                triggerErrors: function (errors) {
                    Livewire.emit('contact-settings-form-error', errors);
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
                                        title: "<?php echo __("company::company.Contact"); ?> - "
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

            // new App.Module.Company.View.Contact.Settings();
        });
    });
</script>