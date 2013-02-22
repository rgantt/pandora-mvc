<?php
namespace Pandora;

use Pandora\PDODatabaseData;

class Environment {
    protected $dbdata;
    
    public function __construct( $config ) {
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
}
