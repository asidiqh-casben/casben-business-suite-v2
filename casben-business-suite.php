<?php
/**
 * Plugin Name: CASBEN Business Suite
 * Plugin URI: 
 * Description: Complete business management system for CASBEN.
 * Version: 1.0.0
 * Author: CASBEN
 * License: GPL2
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Plugin Constants
 */

define(
    'CASBEN_VERSION',
    '1.0.0'
);


define(
    'CASBEN_PLUGIN_DIR',
    plugin_dir_path( __FILE__ )
);


define(
    'CASBEN_PLUGIN_URL',
    plugin_dir_url( __FILE__ )
);


/**
 * Load Core Loader
 */

require_once CASBEN_PLUGIN_DIR . 'includes/class-loader.php';


/**
 * Initialize CASBEN
 */

CASBEN_Loader::load();



/**
 * Activation Hook
 */

register_activation_hook(
    __FILE__,
    array(
        'CASBEN_Activator',
        'activate'
    )
);



/**
 * Deactivation Hook
 */

register_deactivation_hook(
    __FILE__,
    array(
        'CASBEN_Deactivator',
        'deactivate'
    )
);