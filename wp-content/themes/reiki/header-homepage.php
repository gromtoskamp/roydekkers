<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <div class="gridContainer">
      <div class="header_description">
        <h1 class="heading8">
          <?php echo esc_html(get_bloginfo('description')); ?>
        </h1>
      </div>
    </div>
  </div>
<div class="header-homepage" style="background-image:url('<?php echo reiki_homepage_header(); ?>');">
  <div class="row border_bottom">
    <div class="logo_col">
      <?php reiki_logo(); ?>
    </div>
    <div class="main_menu_col">
      <?php
      wp_nav_menu(array(
          'theme_location' => 'primary',
          'menu_id'        => 'drop_mainmenu',
          'menu_class' => 'fm2_drop_mainmenu',
          'container_id' => 'drop_mainmenu_container',
          'fallback_cb' => 'reiki_nomenu_cb'
      ));
      ?>
    </div>
  </div>