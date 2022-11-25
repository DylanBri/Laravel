<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Customer === undefined) App.Module.Customer = {};
            if (App.Module.Customer.View === undefined) App.Module.Customer.View = {};
            if (App.Module.Customer.View === undefined) App.Module.Customer.View = {};
            App.Module.Customer.View.Form = App.View.View.extend({
                el: '#customerForm',
                attributes: {},
                data: {
                    id: null,
                    customer: {
                        settings: null,
                    }
                },
                events: {},

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname.length > 2 && isInt(pathname[2])) {
                        me.data.id = parseInt(pathname[2]);
                    }

                    me.data.customer.settings = new App.Module.Customer.View.Customer.Settings({
                        attributes : {
                            id : me.data.id,
                            isModal : false,
                            isEdit : true,
                        }
                    });

                    me.render()
                },

                afterRender: function () {
                    var me = this;
                    /*me.$el.accordion({
                        heightStyle: "content",
                        collapsible: true,
                        icons: {
                            header: "ui-icon-caret-1-n",
                            activeHeader: "ui-icon-caret-1-s"
                        }
                    });*/

                    Livewire.on('customer-settings-form-success', request => {
                        console.log('customer-settings-form-success', request);
                        window.location.replace("/customer/" + request.id + '/edit');
                    });

                    Livewire.on('work-site-settings-form-success', request => {
                        me.data.customer.settings.setId(request.customer_id);
                    });

                    Livewire.on('work-site-form-without-customerid', request => {
                        // Virer les Chantiers si le numéro de Client n'est pas spécifié
                        $('#workSiteGrid').addClass('d-none');
                        $('.input-text').addClass('input-disabled');
                        $('.input-text').attr('disabled', '');
                        $('.btn-primary').attr('hidden', 'true');
                    });
                }
            });
            new App.Module.Customer.View.Form();
        });
    });
</script>