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
      <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-truck"></i> <?php echo $text_edit; ?></h3></div>
      <div class="panel-body">

        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-settings" data-toggle="tab"><?php echo $text_settings; ?></a></li>
          <li><a href="#tab-api" data-toggle="tab"><?php echo $text_api_console; ?></a></li>
          <li><a href="#tab-log" data-toggle="tab"><?php echo $text_action_log; ?></a></li>
        </ul>

        <div class="tab-content" style="margin-top:15px;">
          <div class="tab-pane active" id="tab-settings">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-codex-novaposhta" class="form-horizontal">
              <input type="hidden" name="save_settings" value="1" />

              <div class="form-group required">
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

          <div class="tab-pane" id="tab-api">
            <p class="help-block"><?php echo $help_api_console; ?></p>

            <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
              <input type="hidden" name="test_api" value="1" />

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-api-model"><?php echo $entry_api_model; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="api_model" value="<?php echo $api_model; ?>" id="input-api-model" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-api-method"><?php echo $entry_api_method; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="api_method" value="<?php echo $api_method; ?>" id="input-api-method" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-api-props"><?php echo $entry_api_properties; ?></label>
                <div class="col-sm-10">
                  <textarea name="api_properties" id="input-api-props" rows="10" class="form-control"><?php echo $api_properties; ?></textarea>
                </div>
              </div>

              <div class="text-right">
                <button type="submit" class="btn btn-info"><i class="fa fa-play"></i> <?php echo $button_test_api; ?></button>
              </div>
            </form>

            <?php if ($api_error) { ?>
              <div class="alert alert-danger" style="margin-top: 15px;"><?php echo $api_error; ?></div>
            <?php } ?>

            <?php if ($api_response) { ?>
              <pre style="margin-top: 15px; max-height: 400px; overflow:auto;"><?php echo $api_response; ?></pre>
            <?php } ?>
          </div>

          <div class="tab-pane" id="tab-log">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Model</th>
                    <th>Method</th>
                    <th>Error</th>
                    <th>Request</th>
                    <th>Response</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($action_logs) { ?>
                    <?php foreach ($action_logs as $log) { ?>
                      <tr>
                        <td><?php echo $log['codex_novaposhta_action_id']; ?></td>
                        <td><?php echo $log['date_added']; ?></td>
                        <td><?php echo $log['model']; ?></td>
                        <td><?php echo $log['method']; ?></td>
                        <td><?php echo $log['is_error'] ? 'Yes' : 'No'; ?></td>
                        <td><textarea class="form-control" rows="4" readonly><?php echo $log['request_json']; ?></textarea></td>
                        <td><textarea class="form-control" rows="4" readonly><?php echo $log['response_json']; ?></textarea></td>
                      </tr>
                    <?php } ?>
                  <?php } else { ?>
                    <tr>
                      <td colspan="7" class="text-center">No actions logged yet.</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
