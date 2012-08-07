<? 

//==== Custom admin panel ====

// Logo personalizzato nel login del backend
function custom_login_logo() {
  echo '<style type="text/css">
    .login h1 { 
      background-image:url('.get_bloginfo('template_directory').'/public/images/logo_admin.png) !important;
      background-size: 300px 56px;
      background-position: top center;
      background-repeat: no-repeat;
      width: 326px;
      height: 60px;
      margin-bottom: 5px;
    }
    .login h1 a {display:none; !important;}
    
    </style>';
}

//Rimuove elementi del menu
function remove_menu_items() {
  
  global $menu;
  $restricted = array( __('Posts'),__('Media'),__('Comments'), __('Plugins'), __('Tools'), __('Settings'), __('Link'),__('Appearance'));
  
  end ($menu);
  while (prev($menu)){
    $value = explode(' ',$menu[key($menu)][0]);
    if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
      unset($menu[key($menu)]);}
    }
}

//Rimuove box dei post
function customize_meta_boxes() {
  /* Removes meta boxes from Posts */
  remove_meta_box('postcustom','post','normal');
  remove_meta_box( 'postimagediv' , 'post' , 'normal' );
  remove_meta_box('categorydiv','post','normal');
  remove_meta_box('trackbacksdiv','post','normal');
  remove_meta_box('commentstatusdiv','post','normal');
  remove_meta_box('commentsdiv','post','normal');
  remove_meta_box('tagsdiv-post_tag','post','normal');
  remove_meta_box('postexcerpt','post','normal');
  /* Removes meta boxes from pages */
  remove_meta_box('postcustom','page','normal');
  remove_meta_box('trackbacksdiv','page','normal');
  remove_meta_box('commentstatusdiv','page','normal');
  remove_meta_box('commentsdiv','page','normal'); 
}

//rimuovo i widget non utilizzati
function unregister_default_wp_widgets() {
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Akismet');
}

function remove_contact_form(){
	echo "<style type='text/css' media='screen'>#toplevel_page_wpcf7{display:none;}</style>";
}

function custom_admin_bar() {
  echo '<style type="text/css">
    #wp-admin-bar-wp-logo{display:none;}
    #wp-admin-bar-comments{display:none;}
    
    #header-logo { background-image: url('.get_bloginfo('template_directory').'/public/images/logo.png) !important; width: 40px;}
    </style>';
}




function remove_dashboard_widgets(){
  global$wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); 
}

function modify_footer_admin () {
  echo 'Sito realizzato da <a href="mailto:elia.pellegrino@gmail.com">elia pellegrino</a>. ';
//  echo 'Powered by <a href="http://WordPress.org">WordPress</a>.';
}

function posts_for_current_author($query) {
  global $pagenow;
  
  if( 'edit.php' != $pagenow || !$query->is_admin )
  return $query;
  
  if( !current_user_can( 'manage_options' ) ) {
  global $user_ID;
  $query->set('author', $user_ID );
  }
  return $query;
}

//Rimuove avviso di update
function wphidenag() {
  remove_action( 'admin_notices', 'update_nag', 3 );
}	

// get the the role object
$role_object = get_role( 'editor' );

// add $cap capability to this role object



global $current_user;
get_currentuserinfo();







if( $current_user->user_login != 'admin'){
  //Rimuove elementi del menu laterale
  add_action('admin_menu', 'remove_menu_items');

  //Rimuove box dei post
  add_action('admin_menu','customize_meta_boxes');
  
  add_action('admin_head','remove_contact_form');
  //rimuove i widget
  add_action('widgets_init', 'unregister_default_wp_widgets', 1);
  
  //Rimuove avviso di update
  add_action('admin_menu','wphidenag');
  
}


add_action('login_head', 'custom_login_logo');

add_action('admin_head', 'custom_admin_bar');

//add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

add_filter('admin_footer_text', 'modify_footer_admin');

//add_filter('pre_get_posts', 'posts_for_current_author');

///////////////////