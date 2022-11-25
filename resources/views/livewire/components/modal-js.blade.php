<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        if (App.View.Component === undefined) App.View.Component = {};
        if (App.View.Component.Modal === undefined) App.View.Component.Modal = {};
        App.View.Component.Modal = App.View.View.extend({
            attributes: {
                elModal: '',
                'title': '',
                'content': '',
                'footer': ''
            },
            events: {
                "click .btn-toggle-modal": "toggleModal",
            },

            afterRender: function () {
                var me = this;
                me.setTitle(me.attributes.title);
                me.setContent(me.attributes.content);
                me.setFooter(me.attributes.footer);
            },

            toggleModal: function () {
                var me = this, elModal = me.attributes.elModal;
                me.$el.find(elModal).toggleClass("hidden").toggleClass("flex");
                me.$el.find(elModal + "-backdrop").toggleClass("hidden").toggleClass("flex");
            },

            setTitle: function (title) {
                var me = this;
                me.$el.find('.modal-title').html(title);
            },

            setContent: function (content) {
                var me = this;
                me.$el.find('.modal-content').html(content);
            },

            setFooter: function (footer) {
                var me = this;
                me.$el.find('.modal-footer').children().before(footer);
            }
        });
    });
</script>