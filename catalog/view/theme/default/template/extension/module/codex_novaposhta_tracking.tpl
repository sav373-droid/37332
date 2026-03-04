<div class="panel panel-default">
  <div class="panel-heading"><strong><?php echo $heading_title; ?></strong></div>
  <div class="panel-body">
    <p><?php echo $text_description; ?></p>
    <form method="post">
      <div class="form-group">
        <label for="input-ttn"><?php echo $entry_ttn; ?></label>
        <input type="text" id="input-ttn" name="ttn" value="<?php echo $ttn; ?>" class="form-control" />
      </div>
      <div class="form-group">
        <label for="input-phone"><?php echo $entry_phone; ?></label>
        <input type="text" id="input-phone" name="phone" value="<?php echo $phone; ?>" class="form-control" />
      </div>
      <button type="submit" class="btn btn-primary"><?php echo $button_track; ?></button>
    </form>

    <?php if ($error_warning) { ?>
      <div class="alert alert-danger" style="margin-top: 15px;"><?php echo $error_warning; ?></div>
    <?php } ?>

    <?php if (!empty($tracking)) { ?>
      <table class="table table-bordered" style="margin-top: 15px;">
        <tr><td><?php echo $text_result_ttn; ?></td><td><?php echo $tracking['ttn']; ?></td></tr>
        <tr><td><?php echo $text_result_status; ?></td><td><?php echo $tracking['status']; ?></td></tr>
        <tr><td><?php echo $text_result_sender_city; ?></td><td><?php echo $tracking['city_sender']; ?></td></tr>
        <tr><td><?php echo $text_result_recipient_city; ?></td><td><?php echo $tracking['city_recipient']; ?></td></tr>
        <tr><td><?php echo $text_result_updated_at; ?></td><td><?php echo $tracking['updated_at']; ?></td></tr>
      </table>
    <?php } ?>
  </div>
</div>
