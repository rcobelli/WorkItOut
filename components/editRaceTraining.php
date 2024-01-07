<?php
/** @var $data array */
/** @var $sportDao SportDao */
?>
<hr/>
<form method="post">
    <h2>Edit Training Schedule for <?php echo $data['race_name'] ?></h2>
    <?php
    for ($index=0; $index <= count($existingTraining); $index++) {
        ?>
        <div class="form-group">
            <input name="title_<?php echo $index ?>" type="text" class="form-control" id="input<?php echo $index ?>" placeholder="Leg Day" value="<?php echo $existingTraining[$index]['title']; ?>">
        </div>
        <div class="form-group">
            <input name="date_<?php echo $index ?>" type="date" class="form-control" id="input<?php echo $index ?>" placeholder="2024-12-31" value="<?php echo $existingTraining[$index]['date']; ?>">
        </div>
        <div class="form-group">
            <textarea name="description_<?php echo $index ?>" class="form-control" id="input<?php echo $index ?>"><?php echo $existingTraining[$index]['description']; ?></textarea>
        </div>
        <hr/>
        <?php
    }
    ?>
    <input type="hidden" name="submit" value="training">
    <input type="hidden" name="race_id" value="<?php echo $_REQUEST['id']; ?>">
    <button type="submit" class="btn btn-primary mt-3">Save</button>
    <button type="button" class="btn btn-secondary mt-3 float-right" onclick="window.location = '?'">Done</button>
</form>
<hr/>
