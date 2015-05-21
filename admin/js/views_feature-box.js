		// Uploading files
		var file_frame;

		jQuery(document).ready(function($){

		var atts = parent.tinymce.activeEditor.windowManager.getParams();

			$('body').on('click', '#mce-addlink', function(event) {
				event.preventDefault();
	            wpActiveEditor = true; //we need to override this var as the link dialogue is expecting an actual wp_editor instance
	            
	            url = $('#_feature_box_link').val();
	        	linktitle = $('#_feature_box_title').val();

	        	

	        	wpLink.setDefaultValues = function () { 
			        $('#url-field').val(url);
	        		$('#link-title-field').val(linktitle);
			        $('#wp-link-submit').val( 'Use this link' );

			    };

			    wpLink.close = function() {
					$( document.body ).removeClass( 'modal-open' );
		        	$('#_feature_box_link').focus();
					$('#wp-link-wrap').hide();
					$( '#wp-link-backdrop' ).hide();
				}


			    
	            wpLink.open(); //open the link popup
	            return false;
	        });


	        


	        $('body').on('click', '#wp-link-update .button', function(e) {
	        	e.preventDefault();

	        	url = $('#url-field').val();
	        	
	        	linktitle = $('#link-title-field').val();

	        	$('#_feature_box_link').val(url);
	        	$('#_feature_box_title').val(linktitle);

	        	wpLink.close();
	        	
	        });


		  $('#mce-upload').on('click', function( event ) {



		    event.preventDefault();

		    // If the media frame already exists, reopen it.
		    if ( file_frame ) {
		      file_frame.open();
		      return;
		    }

		    // Create the media frame.
		    file_frame = wp.media.frames.file_frame = wp.media({
		      title: jQuery( this ).data( 'uploader_title' ),
		      button: {
		        text: jQuery( this ).data( 'uploader_button_text' ),
		      },
		      multiple: false  // Set to true to allow multiple files to be selected
		    });

		    // When an image is selected, run a callback.
		    file_frame.on( 'select', function() {
		      // We set multiple to false so only get one image from the uploader
		      attachment = file_frame.state().get('selection').first().toJSON();
		      console.log(attachment);

		      $('#_unique_name').val(attachment.url);
		      $("#mce-feature-box-form .feature-box img").remove();
		      ext = attachment.url.substr(attachment.url.length - 4);
		      thumb = attachment.url.replace(ext, window.imgSuffix + ext);
			  $("<img>").attr("src", thumb).data('imgid', attachment.id).prependTo( '#mce-feature-box-form .feature-box .img' );


		      // Do something with attachment.id and/or attachment.url here
		    });

		    // Finally, open the modal
		    file_frame.open();
		  });

	
		
		// initial loading of the content from the parent window


	 	$('#mce-feature-content').val( atts.data.innercontent );

	 	idURL = parent.mcedata.apiURL + 'media/' + atts.data.imgid;

	 	$.ajax(idURL,{
                url : idURL,
                type : 'GET',
                //data : dataArray,
                cache : false,
                imgid : atts.data.imgid
            }).done( function( response ) {

            	//ext = response.guid.substr(response.guid.length - 4);
		      	//thumb = response.guid.replace(ext, window.imgSuffix + ext);
		      	thumb = response.attachment_meta.sizes.thumbnail.url;
                $imgEl = $("<img src='" + thumb + "' />").data('imgid', this.imgid);
				$('#mce-feature-box-form header .img').prepend( $imgEl );

          });

	 	
		$('#mce-feature-box').val( atts.data.title );
		$('#_feature_box_link').val( atts.data.link );
		$('#_feature_box_title').val( atts.data.linktitle );

		$('#mce-update').on('click', function(e) {
			e.preventDefault();

			data = {
				innercontent : $('#mce-feature-content').val(),
				//img: $('#mce-feature-box-form header img').attr('src'),
				imgid: $('#mce-feature-box-form header img').data('imgid'),
				title : $('#mce-feature-box').val(),
				link: $('#_feature_box_link').val(),
				linktitle : $('#_feature_box_title').val( ),

			}
			parent.wp.mce.feature_box.update( data );

			parent.tinymce.activeEditor.windowManager.close();


		});

		$('#mce-close').on('click', function(e) {
			e.preventDefault();

			parent.tinymce.activeEditor.windowManager.close();

		});		
	
	

	

	

	}); // end of doc ready