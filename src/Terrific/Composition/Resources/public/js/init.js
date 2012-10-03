(function($) {
    "use strict";

    // global config
    Tc.Config = $.extend({}, Tc.Config, { 'baseurl' : $('body').data('baseurl') });

    // routing stuff
    var moduleRouter = new window.ModuleRouter();
    Backbone.history.start({pushState: false});

})(Tc.$);


// global error handler
window.onerror = function (msg, url, line) {
    console.log(msg);
};