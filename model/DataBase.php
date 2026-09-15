<?php namespace Model;

use PDO;
use PDOStatement;
use Dotenv\Dotenv;

class DataBase {
    private $conn;
    private string $host_name;
    private string $db_name;
    private string $username;
    private string $password;
    protected string $table_name;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->host_name = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];

        $this->conn = new PDO("mysql:host={$this->host_name};dbname={$this->db_name}", $this->username, $this->password);
    }

    public function getConnection() {
        return $this->conn;
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    public function create(array $data) : bool 
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function($key) { return ':' . $key; }, array_keys($data)));
        $statement = $this->conn->prepare("INSERT INTO $this->table_name ($columns) VALUES ($values)");
        $this->bindValues($statement, $data);
        
        return $statement->execute();
    }

    public function delete(int $id) : bool 
    {
        $statement = $this->conn->prepare("DELETE FROM $this->table_name WHERE id = :id");
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }

    public function update(int $id, array $data) : bool 
    {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ', ');

        $statement = $this->conn->prepare("UPDATE $this->table_name SET $set WHERE id = :id");
        
        $statement->bindValue(':id', $id);
        $this->bindValues($statement, $data);
        return $statement->execute();
    }

    public function read(array $wanteds, array $conditions = []) : array 
    {
        if (!empty($conditions)) {
            $where = $this->whereConditions($conditions);
        } else {
            $where = '';
        }
        
        $wanted = implode(', ', $wanteds);
        $statement = $this->conn->prepare("SELECT $wanted FROM $this->table_name $where");
        $this->bindValues($statement, $conditions);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    private function bindValues(PDOStatement $statement, array $data) : void 
    {
        foreach ($data as $key => $value) {
            $statement->bindValue(":" . $key, $value);
        }
    }

    private function whereConditions(array $conditions) : string 
    {
        $where = '';
            $where = 'WHERE ';
            foreach ($conditions as $key => $value) {
                $where .= "$key = :$key AND ";
            }
            $where = rtrim($where, ' AND ');
        return $where;
    }
}