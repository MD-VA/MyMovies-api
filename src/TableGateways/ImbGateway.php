<?php
namespace src\TableGateways;

class ImbGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    
}