<?php
/**
 * Plugin Name: WP Dhenriquez Strava
 * Description: Plugin to get profile stats from strava
 * Plugin URI: https://github.com/dhenriquez/wp-dhenriquez-strava
 * Author: Daniel Henriquez Sandoval
 * Author URI: https://dhenriquez.cl
 * Version: 0.0.1
 */

if ( !defined( 'ABSPATH' )) { die; }
define('WPDHS_PATH', plugin_dir_path(__FILE__));
define('WPDHS_URL', plugin_dir_url(__FILE__));

require_once ABSPATH . 'wp-admin/includes/plugin.php';
require_once WPDHS_PATH . '/libs/tgm-plugin-activation/class-tgm-plugin-activation.php';
require_once WPDHS_PATH . '/class/class-wpdhs-plugins-requeridos.php';
require_once WPDHS_PATH . '/class/class-wpdhs-cmb2.php';

class WP_Dhenriquez_Strava {

    public function __construct() {
        $plugin = get_plugin_data( __FILE__ );
        if (is_plugin_active('cmb2/init.php')) {
            new WPDHS_CMB2($plugin['Version']);
            add_shortcode('strava-stats', array($this,'fn_strava_stats'),10, 1);
        } else {
            new WPDHS_Plugins_Requeridos();
        }        
    }
    
    public function fn_strava_stats( $atts ){
        extract( shortcode_atts( array(
            'recent' => 'ride',
            'value' => 'distance'
        ), $atts) );
        $data = $this->getDataStats();
        if ($recent == 'ride') {
            return $data['recent_ride_totals'][$value];
        }
        if ($recent == 'run') {
            return $data['recent_run_totals'][$value];
        }
        if ($recent == 'swim') {
            return $data['recent_swim_totals'][$value];
        }
    }

    private function getDataStats() {
        $athlete_id = cmb2_get_option( 'wpdhs_options', 'athlete_id_title_wpdhs', false);
        $client_id = cmb2_get_option( 'wpdhs_options', 'client_id_title_wpdhs', false);
        $client_secret = cmb2_get_option( 'wpdhs_options', 'client_secret_title_wpdhs', false);
        $access_token = cmb2_get_option( 'wpdhs_options', 'access_token_title_wpdhs', false);
        $refresh_token = cmb2_get_option( 'wpdhs_options', 'refresh_token_title_wpdhs', false);
        $url = 'https://www.strava.com/api/v3/athletes/' . $athlete_id . '/stats';
        $authorization = 'Authorization: Bearer ' . $access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);

        $options = array('http' => array(
            'method'  => 'GET',
            'header' => 'Content-Type: application/json Authorization: Bearer '.$access_token
        ));
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        return json_decode($response);
    }
    private function wpdhs_save_log( $message ) {
        $plugin = get_plugin_data( __FILE__ );
        $debug = cmb2_get_option( 'wpdhs_options', 'debug_text_wpdhs', false);
        if ($debug) {
            if(is_array($message)) { 
                $message = json_encode($message); 
            } 
            $file = fopen( wpdhs_PATH . "/wpdhs.log","a"); 
            fwrite($file, "\n[" . current_time('Y-m-d h:i:s') . "] [PV: " . $plugin['Version'] . "] " . $message); 
            fclose($file);
        }
    }
}
new WP_Dhenriquez_Strava();
?>