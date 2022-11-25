<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        if (App.Module.Profile === undefined) App.Module.Profile = {};
        if (App.Module.Profile.View === undefined) App.Module.Profile.View = {};
        App.Module.Profile.View.NavigationMenu = App.View.View.extend({
            el: 'nav',
            attributes: {},
            data: {},
            events: {
            },

            afterInitialize: function () {
                var me = this;
                me.render();
            },

            /*afterRender: function () {
                var me = this;
            },*/
        });

        new App.Module.Profile.View.NavigationMenu();
    });
</script>