<?php
    require 'database_config.php';

    //if (empty($_SERVER['HTTPS'])) {
        //exit;
    //} else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conn = new SQLite3($db_filename);

            $enable_foreign_keys = 'PRAGMA foreign_keys = ON';

            if ($conn->query($enable_foreign_keys)) {
                echo 'Foreign keys enabled.' . '<br>';
            }

            $create_table = 'CREATE TABLE IF NOT EXISTS Accounts (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
                username TEXT UNIQUE NOT NULL,
                password_hash TEXT NOT NULL,
                password_salt TEXT NOT NULL,
                account_type_id INTEGER NOT NULL,
                FOREIGN KEY(account_type_id) REFERENCES AccountTypes(id))';

            if ($conn->query($create_table)) {
                echo 'Table creation sucessful!' . '<br>';
            }

            $conn->close();
        }
        
    //}
?>