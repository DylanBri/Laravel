<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
            if (App.Module.Monitoring.View === undefined) App.Module.Monitoring.View = {};
            if (App.Module.Monitoring.View.Monitoring === undefined) App.Module.Monitoring.View.Monitoring = {};
            App.Module.Monitoring.View.Monitoring.Form = App.View.View.extend({
                el: '#monitoringForm',
                attributes: {},
                data: {
                    id: null,
                    monitoring: {
                        settings: null,
                    }
                },
                events: {},

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname.length > 2 && isInt(pathname[2])) {
                        me.data.id = parseInt(pathname[2]);
                    }

                    me.data.monitoring.settings = new App.Module.Monitoring.View.Monitoring.Settings({
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
                        window.location.replace("/monitoring/" + request.id + '/edit');
                    });

                    Livewire.on('work-site-lot-company-settings-form-success', request => {
                        me.data.monitoring.settings.setId(request.monitoring_id);
                    });

                    Livewire.on('work-site-form-without-customerid', request => {
                        $('#workSiteLotCompanyGrid').addClass('d-none');
                        $('.input-text').addClass('input-disabled');
                        $('.input-text').attr('disabled', '');
                        $('.btn-primary').attr('hidden', 'true');
                    });
                },
            });
            new App.Module.Monitoring.View.Monitoring.Form();
        });
    });
</script>