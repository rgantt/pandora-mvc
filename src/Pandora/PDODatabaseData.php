<?php
namespace Pandora;

class PDODatabaseData {
    private $hostname;
    private $driver;
    private $username;
    private $password;

    public function __construct( $hostname, $driver, $database, $username, $password ) {
        $this->hostname = $hostname;
        $this->driver = $driver;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function getUsername() {
        return $this->username;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getDatabase() {
        return $this->database;
    }
    
    public function getHostname() {
        return $this->hostname;
    }
    
    public function getDriver() {
        return $this->driver;
    }
    
    public function getConnectionString() {
        return sprintf('%s:host=%s;dbname=%s', $this->getDriver(), $this->getHostname(), $this->getDatabase());
    }
}
