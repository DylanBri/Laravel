<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Profile === undefined) App.Module.Profile = {};
            if (App.Module.Profile.View === undefined) App.Module.Profile.View = {};
            if (App.Module.Profile.View.User === undefined) App.Module.Profile.View.User = {};
            App.Module.Profile.View.User.MultiSelect = App.View.View.extend({
                el: "#multiselect-user-content",
                attributes: {
                    id: 0,
                    parent: null,
                    type: 'advert'
                },
                data: {
                    alert: null,
                    alreadySave: false,
                    alreadyRender: false
                },
                events: {
                    'change .form-multiselect': 'changeMultiSelect',
                },

                afterInitialize: function () {
                    var me = this;
                    me.attributes.id = (me.attributes.id === undefined) ? 0 : me.attributes.id;
                    me.setId(me.attributes.id);
                },

                afterRender: function () {
                    var me = this;

                    //Après le remplissage du formulaire
                    Livewire.on('users-select-form-mount', hydrate => {
                        if (hydrate !== null) {
                            if (me.attributes.parent !== null && me.attributes.parent !== undefined &&
                                me.attributes.parent.attributes.parent !== null &&
                                me.attributes.parent.attributes.parent !== undefined) {
                                me.attributes.parent.attributes.parent.hydrateModel(hydrate, true)
                            } else if (me.attributes.parent !== null && me.attributes.parent !== undefined) {
                                me.attributes.parent.hydrateModel(hydrate, true)
                            }
                        }
                    });
                },

                changeMultiSelect: function (e) {
                    var me = this;
                    if (me.attributes.parent !== null && me.attributes.parent !== undefined) {
                        me.attributes.parent.changeField(e);
                    }
                },

                setId: function (id) {
                    var me = this;
                    me.attributes.id = (id === null || id === undefined)? 0 : id;
                    if (!me.data.alreadyRender) {
                        me.data.alreadyRender = true;
                        me.render();
                    }

                    //Mise à jour des infos
                    Livewire.emit('users-select-form-update', me.attributes.id, me.attributes.type);
                },

                setOptions: function (options) {
                    var me = this;

                    if (!me.data.alreadyRender) {
                        me.data.alreadyRender = true;
                        me.render();
                    }

                    //Mise à jour des infos
                    Livewire.emit('users-select-form-update', me.attributes.id, me.attributes.type, options);
                }
            });

            // new App.Module.Profile.View.User.MultiSelect();
        });
    });
</script>
