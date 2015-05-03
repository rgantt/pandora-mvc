<?php
namespace Pandora\Framework;

use \Exception;

class PageDispatcher implements Renderable {
    private $controller;
    private $action;

    public static function registerLoader( callable $loader ) {
        spl_autoload_register( $loader );
    }

    public function __construct( $controller, $action ) {
        $this->controller = $controller;
        $this->action = $action;
    }

    public function render() {
        $request = new HTTPRequest();

        $controller = ucfirst($this->controller)."Controller";
        $model = ucfirst($this->controller)."Facade";
        # this isn't how i want to do it
        $pc = new $controller( $request, new $model() );

        // This will be exposed to views as "$env"
        $env = array();

        // Allow the before methods to return env vars
        $before = $pc->before();
        if (is_array($before)) {
            $env = $env + $before;
        }

        // Allow the controller methods to append env
        $view = $pc->{$this->action}();
        if (is_array($view)) {
            $env = $env + $view;
        }

        // Allow the after methods to append end
        $after = $pc->after();
        if (is_array($after)) {
            $env = $env + $after;
        }

        return require_once $this->get_view();
    }

    public function get_view() {
        $content_type = isset( $_SERVER['HTTP_ACCEPT'] ) ? $_SERVER['HTTP_ACCEPT'] : null;
        $response_type = null;
        $accept_types = explode(';', $content_type);
        $accept_types = explode(',', $accept_types[0]);

        // default response type
        $response_type = 'html';
        foreach( $accept_types as $type ) {
            if( $type == 'application/json' ) {
                $response_type = 'json';
                break;
            }
        }

        return "views/{$this->controller}/{$this->action}.{$response_type}.php";
    }
}
