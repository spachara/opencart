<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-thaipost" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-thaipost" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_service; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" id="thai_service">
                <div class="col-sm-12 opt">
                  <div class="checkbox">
                  <label>
                    <input type="checkbox" name="thaipost_reg" id="thaipost_reg" value="1"<?php echo $thaipost_reg=='1'?' checked="checked"':'' ?>> 
                    <?php echo $entry_reg; ?>
                  </label>
                  </div>
                  <input type="text" name="thaipost_reg_cost" value="<?php echo $thaipost_reg_cost; ?>" placeholder="<?php echo $entry_reg_cost; ?>" id="input-reg-cost" class="form-control" />
                </div>
                <div class="col-sm-12 opt">
                  <div class="checkbox">
                  <label>
                    <input type="checkbox" name="thaipost_ems" id="thaipost_ems" value="1"<?php echo $thaipost_ems=='1'?' checked="checked"':'' ?>> 
                    <?php echo $entry_ems; ?>
                  </label>
                  </div>
                  <input type="text" name="thaipost_ems_cost" value="<?php echo $thaipost_ems_cost; ?>" placeholder="<?php echo $entry_ems_cost; ?>" id="input-ems-cost" class="form-control" />
                </div>
              </div>
              <?php if ($error_reg_cost) { ?>
              <div class="text-danger"><?php echo $error_reg_cost; ?></div>
              <?php } ?>
              <?php if ($error_ems_cost) { ?>
              <div class="text-danger"><?php echo $error_ems_cost; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
            <div class="col-sm-10">
              <select name="thaipost_tax_class_id" id="input-tax-class" class="form-control">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $thaipost_tax_class_id) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="thaipost_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $thaipost_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="thaipost_status" id="input-status" class="form-control">
                <?php if ($thaipost_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="thaipost_sort_order" value="<?php echo $thaipost_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
#thai_service {height:100px;overflow:auto;margin-bottom:0}
#thai_service .opt {height:40px}
#thai_service .checkbox {float:left;width:100px}
#thai_service .form-control {float:left;width:200px;display:hidden}
</style>
<script type="text/javascript">
$(document).ready(function() {
  $('#thai_service input[type=checkbox]').on('click',function() {
    ctlOption(this);
  });
  $('#thai_service input[type=checkbox]').each(function() {
    ctlOption(this);
  });
  function ctlOption(obj) {
    var option = $(obj).parents('.opt').find('input[type=text]');
    if($(obj).is(':checked')) option.show(); else option.hide();
  }
})
</script>
<?php echo $footer; ?> 