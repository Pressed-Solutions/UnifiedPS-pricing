<?php
/**
 * Plugin Name: UnifiedPS.com Pricing
 * Plugin URI: https://github.com/Pressed-Solutions/UnifiedPS-pricing
 * Description: Adds shortcode for pricing table
 * Version: 1.0
 * Author: Pressed Solutions
 * Author URI: https://pressedsolutions.com
 * Copyright: 2017 Pressed Solutions

 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined( 'ABSPATH' ) or die( 'No access allowed' );

const UNIFIED_PRICING_PLUGIN_VERSION = '1.0.0';

/*
 * Include ACF settings
 */
include( 'inc/acf.php' );

/**
 * Register assets
 */
function unifiedps_pricing_assets() {
    wp_register_script( 'unifiedps-pricing', plugin_dir_url( __FILE__ ) . 'assets/unifiedps-pricing.min.js', array( 'jquery' ), UNIFIED_PRICING_PLUGIN_VERSION );
    wp_register_style( 'unifiedps-pricing', plugin_dir_url( __FILE__ ) . 'assets/unifiedps-pricing.css', array(), UNIFIED_PRICING_PLUGIN_VERSION );
}
add_action( 'wp_enqueue_scripts', 'unifiedps_pricing_assets' );

/**
 * Display pricing details
 * @return string HTML string
 */
function unifiedps_pricing_shortcode() {
    wp_enqueue_style( 'unifiedps-pricing' );
    wp_enqueue_script( 'unifiedps-pricing' );

    ob_start();

    $products = get_field( 'product' );
    foreach ( $products as $product ) {
        $product_name = $product['product_name'];
        $product_class = str_replace( ' ', '-', strtolower( $product_name ) );
        $slider_label = str_replace( '%%variable%%', '<span class="range-slider value variable-amount">0</span>', $product['slider_label'] );

        $price_point_count = count( $product['price_structure'] );
        $price_point_list = json_encode( $product['price_structure'] );

        $offer_details = $product['offer_details'];
        $cta_details = $product['cta_details'];
        ?>

        <div class="pricing-stripe <?php echo $product_class; ?>">
            <h2 class="price-title"><?php echo $product_name ?></h2>
            <div class="price-range">
              <label for="<?php echo $product_class; ?>"><p><?php echo $slider_label; ?></p>
                  <p><input name="<?php echo $product_class; ?>" class="range-slider range" type="range" min="1" max="<?php echo $price_point_count ?>" step="1" data-quantity-list="<?php echo urlencode( $price_point_list ); ?>"></p>
              </label>
            </div>
            <div class="offer-details"><?php echo $offer_details; ?></div>
            <div class="cta">
                  <p class="price <?php echo $product_class; ?>"><sup>$</sup><span class="monthly-amount variable-amount"></span><wbr><span class="small">/<span class="unit">month</span></span>
                  </p>

                <div class="cta-details"><?php echo $cta_details; ?></div>
            </div>
        </div><!-- .pricing-stripe.<?php echo $product_class ?> -->
        <?php
    }

    return ob_get_clean();
}
add_shortcode( 'unifiedps_pricing', 'unifiedps_pricing_shortcode' );
