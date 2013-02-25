<?php
namespace Pandora;

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
        $request = new Request();
        
        $controller = ucfirst($this->controller)."Controller";
        $model = ucfirst($this->controller)."Facade";
        # this isn't how i want to do it
        $pc = new $controller( $request, new $model() );
        
        $env = $pc->{$this->action}();
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
