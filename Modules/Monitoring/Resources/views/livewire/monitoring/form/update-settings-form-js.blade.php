<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', e => {
        $(document).on('app.ready', function () {
            if (App.Module.Monitoring === undefined) App.Module.Monitoring = {};
            if (App.Module.Monitoring.View === undefined) App.Module.Monitoring.View = {};
            if (App.Module.Monitoring.View.Monitoring === undefined) App.Module.Monitoring.View.Monitoring = {};
            App.Module.Monitoring.View.Monitoring.Settings = App.View.View.extend({
                model: new App.Module.Monitoring.Model.Monitoring(),
                el: '#monitoringSettingsForm',
                attributes: {
                    id: 0,
                    workSiteLotCompanyId: 0,
                    elAlert: '#monitoring-settings-form-alert-success',
                    isModal: false,
                    isEdit: false,
                    parent: null
                },
                data: {
                    alert: null,
                    alreadySave: false,
                    alreadyRender: false,
                    nbRunsDocPenality: 0,
                    nbRunsAccount: 0,
                    nbRunsAccountManagement: 0,
                    nbRunsRetentionMoney: 0,
                },
                events: {
                    'change .form-input': 'changeField',
                    'change .form-textarea': 'changeField',
                    'click .toggle-checkbox': 'changeToggleCheckbox'
                },

                afterInitialize: function () {
                    var me = this, pathname = document.location.pathname.split('/');
                    if (pathname[pathname.length-1] !== '') {
                        me.attributes.isEdit = (pathname[pathname.length-1] === 'edit');
                    } else {
                        me.attributes.isEdit = false;
                    }
                    me.attributes.id = (me.attributes.id === undefined) ? 0 : me.attributes.id;
                    me.setId(me.attributes.id, me.attributes.workSiteLotCompanyId);
                },

                afterRender: function () {
                    var me = this, 
                        $dfdMarket = $.Deferred(),
                        $dfdAdditionMarket = $.Deferred(),
                        $dfdPregress = $.Deferred(),
                        $dfdAccount = $.Deferred(),
                        $dfdAccountMng = $.Deferred(),
                        $dfdRetentionMon = $.Deferred(),
                        $dfdBalance = $.Deferred();

                    me.renderDatePicker('date');
                    //me.renderAutocompleteLot();
                    //me.renderAutocompleteWorkSite();
                    me.renderAutocompleteWorkSiteLotCompany();

                    //Après le remplissage du formulaire
                    Livewire.on('monitoring-settings-form-mount', hydrate => {

                        me.$el.find("#date_show").val(moment(me.$el.find("#date").val()).format('L'));
                        
                        if (me.model !== null) me.model.remove();
                        me.model = new App.Module.Monitoring.Model.Monitoring(hydrate);
                        if (hydrate !== null) {
                            if (me.attributes.parent !== null && me.attributes.parent !== undefined) {
                                delete hydrate.id;
                                me.attributes.parent.hydrateModel(hydrate)
                            }
                        }
                        if (me.attributes.parent !== null && me.attributes.parent !== undefined &&
                            me.attributes.parent.data.modal.$el.find('.modal-container').hasClass('hidden')) {
                            me.attributes.parent.data.stateSettings = true;
                            me.attributes.parent.toggleModal();
                        }

                        me.calculFieldsMarket($dfdMarket);
                        me.calculFieldsAdditionMarket($dfdAdditionMarket);
                        $.when($dfdAdditionMarket).then(function () {me.calculFieldsProgress($dfdPregress)});
                        me.calculFieldsDepositRecovery();
                        $.when($dfdMarket).then(function () {
                            me.calculFieldsAccount("account_percent", $dfdAccount);
                            $.when($dfdAccount).then(function () {
                                me.calculFieldsAccountManagement("account_management_percent", $dfdAccountMng);
                            });
                            me.calculFieldsRetentionMoney("retention_money_percent", $dfdRetentionMon);
                            me.calculFieldsDocPenality("doc_penality_percent");

                            $.when($dfdAccount, $dfdAccountMng, $dfdRetentionMon).then(function () {
                                me.calculFieldsBalance($dfdBalance);
                                $.when($dfdBalance).then(function () {
                                    me.calculFieldsBalanceDu();
                                });
                            });
                        });
                    });

                    //Après la validation du formulaire
                    Livewire.on('monitoring-settings-form-validate', request => {
                        if (me.attributes.parent === null || me.attributes.parent === undefined) {
                            me.saveModel();
                        } else {
                            me.attributes.parent.data.stateSettings = true;
                            me.attributes.parent.saveModel();
                        }
                    })
                },

                /*renderAutocompleteLot: function () {
                    var me = this, elId = 'lot_name', elHidden = 'lot_id';
                    me.autocomplete('#' + elId, '/monitoring/lot/list', {
                        minChars: 0,
                        transformResult: function(response) {
                            return {
                                suggestions: $.map(response, function (dataItem) {
                                    return {
                                        value: dataItem.name,
                                        data: dataItem.id
                                    };
                                })
                            };
                        },
                        onSelect: function (suggestion) {
                            // Already hidden in first
                            me.$el.find('#' + elHidden).val(suggestion.data);
                            me.changeFieldValue(elHidden, suggestion.data);
                            me.changeFieldValue(elId, suggestion.value);
                        }
                    });
                },

                renderAutocompleteWorkSite: function () {
                    var me = this, elId = 'work_site_name', elHidden = 'work_site_id';
                    me.autocomplete('#' + elId, '/monitoring/work-site/list', {
                        minChars: 0,
                        transformResult: function(response) {
                            return {
                                suggestions: $.map(response, function (dataItem) {
                                    return {
                                        value: dataItem.name,
                                        data: dataItem.id
                                    };
                                })
                            };
                        },
                        onSelect: function (suggestion) {
                            // Already hidden in first
                            me.$el.find('#' + elHidden).val(suggestion.data);
                            me.changeFieldValue(elHidden, suggestion.data);
                            me.changeFieldValue(elId, suggestion.value);
                        }
                    });
                },*/

                renderAutocompleteWorkSiteLotCompany: function () {
                    var me = this, elId = 'work_site_lot_company_name', elHidden = 'work_site_lot_company_id';
                    me.autocomplete('#' + elId, '/monitoring/work-site-lot-company/list', {
                        minChars: 0,
                        transformResult: function(response) {
                            return {
                                suggestions: $.map(response, function (dataItem) {
                                    return {
                                        value: dataItem.name,
                                        data: dataItem.id
                                    };
                                })
                            };
                        },
                        onSelect: function (suggestion) {
                            // Already hidden in first
                            me.$el.find('#' + elHidden).val(suggestion.data);
                            me.changeFieldValue(elHidden, suggestion.data);
                            me.changeFieldValue(elId, suggestion.value);
                        }
                    });
                },

                calculFieldsProgress: function ($dfd) {
                    var me = this,
                        addition_market_amount = (me.$el.find("#addition_market_amount").val() !== '') ? parseFloat(me.$el.find("#addition_market_amount").val()) : 0,
                        tot_market_amount = (me.$el.find("#tot_market_amount").val() !== '') ? parseFloat(me.$el.find("#tot_market_amount").val()) : 0,
                        progress;
                    
                    if (addition_market_amount === 0 && tot_market_amount === 0) {
                        me.$el.find('#progress').val(0);
                        return 0;
                    }
                    if(!me.model.attributes.is_progress) {
                        progress = roundWith((tot_market_amount / addition_market_amount) * 100,0);
                        if (progress !== parseFloat(me.$el.find('#progress').val())) {
                            me.$el.find('#progress').val(progress);
                            me.changeFieldValue('progress', progress);
                        }
                    }; 
                    
                    console.log(progress);
                    
                    $dfd.resolve();
                    return progress;
                },

                calculFieldsAdditionMarket: function ($dfd){
                    var me = this,
                        total_market_amount = (me.$el.find("#total_market_amount").val() !== '') ? parseFloat(me.$el.find("#total_market_amount").val()) : 0,
                        total_modify_market_amount = (me.$el.find("#total_modify_market_amount").val() !== '') ? parseFloat(me.$el.find("#total_modify_market_amount").val()) : 0,
                        addition_market_amount;

                    if (total_market_amount === 0 && total_modify_market_amount === 0) {
                        me.$el.find('#addition_market_amount').val(0);
                        return 0;
                    }
                    
                    addition_market_amount = total_market_amount + total_modify_market_amount;

                    if (addition_market_amount !== parseFloat(me.$el.find('#addition_market_amount').val())) {
                        me.$el.find('#addition_market_amount').val(addition_market_amount);
                        me.changeFieldValue('addition_market_amount', addition_market_amount);
                    }

                    $dfd.resolve();
                    return addition_market_amount;
                },

                calculFieldsMarket: function ($dfd){
                    var me = this,
                        market_amount = (me.$el.find("#market_amount").val() !== '') ? parseFloat(me.$el.find("#market_amount").val()) : 0,
                        modify_market_amount = (me.$el.find("#modify_market_amount").val() !== '') ? parseFloat(me.$el.find("#modify_market_amount").val()) : 0,
                        tot_market_amount;

                    if (market_amount === 0 && modify_market_amount === 0) {
                        me.$el.find('#tot_market_amount').val(0);
                        return 0;
                    }
                    
                    tot_market_amount = market_amount + modify_market_amount;

                    if (tot_market_amount !== parseFloat(me.$el.find('#tot_market_amount').val())) {
                        me.$el.find('#tot_market_amount').val(tot_market_amount);
                        me.changeFieldValue('tot_market_amount', tot_market_amount);
                    }

                    $dfd.resolve();

                    return tot_market_amount;
                },

                calculFieldsAccount: function (property, $dfd){
                    var me = this,
                        account_percent = (me.$el.find("#account_percent").val() !== '') ? parseFloat(me.$el.find("#account_percent").val()) : 0,
                        account = (me.$el.find("#account").val() !== '') ? parseFloat(me.$el.find("#account").val()) : 0;
                        tot_market_amount = (me.$el.find("#tot_market_amount").val() !== '') ? parseFloat(me.$el.find("#tot_market_amount").val()) : 0;

                    if ((account_percent === 0 && account === 0) || tot_market_amount === 0) {
                        console.log('les champs sont à 0');
                        me.$el.find('#account').val(0);
                        me.$el.find('#account_percent').val(0);
                        return 0;
                    }

                    if (property === 'account_percent') {
                        console.log("Calculer la valeur du champs account");
                        account = roundWith((account_percent / 100) * tot_market_amount,2);
                    }
                    else if (property === 'account') {
                        console.log("Calculer la valeur du champs account_percent");
                        account_percent = (tot_market_amount === 0 ? 0 : roundWith((account / tot_market_amount) * 100,2));
                    }
                    else {
                        me.$el.find('#account').val(0);
                        me.$el.find('#account_percent').val(0);
                    }

                    me.data.nbRunsAccount = 1;
                    if ((property === 'account_percent')) { 
                        if (account !== parseFloat(me.$el.find("#account").val())) {
                            console.log("Changer le champs account");
                            me.$el.find('#account').val(account);
                            me.changeFieldValue('account', account);
                        }
                    }
                    else if ((property === 'account')) {
                        if (account_percent !== parseFloat(me.$el.find("#account_percent").val())) {
                            console.log("Changer le champs account_percent");
                            me.$el.find('#account_percent').val(account_percent);
                            me.changeFieldValue('account_percent', account_percent); 
                        }
                    }
                    else {
                        console.log('Mettre les champs account et account_percent à 0');
                        me.$el.find('#account').val(0);
                        me.$el.find('#account_percent').val(0);
                    }

                    $dfd.resolve();

                    return account;
                },
                
                calculFieldsAccountManagement: function (property, $dfd){
                    var me = this,
                        account_management_percent = (me.$el.find("#account_management_percent").val() !== '') ? parseFloat(me.$el.find("#account_management_percent").val()) : 0,
                        account_management = (me.$el.find("#account_management").val() !== '') ? parseFloat(me.$el.find("#account_management").val()) : 0;
                        account = (me.$el.find("#account").val() !== '') ? parseFloat(me.$el.find("#account").val()) : 0;
                        console.log(property);
                    
                    if ((account_management_percent === 0 && account_management === 0) || account === 0) {
                        console.log("cas d\'erreur");
                        me.$el.find('#account_management').val(0);
                        me.$el.find('#account_management_percent').val(0);
                        return 0;
                    }   
                
                    if (property === 'account_management_percent') {
                        //if (account_management !== parseFloat(me.$el.find("#account_management").val())) {
                        console.log("Calculer la valeur du champs account_management");
                        account_management = roundWith((account_management_percent / 100) * account,2);
                        //}
                    }
                    else if (property === 'account_management') {
                        //if (account_management_percent !== parseFloat(me.$el.find("#account_management_percent").val())) {
                        console.log("Calculer la valeur du champs account_management_percent");
                        account_management_percent = roundWith((account === 0 ? 0 : (account_management / account) * 100),2);
                        //}
                    }
                    else {
                        account_management = 0;
                        account_management_percent = 0;
                    }

                    me.data.nbRunsAccountManagement = 1;
                    if (property === 'account_management_percent') { 
                        me.$el.find('#account_management').val(account_management);
                        me.changeFieldValue('account_management', account_management);
                    }
                    else if (property === 'account_management') {
                        me.$el.find('#account_management_percent').val(account_management_percent);
                        me.changeFieldValue('account_management_percent', account_management_percent); 
                    }
                    else {
                        me.$el.find('#account_management').val(0);
                        me.$el.find('#account_management_percent').val(0);
                    }

                    $dfd.resolve();

                    return account_management;
                },

                calculFieldsRetentionMoney: function (property, $dfd){
                    var me = this,
                        retention_money_percent = (me.$el.find("#retention_money_percent").val() !== '') ? parseFloat(me.$el.find("#retention_money_percent").val()) : 0,
                        retention_money = (me.$el.find("#retention_money").val() !== '') ? parseFloat(me.$el.find("#retention_money").val()) : 0;
                        tot_market_amount = (me.$el.find("#tot_market_amount").val() !== '') ? parseFloat(me.$el.find("#tot_market_amount").val()) : 0;

                    if ((retention_money_percent === 0 && retention_money === 0) || tot_market_amount === 0) {
                        console.log("cas d\'erreur, les champs retention_money ou retention_money_percent ne sont pas remplis");
                        me.$el.find('#retention_money').val(0);
                        me.$el.find('#retention_money_percent').val(0);
                        return 0;
                    }
                
                    if (property === 'retention_money_percent') {
                        console.log("calcule du champs retention_money");
                        retention_money = roundWith((retention_money_percent / 100) * tot_market_amount,2);
                    }
                    else if (property === 'retention_money') {
                        console.log("calcule du champs retention_money_percent");
                        retention_money_percent = roundWith((tot_market_amount === 0 ? 0 : (retention_money / tot_market_amount) * 100),2);
                    }
                    else {
                        console.log("test");
                        retention_money = 0;
                        retention_money_percent = 0;
                    }

                    me.data.nbRunsRetentionMoney = 1;
                    if (property === 'retention_money_percent') { 
                        if (retention_money !== parseFloat(me.$el.find("#retention_money").val())) {
                            console.log("change la valeur du champs retention_money");
                            me.$el.find('#retention_money').val(retention_money);
                            me.changeFieldValue('retention_money', retention_money);
                        }
                    }
                    else if (property === 'retention_money') {
                        if (retention_money_percent !== parseFloat(me.$el.find("#retention_money_percent").val())) {
                            console.log("change la valeur du champs retention_money_percent");
                            me.$el.find('#retention_money_percent').val(retention_money_percent);
                            me.changeFieldValue('retention_money_percent', retention_money_percent); 
                        }
                    }
                    else {
                        console.log("Mise à 0");
                        me.$el.find('#retention_money').val(0);
                        me.$el.find('#retention_money_percent').val(0);
                    }

                    $dfd.resolve();

                    return retention_money;
                },

                calculFieldsDocPenality: function (property){
                    var me = this,
                        doc_penality_percent = (me.$el.find("#doc_penality_percent").val() !== '') ? parseFloat(me.$el.find("#doc_penality_percent").val()) : 0,
                        doc_penality = (me.$el.find("#doc_penality").val() !== '') ? parseFloat(me.$el.find("#doc_penality").val()) : 0;
                        tot_market_amount = (me.$el.find("#tot_market_amount").val() !== '') ? parseFloat(me.$el.find("#tot_market_amount").val()) : 0;

                    if ((doc_penality_percent === 0 && doc_penality === 0) || tot_market_amount === 0) {
                        me.$el.find('#doc_penality').val(0);
                        me.$el.find('#doc_penality_percent').val(0);
                        return 0;
                    }
                
                    if (property === 'doc_penality_percent') {
                        doc_penality = roundWith((doc_penality_percent / 100) * tot_market_amount,2);
                    }
                    else if (property === 'doc_penality') {
                        doc_penality_percent = roundWith((tot_market_amount === 0 ? 0 : (doc_penality / tot_market_amount) * 100),2);
                    }
                    else {
                        doc_penality = 0;
                        doc_penality_percent = 0;
                    }
 
                    me.data.nbRunsDocPenality = 1;
                    if (property === 'doc_penality_percent') { 
                        me.$el.find('#doc_penality').val(doc_penality);
                        me.changeFieldValue('doc_penality', doc_penality);
                    }
                    else if (property === 'doc_penality') {
                        me.$el.find('#doc_penality_percent').val(doc_penality_percent);
                        me.changeFieldValue('doc_penality_percent', doc_penality_percent); 
                    }
                    else {
                        me.$el.find('#doc_penality').val(0);
                        me.$el.find('#doc_penality_percent').val(0);
                    }
                },

                calculFieldsDepositRecovery: function (){
                    var me = this,
                        deposit = (me.$el.find("#deposit").val() !== '') ? parseFloat(me.$el.find("#deposit").val()) : 0,
                        progress = (me.$el.find("#progress").val() !== '') ? parseFloat(me.$el.find("#progress").val()) : 0,
                        deposit_recovery;
                    console.log(deposit); 
                    if (progress === 0 || deposit === 0) {
                        me.$el.find('#deposit_recovery').val(0);
                        return 0;
                    }

                    deposit_recovery = (progress === 100 ? deposit : 1.25 * deposit * (progress / 100));

                    if (deposit_recovery !== parseFloat(me.$el.find('#deposit_recovery').val())) {
                        me.$el.find('#deposit_recovery').val(deposit_recovery);
                        me.changeFieldValue('deposit_recovery', deposit_recovery);
                    }

                    return roundWith(deposit_recovery,2);
                },

                calculFieldsBalance: function ($dfd){
                    var me = this,
                        tot_market_amount = (me.$el.find("#tot_market_amount").val() !== '') ? parseFloat(me.$el.find("#tot_market_amount").val()) : 0,
                        account = (me.$el.find("#account").val() !== '') ? parseFloat(me.$el.find("#account").val()) : 0,
                        account_management = (me.$el.find("#account_management").val() !== '') ? parseFloat(me.$el.find("#account_management").val()) : 0,
                        retention_money = (me.$el.find("#retention_money").val() !== '') ? parseFloat(me.$el.find("#retention_money").val()) : 0,
                        balance;
                        
                    /* if (tot_market_amount === 0 || account_management === 0 || account === 0 || retention_money === 0) {
                        console.log("Cas d\'érreur : les valeurs sont à 0")
                        me.$el.find('#balance').val(0);
                        return 0;
                    } */
                    
                    balance = roundWith(tot_market_amount - (account + account_management + retention_money),2);

                    if (balance !== parseFloat(me.$el.find('#balance').val())) {
                        console.log("Changement de la valeur balance");
                        me.$el.find('#balance').val(balance);
                        me.changeFieldValue('balance', balance);
                    }

                    $dfd.resolve();

                    return balance;
                },

                calculFieldsBalanceDu: function (){
                    var me = this,
                        balance = (me.$el.find("#balance").val() !== '') ? parseFloat(me.$el.find("#balance").val()) : 0,
                        deposit_recovery = (me.$el.find("#deposit_recovery").val() !== '') ? parseFloat(me.$el.find("#deposit_recovery").val()) : 0,
                        parent_id = me.model.attributes.parent_id,
                        deposit = (me.$el.find("#deposit").val() !== '') ? parseFloat(me.$el.find("#deposit").val()) : 0,
                        balance_du;
                    
                    if (parent_id === null) {
                        console.log('parent_id est null');
                        me.$el.find('#balance_du').val(deposit);
                        me.changeFieldValue('balance_du', deposit);
                        return deposit;
                    }
                    else if (balance === 0 && deposit_recovery === 0) {
                        console.log('les données à 0');
                        me.$el.find('#balance_du').val(0);
                        return 0;
                    }

                    balance_du = roundWith(balance - deposit_recovery,2);

                    if (balance_du !== parseFloat(me.$el.find('#balance_du').val())) {
                        console.log('ici');
                        me.$el.find('#balance_du').val(balance_du);
                        me.changeFieldValue('balance_du', balance_du);
                    }

                    return balance_du;
                },

                calculFieldsAmountToPay: function (){
                    var me = this,
                        deduction_previous_payment = (me.$el.find("#deduction_previous_payment").val() !== '') ? parseFloat(me.$el.find("#deduction_previous_payment").val()) : 0,
                        balance_du = (me.$el.find("#balance_du").val() !== '') ? parseFloat(me.$el.find("#balance_du").val()) : 0,
                        parent_id = me.model.attributes.parent_id,
                        deposit = (me.$el.find("#deposit").val() !== '') ? parseFloat(me.$el.find("#deposit").val()) : 0,
                        amount_to_pay;
                    
                    if(parent_id === null) {
                        me.$el.find('#amount_to_pay').val(deposit)
                        me.changeFieldValue('amount_to_pay', deposit);
                        return deposit;
                    }
                    else if (balance_du === 0 && deduction_previous_payment === 0) {
                        me.$el.find('#amount_to_pay').val(0);
                        return 0;
                    }

                    amount_to_pay = roundWith(balance_du - deduction_previous_payment,2);

                    if (amount_to_pay !== parseFloat(me.$el.find('#amount_to_pay').val())) {
                        me.$el.find('#amount_to_pay').val(amount_to_pay);
                        me.changeFieldValue('amount_to_pay', amount_to_pay);
                    }

                    return amount_to_pay;
                },

                changeFieldValue: function (elId, value) {
                    var me = this;
                    if (me.model !== undefined && me.model !== null) {
                        me.model.setWithVerif(elId, value);
                        Livewire.emit('field-updated', elId, me.$el.find("#" + elId).val());
                    }
                    if (me.attributes.parent !== null && me.attributes.parent !== undefined) {
                        me.attributes.parent.setModel(elId, value);
                    }
                    res = 0;
                    console.log(elId);
                    switch (elId) {
                        case 'total_market_amount' :
                        case 'total_modify_market_amount' :
                            res = me.calculFieldsAdditionMarket($.Deferred()); 
                            console.log('AdditionMarket',res);
                            break;

                        case 'market_amount' :
                        case 'modify_market_amount' :
                            res = me.calculFieldsMarket($.Deferred()); 
                            console.log('Market',res);
                            break;
                        
                        case 'addition_market_amount':
                        case 'tot_market_amount' :
                            res = me.calculFieldsProgress($.Deferred());
                            console.log('progress', res);
                            break;

                        case 'doc_penality' : 
                        case 'doc_penality_percent' : 
                            (me.data.nbRunsDocPenality === 0 ? me.calculFieldsDocPenality(elId) : me.data.nbRunsDocPenality = 0);
                            console.log("doc_pen", res, elId);
                            break;

                        case 'retention_money' : 
                        case 'retention_money_percent' : 
                            if (me.data.nbRunsRetentionMoney === 0) { 
                                res = me.calculFieldsRetentionMoney(elId, $.Deferred());
                                console.log("Retention_money : ", res, elId); 
                            } else { 
                                me.data.nbRunsRetentionMoney = 0 
                            }
                            if (elId === 'retention_money') {
                                res = me.calculFieldsBalance($.Deferred());
                                console.log("Balance : ", res, elId);
                            }
                            break;
                        
                        case 'account' : 
                        case 'account_percent' : 
                            if (me.data.nbRunsAccount === 0) { 
                                res = me.calculFieldsAccount(elId, $.Deferred());
                                console.log("Account : ", res, elId);
                            } else { 
                                me.data.nbRunsAccount = 0 
                            }
                            if (elId === 'account') {
                                res = me.calculFieldsBalance($.Deferred());
                                console.log("Balance : ", res, elId);
                            }
                            break;

                        case 'account_management' : 
                        case 'account_management_percent' : 
                            if (me.data.nbRunsAccountManagement === 0) { 
                                res = me.calculFieldsAccountManagement(elId, $.Deferred());
                                console.log("Account_management : ", res, elId);
                            } else { 
                                me.data.nbRunsAccountManagement = 0 
                            }
                            break;
                        
                        case 'deposit' : 
                        case 'progress' :
                            res = me.calculFieldsDepositRecovery();
                            console.log("Deposit_recovery : ", res, elId);
                            if(elId === 'deposit'){
                                res = me.calculFieldsDeductionPreviousPayment();
                                console.log('Deduction_previous_payment', res, elId);

                                res1 = me.calculFieldsBalanceDu();
                                console.log("balance_du : ", res1, elId);
                            }
                            break;
                        
                        case 'balance' :
                        case 'deposit_recovery' : 
                            res = me.calculFieldsBalanceDu();
                            console.log("balance_du : ", res, elId);
                            break;

                        case 'balance_du' : 
                        case 'deduction_previous_payment' :
                            res = me.calculFieldsAmountToPay();
                            console.log("Montant", res);
                            break;
                    }
                },

                changeField: function (e) {
                    var me = this;
                    me.changeFieldValue(e.currentTarget.id, $(e.currentTarget).val());
                },

                changeToggleCheckbox: function (e) {
                    var me = this;
                    me.changeFieldValue(e.currentTarget.id, e.currentTarget.checked);
                },

                setId: function (id, workSiteLotCompanyId) {
                    var me = this;
                    me.attributes.id = (id === null || id === undefined)? 0 : id;
                    me.attributes.workSiteLotCompanyId = (workSiteLotCompanyId === null || workSiteLotCompanyId === undefined)? 0 : workSiteLotCompanyId;
                    if (!me.data.alreadyRender) {
                        me.data.alreadyRender = true;
                        me.render();
                    }

                    //Mise à jour des infos
                    Livewire.emit('monitoring-settings-form-update', me.attributes.workSiteLotCompanyId, me.attributes.id,  me.attributes.isModal, me.attributes.isEdit);
                },

                formSubmit: function () {
                    Livewire.emit('monitoring-settings-form-submit');
                },

                triggerSuccess: function (result) {
                    Livewire.emit('monitoring-settings-form-success', result);
                },

                triggerErrors: function (errors) {
                    Livewire.emit('monitoring-settings-form-error', errors);
                },

                saveModel: function () {
                    var me = this;
                    if (me.data.alreadySave) return;
                    me.data.alreadySave = true;
                    me.$el.find('input[type=submit]').prop('disabled', true);

                    me.model.save({'_token': me.$el.find('[name=_token]').val()})
                        .done(function (r) {
                            if (me.data.alert === null) {
                                me.data.alert = new App.View.Component.Alert({
                                    el: me.attributes.elAlert,
                                    attributes: {
                                        title: "<?php echo __("monitoring::monitoring.Monitoring"); ?> - "
                                    }
                                });
                            }
                            me.triggerSuccess(r.data);
                            me.data.alreadySave = false;
                        })
                        .fail(function (r) {
                            var errors = r.responseJSON.errors;
                            me.triggerErrors(errors)
                        });
                }
            });

            // new App.Module.Monitoring.View.Monitoring.Settings();
        });
    });
</script>