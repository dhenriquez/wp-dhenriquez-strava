<?php

class WPDHS_CMB2{

	private $version;
    public function __construct( $version ){
		$this->version = $version;
        add_action( 'cmb2_admin_init', array( $this, 'fn_settings'));
    }

    public function fn_settings(){
        $wpdhs_cmb_options =  new_cmb2_box(array(
            'id'       => 'wpdhs_cmb2',
			'title'    => 'WP Dhenriquez Strava <small>' . $this->version . '</small>',
			'menu_title' => 'WP Dhenriquez Strava',
			'position' => 1,
            'icon_url' => 'dashicons-store',
            'show_on'  => array(
                'options-page' => 'wpdhs_options'
            )
        ));

		$wpdhs_cmb_options->add_field( array(
			'name'     => 'Strava',
			'type'     => 'title',
			'id'       => 'strava_title_wpdhs'
		));
		$wpdhs_cmb_options->add_field( array(
			'name'     => 'Athlete ID',
			'type'     => 'text',
			'id'       => 'athlete_id_title_wpdhs'
		));
		$wpdhs_cmb_options->add_field( array(
			'name'     => 'Client ID',
			'type'     => 'text',
			'id'       => 'client_id_title_wpdhs'
		));
		$wpdhs_cmb_options->add_field( array(
			'name'     => 'Client Secret',
			'type'     => 'text',
			'id'       => 'client_secret_title_wpdhs'
		));
		$wpdhs_cmb_options->add_field( array(
			'name'     => 'Access Token',
			'type'     => 'text',
			'id'       => 'access_token_title_wpdhs'
		));
		$wpdhs_cmb_options->add_field( array(
			'name'     => 'Refresh Token',
			'type'     => 'text',
			'id'       => 'refresh_token_title_wpdhs'
		));
		
		$wpdhs_cmb_options->add_field( array(
			'name'     => 'Debug',
			'type'     => 'title',
			'id'       => 'debug_title_wpdhs'
		));
		$wpdhs_cmb_options->add_field( array(
			'name'     => 'Save LOG',
			'desc'     => 'Log will be saved with result of executed functions.',
			'id'       => 'debug_text_wpdhs',
			'type'     => 'select',
			'default'  => 0,
			'options'  => array(
				0 => 'No',
				1 => 'Yes'
			)
        ));
    }
    
}

?>