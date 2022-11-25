<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Customer === undefined) App.Module.Customer = {};
            if (App.Module.Customer.View === undefined) App.Module.Customer.View = {};
            App.Module.Customer.View.List = App.View.Listing.extend({
                el: "#customerList",
                collection: new App.Module.Customer.Collection.Customers(),
                data: {
                    alert: null,
                    loading: null,
                    listing: null,
                },
                events: {
                    "click .btnShow": "toggleCustomer",
                    "click .btnClear": "clearFilters",
                    "click .btnAlpha" : "searchAlpha",
                    "change .input-filter": "searchFilter"
                },

                afterInitialize: function () {
                    var me = this;
                    me.render();
                },

                afterRender: function () {
                    var me = this;

                    me.renderAlphabet([
                        'A','B','C','D','E','F','G','H','I',
                        'J','K','L','M','N','O','P','Q','R',
                        'S','T','U','V','W','X','Y','Z'
                    ]);

                    me.renderFilter([
                        {'id': 'user_name', 'name': "<?php echo __('customer::customer.User Name') ?>"},
                        {'id': 'code', 'name': "<?php echo __('customer::customer.Code') ?>"},
                        {'id': 'search', 'name': "<?php echo __('Search') ?>"}
                    ]);

                    me.collection = new App.Module.Customer.Collection.Customers();
                    me.reload();
                },

                reload: function (e) {
                    var me = this, template = Handlebars.compile($("#itemContent-tpl").html());

                    toggleLoading();

                    me.collection.fetch({'url': '/customer/search'})
                        .done(function () {
                            me.renderContent(template({
                                items: me.collection.models
                            }));
                            if (e !== undefined) $(e.currentTarget).parent().parent().removeClass('hidden');
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
                        field: 'customers.name',
                        type: 'begin',
                        value: $(e.currentTarget).data('value')
                    }]);
                },

                searchFilter: function (e) {
                    var me = this, field = '';

                    switch (e.currentTarget.id) {
                        case 'code':
                            field = 'customers.code';
                            break;
                        case 'user_name':
                            field = 'users.name';
                            break;
                        case 'search':
                            field = 'customers.name';
                            break;
                    }

                    if (field !== '') {
                        me.setFilters([{
                            field: field,
                            type: 'string',
                            value: $(e.currentTarget).val()
                        }]);
                    }
                },

                toggleCustomer: function (e) {
                    var me = this;
                    $(e.currentTarget).parent().parent().find('.item-content').toggleClass('hidden')
                }
            });
            new App.Module.Customer.View.List();
        });
    });
</script>