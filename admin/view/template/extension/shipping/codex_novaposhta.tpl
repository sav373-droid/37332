<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-codex-novaposhta" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3></div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-codex-novaposhta" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-api-url"><?php echo $entry_api_url; ?></label>
            <div class="col-sm-10">
              <input type="text" name="codex_novaposhta_api_url" value="<?php echo $codex_novaposhta_api_url; ?>" id="input-api-url" class="form-control" />
              <p class="help-block"><?php echo $help_api_url; ?></p>
              <?php if ($error_api_url) { ?><div class="text-danger"><?php echo $error_api_url; ?></div><?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-api-key"><?php echo $entry_api_key; ?></label>
            <div class="col-sm-10">
              <input type="text" name="codex_novaposhta_api_key" value="<?php echo $codex_novaposhta_api_key; ?>" id="input-api-key" class="form-control" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-default-cost"><?php echo $entry_default_cost; ?></label>
            <div class="col-sm-10">
              <input type="text" name="codex_novaposhta_default_cost" value="<?php echo $codex_novaposhta_default_cost; ?>" id="input-default-cost" class="form-control" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="codex_novaposhta_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" <?php echo ($geo_zone['geo_zone_id'] == $codex_novaposhta_geo_zone_id) ? 'selected="selected"' : ''; ?>><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-tracking-status"><?php echo $entry_tracking_order_status; ?></label>
            <div class="col-sm-10">
              <select name="codex_novaposhta_tracking_order_status_id" id="input-tracking-status" class="form-control">
                <option value="0">---</option>
                <?php foreach ($order_statuses as $order_status) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" <?php echo ($order_status['order_status_id'] == $codex_novaposhta_tracking_order_status_id) ? 'selected="selected"' : ''; ?>><?php echo $order_status['name']; ?></option>
                <?php } ?>
              </select>
              <p class="help-block"><?php echo $help_tracking_order_status; ?></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="codex_novaposhta_status" id="input-status" class="form-control">
                <option value="1" <?php echo $codex_novaposhta_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php echo !$codex_novaposhta_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="codex_novaposhta_sort_order" value="<?php echo $codex_novaposhta_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
