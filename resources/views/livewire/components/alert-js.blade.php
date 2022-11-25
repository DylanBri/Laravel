<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        if (App.View.Component === undefined) App.View.Component = {};
        if (App.View.Component.Alert === undefined) App.View.Component.Alert = {};
        App.View.Component.Alert = App.View.View.extend({
            attributes: {
                title: '',
                slot:''
            },
            events: {
                'click .btn-alert-close': 'closeAlert'
            },

            afterRender: function() {
                var me = this, template = Handlebars.compile($("#alert-tpl").html());
                me.$el.append(template({
                    'title': me.attributes.title,
                    'slot': me.attributes.slot
                }));
            },

            closeAlert: function (e) {
                var me = this;
                me.$el.empty();
            }
        });
    });
</script>