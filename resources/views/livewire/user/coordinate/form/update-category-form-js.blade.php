<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        if (App.View.User === undefined) App.View.User = {};
        if (App.View.User.Coordinate === undefined) App.View.User.Coordinate = {};
        App.View.User.Coordinate.Category = App.View.View.extend({
            model: new App.Model.User.Coordinate(),
            el: '#userCategoryForm',
            attributes: {
                id: 0,
                elAlert: '#user-category-form-alert-success',
                isModal: false,
                parent: null,
                isAuth: true
            },
            data: {
                categories: [],
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
                me.renderAutocompleteCategory();

                //Après le remplissage du formulaire
                Livewire.on('category-form-mount', hydrate => {
                    if (me.model !== null) me.model.remove();
                    me.model = new App.Model.User.Coordinate(hydrate);
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
                Livewire.on('category-form-validate', request => {
                    if (me.attributes.parent === null || me.attributes.parent === undefined) {
                        me.saveModel();
                    } else {
                        me.attributes.parent.data.stateSettings = true;
                        me.attributes.parent.saveModel();
                    }
                })
            },

            renderAutocompleteCategory: function () {
                var me = this, elId = 'categoryName', elHidden = 'categoryId';
                me.autocomplete('#' + elId, '/user/category/list', {
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
                        me.model.setWithVerif('category_id', suggestion.data);
                    }
                });
            },

            setId: function (id) {
                var me = this;
                me.attributes.id = (id === null || id === undefined)? 0 : id;

                if (!me.data.alreadyRender) {
                    me.data.alreadyRender = true;
                    me.render();
                }

                //Mise à jour des infos
                Livewire.emit('category-form-update', me.attributes.id, me.attributes.isModal);
            },

            formSubmit: function () {
                Livewire.emit('submitForm');
            },

            saveModel: function () {
                var me = this;
                if (me.data.alreadySave) return;
                me.alreadySave = true;
                me.$el.find('input[type=submit]').prop('disabled', true);

                me.model.save({'_token': me.$el.find('[name=_token]').val()})
                    .done(function (r) {
                        Livewire.emit('category-form-success', r.data);
                        me.data.alreadySave = false;
                        window.location.href = '/user/profile';
                    })
                    .fail(function (r) {
                        var errors = r.responseJSON.errors;
                        Livewire.emit('category-form-error', errors);
                    });
            }
        });
        new App.View.User.Coordinate.Category();
    });
</script>