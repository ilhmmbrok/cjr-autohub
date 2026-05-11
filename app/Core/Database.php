<?php


namespace App\Core;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    private static $db_host = "localhost";
    private static $db_name = "autohub";
    private static $db_user = "root";
    private static $db_pass = "";
    private static $db_charset = "utf8mb4";
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection === null) {
            try {
                $dsn = "mysql:host=" . self::$db_host . ";dbname=" . self::$db_name . ";charset=" . self::$db_charset;

                self::$connection = new PDO(
                    $dsn,
                    self::$db_user,
                    self::$db_pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch (PDOException $e) {
                error_log('Database connection failed: ' . $e->getMessage());
                http_response_code(500);
                die(View::render('error.500'));
            }
        }

        return self::$connection;
    }

    public static function query(string $sql, array $params = []): PDOStatement
    {
        try {
            $stmt = self::connect()->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log('Query failed: ' . $e->getMessage());
            http_response_code(500);
            die("Query failed.");
        }
    }

    public static function fetch(string $sql, array $params = []): array|false
    {
        return self::query($sql, $params)->fetch();
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll();
    }

    public static function execute(string $sql, array $params = []): int
    {
        return self::query($sql, $params)->rowCount();
    }

    public static function lastInsertId(): string
    {
        return self::connect()->lastInsertId();
    }
}
