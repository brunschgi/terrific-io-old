(function($) {
    "use strict";

    /* routing stuff */
    var editRouter = new window.EditRouter();
    Backbone.history.start({pushState: false});

    /* navigate to edit page */
    //editRouter.navigate('edit', { trigger : true });
})(Tc.$);


window.onerror = function (msg, url, line) {
    console.log(msg);
};