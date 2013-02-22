<?php
namespace Pandora;

class HTTPException extends \Exception {}
class BadRequestException extends HTTPException {}
class InvalidParameterException extends BadRequestException {}

class HTTP {
    public static function get($param_name, $error_message) {
        $value = self::get_optional($param_name);
	    if( $value === null ) {
	        throw new InvalidParameterException($error_message);
	    }
	    return $value;
    }

    public static function get_optional($param_name, $default = null) {
	    if( !isset( $_GET[$param_name] ) || empty( $_GET[$param_name] ) ) {
		    return $default;
	    }
	    return $_GET[$param_name];
    }

    public static function post($param_name, $error_message) {
        $value = self::post_optional($param_name);
	    if( $value === null ) {
	        throw new InvalidParameterException($error_message);
	    }
	    return $value;
    }

    public static function post_optional($param_name, $default = null) {
	    if( !isset( $_POST[$param_name] ) || empty( $_POST[$param_name] ) ) {
		    return $default;
	    }
	    return $_POST[$param_name];
    }

    public static function checkBasicAuthentication() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="ryangantt.com"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'You must authenticate to add a recipe';
            exit();
        }
    }
}
