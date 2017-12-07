<?php

/**
 * Set ACF local JSON save directory
 * @param  string $path ACF local JSON save directory
 * @return string ACF local JSON save directory
 */
if ( ! function_exists( 'unifiedpsacf_json_save_point' ) ) {
function unifiedpsacf_json_save_point( $path ) {
    return plugin_dir_path( __FILE__ ) . '/../acf-json';
}
}
add_filter( 'acf/settings/save_json', 'unifiedpsacf_json_save_point' );

/**
 * Set ACF local JSON open directory
 * @param  array $path ACF local JSON open directory
 * @return array ACF local JSON open directory
 */
if ( ! function_exists( 'unifiedpsacf_json_load_point' ) ) {
function unifiedpsacf_json_load_point( $path ) {
    $paths[] = plugin_dir_path( __FILE__ ) . '/../acf-json';
    return $paths;
}
}
add_filter( 'acf/settings/load_json', 'unifiedpsacf_json_load_point' );
