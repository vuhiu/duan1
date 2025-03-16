<?php
    function connectDB(){
        $host = DB_HOST;
        $port = DB_PORT;
        $dbName = DB_NAME;

        try {
            $conn = new PDO(
                "mysql:host=$host;port=$port;dbname=$dbName", DB_USERNAME, DB_PASSWORD
            );

            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $conn;
        } catch (\Exception $e){
            echo "Sonething went wrong";
        }
    }
?>