<?php

abstract class Dao extends Helper
{
    public $tableName;
    public $primaryKey;

    public function __construct($config, $tableName, $primaryKey)
    {
        parent::__construct($config);
        $this->tableName = $tableName;
        $this->primaryKey = $primaryKey;
    }

    public function selectAll()
    {
        return $this->query("SELECT * FROM $this->tableName");
    }

    public function select($id)
    {
        return $this->query("SELECT * FROM $this->tableName WHERE $this->primaryKey = ? LIMIT 1", $id);
    }

    public function delete($id)
    {
        return $this->query("DELETE FROM $this->tableName WHERE $this->primaryKey = ?", $id);
    }

    abstract public function insert($object);
    abstract public function update($id, $object);
}

