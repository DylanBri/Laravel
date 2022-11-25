<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Profile.View === undefined) App.Module.Profile.View = {};
            if (App.Module.Profile.View.Admin === undefined) App.Module.Profile.View.Admin = {};
            App.Module.Profile.View.Admin.Grid = App.View.Grid.extend({
                el: "#adminGrid",
                collection: new App.Module.Profile.Collection.Pageable.Administrators(),
                btnSee: true,
                btnAdd: true,
                btnModify: true,
                btnDelete: false,
                data: {
                    alert: null,
                    loading: null,
                    modal: null,
                    stateSettings: false,
                    stateAddress: false,
                    model: null,
                    admin: {
                        address: null,
                        settings: null
                    }
                },
                events: {
                    "click #btnAdd": "addItem",
                    "click .btnModify": "modifyItem",
                    // "click .btnDelete": "deleteItem",
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
                            label: "<?php echo __("Name"); ?>",
                            name: 'name',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'name',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("Zip / Postal Code"); ?>",
                            name: 'zip_code',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'zip_code',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("City"); ?>",
                            name: 'city',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'city',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("Country"); ?>",
                            name: 'country',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'country',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        /*{
                            label: "<?php echo __("Email"); ?>",
                            name: 'email',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'email',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },*/
                        {
                            label: "<?php echo __("Enable"); ?>",
                            name: 'enabled',
                            cell: App.View.Cell.BooleanCell,
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'enabled',
                            filterType: 'boolean',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("Actions"); ?>",
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
                            btnClass: "btnSee btn-toggle-modal",
                            modelId: model.get('id'),
                            imgClass: "fa fa-eye",
                            title: "<?php echo __("actions.See"); ?>"
                        });
                    }
                    if (me.btnModify) {
                        buttons.push({
                            btnClass: "btnModify btn-toggle-modal",
                            modelId: model.get('id'),
                            imgClass: "fa fa-edit",
                            title: "<?php echo __("actions.Modify"); ?>"
                        });
                    }
                    return template({buttons: buttons});
                },

                toggleModal: function () {
                    var me = this;
                    if (me.data.stateSettings && me.data.stateAddress) {
                        me.data.stateSettings = false;
                        me.data.stateAddress = false;
                        me.data.modal.toggleModal();
                    }
                },

                hydrateModel: function (hydrate, isSettings) {
                    var me = this;
                    $.each(hydrate, function (key, value) {
                        me.data.model.set(key, value);
                    });
                },

                renderSettings: function (id) {
                    var me = this;
                    if (me.data.admin.settings === null) {
                        me.data.admin.settings = new App.Module.Profile.View.Settings({
                            attributes : {
                                isModal: true,
                                parent: me,
                                type: 'admin'
                            }
                        });
                    }
                    me.data.admin.settings.setId((id === null)? 0 : id);
                },

                renderAddress: function (id) {
                    var me = this;
                    if (me.data.admin.address === null) {
                        me.data.admin.address = new App.Module.Profile.View.Address({
                            attributes : {
                                isModal: true,
                                parent: me
                            }
                        });
                    }
                    me.data.admin.address.setId((id === null)? 0 : id);
                },

                renderModal: function (id, isNew, isModify) {
                    var me = this, txtSee = "<?php echo __('profile::admin.See'); ?>",
                        txtAdd = "<?php echo __('profile::admin.Add'); ?>",
                        txtModify = "<?php echo __('profile::admin.Modify'); ?>";

                    if (me.data.modal === null) {
                        me.data.modal = new App.View.Component.Modal({
                            el : '#adminModalContainer',
                            attributes: {
                                elModal : '#adminModal'
                            }
                        });
                        me.data.modal.$el.find('.modal-content').accordion({
                            heightStyle: "content",
                            collapsible: true,
                            icons: {
                                header: "ui-icon-caret-1-n",
                                activeHeader: "ui-icon-caret-1-s"
                            }
                        });

                        me.data.modal.$el.find(".btn-form-save").on('click', function () {
                            me.data.admin.settings.formSubmit();
                            me.data.admin.address.formSubmit();
                        });
                        me.data.modal.$el.find(".btn-modal-header").on('click', function () {
                            me.refresh();
                        });
                        me.data.modal.$el.find(".btn-modal-footer").on('click', function () {
                            me.refresh();
                        });
                    }
                    me.data.modal.setTitle((isNew)? txtAdd : (isModify)? txtModify : txtSee);
                    me.data.modal.$el.find(".btn-form-save").addClass('hidden');
                    if (isModify || isNew) me.data.modal.$el.find(".btn-form-save").removeClass('hidden');
                    me.data.modal.$el.find(".btn-alert-close").click();

                    me.data.model = new App.Module.Profile.Model.Administrator();
                    if (id !== null) me.data.model.set('id', id);
                    me.renderSettings(id);
                    me.renderAddress(id);

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
                        id = ($target.data('id') === undefined)? $targetP.data('id') : $target.data('id');
                    /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('UPDUSR')) {
                        return;
                    }*/
                    // window.location.replace("/user/view/" + id);
                    me.renderModal(id, false, true)
                },

                seeItem: function (e) {
                    var me = this, $target = $(e.target), $targetP = $target.parent(),
                        id = ($target.data('id') === undefined)? $targetP.data('id') : $target.data('id');
                    /*if (My.isSuperAdmin === null && !My.Right.AndProfile.includes('SEEUSR')) {
                        return;
                    }*/
                    // window.location.replace("/user/view/" + id + "/read");
                    me.renderModal(id, false, false)
                },

                formSubmit: function () {
                    Livewire.emit('submitForm');
                },

                setModel: function (id, value) {
                    var me = this;
                    me.data.model.setWithVerif(id, value);
                },

                saveModel: function () {
                    var me = this, token = me.data.admin.address.$el.find('[name=_token]').val(),
                        userId = me.data.admin.address.$el.find('#user_id').val(),
                        categoryId = me.data.admin.address.$el.find('#category_id').val();
                    me.$el.find('input[type=submit]').prop('disabled', true);
                    if (me.data.stateSettings && me.data.stateAddress) {
                        me.data.stateSettings = false;
                        me.data.stateAddress = false;
                        me.data.model.save({'_token': token, 'user_id': userId, 'category_id': categoryId})
                            .done(function (r) {
                                if (me.data.alert === null) {
                                    me.data.alert = new App.View.Component.Alert({
                                        el: '#admin-form-alert-success',
                                        attributes: {
                                            title: ''
                                        }
                                    });
                                } else {
                                    me.data.alert.closeAlert();
                                    me.data.alert.render();
                                }
                                Livewire.emit('admin-form-success', r);
                                me.data.modal.$el.find(".btn-toggle-modal")[0].click();
                            })
                            .fail(function (r) {
                                var errors = r.responseJSON.errors;
                                Livewire.emit('admin-form-error', errors);
                            });
                    }
                }
            });
            new App.Module.Profile.View.Admin.Grid();
        });
    });
</script>