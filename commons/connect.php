<?php

    function connectDB(){
        $host = DB_HOST;
        $port = DB_PORT;
        $dbName = DB_NAME;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;

        try {
            $conn = new PDO(
                "mysql:host=$host;port=$port;dbname=$dbName;charset=utf8", $username, $password
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $conn;
        } catch (\Exception $e){
            echo "Kết nối thất bại: " . $e->getMessage();
            return null;
        }
    }
?>