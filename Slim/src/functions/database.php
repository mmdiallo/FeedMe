<?php
    function createTable($db, $table_number) {
        $result = ''; 
        switch ($table_number) {
            case 0:
                $result = $result . createAccountTypesTable($db);
                break;  
        }
        return $result;
    }

    function createAccountTypesTable($db) {
        $result = '';
        $create_table = 'CREATE TABLE IF NOT EXISTS AccountTypes (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
            type TEXT UNIQUE NOT NULL)';

        if ($db->query($create_table)) {
            $result = $result . 'Table creation sucessful!' . '<br>';
            $create_type_user = 'INSERT OR IGNORE INTO AccountTypes(type) VALUES(\'user\')';
            $create_type_restaurant = 'INSERT OR IGNORE INTO AccountTypes(type) VALUES(\'restaurant\')';
            
            if ($db->query($create_type_user) && $db->query($create_type_restaurant)) {
                $result = $result .'Type creation successful!' . '<br>';
            }
        }

        return $result;
    }
?>