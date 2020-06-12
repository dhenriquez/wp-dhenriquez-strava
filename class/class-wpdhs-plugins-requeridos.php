<?php

class WPDHS_Plugins_Requeridos{

    public function __construct(){
        add_action( 'tgmpa_register', array( $this, 'fn_required_plugin') );
    }

    public function fn_required_plugin(){
        $plugins = array(
            array(
                'name' => 'CMB2',
                'slug' => 'cmb2',
                'required' => true,
            )
        );
        $config = array(
            'id' => 'wccps-tgmpa',
            'has_notices' => true,
            'dismissable' => false,
            'is_automatic' => true,
        );
        tgmpa( $plugins, $config);
    }
    
}

?>