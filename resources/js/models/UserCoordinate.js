'use strict';

App.Constants.Qualities = [
    'Monsieur',
    'Madame',
    'Mademoiselle'
];
App.Constants.Countries = [
    { "value": "France", "data": "FR" }
];
App.Constants.Categories = [
    { "value": "Super Administrateur", "data": "1" },
    { "value": "Administrateur", "data": "2" },
    { "value": "Manageur", "data": "3" },
    { "value": "Utilisateur", "data": "4" }
];
// { "value": "Visiteur", "data": "5" }

App.Model.User.Coordinate = App.Model.Model.extend({
    defaults: {
        id: null,
        user_id: 0,
        category_id: 0,
        quality: "",
        address: "",
        address2: "",
        zip_code: "",
        city: "",
        region: "",
        country: "",
        phone: "",
        mobile: "",
        enabled: 1,
        suppressed: 0,
        user: null,
        category: null
    },
    urlRoot: "/user/coordinate",
    parse: function (resp) {
        // TODO
        // resp.category = new App.Model.UserCategory(resp.userCategory);
        return resp;
    }
});