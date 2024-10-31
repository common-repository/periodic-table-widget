<?php

/**
 *
 * @link              www.mahafuzur.tk
 * @since             1.0.0
 * @package           Periodic Table Widget
 *
 */

class Ptw_Deactivator
{

    /**
     * Fired during plugin deactivation
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
        flush_rewrite_rules();
    }

}
