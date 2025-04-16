<?php
class BaseModel
{
    protected $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    protected function getAll($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function getOne($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function update($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    protected function insert($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $this->conn->lastInsertId();
    }

    protected function delete($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }
}
