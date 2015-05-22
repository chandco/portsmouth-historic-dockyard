(function($) {

    var $buttons;

    tinymce.create('tinymce.plugins.cf_features', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.


        
    


         */


        init : function(ed, url) {


            function my_cleanup_callback(type,value) {
              switch (type) {
                case 'get_from_editor':
                  // Remove &nbsp; characters
                  //value = value.replace(/&nbsp;/ig, ' ');
                  break;
                case 'insert_to_editor':
                case 'submit_content':
                case 'get_from_editor_dom':
                case 'insert_to_editor_dom':
                case 'setup_content_dom':
                case 'submit_content_dom':
                default:
                  break;
              }
              return value;
            }

            

            var t = this;

            

          

            ed.on('keydown', function(e) {
                
                if (e.keyCode != 13 || e.shiftKey) return;

                var node = ed.selection.getNode();

                console.log(e);

                var $el = ed.$(node);

                console.log($el);

                if ($el.parent('.col-smart').length) {

                    console.log("In a column...", $el);
                    e.shiftKey = true;
                    return e;
                }                    
                
                
            });

            ed.addButton('cta-link', {
                title: 'Convert Link to CTA',
                cmd: 'cta-link',
                icon: false,
                image : url + '/../img/cta.png'
            });

            ed.addButton('cta-link-wide', {
                title: 'Convert Link to CTA (Wide)',
                cmd: 'cta-link-wide',
                icon: false,
                image : url + '/../img/cta.png'
            });

            ed.addCommand('cta-link', function() {
                var selected_text = ed.selection.getNode();
                var return_text = selected_text;

                if (ed.dom.is(selected_text, 'a')) {

                    ed.dom.removeClass(selected_text, 'cta');
                    ed.dom.toggleClass(selected_text, 'cta-inline');
                }
                //return_text = '[wide_background]' + selected_text + '[/wide_background]';
                
            });

            ed.addCommand('cta-link-wide', function() {
                var selected_text = ed.selection.getNode();
                var return_text = selected_text;

                if (ed.dom.is(selected_text, 'a')) {
                    ed.dom.removeClass(selected_text, 'cta-inline');
                    ed.dom.toggleClass(selected_text, 'cta');
                }
                //return_text = '[wide_background]' + selected_text + '[/wide_background]';
                
            });

           


            
            ed.addButton('feature', {
                title: 'Insert Feature Box',
                cmd: 'feature',
                image : url + '/../img/feature.png'
            });

            

            ed.addButton('widebg', {
                title: 'Add full width Background',
                cmd: 'widebg',
                image : url + '/../img/widebg.jpg'
            });

            

            ed.addCommand('widebg', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '{{section:yellow}}\
                &nbsp;' + selected_text + '';

                var wm = tinyMCE.activeEditor.windowManager;

                wm.open({
                    title: "Insert colour divider",
                    url: mcedata.editorURL + '/section-picker.html',
                    inline: 1,
                    width: 800,
                    height: 500,

                });

                //wm.onClose.add(function() {

                    
                //});

                //
            });





            ed.addButton('addIcons', {
            type: 'menubutton',
            text: 'Insert Icon',
            icon: false,
            menu: [
                    {  icon: ' fa fa-file-pdf-o', text: 'PDF Icon', onclick: function() { insertIcon( 'file-pdf-o', ed); } },
                    {  icon: ' fa fa-download', text: 'Download', onclick: function() { insertIcon( 'download', ed); } },
                    {  icon: ' fa fa-envelope', text: 'Envelope', onclick: function() { insertIcon( 'envelope', ed); } },
                    {  icon: ' fa fa-facebook-square', text: 'Facebook', onclick: function() { insertIcon( 'facebook-square', ed); } },
                    {  icon: ' fa fa-twitter', text: 'Twitter', onclick: function() { insertIcon( 'twitter', ed); } },
                    {  icon: ' fa fa-pinterest', text: 'Pinterest', onclick: function() { insertIcon( 'pinterest', ed); } },
                ]
            });

            ed.addButton('imageStyler', {
            type: 'menubutton',
            text: 'Image Styles',
            icon: false,
            menu: [
                   // {  icon: ' fa fa-th-list', text: 'Start List (do this first)', onclick: function() { startList( 'file-pdf-o', ed); } },
                    {  icon: 'ci polaroid rotate-left', text: 'Border, Rotate Left', onclick: styleImage },
                    {  icon: 'ci polaroid rotate-right', text: 'Border, Rotate Right', onclick: styleImage },
                    {  icon: 'ci polaroid', text: 'Border', onclick: styleImage },
                    {  icon: 'ci rotate-left', text: 'Rotate Left', onclick: styleImage },
                    {  icon: 'ci rotate-right', text: 'Rotate Right', onclick: styleImage },
                    {  icon: ' ', text: 'None', onclick: styleImage }
                ]
            });



            function insertIcon(icon, ed) {
                ed.insertContent('<i class="fa fa-' + icon + '">&nbsp;</i>');
            }



            function styleImage() {

             

                var selected_text = tinyMCE.activeEditor.selection.getNode();

                

                

                var icon = arguments[0].control.settings.icon;
                console.log(icon.split(" "));
                
                console.log(selected_text);
                //console.log(selected_text.nodeName);
                if (selected_text.nodeName == 'IMG') {



                    ed.dom.removeClass( selected_text, 'polaroid');
                    ed.dom.removeClass( selected_text, 'rotate-right');
                    ed.dom.removeClass( selected_text, 'rotate-left');
                    ed.dom.removeClass( selected_text, 'ci');

                    icon.split(" ").forEach( function( classname ) { 
                        console.log(classname);
                        ed.dom.addClass( selected_text, classname );    

                    });
                    
                    
                }
                //console.log(selected_text);
                //ed.insertContent( return_text );
            }

           /* ed.addCommand('feature', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '<div class="feature">\n\t<header>\n\t<h2>Heading Here</h2>' + selected_text + '</header>\n\t<div class="content">\n\tPut your text here</div>';
                ed.execCommand('mceInsertContent', 0, return_text);
            });
            */

            ed.addCommand('feature', function() {
               
                var selected_text = ed.selection.getContent();
                
                //ed.execCommand('mceInsertContent', 0, return_text);
                var data = {
                        imgid: "",
                        link: "",
                        title: "Edit by Clicking",
                        linktitle: "",
                        innercontent: ""
                    }



                var tag = tinyMCE.activeEditor.selection.getNode();

                if (tag.tagName == 'A') {
                    data.link = tag.href;
                }



                data.title = selected_text;
                

                var return_text = build_feature_shortcode( data );

                tinyMCE.activeEditor.selection.select( tinyMCE.activeEditor.selection.getNode() );
                tinyMCE.activeEditor.selection.setContent( return_text );


            });

            ed.addCommand('infobox', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '[infobox title="Info Box"]' + selected_text + '[/infobox]';
                ed.execCommand('mceInsertContent', 0, return_text);
            });

            

            // Just the columns, start with two, add more if needed.  in the future we can add a feature to add predefined layouts with less functionality but
            // for the most part it should be enough for uniformity.  We could also maybe add in a class to set the width dynamically.

            // eg "col-smart' but :first-of-type { width 66% } for wider etc"

            ed.addButton('columns', {
                title: 'Insert Columns',
                cmd: 'columns',
                image : url + '/../img/halves.png'
            });

            ed.addCommand('columns', function() {
                var selected_text = ed.selection.getContent();





                if (!selected_text) { selected_text = ' '}
                
                return_text =   '<div class="row">';
                return_text +=  '<div class="col-smart"><p>' + selected_text + '</p></div>';
                return_text +=  '<div class="col-smart">' + '<p></p></div>';
                return_text +=  '</div><P>&nbsp;</p>';

                ed.selection.setContent(return_text);
                
            });

      

            ed.on('setContent', function(o) {
                
                // add controls to the element for adjustments

                updateColumnButtons(ed);


           });


            function updateColumnButtons(ed) {
                
                ed.$('.col-control-add, .col-control-remove, .col-control-extend, .col-control-shrink, .fixer-widget').remove(); // just get rid in case
                
                // add buttons to columns
                ed.$.each( ed.$('.row > div'), function(index, element) {

                        addControlButtons(ed, element);

                        if (ed.$(element).hasClass('wider')) {
                            addShrinkButton(ed, element);
                        } else {
                           addExtendButton(ed, element);
                        }
                });

                protectButtons(ed);
            }

            function protectButtons(ed) {
                ed.$('.col-control-add, .col-control-remove, .col-control-extend, .col-control-shrink').attr('contentEditable', 'false');
            }

            function addExtendButton(ed, element) {
                 ed.$(element).append("<button class='col-control-extend'>Increase Size Of Column</button>");
            }

            function addPaddingButton(ed, element) {
                 ed.$(element).append("<button class='col-control-padding'>Padding</button>");
            }


            function addShrinkButton(ed, element) {
                ed.$(element).append("<button class='col-control-shrink'>Decrease Size Of Column</button>");
            }

            
           
            function addControlButtons(ed, element) {
                ed.$(element)
                        .append("<p class='fixer-widget mceNonEditable'>&nbsp;</p>") // fix weirdness
                        .append("<button class='col-control-add'>Add Column</button>")
                        .append("<button class='col-control-remove'>Remove Column</button>")
                        .append("<button class='col-control-padding'>Padding</button>");
            }

            ed.on('NodeChange', function(e) {
                //console.log(e);
            });





            

            
            ed.on('SaveContent', function(o) {

                
                // find any columns and remove the buttons

                // get content in temp element

                $element = ed.$("<div>" + o.content + "</div>"); // wrap it so jquery can make something of it
                $element.find('.col-control-add, .col-control-remove, .col-control-extend, .col-control-shrink, .col-control-padding, .fixer-widget').remove(); // just get rid in case
               

                o.content = $element.html();

            });  


            ed.onClick.add(function(ed, e) {

               


                
                //console.debug('Editor was clicked: ', ed.$(e.target));

                //console.log(ed.selection.getNode());

                $element = ed.$(e.target);


                

                
                

                // add a column
                if ($element.hasClass('col-control-add')) {
                    $('<div class="col-smart">&nbsp;</div>')
                            //.prepend("<button class='col-control-add'>Add Column</button>")
                            //.prepend("<button class='col-control-extend'>Increase Size Of Column</button>")
                            //.prepend("<button class='col-control-remove'>Remove Column</button>")
                            .insertAfter( $element.closest('div[class^="col-"]') );


                            updateColumnButtons(ed);
                                        

                } 

                var $container;

                if ($element.hasClass('col-control-padding')) {

                    $contents = $element.closest('div[class^="col-"]');

                    $contents.toggleClass('no-padding');

                }

                if ($element.hasClass('col-control-extend')) {

                    $container = $element.closest('div.row');

                    if ($container.find('div[class^="col-"]').length > 3) {
                        alert("Sorry, you can't have widened columns on a row of 4 or more columns");
                        return;

                    }
                    
                    $container.find('div[class^="col-"]').removeClass('wider');
                    $element.closest('div[class^="col-"]').addClass('wider');

                    

                    addShrinkButton(ed, $element.closest('div[class^="col-"]') );
                    protectButtons(ed);

                    //$element.closest('div[class^="col-"]').prepend("<button class='col-control-shrink mceNonEditable'>Decrease Size Of Column</button>");
                    $container.addClass('has-wide');    

                    $element.remove('.col-control-extend');
                    

                    
                }

                if ($element.hasClass('col-control-shrink')) {

                    $container = $element.closest('div.row');                    
                    $container.find('div[class^="col-"]').removeClass('wider');
                   
                    
                    //$element.closest('div[class^="col-"]').prepend("<button class='col-control-extend mceNonEditable'>Increase Size Of Column</button>");
                    addExtendButton(ed, $element.closest('div[class^="col-"]') );
                    protectButtons(ed);

                    $container.removeClass('has-wide');    
                    

                    $element.remove('.col-control-shrink');
                    
                }

                // remove a column
                if ($element.hasClass('col-control-remove')) {

                    // get column
                    $contents = $element.closest('div[class^="col-"]');

                    if ($contents.hasClass('wider')) {
                        $element.closest('div.row').removeClass('has-wide');
                    }

                    // remove the buttons we added temporarily

                    $contents.find('button[class^="col-control-"]').remove();



                    // get the column row
                    $wrapper = $contents.parent();


                    // put the contents afterwards, outside of the container
                    $wrapper.after( $contents.html() ); // inner HTML not the container as well

                    // now get rid of this column
                    $contents.remove(); 
                    

                    if ($wrapper.find('div[class^="col-"]').length < 1) {
                        //console.log('Nothing Left in columns');
                        $wrapper.remove();
                    }
                }
            });
 
        },

        /**
        * Returns information about the plugin as a name/value array.
        * The current keys are longname, author, authorurl, infourl and version.
        *
        * @return {Object} Name/value array containing information about the plugin.
        */
        getInfo : function() {
            return {
                longname : 'Nathans Wordpress Starter Theme Editor Features',
                author : 'Nathan',
                authorurl : 'http://cowfields.co.uk',
                version : "0.1"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'cf_features', tinymce.plugins.cf_features );


    function build_feature_shortcode( data ) {

        var shortcode_string = 'feature-box';
        var s = '[' + shortcode_string;

                            
                            //s += ' img="' + data.img + '" ';
                            s += ' imgid="' + data.imgid + '" ';
                            s += ' link="' + data.link + '" ';
                            s += ' title="' + data.title + '" ';
                            s += ' linktitle="' + data.linktitle + '" ';
                            s += ' colour="' + data.colour + '" ';
                            s += ' icon="' + data.icon + '" ';
                                
                            s += ']';
                            s += data.innercontent;
                            s += '[/' + shortcode_string + ']';


        return s;
    }

    var shortcode_string = 'feature-box';
                
    window.wp.mce.views.register(shortcode_string, {


        template: wp.media.template('editor-' + shortcode_string),

        initialize: function() {
            var self = this;

            
         
            
            
            
        },

        getContent: function() {
            var options = this.shortcode.attrs.named;
            options['innercontent'] = this.shortcode.content;



            
            // format the template
            var output = this.template(options);

            // get HTML as Jquery object
            $content = $(output);

           
            // add in the image from the id

            // get image SRC

            if (this.shortcode.attrs.named.imgid && this.shortcode.attrs.named.imgid != 'undefined') {


                imgid = this.shortcode.attrs.named.imgid;   

                idURL = mcedata.apiURL + 'media/' + imgid;

                
                // fix the ID for this particular element so that AJAX can find it later.
                current = this; // so ajax doesn't get confused
                current.uid =  tinyMCE.activeEditor.dom.uniqueId('mce_fb_');
                $content.attr("id",current.uid);

                // load the images later when we have them
                $.ajax(idURL,{
                    url : idURL,
                    type : 'GET',
                    //data : dataArray,
                    cache : false,
                    element : current,
                    dataType : 'json'
                }).done( function( response ) {

                    // find teh original one
                    $content = $( tinyMCE.activeEditor.dom.get( this.element.uid ) );

                    //ext = response.guid.substr(response.guid.length - 4);
                    //thumb = response.guid.replace(ext, mcedata.imgSuffix + ext);

                    thumb = response.attachment_meta.sizes.thumbnail.url;
                    
                    $content
                        .find('header')
                        .prepend( $('<img src="' + thumb + '" />') )
                        ;//.prepend( $("<p>Image ID " + this.element.shortcode.attrs.named.imgid + "</p>") );

                    

                });
            } // else no id for image set so no image to find

            // replace the image content;     
            return $content[0].outerHTML;
        },

        edit: function(data, update) { // action when clicks to edit

            var values = this.shortcode.attrs.named;
            window.tempNode = this;
            this.popupwindow(tinyMCE.activeEditor, values, data, update );       



        },

        do_update: function( data, editor, node ) { // editing complete, make the changes

            var instance = wp.mce.views.getInstance( tempNode ); // this

            console.log( instance );

            var s = build_feature_shortcode( data );
            

            // tinyMCE.activeEditor.insertContent( s ); 
            //editor.insertContent( s );

            

            wp.media.editor.insert(s);

            // hack to force a refresh of the content
            var html = tinyMCE.activeEditor.getContent();
            tinyMCE.activeEditor.setContent( html );
            
            // remove global object.
            window.tempNode = false;
            
            

        },

        popupwindow: function(editor, values, node, onsubmit_callback) {
                        
            if(typeof onsubmit_callback != 'function'){
                onsubmit_callback = function( e ) {
                    // not being called right now
                    console.log(e);
                    console.log("Submit Callback");
                };
            }

            editor.windowManager.open( {
                title: "Edit Feature Box",
                url: mcedata.adminurl + 'admin.php?page=' + shortcode_string + '-edit',
                width: 900,
                height: 700,
            },

            {
                data : values
            }
                
            );
        }
        

    });
        




}(jQuery));


