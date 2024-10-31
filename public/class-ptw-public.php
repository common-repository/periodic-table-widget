<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.mahafuzur.tk
 * @since      1.0.0
 *
 * @package    Periodic Table Widget
 *
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Periodic Table Widget
 *
 *
 */
class Ptw_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /* Load plugin style */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ptw-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        wp_enqueue_script('jquery.bxslider', plugin_dir_url(__FILE__) . 'js/jquery.bxslider.js', array('jquery'), '4.1.2', true);

        /* Load plugin script */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ptw-public.js', array('jquery', 'jquery.bxslider'), $this->version, true);

    }

    public function periodic_table_widget_register_fn()
    {
        require_once plugin_dir_path(__DIR__) . 'widget/class.widget.periodic-table.php';
        register_widget('Periodic_Table_Widget');
    }

}
