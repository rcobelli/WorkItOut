<?php

class RaceDao extends Dao
{
    function __construct($config) {
        parent::__construct($config, "races", "race_id");
    }

    public function select($id)
    {
        return $this->query("SELECT `race_id`, `race_name`, `race_date`, `sport_id`, `sport_name` FROM $this->tableName, `sports` WHERE `race_sport` = `sport_id` AND $this->primaryKey = ? LIMIT 1", $id);
    }

    public function selectAll()
    {
        return $this->query("SELECT `race_id`, `race_name`, `race_date`, `sport_id`, `sport_name` FROM $this->tableName, `sports` WHERE `race_sport` = `sport_id`");
    }

    public function insert($object)
    {
        return $this->query(
            "INSERT INTO $this->tableName (`race_name`, `race_date`, `race_sport`) VALUES (?, ?, ?)",
            $object['race_name'],
            date('Y-m-d', strtotime($object['race_date'])),
            $object['race_sport']
        );
    }

    public function update($id, $object)
    {
        if ($object['start_date'] == "") {
            $object['start_date'] = null;
        } else {
            $object['start_date'] = date('Y-m-d', strtotime($object['start_date']));
        }
        
        return $this->query(
            "UPDATE $this->tableName SET `race_name` = ?, `race_date` = ?, `race_sport` = ? WHERE $this->primaryKey = ?",
            $object['race_name'],
            date('Y-m-d', strtotime($object['race_date'])),
            $object['race_sport'],
            $id
        );
    }
}

?>