<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        if (App.View.HeaderCell === undefined) App.View.HeaderCell = {};

        App.View.HeaderCell.MenuHeader = Backgrid.HeaderCell.extend({
            render: function () {
                var me = this, template = Handlebars.compile($("#headerCell-tpl").html());
                me.$el.html(template({
                    label: me.column.get("label"),
                    name: me.column.get("name"),
                    hasSort: me.column.get("sortable"),
                    hasFilter: me.column.get("filterable"),
                    filterName: me.column.get("filterName"),
                    filterType: me.column.get("filterType"),
                    filterValues: me.column.get("filterValues"),
                    autocompleteId: me.column.get("autocompleteId"),
                    hasFilterStr: me.column.get("filterType") === 'string',
                    hasFilterBool: me.column.get("filterType") === 'boolean',
                    hasFilterSelect: me.column.get("filterType") === 'select',
                    hasFilterAuto: me.column.get("filterType") === 'autocomplete',
                    hasFilterNum: me.column.get("filterType") === 'number',
                    hasFilterDate: me.column.get("filterType") === 'date',
                }));

                return this;
            }
        });
    });
</script>