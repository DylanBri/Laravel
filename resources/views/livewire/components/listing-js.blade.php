<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        App.View.Listing = window.Backbone.View;
        _.extend(App.View.Listing.prototype, window.Backbone.Events, {
            module: '',
            collection: App.Collection.Collection,
            listing: null,
            options: {},
            data: {
                loading: null,
            },
            events: {
                "click .btnClear" : "clearFilters",
                "click .btnAlpha" : "searchAlpha",
                "change #search" : "search"
            },

            initialize: function () {
                this.afterInitialize();
            },

            afterInitialize: function () {
                var me = this;
                me.render();
            },

            render: function () {
                var me = this;
                me.afterRender();
            },

            afterRender: function () {
                var me = this;
                me.renderAlphabet();
                me.renderFilter();
                me.renderContent();
            },

            renderAlphabet: function (letters) {
                var me = this, template = Handlebars.compile($("#btnAlphabet-tpl").html());
                me.$el.find(".listing-alphabet").html(template({
                    letters : letters
                }));
            },

            renderFilter: function (filters) {
                var me = this, template = Handlebars.compile($("#inputSearch-tpl").html());
                me.$el.find(".listing-filter").html(template({
                    filters: filters
                }));
            },

            renderContent: function (listing) {
                var me = this, template = Handlebars.compile($("#itemList-tpl").html());
                me.$el.find(".listing-content").html(template({
                    content: listing
                }));
            },

            reload: function () {
                var me = this, template = Handlebars.compile($("#itemContent-tpl").html());

                toggleLoading();
                me.collection = new App.Collection.Collection();
                me.collection.fetch()
                    .done(function () {
                        me.renderContent(template({
                            items: me.collection.models
                        }));
                        toggleLoading();
                    });
            },

            clearFilters: function () {
                var me = this;
                me.$el.find('.input-filter').each(function (key, input) {
                    $(input).val('');
                });
                me.collection.state.filters = [];
                me.reload();
                return this;
            },

            setFilters: function (newFilter) {
                var me = this;

                $.each(newFilter, function (ind, newFil) {
                    $.each(me.collection.state.filters, function (index, filter) {
                        if (filter.field === newFil.field && filter.type === newFil.type) {
                            me.collection.state.filters.splice(index);
                        }
                    });
                    me.collection.state.filters.push(newFil);
                });
                me.reload();

                return this;
            },

            /*searchAlpha: function(e) {
                var me = this;
                me.setFilters([{
                    field: 'name',
                    type: 'begin',
                    value: $(e.currentTarget).data('value')
                }]);
            },*/

            /*search: function(e) {
                var me = this;
                me.setFilters([{
                    field: 'name',
                    type: 'string',
                    value: $(e.currentTarget).val()
                }]);
            }*/
        });
    });
</script>