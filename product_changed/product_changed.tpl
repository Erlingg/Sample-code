<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-bar-chart"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-date-start"><?php echo $entry_date_start; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" id="input-date-start" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-end"><?php echo $entry_date_end; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" id="input-date-end" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="col-sm-1 control-label" for="input-changed"><span data-toggle="tooltip" title="<?php echo $help_product; ?>">Товар</span></label>
                <input type="text" name="changed" value="" placeholder="<?php echo $entry_product; ?>" id="input-changed" class="form-control"/>
                <input type="text" name="product_id" value="" placeholder="<?php echo $entry_product; ?>" id="input-product-id" class="form-control hidden"/>
              </div>
              <div class="form-group">
                <label class="col-sm-1 control-label" for="input-user"><span data-toggle="tooltip" title="<?php echo $help_user; ?>">Пользователь</span></label>
                <select name="user_id" class="form-control" id="input-user">
                  <?php foreach ($user_list as $user) { ?>
                    <?php if ($user['id'] == $filter_user_id) { ?>
                      <option value="<?php echo $user['id']; ?>" selected="selected"><?php echo $user['name']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="col-sm-1 control-label" for="input-user"><span>Действие</span></label>
                <select name="change_type" class="form-control" id="change_type">
                  <?php foreach ($change_types as $change_type) { ?>
                    <?php if ($change_type['id'] == $filter_change_type) { ?>
                      <option value="<?php echo $change_type['id']; ?>" selected="selected"><?php echo $change_type['name']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $change_type['id']; ?>"><?php echo $change_type['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left"><?php echo $column_date; ?></td>
                <td class="text-left"><?php echo $column_product; ?></td>
                <td class="text-center"><?php echo $column_user; ?></td>
                <td class="text-center"><?php echo $column_event; ?></td>
                <td class="text-center"><?php echo $column_object ?></td>
                <td class="text-left"><?php echo $column_old; ?></td>
                <td class="text-left"><?php echo $column_new; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($changes) { ?>
              <?php foreach ($changes as $change) { ?>
              <tr>
                <td class=""><?php echo $change['date_changes']; ?></td>
                <td class=""><?php echo $change['name']; ?></td>
                <td class=""><?php echo $change['username']; ?></td>
                <td class=""><?php echo $change['event']; ?></td>
                <td class=""><?php echo $change['object']; ?></td>
                <td class="" id="old"><?php echo $change['old']; ?></td>
                <td class="" id="new"><?php echo $change['new']; ?></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=report/product_changed&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').val();
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').val();
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}

	var filter_product_id = $('input[name=\'product_id\']').val();

	if (filter_product_id) {
		url += '&filter_product_id=' + encodeURIComponent(filter_product_id);
	}

	var filter_user_name = $('input[name=\'user_name\']').val();

	if (filter_user_name) {
		url += '&filter_user_name=' + encodeURIComponent(filter_user_name);
	}

	var filter_user_id = $('select[name=\'user_id\']').val();

	if (filter_user_id) {
		url += '&filter_user_id=' + encodeURIComponent(filter_user_id);
	}
  
	var filter_change_type = $('select[name=\'change_type\']').val();

	if (filter_change_type) {
		url += '&filter_change_type=' + encodeURIComponent(filter_change_type);
	}
	
	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});


      // Related
      $('input[name=\'changed\']').autocomplete({
          'source': function(request, response) {
              $.ajax({
                  url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                  dataType: 'json',
                  success: function(json) {
                      response($.map(json, function(item) {
                          return {
                              label: item['name'],
                              value: item['product_id']
                          }
                      }));
                  }
              });
          },
          'select': function(item) {
              $('input[name=\'changed\']').val(item['label']);
              $('input[name=\'product_id\']').val(item['value']);


              $('#product-related').append('<div id="product-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_related[]" value="' + item['value'] + '" /></div>');
          }
      });

      $('#product-related').delegate('.fa-minus-circle', 'click', function() {
          $(this).parent().remove();
      });
//--></script> 
</div>
<?php echo $footer; ?>