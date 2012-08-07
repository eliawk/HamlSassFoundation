<? 

//==== Custom admin panel ====

// Logo personalizzato nel login del backend
function custom_login_logo() {
  echo '<style type="text/css">
    h1 a { background-image:url('.get_bloginfo('template_directory').'/public/images/login_logo.png) !important; display:none; }
    </style>';
}

//Rimuove elementi del menu
function remove_menu_items() {
  
  global $menu;
  $restricted = array( __('Comments'), __('Media'),__('Pages'),
  __('Plugins'), __('Tools'), __('Aree'), __('Avvocati'), __('Collaborators'), __('Counsels'), __('Users'), __('Appearance'), __('Settings'));
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

function remove_contact_form(){
	echo "<style type='text/css' media='screen'>#toplevel_page_wpcf7{display:none;}</style>";
}

function custom_logo() {
  echo '<style type="text/css">
    #wp-admin-bar-wp-logo{display:none;}
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
  echo 'Sito realizzato da <a href="http://www.lospaziodiake.com">elia pellegrino</a>. ';
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




global $current_user;
get_currentuserinfo();


if( $current_user->user_login != 'admin' && $current_user->user_login != 'diverba' ){
  //Rimuove elementi del menu
  add_action('admin_menu', 'remove_menu_items');
  //Rimuove box dei post
 
  add_action('admin_menu','customize_meta_boxes');
  
  add_action('admin_head','remove_contact_form');
  
  //Rimuove avviso di update
  add_action('admin_menu','wphidenag');
  function wphidenag() {
  remove_action( 'admin_notices', 'update_nag', 3 );
  }	
}


add_action('login_head', 'custom_login_logo');

add_action('admin_head', 'custom_logo');

//add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

add_filter('admin_footer_text', 'modify_footer_admin');

//add_filter('pre_get_posts', 'posts_for_current_author');

///////////////////