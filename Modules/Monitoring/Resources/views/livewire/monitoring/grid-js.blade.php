<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
            if (App.Module.Monitoring.View === undefined) App.Module.Monitoring.View = {};
            if (App.Module.Monitoring.View.Monitoring === undefined) App.Module.Monitoring.View.Monitoring = {};
            App.Module.Monitoring.View.Monitoring.Grid = App.View.Grid.extend({
                el: "#monitoringGrid",
                collection: new App.Module.Monitoring.Collection.Pageable.Monitorings(),
                btnSee: true,
                btnAdd: true,
                btnModify: true,
                btnDelete: true,
                data: {
                    workSiteLotCompanyId: 0,
                    alert: null,
                    loading: null,
                    modal: null,
                    isEdit: null,
                    stateSettings: true, // false,
                    model: null,
                    monitoring: {
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
                    "dblclick .backgrid tr": "actionDoubleClick"
                },

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname.length > 4 && isInt(pathname[4]) && pathname[3] === 'work-site-lot-company') {
                        console.log(pathname[1], pathname[2],pathname[3])
                        me.data.workSiteLotCompanyId = parseInt(pathname[4]);
                        if (pathname.length > 5 && pathname[5] !== '') {
                            me.data.isEdit = (pathname[5] === 'edit');
                        }
                    } else if (pathname.length > 3 && isInt(pathname[3]) && pathname[2] === 'work-site-lot-company') {
                        me.data.workSiteLotCompanyId = parseInt(pathname[3]);
                        if (pathname.length > 4 && pathname[4] !== '') {
                            me.data.isEdit = (pathname[4] === 'edit');
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
                    me.$el.find('.grid-content').before("<h6 class='text-center'><?php echo __("monitoring::monitoring.List"); ?></h6>");
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
                            label: '<?php echo __("monitoring::monitoring.Id"); ?>',
                            name: 'id',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'monitorings.id',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("monitoring::monitoring.Name"); ?>",
                            name: 'name',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'monitorings.name',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("monitoring::monitoring.Date"); ?>",
                            name: 'date',
                            cell: App.View.Cell.DateCell,
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'monitorings.date',
                            filterType: 'date',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("monitoring::monitoring.Amount_to_pay"); ?>",
                            name: 'amount_to_pay',
                            cell: App.View.Cell.NumberCell,
                            sortable: false,
                            editable: false,
                            filterable: false,
                            //filterName: 'monitorings.date',
                            //filterType: 'number',
                            //headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("monitoring::monitoring.Cumul_WorkSiteLotCompany"); ?>",
                            name: 'cumul_monitoring_previous',
                            cell: App.View.Cell.NumberCell,
                            sortable: false,
                            editable: false,
                            filterable: false,
                            //filterName: 'monitorings.cumul_work_sit_lot_company',
                            //filterType: 'number',
                            //headerCell: App.View.HeaderCell.MenuHeader
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
                        if (me.data.workSiteLotCompanyId > 0) {
                            me.collection.setFilters([{
                                field: 'monitorings.work_site_lot_company_id',
                                value: me.data.workSiteLotCompanyId,
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
                    if (me.data.monitoring.settings === null) {
                        me.data.monitoring.settings = new App.Module.Monitoring.View.Monitoring.Settings({
                            attributes: {
                                workSiteLotCompanyId: me.data.workSiteLotCompanyId,
                                isModal: true,
                                parent: me
                            }
                        });
                    }
                    me.data.monitoring.settings.setId((id === null) ? 0 : id, me.data.workSiteLotCompanyId);
                },

                renderModal: function (id, isNew, isModify) {
                    var me = this, txtSee = "<?php echo __('monitoring::monitoring.See'); ?>",
                        txtAdd = "<?php echo __('monitoring::monitoring.Add'); ?>",
                        txtModify = "<?php echo __('monitoring::monitoring.Modify'); ?>";

                    if (me.data.modal === null) {
                        me.data.modal = new App.View.Component.Modal({
                            el: '#monitoringModalContainer',
                            attributes: {
                                elModal: '#monitoringModal'
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
                            me.data.monitoring.settings.formSubmit();
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

                    me.data.model = new App.Module.Monitoring.Model.Monitoring();
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
                    //window.location.replace("/monitoring/" + id);
                    me.renderModal(id, false, true)
                },

                deleteItem: function (e) {
                    var me = this, $target = $(e.target), $targetP = $target.parent(),
                        id = ($target.data('id') === undefined) ? $targetP.data('id') : $target.data('id');
                    /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('UPDUSR')) {
                        return;
                    }*/
                    if (window.confirm('<?php echo __('monitoring::monitoring.Delete') ?>')) {
                        //me.data.model = new App.Module.Monitoring.Model.Monitoring();
                        //if (id !== null) me.data.model.set('id', id);
                        App.Api.delete('/monitoring/' + id, {'_token': $('[name=_token]').val()})
                        .done(function() {
                            me.reload();
                        });
                        //me.renderSettings(id);
                        //me.setModel('suppressed', true);
                        //me.saveModel();
                    }
                },

                seeItem: function (e) {
                    var me = this, $target = $(e.target), $targetP = $target.parent(),
                        id = ($target.data('id') === undefined) ? $targetP.data('id') : $target.data('id');
                    /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('SEEUSR')) {
                        return;
                    }*/
                    window.location.replace("/monitoring/" + id + "/edit");
                    //me.renderModal(id, false, false)
                },

                actionDoubleClick: function (e) {
                    var me = this, $target = $(e.target), 
                        $targetP = $target.parent().find('.btnSee'),
                        id = ($target.data('id') === undefined) ? $targetP.data('id') : $target.data('id');
                        /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('SEEUSR')) {
                        return;
                    }*/
                    window.location.replace("/monitoring/" + id + "/edit");
                    // me.renderModal(id, false, false)
                },

                formSubmit: function () {
                    Livewire.emit('submitForm');
                },

                setModel: function (id, value) {
                    var me = this;
                    me.data.model.setWithVerif(id, value);
                },

                saveModel: function () {
                    var me = this, token = me.data.monitoring.settings.$el.find('[name=_token]').val();
                    me.$el.find('input[type=submit]').prop('disabled', true);
                    
                    if (me.data.stateSettings) {
                        me.data.stateSettings = false;
                        me.data.model.save({'_token': token})
                            .done(function (r) {
                                if (me.data.alert === null) {
                                    me.data.alert = new App.View.Component.Alert({
                                        el: '#monitoring-form-alert-success',
                                        attributes: {
                                            title: ''
                                        }
                                    });
                                } else {
                                    me.data.alert.closeAlert();
                                    me.data.alert.render();
                                }
                                Livewire.emit('monitoring-form-success', r.data);
                                me.data.monitoring.settings.triggerSuccess(r.data);
                                me.data.modal.$el.find(".btn-toggle-modal")[0].click();
                            })
                            .fail(function (r) {
                                var errors = r.responseJSON.errors;
                                Livewire.emit('monitoring-form-error', errors);
                                me.data.monitoring.settings.triggerErrors(errors);
                            });
                    }
                }
            });
            new App.Module.Monitoring.View.Monitoring.Grid();
        });
    });
</script>
