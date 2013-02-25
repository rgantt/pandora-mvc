<?php
namespace Pandora\Framework;

use Pandora\Data\HTTP;

class Request {
    public function get($name, $error_msg) {
        return HTTP::get($name, $error_msg);
    }
    
    public function get_optional($name, $default) {
        return HTTP::get_optional($name, $default);
    }
    
    public function post($name, $error_msg) {
        return HTTP::post($name, $error_msg);
    }
    
    public function post_optional($name, $default) {
        return HTTP::post_optional($name, $default);
    }
}