<?php

  // require embedded plugins
  require_once dirname(__FILE__).'/lib/vendor/regenerate-thumbnails/regenerate-thumbnails.php';

  // our beloved helpers
  require_once 'lib/helpers.php';


  // require WP init scripts
  require_once 'init/custom_post_types.php';
  require_once 'init/thumbnail_sizes.php';
  require_once 'init/site_options.php';
  require_once 'init/hooks.php';
  require_once 'init/custom_admin_panel.php';