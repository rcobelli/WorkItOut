<?php


class RecurringTrainingDao extends Dao
{
    function __construct($config) {
        parent::__construct($config, "recurring_trainings", "training_id");
    }

    public function selectForSport($sport_id)
    {
        return $this->query("SELECT * FROM $this->tableName WHERE `training_sport` = ?", $sport_id);
    }

    public function selectForDate($dayOfWeek)
    {
        return $this->query("SELECT `day`, `training_sport`, `title`, `description`, `sport_name` FROM $this->tableName, `sports` WHERE `sport_id` = `training_sport` AND `day` = ?", $dayOfWeek);
    }

    public function insert($object)
    {
        // Loop through days of week
        $days = array('Sun', 'Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat');

        foreach ($days as $day) {
            if (empty($object['title_' . $day])) {
                continue;
            }

            if (!$this->query(
                "REPLACE INTO $this->tableName (`day`, `sport_id`, `title`, `description`) VALUES (?, ?, ?, ?)",
                $day,
                $object['sport_id'],
                $object['title_' . $day],
                $object['description_' . $day]
            )) {
                return false;
            }
        }

        return true;
    }

    public function update($id, $object)
    {
        throw new Exception("Un-supported operation");
    }
}

?>