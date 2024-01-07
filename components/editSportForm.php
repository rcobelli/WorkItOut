<?php
/** @var $data array */
?>
<hr/>
<form method="post">
    <h2>Edit Sport</h2>
    <div class="form-group">
        <label for="input1">Name</label>
        <input name="sport_name" type="text" class="form-control" id="input1" placeholder="Rock Climbing" value="<?php echo $data['link_name']; ?>" required>
    </div>
    <input type="hidden" name="submit" value="update">
    <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
<hr/>
