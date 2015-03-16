(function() {

    tinymce.create('tinymce.plugins.wp_microdataPlugin', {
        init : function(ed, url) {

            ed.addButton('wp_microdata', {
                title   : 'WP Microdata',
                text    : ed.getLang( 'wp_microdataPlugin.title', 'Microdata' ),
                cmd     : 'wp_microdata',
                icon    : false,
                type    : 'menubutton',
                menu    : [
                {
                    text    : ed.getLang( 'wp_microdataPlugin.wrapper', 'Add Wrapper' ),
                    onclick: function() {
                        ed.windowManager.open( {
                            title: ed.getLang( 'wp_microdataPlugin.wrapperTitle', 'Insert Microdata Wrapper' ),
                            body: [
                                {
                                    type: 'container',
                                    html: "<p>"+ ed.getLang( 'wp_microdataPlugin.wrapperIntro', "This element should wrap all elements with microdata." ) +"</p>"
                                },
                                {
                                    type: 'textbox',
                                    name: 'type',
                                    label: ed.getLang( 'wp_microdataPlugin.wrapperType', 'Type' ),
                                    value: 'http://schema.org/Article'
                                }
                            ],
                            onsubmit: function( e ) {

                                var selected_text = ed.selection.getContent();

                                ed.insertContent( "[microdata type='"+ e.data.type +"']" + selected_text + '[/microdata]' );
                            }
                        });
                    }
                },
                {
                    text    : ed.getLang( 'wp_microdataPlugin.element', 'Add Element' ),
                    onclick: function() {
                        ed.windowManager.open( {
                            title: ed.getLang( 'wp_microdataPlugin.elementTitle', 'Insert Microdata Element' ),
                            body: [
                                {
                                    type: 'container',
                                    html: '<p>'+ ed.getLang( 'wp_microdataPlugin.elementInto', 'The property of each element should match the specification for the itemscope.' ) +'</p>'
                                },
                                {
                                    type: 'textbox',
                                    name: 'prop',
                                    label: ed.getLang( 'wp_microdataPlugin.elementProperty', 'Property' ),
                                    value: ''
                                },
                                {
                                    type: 'listbox',
                                    name: 'element',
                                    label: ed.getLang( 'wp_microdataPlugin.elementHTML', 'HTML Element' ),
                                    'values': [
                                        {text: 'span',      value: 'span'},
                                        {text: 'div',       value: 'div'},
                                        {text: 'p',         value: 'p'},
                                        {text: 'section',   value: 'section'},
                                        {text: 'aside',     value: 'aside'},
                                        {text: 'h1', 		value: 'h1'},
                                        {text: 'h2', 		value: 'h2'},
                                        {text: 'h3', 		value: 'h3'},
                                        {text: 'h4', 		value: 'h4'},
                                        {text: 'h5', 		value: 'h5'},
                                        {text: 'h6', 		value: 'h6'}
                                    ]
                                },
                                
                            ],
                            onsubmit: function( e ) {
                                
                                var selected_text = ed.selection.getContent();

                                ed.insertContent( "[md_item prop='"+ e.data.prop +"' element='"+ e.data.element +"']"+ selected_text +"[/item]" );

                            }
                        });
                    }
                }
                ]
            });

        }
    }); 

    tinymce.PluginManager.add("wp_microdata", tinymce.plugins.wp_microdataPlugin);

})();