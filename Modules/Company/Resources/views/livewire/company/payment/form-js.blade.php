<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Company === undefined) App.Module.Company = {};
            if (App.Module.Company.View === undefined) App.Module.Company.View = {};
            if (App.Module.Company.View === undefined) App.Module.Company.View.Payment = {};
            App.Module.Company.View.Payment.Form = App.View.View.extend({
                el: '#paymentForm',
                attributes: {},
                data: {
                    id: null,
                    payment: {
                        settings: null,
                    }
                },
                events: {},

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname.length > 2 && isInt(pathname[2])) {
                        me.data.id = parseInt(pathname[2]);
                    }

                    me.data.payment.settings = new App.Module.Company.View.Payment.Settings({
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

                    Livewire.on('payment-settings-form-success', request => {
                        console.log('payment-settings-form-success', request);
                        window.location.replace("/company/ayment/" + request.id + '/edit');
                    });

                    Livewire.on('work-site-lot-company-settings-form-success', request => {
                        me.data.payment.settings.setId(request.payment_id);
                    });

                    Livewire.on('work-site-form-without-customerid', request => {
                        // Virer les Chantiers si le numéro de Client n'est pas spécifié
                        $('#workSiteLotCompanyGrid').addClass('d-none');
                        $('.input-text').addClass('input-disabled');
                        $('.input-text').attr('disabled', '');
                        $('.btn-primary').attr('hidden', 'true');
                    });
                }
            });
            new App.Module.Company.View.Payment.Form();
        });
    });
</script>