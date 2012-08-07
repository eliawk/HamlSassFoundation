<?php

function manage_thumbnails()
{
  // add thumbnails to the following post types
  add_theme_support('post-thumbnails', array('page', 'post', 'slide', 'galleria'));
  set_post_thumbnail_size( 50, 50, true );

  // HP -> Awards
//  add_image_size('900x400', 900, 400, true );
  add_image_size('150x100', 150, 100, false );
}

//add_action('after_setup_theme', 'manage_thumbnails');
