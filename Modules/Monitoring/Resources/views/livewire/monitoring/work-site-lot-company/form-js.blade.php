<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
            if (App.Module.Monitoring.View === undefined) App.Module.Monitoring.View = {};
            if (App.Module.Monitoring.View.WorkSiteLotCompany === undefined) App.Module.Monitoring.View.WorkSiteLotCompany = {};
            App.Module.Monitoring.View.WorkSiteLotCompany.Form = App.View.View.extend({
                el: '#workSiteLotCompanyForm',
                attributes: {},
                data: {
                    id: null,
                    workSiteLotCompany: {
                        settings: null,
                    }
                },
                events: {},

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname.length > 3 && isInt(pathname[3])) {
                        me.data.id = parseInt(pathname[3]);
                    }

                    me.data.workSiteLotCompany.settings = new App.Module.Monitoring.View.WorkSiteLotCompany.Settings({
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

                    Livewire.on('work-site-lot-company-settings-form-success', request => {
                        // console.log(request)
                        window.location.replace("/monitoring/work-site-lot-company/" + request.id + '/edit');
                    });

                    Livewire.on('monitoring-settings-form-success', request => {
                        me.data.workSiteLotCompany.settings.setId(request.work_site_lot_company_id);
                    });

                    Livewire.on('monitoring-form-without-workSiteLotCompanyid', request => {
                        // Virer les Chantiers si le numéro de Client n'est pas spécifié
                        $('#monitoringGrid').addClass('d-none');
                        //$('.input-text').addClass('input-disabled');
                        //$('.input-text').attr('disabled', '');
                        //$('.btn-primary').attr('hidden', 'true');
                    });
                }
            });
            new App.Module.Monitoring.View.WorkSiteLotCompany.Form();
        });
    });
</script>