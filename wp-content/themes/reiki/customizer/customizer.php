<?php


if (class_exists('WP_Customize_Control')) {
  class Reiki_Enable_Companion_Control extends WP_Customize_Control {
      public function render_content() {

          $config = Reiki_Companion_Plugin::$config;

          if (Reiki_Companion_Plugin::$plugin_state['installed']) {
            $link = Reiki_Companion_Plugin::get_activate_link();
            $label = $config['activate_label'];
            $btn_class = "activate";
            $msg = $config['activate_msg'];
          } else {
            $link = Reiki_Companion_Plugin::get_install_link();
            $label = $config['install_label'];
            $btn_class = "install-now";
            $msg = $config['install_msg'];
          }

          ?>
          <div class="reiki-enable-companion">
            <?php
              printf('<p>%1$s</p>', $msg);
              printf('<a class="%1$s button" href="%2$s">%3$s</a>', $btn_class, esc_url($link), $label);
            ?>
          </div>
          <?php
      }
  }
}

class Reiki_Companion_Plugin {
  private static $instance = false;
  private static $companion_slug =  "reiki-companion";

  public static $plugin_state;
  public static $config = array();

  function __construct() {
    self::$config = array(
      'activate_label' =>  __('Activate Reiki Companion', 'reiki'),
      'activate_msg' =>  __('This feature requires the Reiki Companion plugin to be activated.', 'reiki'),
      'install_label' =>  __('Install Reiki Companion', 'reiki'),
      'install_msg' =>  __('This feature requires the Reiki Companion plugin to be installed.', 'reiki'),

      'plugins' => array(
        'reiki-companion' => array(
          'title' =>  __('Reiki Companion', 'reiki'),
          'description' =>  __('The Reiki Companion plugin adds drag and drop functionality and many other features to the Reiki theme.', 'reiki'),
          'activate' => array(
            'label' => __('Activate', 'reiki')
          ),
          'install' => array(
            'label' => __('Install', 'reiki')
          )
        ),

        'contact-form-7' => array(
          'title' =>  __('Contact Form 7', 'reiki'),
          'description' =>  __('The Contact Form 7 plugin is recommended for the Reiki contact section.', 'reiki'),
          'activate' => array(
            'label' => __('Activate', 'reiki')
          ),
          'install' => array(
            'label' => __('Install', 'reiki')
          )
        )
      )
    );

    self::$plugin_state = self::get_plugin_state(self::$companion_slug);

  }

  public static function get_plugin_state( $plugin_slug) {
    $tgmpa = TGM_Plugin_Activation::get_instance();
    $installed = $tgmpa->is_plugin_installed($plugin_slug);
    return array( 
        'installed' => $installed, 
        'active' => $installed && $tgmpa->is_plugin_active($plugin_slug)
    );
  }

  public static function get_install_link($slug = false) {
    if (!$slug) {
      $slug = self::$companion_slug;
    }

    return add_query_arg(
      array(
        'action' => 'install-plugin',
        'plugin' =>  $slug,
        '_wpnonce'      => wp_create_nonce( 'install-plugin_' .  $slug )
      ),
      network_admin_url( 'update.php' )
    );
  }

  public static function get_activate_link($slug = false) {
    if (!$slug) {
      $slug = self::$companion_slug;
    }
    $tgmpa = TGM_Plugin_Activation::get_instance();
    $path = $tgmpa->plugins[ $slug ]['file_path'];
    return add_query_arg( array(
      'action'        => 'activate',
      'plugin'        => rawurlencode( $path ),
      'plugin_status' => 'all',
      'paged'         => '1',
      '_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $path ),
    ), network_admin_url( 'plugins.php' ));
  }

  public static function show_companion_popup() {
    add_action('admin_enqueue_scripts', array( 'Reiki_Companion_Plugin', 'thickbox' ));
    add_action('customize_controls_print_footer_scripts', array('Reiki_Companion_Plugin', 'output_companion_message'));
  }

  public static function thickbox($hook) {
    add_thickbox();
    wp_enqueue_style( 'dashicons' );
    wp_enqueue_script('reiki_customizer_js', get_template_directory_uri() . '/customizer/customizer.js', array('jquery'), false, true);
  }

  public static function output_companion_message() {
  ?>
    <div id="reiki_homepage" style="display:none">
      <div class="reiki-popup">
        <div>
          <h3 class="reiki_title"><?php _e('Please Install the Reiki Companion Plugin to Enable All the Theme Features', 'reiki') ?></h3>
          <div class="reiki_cp_column reiki_left">
            <h4><?php _e('Here\'s what you\'ll get', 'reiki');?></h4>
            <ul class="reiki-features-list">
              <li><?php _e('Beautiful ready-made homepage', 'reiki');?></li>
              <li><?php _e('Drag and drop page customization', 'reiki');?></li>
              <li><?php _e('25 predefined content sections', 'reiki');?></li>
              <li><?php _e('Live content editing', 'reiki');?></li>
              <li><?php _e('5 header types', 'reiki');?></li>
              <li><?php _e('3 footer types', 'reiki');?></li>
              <li><?php _e('and many other features', 'reiki');?></li>
            </ul>
          </div>
          <div class="reiki_cp_column">
            <div class="reiki_scrn_wrapper">
              <img class="reiki-screenshot" src="<?php echo get_template_directory_uri(); ?>/assets/images/screenshot.jpg" />
            </div>
          </div>
        </div>
        <div class="footer">
            <a class="button button-large" class="reiki-popup-cancel" onclick="tb_remove();"> <?php _e('Maybe later', 'reiki') ?> </a>
            <?php
              if (self::$plugin_state['installed']) {
                $link = Reiki_Companion_Plugin::get_activate_link();
                $label = __('Activate now', 'reiki');
              } else {
                $link = Reiki_Companion_Plugin::get_install_link();
                $label = __('Install now', 'reiki');
              }
              printf('<a class="install-now button button-large button-primary" href="%1$s">%2$s</a>', esc_url($link), $label);
            ?>
        </div>
      </div>
    </div>
    <?php
  }

  public static function check_companion($wp_customize) {
    $plugin_state = self::$plugin_state;
    
    if (!$plugin_state['installed'] || !$plugin_state['active']) {

        $wp_customize->add_setting('reiki_companion_install', array(
            'default' => '',
            'sanitize_callback' => 'esc_attr'
        ));
        
        $wp_customize->add_section('reiki_headers', array(
            'priority' => 20,
            'title'    => __('Alternative Headers', 'reiki'),
        ));

        $wp_customize->add_control(new Reiki_Enable_Companion_Control($wp_customize, 'reiki_headers',
        array( 
            'section'  => 'reiki_headers',
            'settings' => 'reiki_companion_install',
            'plugin_state'    => $plugin_state,
        )));

        $wp_customize->add_section('reiki_page_content', array(
            'priority' => 20,
            'title'    => __('Front Page content', 'reiki'),
        ));

        $wp_customize->add_control(new Reiki_Enable_Companion_Control($wp_customize, 'reiki_page_content',
        array( 
            'section'  => 'reiki_page_content',
            'settings' => 'reiki_companion_install',
            'plugin_state'    => $plugin_state,
        )));

        $wp_customize->add_section('reiki_footers', array(
            'priority' => 20,
            'title'    => __('Alternative Footers', 'reiki'),
        ));

        $wp_customize->add_control(new Reiki_Enable_Companion_Control($wp_customize, 'reiki_footers',
        array(
            'section'  => 'reiki_footers',
            'settings' => 'reiki_companion_install',
            'plugin_state'    => $plugin_state,
        )));

        Reiki_Companion_Plugin::show_companion_popup($plugin_state);
    }
  }

   // static functions
  public static function getInstance(){
    if (!self::$instance) {
        self::$instance = new Reiki_Companion_Plugin();
    }

    return self::$instance;
  }

  public static function init(){
    Reiki_Companion_Plugin::getInstance();
  }
}

class Reiki_Basic_Customizer {
  private static $instance = false;
  public $wp_customize;

  public function __construct() {
    self::$instance            = $this;
    add_action('customize_register', array($this, 'customize_register_action'));
    add_action('admin_menu', array( $this, 'register_theme_page' ));
  }

  public function render_theme_page() {
    ?>
    <div class="reiki-about-page">
      <div class="rp-panel">
        <div class="rp-c">
          <h1><?php _e('Thanks for choosing Reiki!', 'reiki'); ?></h1>
          <p><?php _e('We\'re glad you chose our theme and we hope it will help you create a beautiful site in no time!<br> If you have any suggestions, don\'t hesitate to leave us some feedback.', 'reiki'); ?></p>
          <div class="reiki-get-started">
            <h2> <?php _e('Get Started in 3 Easy Steps', 'reiki'); ?></h2>
            <p><?php _e('1. Install the recommended plugins', 'reiki'); ?></p>
              <?php
                $config = Reiki_Companion_Plugin::$config;
                $plugins = $config['plugins'];

                foreach ($plugins as $slug => $plugin) {
                  $state = Reiki_Companion_Plugin::get_plugin_state($slug);
                  
                  $plugin_is_ready = $state['installed'] && $state['active'];
                  if (!$plugin_is_ready) {
                    if ($state['installed']) {
                      $link = Reiki_Companion_Plugin::get_activate_link($slug);
                      $label = $plugin['activate']['label'];
                      $btn_class = "activate";
                    } else {
                      $link = Reiki_Companion_Plugin::get_install_link($slug);
                      $label = $plugin['install']['label'];
                      $btn_class = "install-now";
                    }
                  }

                  $title = $plugin['title'];
                  $description = $plugin['description'];
              ?>

                  <div class="reiki_install_notice <?php if ($plugin_is_ready) echo 'blue'; ?>">
                    <h3 class="rp-plugin-title"><?php echo $title ?></h3>
                    <?php 
                      printf('<p>%1$s</p>', $description);
                      if (!$plugin_is_ready) {
                        printf('<a class="%1$s button" href="%2$s">%3$s</a>', $btn_class, esc_url($link), $label);
                      } else {
                        _e('Plugin is installed and active.', 'reiki');
                      }
                    ?>
                  </div>
              <?php
                }
              ?>
            <p>
              <?php 
              $customize_link = add_query_arg(
                array(
                  'url' =>  get_home_url()
                ),
                network_admin_url( 'customize.php' )
              );

              printf('2. <a class="button" href="%s"> %s </a> your site', $customize_link, __('Customize', 'reiki')); ?></p>
            <p><?php _e('3. Enjoy! :)', 'reiki'); ?></p>
          </div>
        </div>
        <div class="info-boxes">
          <div class="info-box">
            <div class="dashicons dashicons-book-alt icon"></div>
            <p>
              <a target="_blank" href="http://reikitheme.com/documentation"><?php _e('Documentation', 'reiki'); ?></a>
            </p>
          </div>
          
          <div class="info-box">
            <div class="dashicons dashicons-sos icon"></div>
            <p>
            <a target="_blank" href="https://wordpress.org/support/theme/reiki"><?php _e('Support', 'reiki'); ?></a>
            </p>
          </div>

          <div class="info-box">
            <div class="dashicons dashicons-email icon"></div>
            <p>
            <a target="_blank" href="http://reikitheme.com/feedback"><?php _e('Leave Feedback', 'reiki'); ?></a>
            </p>
          </div>
        </div>
      </div>
    </div>
    <?php
  }

  public function register_theme_page() {
    add_theme_page('reiki_theme_page', __('Reiki Info', 'reiki'), 'activate_plugins', 'reiki-welcome', array($this, 'render_theme_page'));
    add_action('admin_enqueue_scripts', array( $this, 'admin_scripts' ));
    add_action('load-themes.php', array( $this, 'activation_admin_notice' ));
  }

  public function activation_admin_notice() {
    global $pagenow;
    if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
      add_action( 'admin_notices', array( $this, 'theme_page_admin_notice' ), 99 );
    }
  }

  public function theme_page_admin_notice() {
  ?>
    <div class="updated notice is-dismissible">
      <p><?php _e('Thanks for choosing Reiki! Here\'s how to get started', 'reiki'); ?></p>
      <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=reiki-welcome' ) ); ?>" class="button"><?php _e( 'Get started with Reiki', 'reiki'); ?></a></p>
    </div>
  <?php
  }

  public function admin_scripts() {
    wp_enqueue_style('reiki_customizer', get_template_directory_uri() . '/customizer/customizer.css');
  }

  public function customize_register_action($wp_customize){
    Reiki_Companion_Plugin::check_companion($wp_customize);
  }

  // static functions
  public static function getInstance(){
    if (!self::$instance) {
        self::$instance = new Reiki_Basic_Customizer();
    }

    return self::$instance;
  }

  public static function init(){
    Reiki_Basic_Customizer::getInstance();
  }
}

