<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.View.Client === undefined) App.View.Client = {};
            if (App.View.Client.Form === undefined) App.View.Client.Form = {};
            App.View.Client.Form.Form = App.View.View.extend({
                el: '#clientForm',
                attributes: {},
                data: {
                    id: 0,
                    client: {
                        address: null,
                        settings: null
                    }
                },
                events: {},

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname.length > 2 && isInt(pathname[2])) {
                        me.data.id = parseInt(pathname[2]);
                    }

                    me.data.client.settings = new App.View.Client.Form.Settings({
                        attributes : {
                            id : me.data.id,
                            isModal : false
                        }
                    });

                    me.data.client.address = new App.View.Client.Form.Address({
                        attributes : {
                            id : me.data.id,
                            isModal : false
                        }
                    });

                    me.render()
                },

                afterRender: function () {
                    var me = this;
                    me.$el.accordion({
                        heightStyle: "content",
                        collapsible: true,
                        icons: {
                            header: "ui-icon-caret-1-n",
                            activeHeader: "ui-icon-caret-1-s"
                        }
                    });
                }
            });
            new App.View.Client.Form.Form();
        });
    });
</script>