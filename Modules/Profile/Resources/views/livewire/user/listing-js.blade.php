<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Profile === undefined) App.Module.Profile = {};
            if (App.Module.Profile.View === undefined) App.Module.Profile.View = {};
            if (App.Module.Profile.View.User === undefined) App.Module.Profile.View.User = {};
            App.Module.Profile.View.User.List = App.View.Listing.extend({
                el: "#userList",
                collection: new App.Module.Profile.Collection.Users(),
                data: {
                    alert: null,
                    loading: null,
                    modal: null,
                    listing: null,
                },
                events: {
                    "click .btnClear" : "clearFilters",
                    "click .btnAlpha" : "searchAlpha",
                    "change #search" : "search"
                },

                afterInitialize: function () {
                    var me = this;
                    me.render();
                },

                afterRender: function() {
                    var me = this;

                    me.renderAlphabet([
                        'A','B','C','D','E','F','G','H','I',
                        'J','K','L','M','N','O','P','Q','R',
                        'S','T','U','V','W','X','Y','Z'
                    ]);

                    me.renderFilter([
                        {'id' : 'search', 'name' : "<?php echo __('Search') ?>"}
                    ]);

                    me.collection = new App.Module.Profile.Collection.Users();
                    me.reload();
                },

                reload: function () {
                    var me = this, template = Handlebars.compile($("#itemContent-tpl").html());

                    toggleLoading();

                    me.collection.fetch({ 'url':'/user/search' })
                        .done(function () {
                            me.renderContent(template({
                                items: me.collection.models
                            }));

                            toggleLoading();
                        });
                },

                resetData: function (name, id) {
                    var me = this;
                    me.$el.find('#' + id).val('');
                    me.$el.find('#' + name).val('');
                    me.changeFieldValue(id, '');
                    me.changeFieldValue(name, '');
                },

                searchAlpha: function (e) {
                    var me = this;
                    me.setFilters([{
                        field: 'users.name',
                        type: 'begin',
                        value: $(e.currentTarget).data('value')
                    }]);
                },

                search: function (e) {
                    var me = this;
                    me.setFilters([{
                        field: 'users.name',
                        type: 'string',
                        value: $(e.currentTarget).val()
                    }]);

            });
            new App.Module.Profile.View.User.List();
        });
    });
</script>