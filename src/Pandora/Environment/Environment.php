<?php
namespace Pandora\Environment;

use Pandora\Data\PDODatabaseData;

class Environment {
    protected $dbdata;
    protected $config;

    public function __construct( $config ) {
        $this->config = $config;
        $db = $config['database'];
        $this->dbdata = new PDODatabaseData(
            $db['hostname'],
            $db['driver'],
            $db['database'],
            $db['username'],
            $db['password']
        );
    }

    public function getPDOData() {
        return $this->dbdata;
    }

    public function get($name) {
        return $this->config[$name];
    }
}
