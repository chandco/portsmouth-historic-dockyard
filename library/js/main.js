
requirejs.config({ 
  paths: {
    typekit : 'http://use.typekit.net/jfl7esy',
    jquery : 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min'
  },
  "shim": {
        'vendor/slick': {
            deps: ['jquery']
        },
        // 'cf7' : ['jquery', 'jqueryForm'],
        'vendor/mailchimp' : ['jquery', 'vendor/mc-validate'],
        'vendor/magnific-popup' : ['jquery'],
        'cf7' : ['jquery', 'vendor/jquery.form.min']
      
  }


});

require(['typekit'], function() {
  try{Typekit.load();}catch(e){}
}, function (err) {
    
  // Typekit obviously didn't load from the CDN.  Update the body tags
  require(['jquery'], function($) {
     $('html').addClass('wf-inactive');
  });
});



require(["smoothscroll"]);



/* 
  ALWAYS ON STUFF 
  Basically anything that we would want on every page, not conditional on what's there, eg responsive stuff.
*/


require(["vendor/modernizr"]);


require(['navigation']);


// Stuff for layout when the window loads / resizes
// require(['components/resize-fix']);

// init magnific popup stuff.  Probably should load conditionally, but people could use it anywhere.  Perhaps we should avoid for homepage?
require(['components/popups']);

// init carousels
require(['components/carousel']);


require(['jquery'], function($) {

  // only load the form if the form is there.

  if ($('.wpcf7-form').length) {
    // Load CF7 JS only if there's actually a form.
    require(['cf7']);
  }

  if ($('#mc_embed_signup').length) {
    // basically takes the MC stuff and loads it "our way";]
    require(['vendor/mailchimp']);
  }




});
  



require(['responsive-table']);