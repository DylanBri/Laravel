<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Company === undefined) App.Module.Company = {};
            if (App.Module.Company.View === undefined) App.Module.Company.View = {};
            if (App.Module.Company.View === undefined) App.Module.Company.View = {};
            App.Module.Company.View.Form = App.View.View.extend({
                el: '#companyForm',
                attributes: {},
                data: {
                    id: null,
                    company: {
                        settings: null,
                    }
                },
                events: {},

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname.length > 2 && isInt(pathname[2])) {
                        me.data.id = parseInt(pathname[2]);
                    }

                    me.data.company.settings = new App.Module.Company.View.Company.Settings({
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

                    Livewire.on('company-settings-form-success', request => {
                        console.log('company-settings-form-success', request);
                        window.location.replace("/company/" + request.id + '/edit');
                    });

                    /* Livewire.on('work-site-settings-form-success', request => {
                        me.data.company.settings.setId(request.customer_id);
                    }); */

                    //Livewire.on('work-site-form-without-customerid', request => {
                        // Virer les Chantiers si le numéro de Client n'est pas spécifié
                        //$('#workSiteGrid').addClass('d-none');
                        //$('.input-text').addClass('input-disabled');
                        //$('.input-text').attr('disabled', '');
                        //$('.btn-primary').attr('hidden', 'true');
                    //});
                }
            });
            new App.Module.Company.View.Form();
        });
    });
</script>