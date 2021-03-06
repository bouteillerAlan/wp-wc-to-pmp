<?php
class WcdouchetteOptions {

  /**
   * the single instance of the class
   */
  protected static $_instance = null;

  /**
   * launch init()
   * @throws Exception
   */
  protected function __construct() {
    $this->init();
  }

  /**
   * singleton the instance
   */
  public static function instance() {
    if (is_null( self::$_instance )) self::$_instance = new self();
    return self::$_instance;
  }

  /**
   * setup options field
   */
  public function wcdouchette_register_settings() {
    add_option('wcdouchette_option_pmp_url', 'http://xx.gtlsrv.com:1337/', '', 'yes');
    add_option('wcdouchette_option_pmp_user', 'Jane', '', 'yes');
    add_option('wcdouchette_option_pmp_pass', '1234', '', 'yes');
    add_option('wcdouchette_option_woo_ck', 'ck_1234', '', 'yes');
    add_option('wcdouchette_option_woo_cs', 'cs_1234', '', 'yes');
    register_setting('wcdouchette_options_group', 'wcdouchette_option_pmp_url');
    register_setting('wcdouchette_options_group', 'wcdouchette_option_woo_ck');
    register_setting('wcdouchette_options_group', 'wcdouchette_option_woo_cs');
    register_setting('wcdouchette_options_group', 'wcdouchette_option_pmp_user');
    register_setting('wcdouchette_options_group', 'wcdouchette_option_pmp_pass');
  }

  /**
   * output the HTML for the option page
   */
  public function wcdouchette_options_page_html() {

    // check user capabilities
    if (!current_user_can('manage_options')) return;

          // form
    ?>
          <div class="wrap">
              <h1><?php echo esc_html(get_admin_page_title());?></h1>
              <!--options.php-->
              <form action="options.php" method="post">
                  <?php settings_fields('wcdouchette_options_group'); ?>

                  <table>
                      <tr>
                          <tr><h4>Woocommerce informations</h4></tr>
                          <tr><code>The woocommerce key need read/write right in administrator account</code></tr>
                          <tr>
                            <td><label for='wcdouchette_option_woo_ck'>Woocommerce ck key</label></td>
                            <td>
                                <input type='text' name='wcdouchette_option_woo_ck'
                                       value="<?php echo esc_attr( get_option('wcdouchette_option_woo_ck'));?>"
                                />
                            </td>
                          </tr>
                          <tr>
                            <td><label for='wcdouchette_option_woo_cs'>Woocommerce cs key</label></td>
                            <td>
                                <input type='password' name='wcdouchette_option_woo_cs'
                                       value="<?php echo esc_attr( get_option('wcdouchette_option_woo_cs'));?>"
                                />
                            </td>
                          </tr>
                          <tr><td><h4>Pickeos Mission Prepa informations</h4></td></tr>
                          <tr>
                            <td><label for='wcdouchette_option_pmp_url'>PMP URL (with the trailling slash)</label></td>
                            <td>
                                <input type='text' name='wcdouchette_option_pmp_url'
                                       value="<?php echo esc_attr(get_option('wcdouchette_option_pmp_url'));?>"
                                />
                            </td>
                          </tr>
                          <tr>
                            <td><label for='wcdouchette_option_pmp_user'>PMP user</label></td>
                            <td>
                                <input type='text' name='wcdouchette_option_pmp_user'
                                       value="<?php echo esc_attr( get_option('wcdouchette_option_pmp_user'));?>"
                                />
                            </td>
                          </tr>
                          <tr>
                            <td><label for='wcdouchette_option_pmp_pass'>PMP password</label></td>
                            <td>
                                <input type='password' name='wcdouchette_option_pmp_pass'
                                       value="<?php echo esc_attr( get_option('wcdouchette_option_pmp_pass'));?>"
                                />
                            </td>
                          </tr>
                      </tr>
                  </table>

                  <?php submit_button(__('Save Settings', 'textdomain')); ?>
              </form>
          </div>
    <?php
  }

  /**
   * setup the submenu into settings main menu
   */
  public function wcdouchette_options_page() {
    add_submenu_page(
      'woocommerce',
      'wc-douchette options',
      'wc-douchette options',
      'manage_options',
      'wcdouchette',
      array($this, 'wcdouchette_options_page_html')
    );
  }

  /**
   * add option submenu into the woocommerce primary menu
   */
  private function init() {
    add_action('admin_menu', array($this, 'wcdouchette_options_page'));
    add_action('admin_init', array($this, 'wcdouchette_register_settings'));
  }
}
