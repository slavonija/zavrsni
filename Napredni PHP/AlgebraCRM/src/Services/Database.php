<?php
 
namespace App\Services;
 
use PDO;
use PDOException;
 
class Database
{
    private static ?Database $instance = null;
    private PDO $conn;
    private string $table;
    private string $columns = "*";
    private array $where = [];
 
    private function __construct() {
        $this->connect();
    }
 
    private function __clone() {}
 
    private function connect() {
        $dsn = DB_DRIVER.":host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
 
        try{
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Zapiši iznimku u log datoteku
            throw $e;
        }
    }
 
    private function reset(): void {
        $this->columns = "*";
        $this->where = [];
    }
 
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
 
    public function getConnection(): PDO {
        return $this->conn;
    }
 
    public function table(string $table): Database {
        $this->table = $table;
        return $this;
    }
 
    public function select(string|array $columns): Database {
        $this->columns = is_array($columns) ? implode(", ", $columns) : $columns;
        return $this;
    }
 
    public function where($column, $operator, $value = null): Database {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = "=";
        }
        $this->where[] = [$column, $operator, $value];
        return $this;
    }
 
    public function get() {
        $sql = "SELECT $this->columns FROM $this->table";
 
        if (!empty($this->where)) {
            $whereParts = [];
            foreach ($this->where as $condition) {
                $whereParts[] = $condition[0] . " " . $condition[1] . " ?";
            }
 
            $sql .= " WHERE " . implode(" AND ", $whereParts);
        }
 
        $stmt = $this->conn->prepare($sql);
 
        $params = array_map(function($condition){
            return $condition[2];
        }, $this->where);
 
        $stmt->execute($params);
 
        $this->reset();
 
        return $stmt->fetchAll();
    }
 
    public function find($id, $column = "id"): ?array {
        return $this->where($column, $id)->get()[0] ?? null;
    }
 
    public function first(): ?array {
        return $this->get()[0] ?? null;
    }
 
    public function insert(array $data): bool|int 
    {
        $this->columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $this->table ($this->columns) VALUES ($placeholders)";
 
        $stmt = $this->conn->prepare($sql);
        $this->reset();
 
        if ($stmt->execute(array_values($data))) {
            return $this->conn->lastInsertId();
        }
 
        return false;
    }
}