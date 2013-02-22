<?php
namespace Pandora;

use Pandora\PageDispatcher;
use Pandora\HTTP;

class FrontController {
    public static function render( $default_page, $default_action ) {
        PageDispatcher::dispatch(
            HTTP::get_optional('page', $default_page),
            HTTP::get_optional('action', $default_action)
        );
    }
}