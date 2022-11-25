<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Log === undefined) App.Module.Log = {};
            if (App.Module.Log.View === undefined) App.Module.Log.View = {};
            if (App.Module.Log.View.LogQueue === undefined) App.Module.Log.View.LogQueue = {};
            App.Module.Log.View.LogQueue.Grid = App.View.Grid.extend({
                el: "#logQueueGrid",
                collection: new App.Module.Log.Collection.Pageable.LogQueues(),
                btnSee: true,
                btnAdd: false,
                btnModify: false,
                btnDelete: false,
                data: {
                    alert: null,
                    loading: null,
                    modal: null,
                    stateSettings: false,
                    model: null,
                    logQueue: {
                        settings: null,
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
                            label: "<?php echo __("log::logQueue.Name"); ?>",
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
                            label: "<?php echo __("log::logQueue.Action"); ?>",
                            name: 'action',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'action',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        /*{
                            label: "<?php echo __("log::logQueue.Data"); ?>",
                            name: 'data',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'data',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },*/
                        {
                            label: "<?php echo __("log::logQueue.Log"); ?>",
                            name: 'log',
                            cell: 'string',
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterName: 'log',
                            filterType: 'string',
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("log::logQueue.State"); ?>",
                            name: 'state',
                            cell: App.View.Cell.SelectCell.extend({
                                optionValues: [["En attente", "0"], ["En cours", "1"], ["Terminé", "2"]]
                            }),
                            sortable: true,
                            editable: false,
                            filterable: true,
                            filterType: 'select',
                            filterValues: me.data.states,
                            headerCell: App.View.HeaderCell.MenuHeader
                        },
                        {
                            label: "<?php echo __("Actions"); ?>",
                            name: 'actions',
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
                    if (me.data.logQueue.settings === null) {
                        me.data.logQueue.settings = new App.Module.Log.View.LogQueue.Settings({
                            attributes: {
                                isModal: true,
                                parent: me
                            }
                        });
                    }
                    me.data.logQueue.settings.setId((id === null) ? 0 : id);
                },

                renderModal: function (id, isNew, isModify) {
                    var me = this, txtSee = "<?php echo __('log::logQueue.See'); ?>",
                        txtAdd = "<?php echo __('log::logQueue.Add'); ?>",
                        txtModify = "<?php echo __('log::logQueue.Modify'); ?>";

                    if (me.data.modal === null) {
                        me.data.modal = new App.View.Component.Modal({
                            el: '#logQueueModalContainer',
                            attributes: {
                                elModal: '#logQueueModal'
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
                            me.data.logQueue.settings.formSubmit();
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

                    me.data.model = new App.Module.Log.Model.LogQueue();
                    if (id !== null) {
                        me.data.model.set('id', id);
                        me.data.model.fetch({'url': '/logQueue/byId/' + id})
                            .done(function () {
                                me.renderSettings(id);
                                // me.data.modal.toggleModal(); //fait par les enfants
                            });
                    } else {
                        me.renderSettings(id);
                        // me.data.modal.toggleModal(); //fait par les enfants
                    }
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

                seeItem: function (e) {
                    var me = this, $target = $(e.target), $targetP = $target.parent(),
                        id = ($target.data('id') === undefined) ? $targetP.data('id') : $target.data('id');
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
                    var me = this, token = me.data.logQueue.settings.$el.find('[name=_token]').val();
                    me.$el.find('input[type=submit]').prop('disabled', true);
                    if (me.data.stateSettings) {
                        me.data.stateSettings = false;
                        me.data.model.save({'_token': token})
                            .done(function (r) {
                                if (me.data.alert === null) {
                                    me.data.alert = new App.View.Component.Alert({
                                        el: '#log-queue-form-alert-success',
                                        attributes: {
                                            title: ''
                                        }
                                    });
                                } else {
                                    me.data.alert.closeAlert();
                                    me.data.alert.render();
                                }
                                Livewire.emit('log-queue-form-success', r.data);
                                me.data.logQueue.settings.triggerSuccess(r.data);
                                me.data.modal.$el.find(".btn-toggle-modal")[0].click();
                            })
                            .fail(function (r) {
                                var errors = r.responseJSON.errors;
                                Livewire.emit('log-queue-form-error', errors);
                                me.data.logQueue.settings.triggerErrors(errors);
                            });
                    }
                }
            });
            new App.Module.Log.View.LogQueue.Grid();
        });
    });
</script>