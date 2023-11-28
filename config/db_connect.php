<?php
# This code is only meant to connect to the database for CRUD operations.
# It is good practice to set '$db = null;' to close the connection after CRUD Operation completes.
try {
    # Path to database
    $db_directory = __DIR__ . DIRECTORY_SEPARATOR . 'chipper_db' . DIRECTORY_SEPARATOR . 'chipper_db.accdb';
    # PDO connection using the Microsoft Access Driver.
    $db = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq={$db_directory}");
# Error handling
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>