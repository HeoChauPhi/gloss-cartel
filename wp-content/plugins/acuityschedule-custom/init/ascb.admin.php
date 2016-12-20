<?php
/**
 * Admin settings page.
 */

class ASCBSettingsPage {
  /**
  * Holds the values to be used in the fields callbacks
  */
  private $options;

  /**
  * Start up
  */
  public function __construct() {
    add_action('admin_menu', array($this, 'ascb_add_plugin_page' ));
    add_action('admin_init', array($this, 'ascb_page_init'));
  }

  /**
  * Add options page
  */
  public function ascb_add_plugin_page() {
    // This page will be under "Settings"
    add_options_page(
      __('Appointment Scheduling Settings', 'ascb'),
      __('Appointment Scheduling', 'ascb'),
      'manage_options',
      'ascb-setting-admin',
      array($this, 'ascb_reate_admin_page')
    );
  }

  /**
  * Options page callback
  */
  public function ascb_reate_admin_page() {
    // Set class property
    $this->options = get_option('ascb_board_settings');

    ?>
    <div class="wrap">
      <h1><?php echo __('Appointment Scheduling Plugin settings', 'ascb') ?></h1>
      <form method="post" action="options.php">
      <?php
        // This prints out all hidden setting fields
        settings_fields('ascb_option_config');
        do_settings_sections('ascb-setting-admin');
        submit_button();
      ?>
      </form>
    </div>
    <?php
  }

  /**
  * Register and add settings
  */
  public function ascb_page_init() {
    register_setting('ascb_option_config', 'ascb_board_settings');

    // Facebook Account
    add_settings_section(
      'ascb_section_id', // ID
      '', // Title
      array( $this, 'ascb_print_section_info' ), // Callback
      'ascb-setting-admin' // Page
    );

    add_settings_field(
      'ascb_user_id',
      __('User ID API <br><i style="font-size: 10px; color: #72777c; font-weight: 400;">Get User ID in: <a href="https://secure.acuityscheduling.com/app.php?action=settings&key=api" target="_blank">Click Here</a></i>', 'ascb'),
      array( $this, 'ascb_form_textfield' ), // Callback
      'ascb-setting-admin', // Page
      'ascb_section_id',
      'ascb_user_id'
    );

    add_settings_field(
      'ascb_user_key',
      __('User Key API <br><i style="font-size: 10px; color: #72777c; font-weight: 400;">Get User Key in: <a href="https://secure.acuityscheduling.com/app.php?action=settings&key=api" target="_blank">Click Here</a></i>', 'ascb'),
      array( $this, 'ascb_form_textfield' ), // Callback
      'ascb-setting-admin', // Page
      'ascb_section_id',
      'ascb_user_key'
    );

    add_settings_field(
      'ascb_url_api',
      __('Url API <br><i style="font-size: 10px; color: #72777c; font-weight: 400;">Get Url API in: <a href="https://developers.acuityscheduling.com/docs/" target="_blank">Click Here</a></i>', 'ascb'),
      array( $this, 'ascb_form_textfield' ), // Callback
      'ascb-setting-admin', // Page
      'ascb_section_id',
      'ascb_url_api'
    );

    add_settings_field(
      'ascb_product_url',
      __('Product URL <br><i style="font-size: 10px; color: #72777c; font-weight: 400;">Get Product URL in: <a href="https://developers.acuityscheduling.com/docs/" target="_blank">Click Here</a></i>', 'ascb'),
      array( $this, 'ascb_form_textfield' ), // Callback
      'ascb-setting-admin', // Page
      'ascb_section_id',
      'ascb_product_url'
    );
  }

  /**
  * Print the Section text
  */
  public function ascb_print_section_info() {
    echo __("", 'ascb');
  }

  /**
  * Get the settings option array and print one of its values
  */
  public function ascb_form_textfield($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<input type="text" size=60 id="form-id-%s" name="ascb_board_settings[%s]" value="%s" />', $name, $name, $value);
  }
}
