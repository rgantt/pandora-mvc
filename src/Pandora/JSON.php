<?php
namespace Pandora;

class JSON {
    public static function decode_file( $filename, $assoc = false ) {
	    if ( !file_exists( $filename ) ) {
		    throw new Exception("Could not find {$filename}");
	    }
	    $json_blob = file_get_contents($filename);
	    return self::decode( $json_blob, $assoc );
    }
    
    public static function decode( $json_blob, $assoc = false ) {
	    $map = json_decode($json_blob, $assoc);
	    if ( ( $json_error = json_last_error() ) != null ) {
		    throw new Exception(sprintf("Could not decode JSON: %s", self::get_error($json_error)));
	    }
	    return $map;
    }

    public static function encode_file( $filename, array $contents, $error_message = null ) {
	    if ( !file_exists( $filename ) ) {
		    throw new Exception("Could not find {$filename}");
	    }
	    $raw_json = self::encode($contents);
	    $tmp = file_put_contents($filename, $raw_json);
	    if ( $tmp === false ) {
		    throw new Exception($error_message);
	    }
    }
    
    public static function encode( array $contents ) {
        $raw_json = json_encode($contents);
	    if ( ( $json_error = json_last_error() ) != null ) {
		    throw new Exception(sprintf("Could not encode JSON: %s", self::get_error($json_error)));
	    }
	    return $raw_json;
    }

    protected static function get_error( $error_code ) {
        switch ($error_code) {
            case JSON_ERROR_NONE:
                return 'No errors';
                break;
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                return 'Unknown error';
                break;
        }
    }
}
