<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
            if (App.Module.Monitoring.View === undefined) App.Module.Monitoring.View = {};
            if (App.Module.Monitoring.View.WorkSite === undefined) App.Module.Monitoring.View.WorkSite = {};
            App.Module.Monitoring.View.WorkSite.Form = App.View.View.extend({
                el: '#workSiteForm',
                attributes: {},
                data: {
                    id: null,
                    workSite: {
                        settings: null,
                    }
                },
                events: {},

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname.length > 3 && isInt(pathname[3])) {
                        me.data.id = parseInt(pathname[3]);
                    }

                    me.data.workSite.settings = new App.Module.Monitoring.View.WorkSite.Settings({
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

                    Livewire.on('work-site-settings-form-success', request => {
                        window.location.replace("/monitoring/work-site/" + request.id + '/edit');
                    });

                    Livewire.on('work-site-lot-company-settings-form-success', request => {
                        me.data.workSite.settings.setId(request.work_site_id);
                    });

                    Livewire.on('work-site-form-without-customerid', request => {
                        $('#workSiteLotCompanyGrid').addClass('d-none');
                        $('.input-text').addClass('input-disabled');
                        $('.input-text').attr('disabled', '');
                        $('.btn-primary').attr('hidden', 'true');
                    });
                }
            });
            new App.Module.Monitoring.View.WorkSite.Form();
        });
    });
</script>