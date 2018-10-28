<?php

use WHMCS\Database\Capsule;

add_hook( 'ClientAreaPage', 1, function( array $params ) {
    $locales = $params['locales'];

    $getEnabled = Capsule::table( 'mod_disable_languages' )->first();

    $enabled = json_decode( $getEnabled->enabled );
     
    foreach ( $locales as $key => $locale ) { 
        if ( ! in_array( $locale['language'], $enabled ) ) {
            unset( $locales[$key] ); 
        }
    }
     
    return array( 'locales' => $locales );
});
