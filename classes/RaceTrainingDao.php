<?php


class RaceTrainingDao extends Dao
{
    function __construct($config) {
        parent::__construct($config, "race_trainings", "training_id");
    }

    public function selectForRace($race_id)
    {
        return $this->query("SELECT * FROM $this->tableName WHERE `race_id` = ?", $race_id);
    }

    public function selectForDate($date)
    {
        return $this->query("SELECT `training_id`, `date`, $this->tableName.`race_id`, `title`, `description`, `race_sport`, `sport_name` FROM $this->tableName, `races`, `sports` WHERE `race_sport` = `sport_id` AND `races`.`race_id` = $this->tableName.`race_id` AND `date` = ?", $date);
    }

    public function insert($object)
    {
        if (!$this->deleteForRace($object['race_id'])) {
            return false;
        }

        $index = 0;

        while (!empty($object['title_' . $index])) {
            if (!$this->query(
                "INSERT INTO $this->tableName (`date`, `race_id`, `title`, `description`) VALUES (?, ?, ?, ?)",
                date('Y-m-d', strtotime($object['date_' . $index])),
                $object['race_id'],
                $object['title_' . $index],
                $object['description_' . $index]
            )) {
                return false;
            }

            $index++;
        }

        return true;
    }


    public function deleteForRace($race_id)
    {
        return $this->query("DELETE FROM $this->tableName WHERE `race_id` = ?", $race_id);
    }

    public function update($id, $object)
    {
        throw new Exception("Un-supported operation");
    }
}

?>