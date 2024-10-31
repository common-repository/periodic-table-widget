<?php
/**
 *
 * @link              www.mahafuzur.tk
 * @package           Periodic Table Widget
 * @author            mahafuzur <mahafuzur1986@gmail.com>
 *
 *
 */

/**
 * The periodic table main widget class
 *
 * @package    Periodic Table Widget
 *
 * @since             1.0.0
 *
 */

class Periodic_Table_Widget extends WP_Widget
{

    /*======================================================
     * Class Construct method
    ========================================================*/
    public function __construct()
    {

        add_action('wp_footer', array($this, 'enqueue_inline_styles'));

        $widget_ops = array(
            'classname'                   => 'widget-periodic-table',
            'description'                 => esc_html__('Periodic Table Slider', 'periodic-table-widget'),
            'customize_selective_refresh' => true,
        );
        parent::__construct('periodic_table_widget', __('Periodic Table', 'periodic-table-widget'), $widget_ops);

    }

    /*======================================================
     * Variable to hold the all custom css for dynamic-theme
    ========================================================*/
    public $allDynamicStyle = array();

    /*===========================================
     * Display the widget to frontend
    =============================================*/
    public function widget($args, $instance)
    {
        /*===========================================
         * Widget Title
        =============================================*/
        $title = (!empty($instance['title']) ? $instance['title'] : esc_html__('Periodic Table', 'periodic-table-widget'));

        /*===========================================
         * Widget Default Theme
        =============================================*/
        $theme = (!empty($instance['theme']) ? $instance['theme'] : 'light');

        /*===========================================
         * Default settings for bx slider
        =============================================*/
        $infiniteLoop = (!empty($instance['infiniteLoop']) ? '1' : '0');
        $mode         = (!empty($instance['mode']) ? $instance['mode'] : 'horizontal');
        $controls     = (!empty($instance['controls']) ? '1' : '0');
        $speed        = (!empty($instance['speed']) ? absint($instance['speed']) : 500);
        $auto         = (!empty($instance['auto']) ? '1' : '0');
        $autoHover    = (!empty($instance['autoHover']) ? '1' : '0');
        $randomStart  = (!empty($instance['randomStart']) ? '1' : '0');
        $pager        = (!empty($instance['pager']) ? '1' : '0');
        $pause        = (!empty($instance['pause']) ? absint($instance['pause']) : 4000);

        /*====================================================
         * Dynamicaly Generate Theme Class for user selection
        =====================================================*/
        if ($theme == 'dark') {
            $themeClass = 'theme-dark';
        } elseif ($theme == 'dynamic') {
            $themeClass = 'theme-dynamic';
        } else {
            $themeClass = 'theme-light';
        }

        /*====================================================
         * Main Markup Start
        =====================================================*/
        echo $args['before_widget'];

        if (!empty($instance['title'])):

            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];

        endif;?>

        <?php

        /*====== Load Periodic Table Data From Json File =====*/
        $response = wp_remote_get(PERIODIC_TABLE_WIDGET_PLUGIN_URL . "public/js/preodicTableData.json", array('timeout' => 120, 'httpversion' => '1.1'));

        if (is_array($response)) {
            $header = $response['headers']; // array of http header lines
            $body   = $response['body']; // use the content
        }
        // $preodicTableData   = file_get_contents(PERIODIC_TABLE_WIDGET_PLUGIN_URL . "public/js/preodicTableData.json");

        /*====== Convert Json Data To Php Array =====*/
        $elements = json_decode($body, true);
        // $elements = json_decode($preodicTableData, true);

        /*====== Get The Current Widget Id =====*/
        $widgetId = $this->id;

        /*====== Generate Data Attribute From All Bxslider Options =====*/
        $slider_options = array(
            'infiniteLoop' => $instance['infiniteLoop'],
            'mode'         => $instance['mode'],
            'controls'     => $instance['controls'],
            'speed'        => $instance['speed'],
            'auto'         => $instance['auto'],
            'autoHover'    => $instance['autoHover'],
            'randomStart'  => $instance['randomStart'],
            'pager'        => $instance['pager'],
            'pause'        => $instance['pause'],
        );
        $slider_option_data = array();
        foreach ($slider_options as $name => $value) {
            array_push($slider_option_data, 'data-' . esc_attr($name) . '="' . esc_attr($value) . '"');
        }

        /*====== Html Markup for the Widget =====*/
        ?>

    <div class="widget-inner <?php echo esc_attr($themeClass); ?>">
      <!-- // Hold the element summary text -->
      <div class="box"></div>
      <div class="periodicTable" <?php echo implode(' ', $slider_option_data); ?> >

        <?php foreach ($elements as $key => $value):

            /*====== Generate The Custom CSS For dynamic-css class =====*/
            $dynamicStyle = $primaryColor = $secondaryColor = $css = '';
            if ($themeClass == 'theme-dynamic') {
                $primaryColor   = $value['cpkHexColor'];
                $secondaryColor = $this->coplementColor($value['cpkHexColor']);
                $css .= '#' . $widgetId . ' #' . $value['symbol'] . ' .element_container,';
                $css .= '#' . $widgetId . ' #' . $value['symbol'] . ' .element_details,';
                $css .= '#' . $widgetId . ' p[dataStyle="box-' . $value['symbol'] . '"]{';
                $css .= 'background-color:' . $primaryColor . ';';
                $css .= 'color:' . $secondaryColor . ';';
                $css .= 'border-color:' . $secondaryColor . ';';
                $css .= '}';
                $css .= '#' . $widgetId . ' #' . $value['symbol'] . ' .element_header h4{';
                $css .= 'background-color:' . $secondaryColor . ';';
                $css .= 'color:' . $primaryColor . ';';
                $css .= 'border-color:' . $secondaryColor . ';';
                $css .= '}';
                $css .= '#' . $widgetId . ' #' . $value['symbol'] . ' .element_details li{';
                $css .= 'border-bottom-color:' . $secondaryColor . ';';
                $css .= '}';
                $css .= '#' . $widgetId . ' #' . $value['symbol'] . ' .element_details li a,';
                $css .= '#' . $widgetId . ' #' . $value['symbol'] . ' .element_details li a:hover{';
                $css .= 'color:' . $secondaryColor . ';';
                $css .= '}';
                $css .= '#' . $widgetId . ' #' . $value['symbol'] . ' .more_toggle span{';
                $css .= 'background-color:' . $primaryColor . ';';
                $css .= '}';
                $css .= '#' . $widgetId . ' #' . $value['symbol'] . ' table td,';
                $css .= '#' . $widgetId . ' #' . $value['symbol'] . ' table tr,';
                $css .= '#' . $widgetId . ' #' . $value['symbol'] . ' table th{';
                $css .= 'border-color:' . $secondaryColor . ';';
                $css .= '}';

                /*====== Add Css to the variable =====*/
                array_push($this->allDynamicStyle, $css);

            }
            /*====== Html Markup for the Widget =====*/
            ?>

            <div id="<?php echo $value['symbol']; ?>" class="element">
              <div class="element_container">
              <div class="element_header">
                <h4 class="atom_name"><?php echo $value['name']; ?></h4>
                <a class="more_toggle" href="#">
                  <span class="bar1"></span>
                  <span class="bar2"></span>
                  <span class="bar3"></span>
                </a>
              </div>
              <div class="element_content">
                <table class="table_top">
                  <tr>
                    <th class="left_align">Discovered</th>
                    <th class="right_align">State</th>
                  </tr>
                  <tr>
                    <td class="left_align">
                      <?php echo $value['yearDiscovered']; ?>
                    </td>
                    <td class="right_align">
                      <?php echo $value['standardState']; ?>
                    </td>
                  </tr>
                  <tr>
                    <th class="left_align">Atomic Mass</th>
                    <th class="right_align">Density</th>
                  </tr>
                  <tr>
                    <td class="left_align">
                      <?php echo $value['atomicMass']; ?>
                    </td>
                    <td class="right_align">
                      <?php echo $value['density']; ?> g/L
                    </td>
                  </tr>
                </table>

                <div class="atom_container">
                  <span class="atom">
                    <sup class="mass"><?php echo $value['atomicNumber'] + $value['neutonNumber']; ?></sup>
                    <sub class="proton"><?php echo $value['atomicNumber']; ?></sub>
                    <span class="symbol"><?php echo $value['symbol']; ?></span>
                    <sub class="state"><?php echo $value['atomicState']; ?></sub>
                  </span>
                </div>


                <table class="table_bottom">
                  <tr>
                    <th>Electrons</th>
                    <th>Protons</th>
                    <th>Neutrons</th>
                  </tr>
                  <tr>
                    <td>
                      <?php echo $value['electronNumber']; ?>
                    </td>
                    <td>
                      <?php echo $value['atomicNumber']; ?>
                    </td>
                    <td>
                      <?php echo $value['neutonNumber']; ?>
                    </td>
                  </tr>
                  <tr>
                    <th colspan="3">Electronic Configuration</th>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <?php echo $value['electronicConfiguration']; ?>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="element_details closed">
                <ul>
                  <li>
                    <span>Discovered By: </span><span><?php echo $value['discoveredBy']; ?></span>
                  </li>
                  <li>
                    <span>Appearance: </span><span><?php echo $value['appearance']; ?></span>
                  </li>
                  <li>
                    <span>Category: </span><span><?php echo $value['category']; ?></span>
                  </li>
                  <li>
                    <span>Melting Point: </span><span><?php echo $value['meltingPoint']; ?> K</span>
                  </li>
                  <li>
                    <span>Boiling Point: </span><span><?php echo $value['boilingPoint']; ?> K</span>
                  </li>
                  <li>
                    <span>Ox. State: </span><span><?php echo $value['oxidationStates']; ?></span>
                  </li>
                  <li>
                    <span>Bonding Type: </span><span><?php echo $value['bondingType']; ?></span>
                  </li>
                  <li>
                    <span>Electronegativity: </span><span><?php echo $value['electronegativity']; ?></span>
                  </li>
                  <li>
                    <span>Wiki Link: </span><span><a href="<?php echo $value['source']; ?>" target="_blank">Source Link</a></span>
                  </li>
                  <li>
                    <span>Element Image: </span><span><a href="<?php echo $value['spectral_img']; ?>" target="_blank">Image Link</a></span>
                  </li>
                </ul>
              </div>
              <div class="element_summary">
                <p dataStyle="box-<?php echo $value['symbol']; ?>">
                  <?php echo $value['summary']; ?>
                </p>
              </div>
              </div>
            </div>
            <?php endforeach;?>

      </div>
    </div>


    <?php

        echo $args['after_widget'];
        /*========= End of the Widget html markup ==========*/
    }

    /*====================================================
     * Create the Full style for dynamic-css, for enqueuing
    =====================================================*/
    public function enqueue_inline_styles()
    {
        if (!empty($this->allDynamicStyle)) {
            $style = '';
            foreach ($this->allDynamicStyle as $css) {
                $style .= $css;
            }
            echo '<style id="periodic_table_dynamic_style" type="text/css">' . $style . '</style>';
        }
    }

    /*====================================================
     * Backend Form For Widget
    =====================================================*/
    public function form($instance)
    {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'theme' => 'light'));

        /*========= Widget Title ==========*/
        $title = (!empty($instance['title']) ? esc_attr($instance['title']) : esc_html__('Periodic Table', 'periodic-table-widget'));
        /*========= Widget Theme ==========*/
        $theme = (!empty($instance['theme']) ? esc_attr($instance['theme']) : 'light');

        /*========= Widget Slider Options ==========*/
        $infiniteLoop = (isset($instance['infiniteLoop']) ? $instance['infiniteLoop'] : true);
        $mode         = (!empty($instance['mode']) ? esc_attr($instance['mode']) : 'horizontal');
        $controls     = (isset($instance['controls']) ? $instance['controls'] : false);
        $speed        = (!empty($instance['speed']) ? absint($instance['speed']) : 500);
        $auto         = (isset($instance['auto']) ? $instance['auto'] : true);
        $autoHover    = (isset($instance['autoHover']) ? $instance['autoHover'] : true);
        $randomStart  = (isset($instance['randomStart']) ? $instance['randomStart'] : true);
        $pager        = (isset($instance['pager']) ? $instance['pager'] : false);
        $pause        = (!empty($instance['pause']) ? absint($instance['pause']) : 4000);

        /*========= Admin Form ==========*/
        ?>
      <!-- Start Title -->
      <p>
        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
          <?php esc_html_e('Title:', 'periodic-table-widget');?>
        </label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_html($title); ?>" />
      </p>
      <!-- // End Title -->
      <!-- Start Theme -->
      <p>
        <label for="<?php echo esc_attr($this->get_field_id('theme')); ?>">
          <?php esc_html_e('Theme:', 'periodic-table-widget');?>
        </label>
        <select class="widefat" name="<?php echo esc_attr($this->get_field_name('theme')); ?>" id="<?php echo esc_attr($this->get_field_id('theme')); ?>">
            <option value="light" <?php selected($instance['theme'], 'light');?> >Light</option>
            <option value="dark" <?php selected($instance['theme'], 'dark');?> >Dark</option>
            <option value="dynamic" <?php selected($instance['theme'], 'dynamic');?> >Dynamic</option>
        </select>
      </p>
      <!-- // End Theme -->
      <!-- Description -->
      <p class="description" style="padding-bottom: 0px">All Slider Settings</p>
      <!-- // End Description -->

      <!-- Start Animation Mode -->
      <p>
        <label for="<?php echo esc_attr($this->get_field_id('mode')); ?>">
          <?php esc_html_e('Animation Mode:', 'periodic-table-widget');?>
        </label>
        <select class="widefat" name="<?php echo esc_attr($this->get_field_name('mode')); ?>" id="<?php echo esc_attr($this->get_field_id('mode')); ?>">
            <option value="horizontal" <?php selected($mode, 'horizontal');?> >Horizontal</option>
            <option value="vertical" <?php selected($mode, 'vertical');?> >Vertical</option>
            <option value="fade" <?php selected($mode, 'fade');?> >Fade</option>
        </select>
      </p>
      <!-- // End Animation Mode -->
      <!-- Start Animation Speed -->
      <p>
        <label for="<?php echo esc_attr($this->get_field_id('speed')); ?>">
          <?php esc_html_e('Animation Speed:', 'periodic-table-widget');?>
        </label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('speed')); ?>" name="<?php echo esc_attr($this->get_field_name('speed')); ?>" type="number" value="<?php echo esc_html($speed); ?>" />
      </p>
      <!-- End Animation Speed -->
      <!-- Start Slide Delay -->
      <p>
        <label for="<?php echo esc_attr($this->get_field_id('pause')); ?>">
          <?php esc_html_e('Slide Delay:', 'periodic-table-widget');?>
        </label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('pause')); ?>" name="<?php echo esc_attr($this->get_field_name('pause')); ?>" type="number" value="<?php echo esc_html($pause); ?>" />
      </p>
      <!-- End Slide Delay -->
      <!-- Start Infinite Loop -->
    <p>
      <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('infiniteLoop')); ?>" name="<?php echo esc_attr($this->get_field_name('infiniteLoop')); ?>" <?php checked($infiniteLoop);?> />
      <label for="<?php echo esc_attr($this->get_field_id('infiniteLoop')); ?>"><?php esc_html_e('Infinite Loop', 'periodic-table-widget');?></label>
    </p>
      <!-- End Infinite Loop -->
      <!-- Start Controls -->
    <p>
      <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('controls')); ?>" name="<?php echo esc_attr($this->get_field_name('controls')); ?>"<?php checked($controls);?> />
      <label for="<?php echo esc_attr($this->get_field_id('controls')); ?>"><?php esc_html_e('Controls', 'periodic-table-widget');?></label>
    </p>
      <!-- End Controls -->
      <!-- Start Auto Start -->
    <p>
      <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('auto')); ?>" name="<?php echo esc_attr($this->get_field_name('auto')); ?>"<?php checked($auto);?> />
      <label for="<?php echo esc_attr($this->get_field_id('auto')); ?>"><?php esc_html_e('Auto Start', 'periodic-table-widget');?></label>
    </p>
      <!-- End Auto Start -->
      <!-- Start Push on hover -->
    <p>
      <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('autoHover')); ?>" name="<?php echo esc_attr($this->get_field_name('autoHover')); ?>"<?php checked($autoHover);?> />
      <label for="<?php echo esc_attr($this->get_field_id('autoHover')); ?>"><?php esc_html_e('Push on hover', 'periodic-table-widget');?></label>
    </p>
      <!-- End Push on hover -->
      <!-- Start Random slide  -->
    <p>
      <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('randomStart')); ?>" name="<?php echo esc_attr($this->get_field_name('randomStart')); ?>"<?php checked($randomStart);?> />
      <label for="<?php echo esc_attr($this->get_field_id('randomStart')); ?>"><?php esc_html_e('Start random slide on page load', 'periodic-table-widget');?></label>
    </p>
      <!-- End Random slide -->
      <!-- Start Show pager  -->
    <p>
      <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('pager')); ?>" name="<?php echo esc_attr($this->get_field_name('pager')); ?>"<?php checked($pager);?> />
      <label for="<?php echo esc_attr($this->get_field_id('pager')); ?>"><?php esc_html_e('Show pager', 'periodic-table-widget');?></label>
    </p>
      <!-- End Show pager  -->
      <?php
}

    /*====================================================
     * Update The Widget Options When Save
    =====================================================*/
    public function update($new_instance, $old_instance)
    {

        $instance          = $old_instance;
        $instance['title'] = (!empty($new_instance['title']) ? strip_tags($new_instance['title']) : '');
        $instance['theme'] = (!empty($new_instance['theme']) ? $new_instance['theme'] : '');

        $instance['infiniteLoop'] = (!empty($new_instance['infiniteLoop']) ? 1 : 0);
        $instance['mode']         = (!empty($new_instance['mode']) ? $new_instance['mode'] : '');
        $instance['controls']     = (!empty($new_instance['controls']) ? 1 : 0);
        $instance['speed']        = (!empty($new_instance['speed']) ? absint(strip_tags($new_instance['speed'])) : 500);
        $instance['auto']         = (!empty($new_instance['auto']) ? 1 : 0);
        $instance['autoHover']    = (!empty($new_instance['autoHover']) ? 1 : 0);
        $instance['randomStart']  = (!empty($new_instance['randomStart']) ? 1 : 0);
        $instance['pager']        = (!empty($new_instance['pager']) ? 1 : 0);
        $instance['pause']        = (!empty($new_instance['pause']) ? absint(strip_tags($new_instance['pause'])) : 4000);

        return $instance;

    }

    /*====================================================
     * Helper Function
     *
     * Generate a complementary color based on the
     * background color of the container.
    =====================================================*/
    public function coplementColor($hexcode)
    {
        /*========= Remove '#' From Color Hex code ==========*/
        $hexcode = str_replace('#', '', $hexcode);

        /*========= Convert Hex color Code To Rgb ==========*/
        $r = substr($hexcode, 0, 2);
        $g = substr($hexcode, 2, 2);
        $b = substr($hexcode, 4, 2);

        $vr = (hexdec($r)) / 255;
        $vg = (hexdec($g)) / 255;
        $vb = (hexdec($b)) / 255;

        /*========= Generate complementary color ==========*/
        $var_min = min($vr, $vg, $vb);
        $var_max = max($vr, $vg, $vb);
        $del_max = $var_max - $var_min;
        $I       = ($var_max + $var_min) / 2;

        if ($del_max == 0) {
            $h = 255;
            $s = 255;
        } else {
            if ($I < 0.5) {
                $s = $del_max / ($var_max + $var_min);
            } else {
                $s = $del_max / (2 - $var_max - $var_min);
            }
            $del_r = ((($var_max - $vr) / 6) + ($del_max / 2)) / $del_max;
            $del_g = ((($var_max - $vg) / 6) + ($del_max / 2)) / $del_max;
            $del_b = ((($var_max - $vb) / 6) + ($del_max / 2)) / $del_max;

            if ($vr == $var_max) {
                $h = $del_b - $del_g;
            } elseif ($vg == $var_max) {
                $h = (1 / 3) + $del_r - $del_b;
            } elseif ($vb == $var_max) {
                $h = (2 / 3) + $del_g - $del_r;
            }
            if ($h < 0) {
                $h += 1;
            }
            if ($h > 1) {
                $h -= 1;
            }

        }

        $h2 = $h + 0.5;

        if ($h2 > 1) {
            $h2 -= 1;
        }

        if ($s == 0) {
            $r = $I * 255;
            $g = $I * 255;
            $b = $I * 255;
        } else {
            if ($I < 0.5) {
                $var_2 = $I * (1 + $s);
            } else {
                $var_2 = ($I + $s) - ($s * $I);
            }
            $var_1 = 2 * $I - $var_2;

            /*========= Convert hls To rgb Color Code ==========*/
            $r = 255 * $this->hue_2_rgb($var_1, $var_2, $h2 + (1 / 3));
            $g = 255 * $this->hue_2_rgb($var_1, $var_2, $h2);
            $b = 255 * $this->hue_2_rgb($var_1, $var_2, $h2 - (1 / 3));
        }

        /*========= Round Up the Rgb Value ==========*/
        $rhex = sprintf("%02X", round($r));
        $ghex = sprintf("%02X", round($g));
        $bhex = sprintf("%02X", round($b));

        /*========= Combine The Rgb Value ==========*/
        $rgbhex = $rhex . $ghex . $bhex;
        
        if(strlen($rgbhex) > 6 ){
        $rgbhex = substr($rgbhex, 0,6);
        }
        /*=========  Generate Light or Dark Color Based on Input Hex Color ==========*/
        if ($this->getContrest($hexcode) == true) {
            $rgbhex = $this->adjB($rgbhex, -180);
        } elseif ($this->getContrest($hexcode) == false) {
            $rgbhex = $this->adjB($rgbhex, 150);
        }

        /*=========  Return The Color Hex code ==========*/
        return '#' . $rgbhex;
    }

    /*====================================================
     * Helper Function
     *
     * Convert Hls color Value to Rgb Value
    =====================================================*/
    public function hue_2_rgb($v1, $v2, $vh)
    {
        if ($vh < 0) {
            $vh += 1;
        }
        if ($vh > 1) {
            $vh -= 1;
        }
        if ((6 * $vh) < 1) {
            return ($v1 + ($v2 - $v1) * 6 * $vh);
        }
        if ((2 * $vh) < 1) {
            return ($v2);
        }
        if ((3 * $vh) < 2) {
            return ($v1 + ($v2 - $v1) * ((2 / 3 - $vh) * 6));
        }
        return ($v1);
    }

    /*====================================================
     * Helper Function
     *
     * Check Given Color Light or Dark
    =====================================================*/
    public function getContrest($hexcolor)
    {
        $r   = hexdec(substr($hexcolor, 0, 2));
        $g   = hexdec(substr($hexcolor, 2, 2));
        $b   = hexdec(substr($hexcolor, 4, 2));
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($yiq >= 128) ? true : false;
    }

    /*==========================================================
     * Helper Function
     *
     * Convert Lighter Color to Dark and Darker Color To Light
    ===========================================================*/
    public function adjB($hex, $steps)
    {
        $steps = max(-255, min(255, $steps));
        $hex   = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
        }
        $color_parts = str_split($hex, 2);
        $return      = '';

        foreach ($color_parts as $color) {
            $color = hexdec($color);
            $color = max(0, min(255, $color + $steps));
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT);
        }

        return $return;
    }

}

/*================== End of the Widget Class =========================*/