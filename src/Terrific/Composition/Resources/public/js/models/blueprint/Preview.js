(function () {

    "use strict";

    window.blueprint.Preview = Backbone.Model.extend({

        defaults:function () {
            return {
                markup: new window.blueprint.Editor({ 'mode' : 'text/html', 'code' : '<div class="mod mod-draft"></div>'}),
                style: new window.blueprint.Editor({ 'mode' : 'text/css', 'code' : ''}),
                script: new window.blueprint.Editor({ 'mode' : 'text/javascript', 'code' : ''})
            };
        },

        initialize:function () {
            if (!this.get('markup')) {
                this.set({'markup':this.defaults.markup});
            }

            if (!this.get('style')) {
                this.set({'style':this.defaults.style});
            }

            if (!this.get('script')) {
                this.set({'script':this.defaults.script});
            }
        },

        clear:function () {
            this.destroy();
        }
    });
})();
