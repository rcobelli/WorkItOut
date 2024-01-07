<?php

class SportDao extends Dao
{
    function __construct($config) {
        parent::__construct($config, "sports", "sport_id");
    }

    public function insert($object)
    {
        return $this->query(
            "INSERT INTO $this->tableName (`sport_name`) VALUES (?)",
            $object['sport_name']
        );
    }

    public function update($id, $object)
    {   
        return $this->query(
            "UPDATE $this->tableName SET `sport_name` = ?, WHERE $this->primaryKey = ?",
            $object['sport_name'],
            $id
        );
    }
}

?>