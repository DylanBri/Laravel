<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        if (App.Module.Profile === undefined) App.Module.Profile = {};
        if (App.Module.Profile.View === undefined) App.Module.Profile.View = {};
        App.Module.Profile.View.Address = App.View.View.extend({
            model: new App.Model.User.Coordinate(),
            el: '#userAddressForm',
            attributes: {
                id: 0,
                elAlert: '#user-address-form-alert-success',
                isModal: false,
                parent: null
            },
            data: {
                modal: {},
                alert: null,
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

                me.renderAutocompleteQuality();
                me.renderAutocompleteCountry();

                //Après le remplissage du formulaire
                Livewire.on('user-address-form-mount', hydrate => {
                    if (me.model !== null) me.model.remove();
                    me.model = new App.Model.User.Coordinate(hydrate);
                    if (hydrate !== null) {
                        if (me.attributes.parent !== null && me.attributes.parent !== undefined) {
                            me.attributes.parent.hydrateModel(hydrate)
                        }
                    }
                    if (me.attributes.parent !== null && me.attributes.parent !== undefined &&
                        me.attributes.parent.data.modal.$el.find('.modal-container').hasClass('hidden')) {
                        me.attributes.parent.data.stateAddress = true;
                        me.attributes.parent.toggleModal();
                    }
                });

                //Après la validation du formulaire
                Livewire.on('user-address-form-validate', request => {
                    if (me.attributes.parent === null || me.attributes.parent === undefined) {
                        me.saveModel();
                    } else {
                        me.attributes.parent.data.stateAddress = true;
                        me.attributes.parent.saveModel();
                    }
                });
            },

            renderAutocompleteQuality: function () {
                var me = this, elId = 'quality';
                me.$el.find('#' + elId).autocomplete({
                    minChars:0,
                    lookup: App.Constants.Qualities,
                    autoSelectFirst: true,
                    onSelect: function (suggestion) {
                        me.changeFieldValue(elId, suggestion.value);
                    }
                });
            },

            renderAutocompleteCountry: function () {
                var me = this, elId = 'country';
                me.$el.find('#' + elId).autocomplete({
                    minChars: 0,
                    lookup: App.Constants.Countries,
                    autoSelectFirst: true,
                    onSelect: function (suggestion) {
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
                Livewire.emit('user-address-form-update', me.attributes.id, me.attributes.isModal);
            },

            formSubmit: function () {
                Livewire.emit('submitForm');
            },

            triggerSuccess: function (result) {
                Livewire.emit('user-address-form-success', result);
            },

            triggerErrors: function (errors) {
                Livewire.emit('user-address-form-error', errors);
            },

            saveModel: function () {
                var me = this;
                me.$el.find('input[type=submit]').prop('disabled',true);

                me.model.save({'_token': me.$el.find('[name=_token]').val()})
                    .done(function (r) {
                        if (me.data.alert === null) {
                            me.data.alert = new App.View.Component.Alert({
                                el: me.attributes.elAlert,
                                attributes: {
                                    title: "<?php echo __("user-coordinates.Coordinates"); ?> - "
                                }
                            });
                        } else {
                            me.data.alert.closeAlert();
                            me.data.alert.render();
                        }
                        me.triggerSuccess(r.data)
                    })
                    .fail(function (r) {
                        var errors = r.responseJSON.errors;
                        me.triggerErrors(errors);
                    });
            }
        });

        // new App.Module.Profile.View.Address();
    });
</script>