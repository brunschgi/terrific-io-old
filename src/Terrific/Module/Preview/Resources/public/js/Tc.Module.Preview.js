(function ($) {

    "use strict";

    Tc.Module.Preview = Tc.Module.extend({

        init:function ($ctx, sandbox, id) {
            // call base constructor
            this._super($ctx, sandbox, id);
            this.model = sandbox.getConfigParam('model').module;
        },

        on:function (callback) {
            var self = this,
                $ctx = this.$ctx,
                doc = $ctx.contents()[0],
                model = this.model,
                baseurl = '/js/dependencies/' + model.get('id'),
                view = doT.template($('#mod-preview').text());

            // create DOM
            $ctx.html(view());

            var head = doc.getElementsByTagName('head')[0],
                body = doc.getElementsByTagName('body')[0],
                $body = $(body);

            // because iframe content can not be rendered directly with doT, we need to render it manually
            head.innerHTML = '<style></style>';
            var style = doc.getElementsByTagName('style')[0];

            var requirejs = doc.createElement('script');
            requirejs.setAttribute('type','text/javascript');
            requirejs.setAttribute('src', '/js/dependencies/libraries/require.js');

            var requireConfig = doc.createElement('script');
            requireConfig.setAttribute('type','text/javascript');
            requireConfig.appendChild(doc.createTextNode('requirejs.config({ baseUrl: "' + baseurl + '", paths: { lib: "../libraries" }});'));

            // start loading
            requirejs.onload = function() {
                head.appendChild(requireConfig);

                // initial rendering
                render();
            };

            head.appendChild(requirejs);

            var render = function() {
                // style -> including all external resources
                style.innerHTML = '<style>body { margin: 0; } ' + model.get('style').get('code') + '</style>';

                // markup
                body.innerHTML = model.get('markup').get('code');

                // script -> wrapped with a require.js definition for all external resources
                var script = doc.createElement('script');
                script.setAttribute('type','text/javascript');
                script.appendChild(doc.createTextNode('require(["lib/jquery", "lib/terrific"], function() {' + model.get('script').get('code') + ' });'));
                head.appendChild(script);

                // set height
                $ctx.height($body.outerHeight());
            };

            // editor events
            model.get('markup').on('change:code', function() {
                render();
            });

            model.get('style').on('change:code', function() {
                render();
            });

            model.get('script').on('change:code', function() {
                render();
            });

            callback();
        },

        onActivate: function(data) {
            var self = this,
                $ctx = this.$ctx;

            if(data.type === 'preview') {
                $ctx.show();
            }
            else {
                $ctx.hide();
            }
        }
    });
})(Tc.$);
