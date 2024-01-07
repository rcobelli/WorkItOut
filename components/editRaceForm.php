<?php
/** @var $data array */
/** @var $sportDao SportDao */
?>
<hr/>
<form method="post">
    <h2>Edit Event</h2>
    <div class="form-group">
        <label for="input1">Name</label>
        <input name="race_name" type="text" class="form-control" id="input1" placeholder="Ironman Hawaii" value="<?php echo $data['race_name']; ?>" required>
    </div>
    <div class="form-group">
        <label for="input2">Date</label>
        <input name="race_date" type="date" class="form-control" id="input2" placeholder="2024-12-31" value="<?php echo $data['race_date']; ?>" required>
    </div>
    <div class="form-group">
        <label for="input3">Sport</label>
        <select class="form-control" name="race_sport" id="input3">
            <option disabled selected>Select Sport...</option>
            <?php
            $sport = $sportDao->selectAll();
            foreach ($sport as $s) {
                echo "<option value='" . $s['sport_id'] . "'";
                if ($s['sport_id'] == $data['race_sport']) {
                    echo "selected";
                }
                echo ">" . $s['sport_name'] . "</option>";
            }
            ?>
        </select>
    </div>
    <input type="hidden" name="submit" value="update">
    <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
<hr/>
