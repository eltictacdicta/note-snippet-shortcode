(function() {
    tinymce.PluginManager.add('button-shortcode-snippet', function( editor, url ) {
        editor.addButton( 'button-shortcode-snippet', {
            text: ' Note snippet',
            icon: 'mce-ico mce-i-pluscircle',
            onclick: function() {
                editor.windowManager.open( {
                    title: 'Add Note Snippet',
                    body: [
                        /*{
                            type: 'listbox',
                            label: 'Size',
                            name: 'size',
                            values: [
                                { text: 'Small', value: 'small' },
                                { text: 'Regular', value: 'regular' },
                                { text: 'Wide', value: 'wide' },
                                { text: 'Large', value: 'large' },
                            ],
                            value: ''
                        },*/
                        
                        {
                            type: 'textbox',
                            label: 'Question',
                            name: 'pregunta',
                            // tooltip: 'Some nice tooltip to use',
                            value: ''
                        },
                        {
                            type: 'textbox',
                            label: 'Response',
                            name: 'respuesta',
                            // tooltip: 'Some nice tooltip to use',
                            value: ''
                        },
                        {
                            type: 'textbox',
                            label: 'Link (URL)',
                            name: 'url',
                            //tooltip: 'If linking to another page, please use a relative URL - eg. /about not http://google.com/about',
                            value: ''
                        }
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[nota_snippet url="' + e.data.url + '" pregunta="' + e.data.pregunta + '" respuesta="' + e.data.respuesta + '"]');
                    }
                });
            },
        });
        
    });
    

})();
