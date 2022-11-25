<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
            if (App.Module.Monitoring.View === undefined) App.Module.Monitoring.View = {};
            if (App.Module.Monitoring.View.WorkSite === undefined) App.Module.Monitoring.View.WorkSite = {};
            App.Module.Monitoring.View.WorkSite.Grid = App.View.Grid.extend({
                el: "#workSiteGrid",
                collection: new App.Module.Monitoring.Collection.Pageable.WorkSites(),
                btnSee: true,
                btnAdd: true,
                btnModify: true,
                btnDelete: false,
                data: {
                    customerId: 0,
                    alert: null,
                    loading: null,
                    modal: null,
                    isEdit: null,
                    stateSettings: true, // false,
                    model: null,
                    workSite: {
                        settings: null,
                    }
                },
                events: {
                    "click #btnAdd": "addItem",
                    "click .btnModify": "modifyItem",
                    "click .btnDelete": "deleteItem",
                    "click .btnSee": "seeItem",
                    "click #btnReload": "reload",
                    "close.view #viewModal": "reload",
                    "change #pageSize": "changePageSize",
                    "click .toggleSort": "sortField",
                    "change .filter": "filterField",
                    "dblclick .backgrid tr": "seeItem",
                },

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname.length > 5 && isInt(pathname[5]) && pathname[4] === 'customer') {
                        me.data.customerId = parseInt(pathname[5]);
                        if (pathname.length > 6 && pathname[6] !== '') {
                            me.data.isEdit = (pathname[6] === 'edit');
                        }
                    } else if (pathname.length > 2 && isInt(pathname[2]) && pathname[1] === 'customer') {
                        me.data.customerId = parseInt(pathname[2]);
                        if (pathname.length > 3 && pathname[3] !== '') {
                            me.data.isEdit = (pathname[3] === 'edit');
                        }
                    }
                    if (me.data.isEdit === false) {
                        me.btnAdd = false;
                        me.btnModify = false;
                    }
                    me.initGrid();
                    me.render();
                },

                afterRender: function () {
                    var me = this;
                    me.$el.find('.grid-content').before("<h6 class='text-center'><?php echo __("monitoring::work-site.List"); ?></h6>");
                },

                initColumns: function () {
                    var me = this;

                    App.View.Cell.ActionCell = window.Backgrid.Cell.extend({
                        render: function () {
                            // Put what you want inside the cell (Can use .html if HTML formatting is needed)
                            this.$el.html(me.tplBtnAction(this.model));

                            // MUST do this for the grid to not error out
                            return this;
                        }
                    });

                    me.columns = [
                        {
                            label: "<?php echo __("monitoring::work-site.Id"); ?>",
                            name: 'id',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'work_sites.id',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("monitoring::work-site.Name"); ?>",
                            name: 'name',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'work_sites.name',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },/* 
                        {
                            label: "<?php echo __("monitoring::work-site.Customer_name"); ?>",
                            name: 'customer_name',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'customers.name',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        }, */
                        {
                            label: "<?php echo __("monitoring::work-site.Notes"); ?>",
                            name: 'notes',
                            cell: 'string',
                            sortable: false,
                            editable: false,
                            filterable: false,
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("actions.Actions"); ?>",
                            name: 'action',
                            cell: App.View.Cell.ActionCell,
                            sortable: false,
                            editable: false,
                            filterable: false,
                            headerCell: App.View.HeaderCell.MenuHeader
                        }
                    ]
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

                        // Filters
                        if (me.data.customerId > 0) {
                            me.collection.setFilters([{
                                field: 'work_sites.customer_id',
                                value: me.data.customerId,
                                type: 'number'
                            }]);
                        }

                        me.collection.fetch().always(function () {
                            toggleLoading();
                        });
                    }
                },

                tplBtnAction: function (model) {
                    var me = this, template = Handlebars.compile($("#btnAction-tpl").html()), buttons = [];
                    if (me.btnSee) {
                        buttons.push({
                            btnClass: "btnSee btn-toggle-modal btn-primary-border",
                            modelId: model.get('id'),
                            imgClass: "fa fa-eye",
                            title: "<?php echo __("actions.See"); ?>"
                        });
                    }
                    if (me.btnModify) {
                        buttons.push({
                            btnClass: "btnModify btn-toggle-modal btn-primary-border",
                            modelId: model.get('id'),
                            imgClass: "fa fa-edit",
                            title: "<?php echo __("actions.Modify"); ?>"
                        });
                    }
                    if (me.btnDelete) {
                        buttons.push({
                            btnClass: "btnDelete btn-toggle-modal btn-primary-border",
                            modelId: model.get('id'),
                            imgClass: "fa fa-trash",
                            title: "<?php echo __("actions.Delete"); ?>"
                        });
                    }
                    return template({buttons: buttons});
                },

                toggleModal: function () {
                    console.log('toggleModal WS');
                    var me = this;
                    if (me.data.stateSettings) {
                        me.data.stateSettings = false;
                        me.data.modal.toggleModal();
                    }
                },

                hydrateModel: function (hydrate) {
                    var me = this;
                    $.each(hydrate, function (key, value) {
                        me.data.model.set(key, value);
                    });
                },

                renderSettings: function (id) {
                    var me = this;
                    if (me.data.workSite.settings === null) {
                        me.data.workSite.settings = new App.Module.Monitoring.View.WorkSite.Settings({
                            attributes: {
                                customerId: me.data.customerId,
                                isModal: true,
                                parent: me
                            }
                        });
                    }
                    me.data.workSite.settings.setId((id === null) ? 0 : id, me.data.customerId);
                },

                renderModal: function (id, isNew, isModify) {
                    var me = this, txtSee = "<?php echo __('monitoring::work-site.See'); ?>",
                        txtAdd = "<?php echo __('monitoring::work-site.Add'); ?>",
                        txtModify = "<?php echo __('monitoring::work-site.Modify'); ?>";

                    if (me.data.modal === null) {
                        me.data.modal = new App.View.Component.Modal({
                            el: '#workSiteModalContainer',
                            attributes: {
                                elModal: '#workSiteModal'
                            }
                        });
                        /*me.data.modal.$el.find('.modal-content').accordion({
                            heightStyle: "content",
                            collapsible: true,
                            icons: {
                                header: "ui-icon-caret-1-n",
                                activeHeader: "ui-icon-caret-1-s"
                            }
                        });*/

                        me.data.modal.$el.find(".btn-form-save").on('click', function () {
                            me.data.workSite.settings.formSubmit();
                        });
                        me.data.modal.$el.find(".btn-modal-header").on('click', function () {
                            me.refresh();
                        });
                        me.data.modal.$el.find(".btn-modal-footer").on('click', function () {
                            me.refresh();
                        });
                    }
                    me.data.modal.setTitle((isNew) ? txtAdd : (isModify) ? txtModify : txtSee);
                    me.data.modal.$el.find(".btn-form-save").addClass('hidden');
                    if (isModify || isNew) me.data.modal.$el.find(".btn-form-save").removeClass('hidden');
                    me.data.modal.$el.find(".btn-alert-close").click();

                    me.data.model = new App.Module.Monitoring.Model.WorkSite();
                    if (id !== null) me.data.model.set('id', id);
                    me.renderSettings(id);

                    // me.data.modal.toggleModal(); //fait par les enfants
                },

                addItem: function (e) {
                    var me = this;
                    /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('ADDUSR')) {
                        return;
                    }*/
                    // window.location.replace("/user/view");
                    me.renderModal(null, true, false)
                },

                modifyItem: function (e) {
                    var me = this, $target = $(e.target), $targetP = $target.parent(),
                        id = ($target.data('id') === undefined) ? $targetP.data('id') : $target.data('id');
                    /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('UPDUSR')) {
                        return;
                    }*/
                    // window.location.replace("/user/view/" + id);
                    me.renderModal(id, false, true)
                },

                deleteItem: function (e) {
                    var me = this, $target = $(e.target), $targetP = $target.parent(),
                        id = ($target.data('id') === undefined) ? $targetP.data('id') : $target.data('id');
                    /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('UPDUSR')) {
                        return;
                    }*/
                    if (window.confirm('<?php echo __('monitoring::work-site.Delete') ?>')) {
                        me.data.model = new App.Module.Monitoring.Model.WorkSite();
                        if (id !== null) me.data.model.set('id', id);
                        me.renderSettings(id);
                        me.setModel('suppressed', true);
                        me.saveModel();
                    }
                },

                seeItem: function (e) {
                    var me = this, $target = $(e.target), 
                        $targetP = ($target.hasClass('.btnSee') ? $target.parent() : $target.parent().parent().find('.btnSee')),
                        id = ($target.data('id') === undefined) ? $targetP.data('id') : $target.data('id');
                    /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('SEEUSR')) {
                        return;
                    }*/
                    window.location.replace("/monitoring/work-site/" + id + "/edit");
                    //me.renderModal(id, false, false)
                },

                formSubmit: function () {
                    Livewire.emit('work-site-submit-form');
                },

                setModel: function (id, value) {
                    var me = this;
                    me.data.model.setWithVerif(id, value);
                },

                saveModel: function () {
                    var me = this, token = me.data.workSite.settings.$el.find('[name=_token]').val();
                    me.$el.find('input[type=submit]').prop('disabled', true);
                    
                    if (me.data.stateSettings) {
                        me.data.stateSettings = false;
                        me.data.model.save({'_token': token})
                            .done(function (r) {
                                if (me.data.alert === null) {
                                    me.data.alert = new App.View.Component.Alert({
                                        el: '#work-site-form-alert-success',
                                        attributes: {
                                            title: ''
                                        }
                                    });
                                } else {
                                    me.data.alert.closeAlert();
                                    me.data.alert.render();
                                }
                                Livewire.emit('work-site-form-success', r.data);
                                me.data.workSite.settings.triggerSuccess(r.data);
                                me.data.modal.$el.find(".btn-toggle-modal")[0].click();
                            })
                            .fail(function (r) {
                                var errors = r.responseJSON.errors;
                                Livewire.emit('work-site-form-error', errors);
                                me.data.workSite.settings.triggerErrors(errors);
                            });
                    }
                }
            });
            new App.Module.Monitoring.View.WorkSite.Grid();
        });
    });
</script>
