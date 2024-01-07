<?php
/** @var $data array */
/** @var $sportDao SportDao */
?>
<hr/>
<form method="post">
    <h2>Edit Training Schedule for <?php echo $data['sport_name'] ?></h2>
    <?php

    $days = array('Sun', 'Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat');


    foreach ($days as $d) {
        $index = array_search($d, array_column($existingTraining, 'day'));

        if ($index === false) {
            $index = -1;
        }

        ?>
        <div class="form-group">
            <label for="input<?php echo $d ?>"><?php echo $d ?></label>
            <input name="title_<?php echo $d ?>" type="text" class="form-control" id="input<?php echo $d ?>" placeholder="Leg Day" value="<?php echo $existingTraining[$index]['title']; ?>">
        </div>
        <div class="form-group">
            <textarea name="description_<?php echo $d ?>" class="form-control" id="input<?php echo $d ?>"><?php echo $existingTraining[$index]['description']; ?></textarea>
        </div>
        <hr/>
        <?php
    }

    ?>
    <input type="hidden" name="submit" value="training">
    <input type="hidden" name="training_sport" value="<?php echo $_REQUEST['id']; ?>">
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
<hr/>
