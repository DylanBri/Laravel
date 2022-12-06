<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Company === undefined) App.Module.Company = {};
            if (App.Module.Company.View === undefined) App.Module.Company.View = {};
            if (App.Module.Company.View.Company === undefined) App.Module.Company.View.Company = {};
            App.Module.Company.View.Company.Settings = App.View.View.extend({
                model: new App.Module.Company.Model.Company(),
                el: '#companySettingsForm',
                attributes: {
                    id: 0,
                    elAlert: '#company-settings-form-alert-success',
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
                    Livewire.on('company-settings-form-mount', hydrate => {
                        if (me.model !== null) me.model.remove();
                        console.log(hydrate);
                        me.model = new App.Module.Company.Model.Company(hydrate);
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
                    Livewire.on('company-settings-form-validate', request => {
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
                    Livewire.emit('company-settings-form-update', me.attributes.id, me.attributes.isModal, me.attributes.isEdit);
                },

                formSubmit: function () {
                    Livewire.emit('submitForm');
                },

                triggerSuccess: function (result) {
                    Livewire.emit('company-settings-form-success', result);
                },

                triggerErrors: function (errors) {
                    Livewire.emit('company-settings-form-error', errors);
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
                                        title: "<?php echo __("company::company.Company"); ?> - "
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

            // new App.Module.Company.View.Company.Settings();
        });
    });
</script>