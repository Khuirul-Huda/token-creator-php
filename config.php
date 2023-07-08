<?php

class Config {
    public $adminPassword;
    public $tokenPrefix;
    public $defaultExpirationDay;
    public $sessionAuthValue;
    
    
    function __construct(){
        $this->adminPassword = "huda2023";
        $this->defaultExpirationDay = 7;
        $this->sessionAuthValue = "mocci";
        $this->tokenPrefix = "UNFOLLTHEM-";
    }

}

