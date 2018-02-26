<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1>Создать спецификацию</h1>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> Создать спецификацию</h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $excel; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="tab-content">
                <div class="table-responsive">
                  <table  class="table table-striped table-bordered table-hover">
                    <tr>
                      <td>
                        <select style="display: unset; "  name="list" id="input-list" class="form-control">
                          <?php foreach ($product_attributes_default as $default_list) { ?>
                          <option <?php if ($attribute_default == $default_list['id']) { echo ("selected");}  ?> value="<?php echo $default_list['id']; ?>"><?php echo $default_list['name']; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                      <td>
                        <button id="button-xls" form="form-order" data-toggle="tooltip" title="Сохранить в Excel" class="btn btn-primary"><i class="fa fa-table"></i></button>
                      </td>
                    </tr>
                  </table>
                </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="/admin/view/javascript/jquery/jquery-ui-1.12.1-no-autocomplete.min.js"></script>
  <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
<?php if ($ckeditor) { ?>
ckeditorInit('input-description<?php echo $language['language_id']; ?>', '<?php echo $token; ?>');
<?php } else { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({height: 300, lang:'<?php echo $lang; ?>'});
<?php } ?>
<?php } ?>
//--></script>

	
  <script type="text/javascript"><!--
      $('#button-xls').click(function () {
          location.href = 'index.php?route=catalog/product_spec/excel&token=<?php echo $token; ?>' + '&list=' + $('#input-list').val();
      });

//--></script>

<style>
	header
	{
		display: none;
	}
</style>
<?php echo $footer; ?>
