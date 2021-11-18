<?php

namespace App\lib;

use Exception;

class DataBase
{
    private string $host = HOST;
    private string $user = USER_DB;
    private string $password = PASSWORD_DB;
    private string $dbName = DB_NAME;
    private string $query;
    private string $table;
    private \mysqli $connection;

    public function __construct()
    {
        $this->connectionOpen();
    }

    private function connectionOpen():void
    {
        $this->connection = new \mysqli($this->host, $this->user, $this->password, $this->dbName);

        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    /**
     * @param array $data ['field' => 'value']
     * @return bool
     * @throws Exception
     */
    public function insert(array $data)
    {
        $this->query = "INSERT INTO {$this->table}";
        $fields = implode(', ', array_keys($data));
        $values = implode(', ', $data);
        $this->query .= " ({$fields}) VALUES ({$values})";

        if ($this->connection->query($this->query) === true) {
            return $this->connection->insert_id;
        }
        return false;
    }

    /**
     * @param string $fields
     * @param string|null $where
     * @param string|null $order_by
     * @return array
     */
    public function select(string $fields = '*', string $where = null, string $order_by = null): array
    {
        $this->query = "SELECT {$fields} FROM {$this->table}";
        $this->query .= $where ? " WHERE {$where} AND deleted_at IS NULL" : ' WHERE deleted_at IS NULL';
        $this->query .= $order_by ? " ORDER_BY {$order_by} " : '';
        $result = $this->connection->query($this->query);
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;

    }

    /**
     * @param array $data
     * @param string $where
     * @return bool
     */
    public function update(array $data, string $where): bool
    {
        $this->query = "UPDATE {$this->table} SET";
        foreach ($data as $field => $value) {
            $this->query .= " {$field} = {$value}";
        }
        $this->query .= " WHERE {$where}";
        return $this->connection->query($this->query);
    }

    /**
     * @param string $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    public function connectionClose():void
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    public function __destruct()
    {
        $this->connectionClose();
    }
}