<?php
/** @var $data array */
/** @var $sportDao SportDao */
?>
<hr/>
<form method="post">
    <h2 class="mt-4">New Event</h2>
    <div class="form-group">
        <label for="input1">Name</label>
        <input name="race_name" type="text" class="form-control" id="input1" placeholder="Ironman Hawaii" required>
    </div>
    <div class="form-group">
        <label for="input2">Date</label>
        <input name="race_date" type="date" class="form-control" id="input2" placeholder="2024-12-31" required>
    </div>
    <div class="form-group">
        <label for="input3">Sport</label>
        <select class="form-control" name="race_sport" id="input3">
            <option disabled selected>Select Sport...</option>
            <?php
            $sport = $sportDao->selectAll();
            foreach ($sport as $s) {
                echo "<option value='" . $s['sport_id'] . "'>" . $s['sport_name'] . "</option>";
            }
            ?>
        </select>
    </div>
    <input type="hidden" name="submit" value="create">
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
