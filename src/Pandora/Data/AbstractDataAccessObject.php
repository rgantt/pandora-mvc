<?php
namespace Pandora\Data;

use Pandora\Environment\Environment;
use Pandora\Environment\EnvironmentFactory;

use \PDO;

class AbstractDataAccessObject {
    protected $dbh;
    private $env;
    
    public function __construct() {
        $env = $this->getEnvironment();
        $this->dbh = new PDO(
            $env->getPDOData()->getConnectionString(), 
            $env->getPDOData()->getUsername(), 
            $env->getPDOData()->getPassword()
        );
    }
    
    public function setEnvironment( Environment $env ) {
        $this->env = $env;
    }
    
    public function getEnvironment() {
        if( $this->env == null ) {
            $this->env = EnvironmentFactory::currentEnvironment();
        }
        return $this->env;
    }
    
    public function getDbh() {
        return $this->dbh;
    }
    
    public function setDbh( PDO $dbh ) {
        $this->dbh = $dbh;
    }
}
