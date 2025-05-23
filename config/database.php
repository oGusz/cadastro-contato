<?php
/* conexão database */
class Database {
    private static $host = "localhost";
    private static $dbname = "dbcontacts";
    private static $username = "root";
    private static $password = "";
    public static function conectar() {
        try {
            return new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$username, self::$password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }
}
?>
