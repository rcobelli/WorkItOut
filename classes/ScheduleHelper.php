<?php

enum WorkoutType {
    case Recurring;
    case Race;
}

class ScheduleHelper {
    private $recurringDao;
    private $raceDao;

    function __construct($config) {
        $this->recurringDao = new RecurringTrainingDao($config);
        $this->raceDao = new RaceTrainingDao($config);
    }

    public function fetchSchedule($date) {
        $overrides = $this->raceDao->selectForDate($date);
        $normal = $this->recurringDao->selectForDate(date('D', strtotime($date)));

        // Remove any conflicts between normal & overrides
        for ($i=0; $i < count($normal) && $overrides !== false; $i++) { 
            $matching_index = array_search($normal[$i]['training_sport'], array_column($overrides, 'race_sport'));
            if ($matching_index !== false) {
                unset($normal[$i]);
            }
        }

        // Add all the overrides
        for ($i=0; $i < count($overrides); $i++) {
            array_push($normal, $overrides[$i]);
        }

        return $normal;
    }
}

?>