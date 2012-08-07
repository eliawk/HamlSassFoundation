<?php

  function manage_custom_post_types_and_custom_taxonomies() {
    new_post_type("evento","eventi", array('title', 'thumbnail'), false);
    new_post_type("slide","slides", array('thumbnail'));
    new_post_type("canzone","canzoni", array('thumbnail' , 'comments', 'author'), true);
    new_post_type("galleria","foto", array('title','thumbnail', 'comments'), false);
    
    
    
    new_taxonomy("disco", array("canzone"));
  }

//  add_action('init', 'manage_custom_post_types_and_custom_taxonomies');

