<?php

/**
 * Internationalization functionality
 *
 *
 * @link       www.mahafuzur.tk
 * @since      1.0.0
 *
 * @package    Periodic Table Widget
 */

/**
 * Define the internationalization functionality.
 *
 *
 * @since      1.0.0
 * @package    Periodic Table Widget
 */
class Ptw_i18n
{

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            'periodic-table-widget',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }

}
