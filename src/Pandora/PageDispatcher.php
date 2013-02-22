<?php
namespace Pandora;

use Pandora\Request;
use Pandora\PageDispatcher;
use Pandora\HTTP;

// load controllers on demand
spl_autoload_register( function ($class) {
    echo sprintf("Trying to autoload %s (controllers)<br/>", $class);
    $class = strtolower($class);
    if( strstr($class, 'controller') !== false ) {
        $class = str_replace('controller', '', $class);
        $filename = "controllers/{$class}.php";
        if( file_exists( $filename ) ) {
            require_once $filename;
        } else {
            throw new \Exception("Could not load {$class} controller!");
        }
    }
});

spl_autoload_register( function ($class) {
    echo sprintf("Trying to autoload %s (models)<br/>", $class);
    $class = strtolower($class);
    $class = str_replace('facade', '', $class);
    $filename = "models/{$class}.php";
    if( file_exists( $filename ) ) {
        require_once $filename;
    }
});

class PageDispatcher {
    private $controller;
    private $action;

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
        
        return $pc->{$this->action}();
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
    
    public static function dispatch( $controller, $action ) {
        $page = new PageDispatcher( $controller, $action );

        ob_start();        
        HTTP::checkBasicAuthentication();
        $env = $page->render( $controller, $action );
        require_once $page->get_view();
        
        return ob_get_flush();
    }
}
