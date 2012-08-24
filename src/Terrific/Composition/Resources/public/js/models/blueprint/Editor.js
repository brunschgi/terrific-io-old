(function () {

    "use strict";

    window.blueprint.Editor = Backbone.Model.extend({

        defaults:function () {
            return {
                mode:'text/plain',
                code:'Plain Text'
            };
        },

        initialize:function () {
            if (!this.get('mode')) {
                this.set({'mode':this.defaults.mode});
            }

            if (!this.get('code')) {
                this.set({'code':this.defaults.code});
            }
        },

        clear:function () {
            this.destroy();
        }
    });
})();
