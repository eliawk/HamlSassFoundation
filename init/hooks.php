<?php

  
/*
  // Exclude certain categories from home
  function exclude_category() {
    if (is_home()) {
      $cat = '-' . get_category_id_by_name("Interviste");
      set_query_var('cat', $cat);
    }
  }
  add_filter('pre_get_posts', 'exclude_category');
*/

/*
  // Hide/remove some features from Wordpress backend
  function simplify_backend() {
    echo '<script type="text/javascript" charset="utf-8">';
    echo '  jQuery(document).ready(function() {';
    echo '    jQuery("#menu-links").remove();';
    echo '    jQuery("#pageparentdiv, #media-buttons, #commentstatusdiv, #trackbacksdiv, #postcustom, #authordiv, #revisionsdiv, #tagsdiv-post_tag, *[href=edit-tags.php?taxonomy=post_tag]").hide();';
    echo '  });';
    echo '</script>';
  }
  add_action('admin_head', 'simplify_backend' );
*/

/*
  // Add custom post types to the general feed
  function add_custom_posts_to_feed($qv) {
    if (isset($qv['feed']))
      $qv['post_type'] = array('review', 'journey', 'news', 'magazine_edition', 'event', 'post');
    return $qv;
  }
  add_filter('request', 'add_custom_posts_to_feed');
*/

/*
  // Enable upload of custom MIME types
  function custom_upload_mimes ( $existing_mimes=array() ) {
    $existing_mimes['bib'] = 'text/x-bibtex';
    return $existing_mimes;
  }
  add_filter('upload_mimes', 'custom_upload_mimes');
*/

/* Add class nice to contact form 7 */

add_filter( 'wpcf7_form_class_attr', 'your_custom_form_class_attr' );

function your_custom_form_class_attr( $class ) {
	$class .= ' nice';
	return $class;
}



/* Remove Inline CSS and Line Breaks in WordPress Galleries */
  
add_filter('the_content', 'remove_br_gallery', 11);
function remove_br_gallery($output) {
	return preg_replace('/(<br[^>]*>\s*){2,}/', '<br />', $output);
}

add_filter('use_default_gallery_style', '__return_false');


/* Pulisce html della gallery wordpress*/

function custom_gallery( $output, $attr ){
  global $post, $wp_locale;

  static $instance = 0;
  $instance++;
  
  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if ( isset( $attr['orderby'] ) ) {
      $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
      if ( !$attr['orderby'] )
          unset( $attr['orderby'] );
  }
  
  extract(shortcode_atts(array(
      'order'      => 'ASC',
      'orderby'    => 'menu_order ID',
      'id'         => $post->ID,
      'itemtag'    => 'li',
      'icontag'    => '',
      'captiontag' => '',
      'columns'    => 3,
      'size'       => 'thumbnail',
      'include'    => '',
      'exclude'    => ''
  ), $attr));
  
  $id = intval($id);
  if ( 'RAND' == $order )
      $orderby = 'none';
  
  if ( !empty($include) ) {
      $include = preg_replace( '/[^0-9,]+/', '', $include );
      $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  
      $attachments = array();
      foreach ( $_attachments as $key => $val ) {
          $attachments[$val->ID] = $_attachments[$key];
      }
  } elseif ( !empty($exclude) ) {
      $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
      $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  } else {
      $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  }
  
  if ( empty($attachments) )
      return '';
  
  if ( is_feed() ) {
      $output = "\n";
      foreach ( $attachments as $att_id => $attachment )
          $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
      return $output;
  }
  
  $itemtag = tag_escape($itemtag);
  $captiontag = tag_escape($captiontag);
  $columns = intval($columns);
  $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
  $float = is_rtl() ? 'right' : 'left';
  
  $selector = "gallery-{$instance}";
  
  $gallery_div = '';
  $size_class = sanitize_html_class( $size );
  $gallery_div = "<ul id=\"$selector\" class=\"gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}\">";
  $output = apply_filters( 'gallery_style', $gallery_div );
  
  $i = 0;
  foreach ( $attachments as $id => $attachment ) {
      $image = wp_get_attachment_link( $id, $size );
  
      $output .= "<{$itemtag} class=\"gallery-item\">";
      $output .= $image;
      if ( $captiontag && trim($attachment->post_excerpt) ) {
          $output .= "
              <{$captiontag} class=\"wp-caption-text gallery-caption\">
              " . wptexturize($attachment->post_excerpt) . "
              </{$captiontag}>";
      }
      $output .= "</{$itemtag}>";
  }
  
  $output .= "
      </ul>\n";
  
  return $output;
}
add_filter('post_gallery', 'custom_gallery', 11, 2);

// Modifica the_excerpt() mantenendo la formattazione
function improved_trim_excerpt($text) {
  global $post;
  if ( '' == $text ) {
          $text = get_the_content('');
          $text = apply_filters('the_content', $text);
          $text = str_replace('\]\]\>', ']]&gt;', $text);
          $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
          $text = strip_tags($text, '<p><a>');
          $excerpt_length = 50;
          $words = explode(' ', $text, $excerpt_length + 1);
          if (count($words)> $excerpt_length) {
                  array_pop($words);
                  array_push($words, '[...]');
                  $text = implode(' ', $words);
          }
  }
  return $text;
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'improved_trim_excerpt');



