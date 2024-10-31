<?php

/**
 *
 * @link              www.mahafuzur.tk
 * @since             1.0.0
 * @package           Periodic Table Widget
 *
 */

class Ptw_Activator
{

/**
 * Fired during plugin activation
 *
 *
 * @since    1.0.0
 */
    public static function activate()
    {
        flush_rewrite_rules();
    }

}
