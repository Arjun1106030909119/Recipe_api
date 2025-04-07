<?php

class Database {
    public function getConnection(): PDO {
        return new PDO(
            'pgsql:host=db;port=5432;dbname=recipes_db',
            'recipe_user',
            'recipe_pass',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}

