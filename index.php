<?php
  require_once 'lib/helpers.php';

  // Here you call the proper view (these are placed in src/views/ directory)

  /* Some useful reminders:

     is_front_page()
     is_page("page-slug") or is_page()
     is_post_type_archive("custom-post-type") or is_post_type_archive()
     is_tax("custom-taxonomy-name")

     Add yours here.

  */

  if (is_front_page()) {
<<<<<<< HEAD
    render_view("home");
=======
    render_view("page");
  } else if (is_post_type_archive()) {
    render_view("archive");
>>>>>>> 5e78908... update index + 404 page
  } else if (is_single()) {
    render_view("single");
  } else if (is_page()) {
    render_view("single");
  } else {
    render_view("404");
  }
  
  //inutile
