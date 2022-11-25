<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        if (App.Module.Profile === undefined) App.Module.Profile = {};
        if (App.Module.Profile.View === undefined) App.Module.Profile.View = {};
        if (App.Module.Profile.View.Sidenav === undefined) App.Module.Profile.View.Sidenav = {};
        App.Module.Profile.View.Sidenav = App.View.View.extend({
            el: '#sidenav-container',
            attributes: {},
            data: {},
            events: {},

            afterInitialize: function () {
                var me = this;
                me.render();
            },

            afterRender: function () {
                var me = this;
                $.each(me.$el.find('.nav-item'), function (index, nav) {
                    var navRoute = $(nav).data('route').split('|');
                    $.each(navRoute, function (ind, navPath) {
                        if (window.location.pathname.indexOf('dashboard') > -1) {
                            if (navPath === window.location.pathname)
                                $(nav).removeClass('nav-item-inactive').addClass('nav-item-active')
                        } else if (navPath === window.location.pathname) {
                            $(nav).removeClass('nav-item-inactive').addClass('nav-item-active')
                        }/* else if (window.location.pathname.indexOf(navPath) > -1) {
                            $(nav).removeClass('nav-item-inactive').addClass('nav-item-active')
                        }*/
                    })
                })
            }
        });

        new App.Module.Profile.View.Sidenav();
    });
</script>