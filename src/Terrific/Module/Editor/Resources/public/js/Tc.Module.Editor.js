(function ($) {

    "use strict";

    /**
     * Editor module implementation.
     *
     * @author Terrific Composer
     * @namespace Tc.Module
     * @class Editor
     * @extends Tc.Module
     */
    Tc.Module.Editor = Tc.Module.extend({
        /**
         * Initializes the Editor module.
         *
         * @method init
         * @return {void}
         * @constructor
         * @param {jQuery} $ctx the jquery context
         * @param {Sandbox} sandbox the sandbox to get the resources from
         * @param {Number} id the unique module id
         */
        init:function ($ctx, sandbox, id) {
            // call base constructor
            this._super($ctx, sandbox, id);
            this.model = window.Preview;
        },

        /**
         * Hook function to do all of your module stuff.
         *
         * @method on
         * @param {Function} callback function
         * @return void
         */
        on:function (callback) {
            var self = this,
                $ctx = this.$ctx,
                $editor = $('.editor', $ctx),
                type = $editor.data('type'),
                model = this.model.get(type),
                delay;


            var editor = CodeMirror($editor.get(0), {
                mode: model.get('mode'),
                value: model.get('code'),
                theme: 'monokai',
                onChange: function() {
                    clearTimeout(delay);
                    delay = setTimeout(function() {
                        // change model
                        model.set('code', editor.getValue());
                    }, 300);
                }
            });

            callback();
        }
    });
})(Tc.$);
