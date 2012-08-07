<?php

function setup_theme_options() {
  require_once (TEMPLATEPATH . '/lib/options-interface.php');

  add_action('wp_head', 'neuTothemes_wp_head');
  add_action('admin_menu', 'neuTothemes_add_admin');

  $options = array();

  $options[] = array("name" => "Theme Options",
                      "type" => "heading");

  $terms = get_terms('technology-genre', 'orderby=count&hide_empty=0');
  $terms_options = array();
  foreach ($terms as $term) {
    $terms_options[$term->term_id] = $term->name;
  }

  $options[] = array("name" => "Prova multicheck",
            "desc" => "Select the technology genres you want to show on the HP",
            "id" => "home_technology_genres",
            "std" => "",
            "options" => $terms_options,
            "type" => "multicheck");

  update_option('neuTo_template',$options);
  update_option('neuTo_themename', get_bloginfo("name"));
  update_option('neuTo_shortname', get_bloginfo("name"));
  update_option('neuTo_manual', "#");
}

//add_filter("init", "setup_theme_options");