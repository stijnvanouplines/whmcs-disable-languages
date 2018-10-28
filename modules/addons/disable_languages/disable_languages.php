<?php

if ( ! defined( 'WHMCS' ) ) {
    die( 'This file cannot be accessed directly' );
}

use WHMCS\Database\Capsule;
use WHMCS\Module\Addon\DisableLanguages\Admin\AdminDispatcher;

/**
 * Define addon module configuration parameters.
 *
 * @return array
 */
function disable_languages_config()
{
    return array(
        'name'          => 'Disable Languages',
        'description'   => 'With this module you can easily disable languages from the WHMCS client area.',
        'author'        => 'Solitweb',
        'language'      => 'english',
        'version'       => '1.0',
        'fields'        => []
    );
}

/**
 * Activate.
 *
 * @return array Optional success/failure message
 */
function disable_languages_activate()
{
	$LANG = $vars['_lang'];

	try {
		if ( ! Capsule::schema()->hasTable( 'mod_disable_languages' ) ) {
			Capsule::schema()->create( 'mod_disable_languages', function ( $table ) {
				$table->increments( 'id' );
				$table->json( 'enabled' )->nullable();
            });
            
            Capsule::table( 'mod_disable_languages' )->insert([
                'enabled' => json_encode( array() ),
            ]);
		}
	} catch ( Exception $e ) {
		return [
			'status'        => 'error',
			'description'   => 'Cannot create table! (' . $e->getMessage() , ')'
		];
    }

	return [
		'status'        => 'success',
		'description'   => 'The module is activated successfully.'
	];
}

/**
 * Deactivate.
 *
 * @return array Optional success/failure message
 */
function disable_languages_deactivate()
{
	try {
        Capsule::schema()->dropIfExists( 'mod_disable_languages' );

		return [
			'status'        => 'success',
			'description'   => 'Module deactivated successfully!'
		];
	}
	catch ( Exception $e ) {
		return [
			'status'        => 'error',
			'description'   => 'Unable to drop table! (' . $e->getMessage() .')'
		];
	}
}

/**
 * Admin Area Output.
 *
 * @return string
 */
function disable_languages_output( $vars )
{
    $action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';

    $dispatcher = new AdminDispatcher();

    $response = $dispatcher->dispatch( $action, $vars );

    echo $response;
}
