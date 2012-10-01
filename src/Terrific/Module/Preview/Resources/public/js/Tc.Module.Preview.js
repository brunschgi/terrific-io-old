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
                $iframe = $ctx.contents(),
                model = this.model;

            // create DOM
            var view = doT.template($('#mod-preview').text());
            $ctx.html(view({ model : model }));
            $('head', $iframe)[0].innerHTML = '<style></style>';

            // because iframe content can not be rendered directly with doT, we need to render it manually
            var render = function() {
                // style
                $('style', $iframe).text(model.get('style').get('code'));

                // markup
                $('body', $iframe).empty().html(model.get('markup').get('code'));

                // script
                var doc = $iframe[0];

                var jqueryElement = doc.createElement('script');
                jqueryElement.setAttribute('type','text/javascript');
                jqueryElement.setAttribute('src', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');

                var scriptElement = doc.createElement('script');
                scriptElement.setAttribute('type','text/javascript');
                scriptElement.appendChild(doc.createTextNode('$(function() { try {' + model.get('script').get('code') + ' } catch(e) { console.log(e.message); } });'));

                var head = doc.getElementsByTagName('head')[0];
                head.appendChild(jqueryElement);
                head.appendChild(scriptElement);
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

            // initial rendering
            render();

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
