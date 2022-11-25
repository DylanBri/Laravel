/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var $dfd = $.Deferred();
var $dfdinit = $.Deferred();

global.App = {
    Api: {},
    Collection: {},
    Model: {},
    Module: {},
    View: {},
    Constants: {}
};
global.My = {
    auth: false,
    Client: {},
    User: {},
    Profile: {},
    Right: {},
    isSuperAdmin: null,
    isAdmin: null,
    isManager: null,
    isUser: null,
    isViewer: null
};

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/**
 * Initialisation du composant Moment
 */

window.moment = require('moment');
const lang = document.documentElement.lang;
moment.locale(lang);

/**
 * Initialisation des composants Vue
 */

window.Vue = require('vue');

/**
 * Backbone et Backgrid
 */

require('underscore');
window.Backbone = require('backbone');

// Corrige le problème dans le grid pour la suppression des lignes
// Laisser avant backbone.paginator (ne fonctionne pas ailleurs)
// Define the Collection's inheritable methods.
_.extend(window.Backbone.Collection.prototype, window.Backbone.Events, {

    // Internal method called by both remove and set.
    _removeModels: function(models, options) {
        var removed = [];
        for (var i = 0; i < models.length; i++) {
            var model = this.get(models[i]);
            if (!model) continue;

            // var index = this.indexOf(model);
            var index = -1;
            for (var ind = 0; ind < this.models.length; ind++) {
                if (this.models[ind].cid === model.cid) {
                    index = ind;
                }
            }
            this.models.splice(index, 1);
            this.length--;

            // Remove references before triggering 'remove' event to prevent an
            // infinite loop. #3693
            delete this._byId[model.cid];
            var id = this.modelId(model.attributes);
            if (id != null) delete this._byId[id];

            if (!options.silent) {
                options.index = index;
                model.trigger('remove', model, this, options);
            }

            removed.push(model);
            this._removeReference(model, options);
        }
        return removed;
    },
});

window.PageableCollection = require('backbone.paginator');
window.Backgrid = require('backgrid');
require('backgrid-paginator');

/**
 * Handlebars
 */

// window.Handlebars = require("handlebars");
window.Handlebars = require('./lib/handlebars/4.7.7/handlebars.min');

// Deprecated since version 0.8.0
window.Handlebars.registerHelper("formatDate", function (datetime, format) {
    if (moment) {
        // can use other formats like 'lll' too
        // format = DateFormats[format] || format;
        return moment(datetime).format(format);
    }
    else {
        return datetime;
    }
});

// Deprecated since version 0.8.0
window.Handlebars.registerHelper("limit", function (string, size) {
    return string.substring(0, size-1) + ' ...';
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Vue.component('welcome', require('./components/Welcome.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*const app = new window.Vue({
    el: '#app'
});*/

/**
 * Summernote
 */

require('summernote/dist/summernote.min');
require('summernote/dist/summernote-lite.min');
require('summernote/dist/summernote-bs4.min');

/**
 * Tinymce
 */

// require('/node_modules/tinymce/jquery.tinymce');
// require('/node_modules/tinymce/tinymce');

/**
 * Ckeditor
 */

// window.ClassicEditor = require('@ckeditor/ckeditor5-build-classic/build/ckeditor');

/**
 * Ajout des js de bases
 */

require('./app/Api');
require('./app/View');
require('./app/Model');
require('./app/Collection');
require('./app/PageableCollection');

require('./models/User');
require('./models/Profile');
require('./models/Client');
require('./models/UserCoordinate');

require('./collections/Clients');
require('./collections/Users');

require('./collections/pageable/Clients');
require('./collections/pageable/Users');

App.Api.get('/session/profile/logged')
    .done(function (res) {
        var r = res.data;
        My.auth = true;
        My.Profile = new App.Model.Profile({
            'user_id': r.profile.user_id,
            'client_id': r.profile.client_id,
            'role_id': r.profile.role_id,
        });

        My.isSuperAdmin = r.isSuperAdmin;
        My.isAdmin = r.isAdmin;
        My.isManager = r.isManager;
        My.isUser = r.isUser;
        My.isViewer = r.isViewer;

        $dfdinit.resolve();
    });

//document ready
$(function () {

    /**
     * Initialisation du composant Datepicker regional
     */

    $.datepicker.regional.fr = {
        closeText: "Fermer",
        prevText: "Précédent",
        nextText: "Suivant",
        currentText: "Aujourd'hui",
        monthNames: [ "janvier", "février", "mars", "avril", "mai", "juin",
            "juillet", "août", "septembre", "octobre", "novembre", "décembre" ],
        monthNamesShort: [ "janv.", "févr.", "mars", "avr.", "mai", "juin",
            "juil.", "août", "sept.", "oct.", "nov.", "déc." ],
        dayNames: [ "dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi" ],
        dayNamesShort: [ "dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam." ],
        dayNamesMin: [ "D", "L", "M", "M", "J", "V", "S" ],
        weekHeader: "Sem.",
        dateFormat: "dd/mm/yy",
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ""
    };

    $dfd.resolve();
    console.log('ready')
});
// end document ready

$.when($dfd, $dfdinit).then(function () {

    /*tinymce.init({
        selector:'textarea.tinymce',
        height: 300
    });*/

    /*ClassicEditor
        .create( document.querySelector( '.ckeditor' ) )
        .catch( error => {
            console.error( error );
        } );*/

    $(document).trigger('app.ready', App);
    console.log('app.ready')
});
