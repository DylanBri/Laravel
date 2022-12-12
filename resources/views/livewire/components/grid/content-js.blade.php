<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        if (App.View.Cell === undefined) App.View.Cell = {};
        App.View.Cell.BooleanCell = window.Backgrid.BooleanCell.extend({
            render: function () {
                var $checkbox = $("<input/>", {
                    type: "checkbox",
                    class: "form-checkbox",
                    checked: this.model.get('enabled') === true,
                    disabled: true
                });

                // Put what you want inside the cell (Can use .html if HTML formatting is needed)
                this.$el.html($checkbox);

                // MUST do this for the grid to not error out
                return this;
            }
        });

        App.View.Cell.SelectCell = window.Backgrid.SelectCell.extend();

        App.View.Cell.ActionCell = window.Backgrid.Cell.extend({
            render: function () {
                // Put what you want inside the cell (Can use .html if HTML formatting is needed)
                this.$el.html(this.tplBtnAction(this.model));

                // MUST do this for the grid to not error out
                return this;
            }
        });

        App.View.Cell.DateCreatedAtCell = window.Backgrid.DateCell.extend({
            render: function () {
                // Put what you want inside the cell (Can use .html if HTML formatting is needed)
                this.$el.html(window.moment(this.model.get("created_at")).format("L LTS"));

                // MUST do this for the grid to not error out
                return this;
            }
        });

        App.View.Cell.DateTimeCell = window.Backgrid.DateCell.extend({
            render: function () {
                // Put what you want inside the cell (Can use .html if HTML formatting is needed)
                this.$el.html(window.moment(this.model.get(this.column.get("name"))).format("L LTS"));
                // MUST do this for the grid to not error out
                return this;
            }
        });
        
        App.View.Cell.DateCell = window.Backgrid.DateCell.extend({
            render: function () {
                // Put what you want inside the cell (Can use .html if HTML formatting is needed)
                this.$el.html(window.moment(this.model.get(this.column.get("name"))).format("L"));
                // MUST do this for the grid to not error out
                return this;
            }
        });
        
        App.View.Cell.NumberCell = window.Backgrid.NumberCell.extend({
            decimalSeparator : ",",
            orderSeparator : " "
        });


    });
</script>