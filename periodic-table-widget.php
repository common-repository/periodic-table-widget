<?php
/**
 *
 * @link              www.mahafuzur.tk
 * @since             1.0.0
 * @package           Periodic Table Widget
 * @author            mahafuzur <mahafuzur1986@gmail.com>
 *
 *
 * @wordpress-plugin
 * Plugin Name:       Periodic Table Widget
 * Plugin URI:        http://www.mahafuzur.tk/plugins/periodic-table-widget
 * Description:       This is a educational wordpress widget. This widget provide you a nice looking slide for each periodic table element, you can also view more info by click bar icon.
 * Version:           1.0.0
 * Author:            Md. Mahafuzur Rahaman
 * Author URI:        www.mahafuzur.tk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       periodic-table-widget
 * Domain Path:       /languages
 */

/*===========================================
 ** If this file is called directly, abort.
=============================================*/
if (!defined('WPINC')) {
    die;
}

/*===========================================
 * Currently plugin version.
=============================================*/
define('PERIODIC_TABLE_WIDGET', '1.0.0');

/*===========================================
 * PLUGIN DIRECTORY URL
=============================================*/
define('PERIODIC_TABLE_WIDGET_PLUGIN_URL', plugins_url('/', __FILE__));

/*===========================================
 * Runs during plugin activation.
=============================================*/
function activate_ptw()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-ptw-activator.php';
    Ptw_Activator::activate();
}
register_activation_hook(__FILE__, 'activate_ptw');

/*===========================================
 * Runs during plugin deactivation.
=============================================*/
function deactivate_ptw()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-ptw-deactivator.php';
    Ptw_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_ptw');

/*====================================================================
 * The core plugin class that is used to define internationalization,
======================================================================*/
require plugin_dir_path(__FILE__) . 'includes/class-ptw.php';

/*====================================================================
 * Begins execution of the plugin.
======================================================================*/
function run_ptw()
{

    $plugin = new Ptw();
    $plugin->run();

}
run_ptw();
