<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
            if (App.Module.Monitoring.View === undefined) App.Module.Monitoring.View = {};
            if (App.Module.Monitoring.View.WorkSiteLotCompany === undefined) App.Module.Monitoring.View.WorkSiteLotCompany = {};
            App.Module.Monitoring.View.WorkSiteLotCompany.Grid = App.View.Grid.extend({
                el: "#workSiteLotCompanyGrid",
                collection: new App.Module.Monitoring.Collection.Pageable.WorkSiteLotCompany(),
                btnSee: true,
                btnAdd: true,
                btnModify: true,
                btnDelete: true,
                btnPayment: true,
                data: {
                    workSiteId: 0,
                    lotId:0,
                    alert: null,
                    loading: null,
                    modal: null,
                    isEdit: null,
                    stateSettings: true, // false,
                    model: null,
                    workSiteLotCompany: {
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
                    "click .btnPayment": "showPayment",
                },

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname.length > 5 && isInt(pathname[5]) && pathname[4] === 'work-site') {
                        me.data.workSiteId = parseInt(pathname[5]);
                        if (pathname.length > 6 && pathname[6] !== '') {
                            me.data.isEdit = (pathname[6] === 'edit');
                        }
                    } else if (pathname.length > 3 && isInt(pathname[3]) && pathname[2] === 'work-site') {
                        me.data.workSiteId = parseInt(pathname[3]);
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
                    me.$el.find('.grid-content').before("<h6 class='text-center'><?php echo __("monitoring::work-site-lot-company.List"); ?></h6>");
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
                        if (me.data.workSiteId > 0) {
                            me.collection.setFilters([{
                                field: 'work_site_lot_company.work_site_id',
                                value: me.data.workSiteId,
                                type: 'number'
                            }]);
                        }

                        me.collection.setFilters([{
                            field: 'work_site_lot_company.is_type',
                            value: 0,
                            type: 'number'
                        }]);

                        me.collection.fetch().always(function () {
                            toggleLoading();
                        });
                    }
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
                            label: "<?php echo __("monitoring::work-site-lot-company.Id"); ?>",
                            name: 'id',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'work_site_lot_company.id',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("monitoring::work-site-lot-company.Name"); ?>",
                            name: 'name',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'work_site_lot_company.name',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("monitoring::lot.Company_name"); ?>",
                            name: 'company_name',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'work_site_lot_company.name',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("monitoring::work-site-lot-company.Amount_ttc"); ?>",
                            name: 'amount_ttc',
                            cell: App.View.Cell.NumberCell,
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
                    if (me.btnPayment) {
                        buttons.push({
                            btnClass: "btnPayment btn-toggle-modal btn-primary-border",
                            modelId: model.get('id'),
                            imgClass: "fa fa-credit-card",
                            title: "<?php echo __("company::company.Payment"); ?>"
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
                    if (me.data.workSiteLotCompany.settings === null) {
                        me.data.workSiteLotCompany.settings = new App.Module.Monitoring.View.WorkSiteLotCompany.Settings({
                            attributes: {
                                workSiteId: me.data.workSiteId,
                                isModal: true,
                                isEdit: me.data.isEdit,
                                parent: me
                            }
                        });
                    }
                    me.data.workSiteLotCompany.settings.setId((id === null) ? 0 : id, null, me.data.workSiteId, 0);
                },

                renderModal: function (id, isNew, isModify) {
                    var me = this, txtSee = "<?php echo __('monitoring::work-site-lot-company.See'); ?>",
                        txtAdd = "<?php echo __('monitoring::work-site-lot-company.Add'); ?>",
                        txtModify = "<?php echo __('monitoring::work-site-lot-company.Modify'); ?>";

                    if (me.data.modal === null) {
                        me.data.modal = new App.View.Component.Modal({
                            el: '#workSiteLotCompanyModalContainer',
                            attributes: {
                                elModal: '#workSiteLotCompanyModal'
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
                            me.data.workSiteLotCompany.settings.formSubmit();
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

                    me.data.model = new App.Module.Monitoring.Model.WorkSiteLotCompany();
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
                        //me.data.model = new App.Module.Monitoring.Model.WorkSiteLotCompany();
                        //if (id !== null) me.data.model.set('id', id);
                        App.Api.delete('/monitoring/work-site-lot-company/' + id, {'_token': $('[name=_token]').val()})
                        .done(function() {
                            me.reload();
                        });
                        console.log('here');
                        //me.renderSettings(id);
                        //me.setModel('suppressed', true);
                        //me.saveModel();
                    }
                },

                seeItem: function (e) {
                    var me = this, $target = $(e.target), 
                        $targetP = ($target.hasClass('.btnSee') ? $target.parent() : $target.parent().parent().find('.btnSee')),
                        id = ($target.data('id') === undefined) ? $targetP.data('id') : $target.data('id');
                    /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('SEEUSR')) {
                        return;
                    }*/
                    window.location.replace("/monitoring/work-site-lot-company/" + id + "/edit");
                    //me.renderModal(id, false, false)
                },

                showPayment: function (e) {
                    var me = this, $target = $(e.target), $targetP = $target.parent(),
                    userId = ($target.data('id') === undefined) ? $targetP.data('id') : $target.data('id');
                    /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('ADDUSR')) {
                    return;
                    }*/
                    window.location.replace("/monitoring/work-site-lot-company/" + userId + "/payment");
                },

                formSubmit: function () {
                    Livewire.emit('work-site-lot-company-submit-form');
                },

                setModel: function (id, value) {
                    var me = this;
                    me.data.model.setWithVerif(id, value);
                },

                saveModel: function () {
                    var me = this, token = me.data.workSiteLotCompany.settings.$el.find('[name=_token]').val();
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
                                me.data.workSiteLotCompany.settings.triggerSuccess(r.data);
                                me.data.modal.$el.find(".btn-toggle-modal")[0].click();
                            })
                            .fail(function (r) {
                                var errors = r.responseJSON.errors;
                                Livewire.emit('work-site-form-error', errors);
                                me.data.workSiteLotCompany.settings.triggerErrors(errors);
                            });
                    }
                }
            });
            new App.Module.Monitoring.View.WorkSiteLotCompany.Grid();
        });
    });
</script>
