<?php

// Sidebars & Widgetizes Areas

function cf_register_sidebars() {


	register_sidebar(array(
		'id' => 'blog-sidebar',
		'name' => __( 'blog-sidebar', 'cf-theme' ),
		'description' => __( 'This sidebar appears for blog posts and for blog feeds.  So perhaps use things like categories, tags, etc.', 'cf-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

		register_sidebar(array(
		'id' => 'home-sidebar',
		'name' => __( 'home-sidebar', 'cf-theme' ),
		'description' => __( 'This sidebar appears for the home page', 'cf-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

		register_sidebar(array(
		'id' => 'home-footer-sidebar',
		'name' => __( 'home-footer-sidebar', 'cf-theme' ),
		'description' => __( 'This sidebar appears for the footer on the homepage', 'cf-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'cta-sidebar',
		'name' => __( 'CTA Sidebar', 'cf-theme' ),
		'description' => __( 'Floats top and right - reserved for a CTA etc', 'cf-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'secondary-links',
		'name' => __( 'Secondary links', 'cf-theme' ),
		'description' => __( 'Secondary Link area - appears beneath most pages (but not blogs)', 'cf-theme' ),
		'before_widget' => '<div id="%1$s" class="col-smart">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'footer-middle',
		'name' => __( 'Footer Middle', 'cf-theme' ),
		'description' => __( 'Appears in the footer, in the middle', 'cf-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'footer-right',
		'name' => __( 'Footer Right', 'cf-theme' ),
		'description' => __( 'Appears in the footer, on the right.', 'cf-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'cf-theme' ),
		'description' => __( 'The second (secondary) sidebar.', 'cf-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!