(function ($) {

    "use strict";

    Tc.Module.Preview = Tc.Module.extend({

        init:function ($ctx, sandbox, id) {
            // call base constructor
            this._super($ctx, sandbox, id);
            this.model = sandbox.getConfigParam('model').module;
            this.offsetY = $(window).height() - 50;
        },

        on:function (callback) {
            var self = this,
                $ctx = this.$ctx,
                model = this.model,
                dependencyBaseurl = '/js/dependencies/' + model.get('id'),
                baseurl = this.sandbox.getConfigParam('baseurl'),
                view = doT.template($('#mod-preview').text());


            // local models & settings
            var markup = model.get('markup'),
                style = model.get('style'),
                script = model.get('script'),
                precompilers = {
                    markup : null,
                    style : null,
                    script : null
                };

            var setPrecompilers = function() {
                if(style.get('mode') !== 'text/css') {
                    precompilers['style'] = style.get('mode');
                }
                else {
                    precompilers['style'] = null;
                }
            };

            // initial set of precompilers
            setPrecompilers();

            // create DOM
            $ctx.html(view());

            var $iframe = $ctx.find('iframe'),
                doc = $iframe.contents()[0],
                $divider = $('.divider', $ctx);

            // FF hack
            doc.open();
            doc.close();

            var head = doc.getElementsByTagName('head')[0],
                body = doc.getElementsByTagName('body')[0];

            // because iframe content can not be rendered directly with doT, we need to render it manually
            head.innerHTML = '<style></style>';
            var moduleStyle = doc.getElementsByTagName('style')[0];

            var requirejs = doc.createElement('script');
            requirejs.setAttribute('type','text/javascript');
            requirejs.setAttribute('src', '/js/dependencies/libraries/require.js');

            // require config
            var require = {
                baseUrl: dependencyBaseurl,
                paths:{
                    lib:'../libraries'
                },
                shim:{
                    'lib/terrific':{
                        deps:['lib/jquery'],
                        exports:'Tc'
                    }
                }
            };

            var requireConfig = doc.createElement('script');
            requireConfig.setAttribute('type','text/javascript');
            requireConfig.appendChild(document.createTextNode('requirejs.config(' + JSON.stringify(require) + ')'));

            var moduleScript = null;

            // start loading
            requirejs.onload = function() {
                head.appendChild(requireConfig);
                // initial rendering (compile everything)
                render({ markup : true, style : true, script : true });
            };
            head.appendChild(requirejs);

            var render = function(compile) {
                compile = $.extend({}, { markup : false, style : false, script : false }, compile);

                function renderMarkupAndScript() {
                    // markup (always renew because of possibly applied styles and functionality from js)
                    body.innerHTML = markup.get('code');

                    // script -> wrapped with a require.js definition for all external resources
                    if(moduleScript) {
                        head.removeChild(moduleScript);
                    }
                    moduleScript = doc.createElement('script');
                    moduleScript.setAttribute('type','text/javascript');
                    moduleScript.appendChild(doc.createTextNode('require(["lib/jquery", "lib/terrific"], function() {' + script.get('code') + ' });'));

                    head.appendChild(moduleScript);
                }

                // style -> including all external resources
                var userStyle = style.get('code');
                if(compile['style'] && precompilers['style']) {
                    $.ajax(baseurl + '/api/precompile/' + precompilers['style'], {
                        type : 'POST',
                        data : userStyle,
                        success : function (data) {
                            moduleStyle.innerHTML = data;
                            renderMarkupAndScript();
                        }
                    });
                } else if (compile['style']) {
                    moduleStyle.innerHTML = userStyle;
                    renderMarkupAndScript();
                }
                else {
                    renderMarkupAndScript();
                }
            };

            // editor events
            markup.on('change:code', function() {
                render({ markup : true});
            });

            style.on('change:code', function() {
                render({ style : true});
            });

            script.on('change:code', function() {
                render({ script : true});
            });

            // editor settings events
            style.on('change:mode', function() {
                setPrecompilers();
                render({ style : true});
            });

            // divider
            $divider.draggable({
                handle: '.header',
                iframeFix: true,
                axis: 'y',
                stop: function(e, ui) {
                    self.offsetY = ui.position.top;
                    self.fire('resize', { height : self.offsetY })
                }
            });

            callback();
        },

        onActivate: function(data) {
            var self = this,
                $ctx = this.$ctx;

            if(data.type === 'preview') {
                $('.divider', $ctx).animate({'top' : 0}, 200);
            }
            else {
                $('.divider', $ctx).animate({'top' : this.offsetY}, 200);
            }
        },

        onShare: function() {
            var self = this,
                model = this.model;

            model.save({ 'inWork' : false, 'shared' : true }, { success : function() {
                console.log('successfully shared');
            }});
        },

        onSave: function() {
            var self = this,
                model = this.model;

            model.save({ 'inWork' : true }, { success : function() {
                console.log('successfully saved');
            }});
        }
    });
})(Tc.$);
