<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
            if (App.Module.Monitoring.View === undefined) App.Module.Monitoring.View = {};
            if (App.Module.Monitoring.View.WorkSiteLotCompany === undefined) App.Module.Monitoring.View.WorkSiteLotCompany = {};
            App.Module.Monitoring.View.WorkSiteLotCompany.Settings = App.View.View.extend({
                model: new App.Module.Monitoring.Model.WorkSiteLotCompany(),
                el: '#workSiteLotCompanySettingsForm',
                attributes: {
                    id: 0,
                    isType: 0,
                    monitoringId: 0,
                    workSiteId: 0,
                    elAlert: '#work-site-lot-company-settings-form-alert-success',
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
                    me.attributes.isType = (me.attributes.isType === undefined) ? 0 : me.attributes.isType;
                    me.setId(me.attributes.id, me.attributes.workSiteId, me.attributes.isType);
                },

                afterRender: function () {
                    var me = this;

                    me.renderAutocompleteLot();
                    me.renderAutocompleteWorkSite();
                    me.renderAutocompleteCompany();

                    //Après le remplissage du formulaire
                    Livewire.on('work-site-lot-company-settings-form-mount', hydrate => {
                        if (me.model !== null) me.model.remove();
                        me.model = new App.Module.Monitoring.Model.WorkSiteLotCompany(hydrate);
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
                    Livewire.on('work-site-lot-company-settings-form-validate', request => {
                        if (me.attributes.parent === null || me.attributes.parent === undefined) {
                            me.saveModel();
                        } else {
                            me.attributes.parent.data.stateSettings = true;
                            me.attributes.parent.saveModel();
                        }
                    })
                },

                renderAutocompleteLot: function () {
                    var me = this, elId = 'lot_name', elHidden = 'lot_id';
                    me.autocomplete('#' + elId, '/monitoring/lot/list', {
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
                            me.$el.find('#' + elHidden).val(suggestion.data);
                            me.changeFieldValue(elHidden, suggestion.data);
                            me.changeFieldValue(elId, suggestion.value);
                        }
                    });
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

                setId: function (id, monitoringId, workSiteId, isType) {
                    var me = this;
                    me.attributes.workSiteId = (workSiteId === null || workSiteId === undefined)? 0 : workSiteId;
                    me.attributes.id = (id === null || id === undefined)? 0 : id;
                    me.attributes.isType = (isType === null || isType === undefined)? 0 : isType;
                    me.attributes.monitoringId = (monitoringId === null || monitoringId === undefined)? 0 : monitoringId;
                    console.log('upate > setId type : ' + me.attributes.isType);
                    if (!me.data.alreadyRender) {
                        me.data.alreadyRender = true;
                        me.render();
                    }

                    //Mise à jour des infos
                    Livewire.emit('work-site-lot-company-settings-form-update', me.attributes.id, me.attributes.monitoringId, me.attributes.isType, me.attributes.workSiteId, me.attributes.isModal, me.attributes.isEdit);
                },

                formSubmit: function () {
                    Livewire.emit('work-site-lot-company-submit-form');
                },

                triggerSuccess: function (result) {
                    Livewire.emit('work-site-lot-company-settings-form-success', result);
                },

                triggerErrors: function (errors) {
                    Livewire.emit('work-site-lot-company-settings-form-error', errors);
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
                                        title: "<?php echo __("monitoring::monitoring.WorkSiteLotCompany"); ?> - "
                                    }
                                });
                            }
                            me.triggerSuccess(r);
                            me.data.alreadySave = false;
                        })
                        .fail(function (r) {
                            var errors = r.responseJSON.errors;
                            me.triggerErrors(errors)
                        });
                }
            });
        });
    });
</script>