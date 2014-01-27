<?php
namespace Pandora\Framework;

use Pandora\Framework\PageDispatcher;
use Pandora\Data\HTTP;

class FrontController {
    public static function render( $default_page, $default_action ) {
        $dispatcher = new PageDispatcher(
            HTTP::get_optional('page', $default_page),
            HTTP::get_optional('action', $default_action)
        );
        $dispatcher->render();
    }

    public static function redirect( $page, $action ) {
        header("location: index.php?page=$page&action=$action");
    }
}