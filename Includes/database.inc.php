<?php
/**
    Created 2019 by E. Steens
    Edited 2020-2025 by E. Steens
**/
namespace Includes;

use PDO;
use PDOException;

abstract class Database {
    private static $result = [];
    private static $numrows = -1;
    private static $currentrow = -1;
    private static $lastinsertedrow;

    private static function dbConnect() {
        $dbhost = "localhost";
        $dbname = "db_pokedex"; // Zorg dat deze klopt met je database
        $dbuser = "root";  // Zorg dat deze klopt met je XAMPP instellingen
        $dbpass = "";   // Laat leeg als je geen wachtwoord hebt ingesteld

        $charset = "utf8mb4";
        $conn = "mysql:host=" . $dbhost . "; dbname=" . $dbname . ";charset=" . $charset;

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            return new PDO($conn, $dbuser, $dbpass, $options);
        } catch (PDOException $e) {
            die("❌ Database fout: " . $e->getMessage());
        }
    }

    public static function getConnection() {
        return self::dbConnect();
    }

    // ✅ SELECT Queries
    public static function getData($sql, $params = []) {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        self::$numrows = $stmt->rowCount();
        self::$result = $stmt->fetchAll();
        self::$currentrow = 0;
        return self::$result;
    }

    // ✅ INSERT / UPDATE / DELETE Queries
    public static function executeQuery($sql, $params = []) {
        try {
            $pdo = self::getConnection();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            die("❌ Database fout: " . $e->getMessage());
        }
    }

    public static function getNumRows() {
        return self::$numrows;
    }

    public static function getLastInsertedRow() {
        return self::$lastinsertedrow;
    }

    public static function jsonParse($value) {
        return is_array($value) ? json_encode($value) : json_decode($value);
    }
}
