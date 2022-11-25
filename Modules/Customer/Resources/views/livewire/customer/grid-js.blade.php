<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Customer === undefined) App.Module.Customer = {};
            if (App.Module.Customer.View === undefined) App.Module.Customer.View = {};
            if (App.Module.Customer.View.Customer === undefined) App.Module.Customer.View.Customer = {};
            App.Module.Customer.View.Customer.Grid = App.View.Grid.extend({
                el: "#customerGrid",
                collection: new App.Module.Customer.Collection.Pageable.Customers(),
                btnSee: true,
                btnAdd: true,
                btnModify: true,
                btnDelete: false,
                data: {
                    alert: null,
                    loading: null,
                    modal: null,
                    stateSettings: true, // false,
                    model: null,
                    customer: {
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
                    var me = this;
                    me.initGrid();
                    me.render();
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
                            label: "<?php echo __("customer::customer.Id"); ?>",
                            name: 'id',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'customers.id',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("customer::customer.Name"); ?>",
                            name: 'name',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'customers.name',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("customer::customer.Phone"); ?>",
                            name: 'phone',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'customers.phone',
                            filterType: 'string',
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
                            btnClass: "btnModify btn-toggle-modal  btn-primary-border",
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
                    if (me.data.customer.settings === null) {
                        me.data.customer.settings = new App.Module.Customer.View.Customer.Settings({
                            attributes: {
                                isModal: true,
                                parent: me
                            }
                        });
                    }
                    me.data.customer.settings.setId((id === null) ? 0 : id);
                },

                renderModal: function (id, isNew, isModify) {
                    var me = this, txtSee = "<?php echo __('customer::customer.See'); ?>",
                        txtAdd = "<?php echo __('customer::customer.Add'); ?>",
                        txtModify = "<?php echo __('customer::customer.Modify'); ?>";

                    if (me.data.modal === null) {
                        me.data.modal = new App.View.Component.Modal({
                            el: '#customerModalContainer',
                            attributes: {
                                elModal: '#customerModal'
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
                            me.data.customer.settings.formSubmit();
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

                    me.data.model = new App.Module.Customer.Model.Customer();
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
                    if (window.confirm('<?php echo __('customer::customer.Delete') ?>')) {
                        me.data.model = new App.Module.Customer.Model.Customer();
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
                    window.location.replace("/customer/" + id + "/edit");
                    // me.renderModal(id, false, false)
                },

                actionDoubleClick: function (e) {
    
                    var me = this, $target = $(e.target), 
                        $targetP = $target.parent().find('.btnSee'),
                        id = ($target.data('id') === undefined) ? $targetP.data('id') : $target.data('id');
                    /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('SEEUSR')) {
                        return;
                    }*/
                    window.location.replace("/customer/" + id + "/edit");
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
                    var me = this, token = me.data.customer.settings.$el.find('[name=_token]').val();
                    me.$el.find('input[type=submit]').prop('disabled', true);
                    
                    if (me.data.stateSettings) {
                        me.data.stateSettings = false;
                        me.data.model.save({'_token': token})
                            .done(function (r) {
                                if (me.data.alert === null) {
                                    me.data.alert = new App.View.Component.Alert({
                                        el: '#customer-form-alert-success',
                                        attributes: {
                                            title: ''
                                        }
                                    });
                                } else {
                                    me.data.alert.closeAlert();
                                    me.data.alert.render();
                                }
                                Livewire.emit('customer-form-success', r);
                                me.data.customer.settings.triggerSuccess(r);
                                me.data.modal.$el.find(".btn-toggle-modal")[0].click();
                            })
                            .fail(function (r) {
                                var errors = r.responseJSON.errors;
                                Livewire.emit('customer-form-error', errors);
                                me.data.customer.settings.triggerErrors(errors);
                            });
                    }
                }
            });
            new App.Module.Customer.View.Customer.Grid();
        });
    });
</script>
