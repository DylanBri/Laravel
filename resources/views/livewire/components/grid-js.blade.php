<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        App.View.Grid = window.Backbone.View;
        _.extend(App.View.Grid.prototype, window.Backbone.Events, {
            module: '',
            collection: App.Collection.Pageable.Pageable,
            columns: null,
            grid: null,
            paginator: null,
            row: window.Backgrid.Row.extend(),
            btnAdd: false,
            btnModify: false,
            btnDelete: false,
            options: {},
            data: {
                loading: null,
            },
            events: {
                "click #btnAdd": "addItem",
                "click .btnModify": "modifyItem",
                "click .btnDelete": "deleteItem",
                "click #btnReload": "reload",
                "close.view #viewModal": "reload",
                "change #pageSize": "changePageSize",
                "click .toggleSort": "sortField",
                "change .filter": "filterField",
                "dblclick .backgrid tr": "actionDoubleClick"
            },

            initialize: function () {
                this.afterInitialize();
            },

            initColumns: function () {
            },

            initPaginator: function () {
                var me = this;

                me.paginator = new window.Backgrid.Extension.Paginator({
                    collection: me.collection,
                    className: 'backgrid-paginator grid-pagination',
                    renderIndexedPageHandles: true,
                    renderMultiplePagesOnly: false,
                    controls: {
                        rewind: {
                            label: "<i class='fa fa-angle-double-left'/>",
                            title: "<?php echo __("pagination.first"); ?>"
                        },
                        back: {
                            label: "<i class='fa fa-angle-left'/>",
                            title: "<?php echo __("pagination.previous"); ?>"
                        },
                        forward: {
                            label: "<i class='fa fa-angle-right'/>",
                            title: "<?php echo __("pagination.next"); ?>"
                        },
                        fastForward: {
                            label: "<i class='fa fa-angle-double-right'/>",
                            title: "<?php echo __("pagination.last"); ?>"
                        }
                    }
                });
            },

            initGrid: function () {
                var me = this;
                me.initColumns();
                if (me.columns !== null && me.collection !== null) {
                    me.initPaginator();
                    me.grid = new window.Backgrid.Grid({
                        className: "backgrid grid-header",
                        row: me.row,
                        columns: me.columns,
                        collection: me.collection
                    });

                    me.grid.removeRow = function (model, collection, options) {
                            // removeRow() is called directly
                            if (!options) {
                                this.collection.remove(model, (options = collection));
                                if (this._unshiftEmptyRowMayBe()) {
                                    this.render();
                                }
                                return;
                            }

                            if (_.isUndefined(options.render) || options.render) {
                                this.rows[options.index].remove();
                            }

                            this.rows.splice(options.index, 1);
                            if (this._unshiftEmptyRowMayBe()) {
                                this.render();
                            }

                            return this;
                    }
                }
            },

            afterInitialize: function () {
                var me = this;
                me.initGrid();
                me.render();
            },

            render: function () {
                var me = this;
                me.reload();
                me.afterRender();
            },

            tplBtnAction: function (model) {
                var me = this, template = Handlebars.compile($("#btnAction-tpl").html()), buttons = [];
                if (me.btnModify) {
                    buttons.push({
                        btnClass: "btnModify btn-toggle-modal",
                        modelId: model.get('id'),
                        imgClass: "fa fa-edit",
                        title: "<?php echo __("actions.Modify"); ?>"
                    });
                }
                if (me.btnDelete) {
                    buttons.push({
                        btnClass: "btnDelete",
                        modelId: model.get('id'),
                        imgClass: "fa fa-trash-alt",
                        title: "<?php echo __("actions.Delete"); ?>"
                    });
                }
                return template({buttons: buttons});
            },

            tplBase: function () {
                return $("<div/>", {class: 'grid-pagination'}).append($("<ul/>"));
            },

            tplBtnStd: function (id, imgClass, title, btnClass) {
                var template = Handlebars.compile($("#btnStd-tpl").html());
                return template({id: id, imgClass: imgClass, title: title, btnClass: btnClass});
            },

            tplBtnPageSize: function () {
                var template = Handlebars.compile($("#btnPageSize-tpl").html());
                return template({pageSizes: [5, 10, 20, 50, 100]});
            },

            renderBtnPaginator: function () {
                var me = this, state = me.collection.state, $footer, $ul;

                $footer = me.$el.find(".grid-footer");

                /** Footer left */
                $footer.find(".grid-footer-left").empty().append(me.tplBase());
                $ul = $footer.find(".grid-pagination ul");
                if (me.btnAdd) {
                    $ul.append(me.tplBtnStd("btnAdd", "fa fa-plus", "<?php echo __("actions.Add"); ?>", "btn-toggle-modal"));
                }
                $ul.append(me.tplBtnStd("btnReload", "fa fa-refresh", "<?php echo __("actions.Reload"); ?>"));

                /** Footer center */
                $footer.find(".grid-footer-center").empty().append(me.paginator.render().el);

                /** Footer right */
                $footer.find(".grid-footer-right").empty()
                    .append(me.tplBase()).find(".grid-pagination ul")
                    .append(me.tplBtnPageSize());
                $footer.find("#pageSize option").each(function (ind, option) {
                    if (parseInt($(option).val()) === state.pageSize) {
                        $(option).attr("selected", true);
                    }
                });
            },

            reload: function () {
                var me = this;
                if (me.grid !== null) {
                    toggleLoading();
                    me.$el.find(".grid-content").empty().append(me.grid.render().el);
                    me.renderBtnPaginator();
                    me.collection.state.currentPage = 1;
                    me.collection.setSorting(null, -1, {});
                    me.collection.clearFilters();
                    me.collection.fetch().always(function () {
                        toggleLoading();
                    });
                }
            },

            refresh: function () {
                var me = this;
                if (me.grid !== null) {
                    toggleLoading();
                    me.collection.fetch().always(function () {
                        toggleLoading();
                    });
                }
            },

            afterRender: function () {
            },

            actionDoubleClick: function () {
            },

            changePageSize: function (e) {
                var me = this;
                if (me.grid !== null && me.collection !== null) {
                    me.collection.setPageSize(parseInt(e.target.value), {
                        first: true
                    });
                }
            },

            addItem: function () {
            },

            modifyItem: function () {
            },

            deleteItem: function () {
            },

            confirmBox: function (message, model) {
                var me = this;
                /*return window.bootbox.confirm({
                    message: message,
                    buttons: {
                        confirm: {
                            label: "btnConfirm",
                            className: 'btn-primary'
                        },
                        cancel: {
                            label: "btnCancel",
                            className: 'btn-default'
                        }
                    },
                    callback: function (confirm) {
                        if (confirm) {
                            model.destroy()
                        }
                    }
                });*/
            },

            sortField: function (e) {
                var me = this, $currentTarget = $(e.currentTarget),
                    field = $currentTarget.data("field"),
                    name = $currentTarget.data("name"),
                    sort = parseInt($currentTarget.data("sort"));
                toggleLoading();
                // e.preventDefault();
                // e.stopPropagation();

                me.collection.setSorting((field !== '')? field : name, sort, {'mode':'server'});
                me.collection.fetch().always(function () {
                    toggleLoading();
                });
                me.toggleIcon($currentTarget, sort);
            },

            toggleIcon: function ($el, sort) {
                $('.fa-sort-down,.fa-sort-up').each( function () {
                    $(this).addClass('hidden');
                });
                switch (sort) {
                    case -1:
                        $el.data('sort', 1);
                        $el.parent().find('.fa-sort-down').removeClass('hidden');
                        $el.parent().find('.fa-sort-up').addClass('hidden');
                        break;
                    case 1:
                        $el.data('sort', -1);
                        $el.parent().find('.fa-sort-down').addClass('hidden');
                        $el.parent().find('.fa-sort-up').removeClass('hidden');
                        break;
                }
            },

            filterField: function (e) {
                var me = this, $currentTarget = $(e.currentTarget),
                    field = $currentTarget.data("field"),
                    name = $currentTarget.data("name"),
                    type = $currentTarget.data("type");
                toggleLoading();
                // e.preventDefault();
                // e.stopPropagation();
                me.collection.setFilters([{field: (field !== '')? field : name, type: type, value: $currentTarget.val()}]);
                me.collection.fetch().always(function () {
                    toggleLoading();
                });
            }
        });
    });
</script>