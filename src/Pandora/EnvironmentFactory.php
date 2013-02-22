<?php
namespace Pandora;

use Pandora\JSON;

class EnvironmentFactory {
    const ENV_FILE = 'conf/environment.json';
    const ENV_TYPE = 'ENV_TYPE';
    const ENV_PROD = 'PROD';
    const ENV_BETA = 'BETA';
    const PROD_TYPE = 'production';
    
    private static $environment = null;
    
    public static function currentEnvironment() {
        if ( self::$environment === null ) {
            self::$environment = self::createEnvironment();
        }
        return self::$environment;
    }
    
    private static function createEnvironment() {
        $raw_config = JSON::decode_file(self::ENV_FILE, true);
        
        $type = getenv(self::ENV_TYPE);
        switch ( $type ) {
            case self::PROD_TYPE:
                $env_type = self::ENV_PROD;
                break;
            default:
                $env_type = self::ENV_BETA;
        }
        
        return new Environment(self::filterConfig( $env_type, $raw_config ));
    }
    
    /**
     * Reads a config multi-dimensional map and flattens it based
     * on the current environment type
     */
    private static function filterConfig( $env, $config ) {
        $new_config = array();
        foreach ( $config as $key => $value ) {
            if ( is_array( $value ) ) {
                if ( isset( $value[$env] ) ) {
                    $new_config[$key] = $value[$env];
                } else {
                    $new_config[$key] = self::filterConfig( $env, $value );
                }
            } else {
                $new_config[$key] = $value;
            }
        }
        return $new_config;
    }
}