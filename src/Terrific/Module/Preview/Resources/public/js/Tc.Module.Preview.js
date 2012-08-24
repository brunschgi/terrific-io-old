(function ($) {

    "use strict";

    /**
     * Preview module implementation.
     *
     * @author Terrific Composer
     * @namespace Tc.Module
     * @class Preview
     * @extends Tc.Module
     */
    Tc.Module.Preview = Tc.Module.extend({
        /**
         * Initializes the Preview module.
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
                model = this.model,
                $iframe = $ctx.contents();

            // prepare iframe head
            $('head', $iframe)[0].innerHTML = '<style></style>';

            model.get('markup').on('change:code', function() {
                $('body', $iframe).html(model.get('markup').get('code'));
            });

            model.get('style').on('change:code', function() {
                $('style', $iframe).text(model.get('style').get('code'));
            });

            model.get('script').on('change:code', function() {
                // clear & redraw the markup to remove events
                $('body', $iframe).empty().html(model.get('markup').get('code'));

                var doc = $iframe[0];

                var jqueryElement = doc.createElement('script');
                jqueryElement.setAttribute('type','text/javascript');
                jqueryElement.setAttribute('src', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');

                var scriptElement = doc.createElement('script');
                scriptElement.setAttribute('type','text/javascript');
                scriptElement.appendChild(doc.createTextNode('try {' + model.get('script').get('code') + ' } catch(e) { console.log(e.message); }'));

                var head = doc.getElementsByTagName('head')[0];
                head.appendChild(jqueryElement);
                head.appendChild(scriptElement);

                window.onerror = function (msg, url, line) {
                    console.log(msg);
                };
            });

            callback();
        }
    });
})(Tc.$);
