<?php

namespace WHMCS\Module\Addon\DisableLanguages\Admin;

class AdminDispatcher {

    /**
     * Dispatch request.
     *
     * @param string $action
     * @param array $parameters
     *
     * @return string
     */
    public function dispatch( $action, $parameters )
    {
        if ( ! $action ) {
            $action = 'index';
        }

        $controller = new Controller();

        if ( is_callable( array( $controller, $action ) ) ) {
            return $controller->$action( $parameters );
        }

        return '<p>Invalid action requested. Please go back and try again.</p>';
    }
}
