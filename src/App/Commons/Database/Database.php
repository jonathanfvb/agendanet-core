<?php

namespace Agendanet\App\Commons\Database;

use PDO;

class Database
{
    protected PDO $pdo;
    
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=db;port=3306;dbname=agendanet_schedule', 'root', 'root');
    }
}
