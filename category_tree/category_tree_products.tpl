<script>
  $('#product_select_all').change(function(){
    $('input[name="product_select"]').not(this).prop('checked', this.checked);
  });
</script>
<label class="col-sm-12 text-right"><?php echo $results; ?></label>
<table class="table table-bordered table-hover">
  <thead>
  <th class="text-center"><input type="checkbox" id="product_select_all"></th>
    <th class="text-center">Изобр.</th>
    <th class="text-left">Наименование</th>
    <th class="text-left">Категории</th>
    <th class="text-right">Цена</th>
    <th class="text-center">Статус</th>
    <th class="text-center hidden">Сортировка</th>
    <th class="text-center">П</th>
  </thead>
  <tbody>
<?php foreach($products as $product) { ?>
<tr>
  <form>

  <td class="text-center">
    <input type="hidden" name="product_id" value="<?php echo $product['product_id'] ?>">
    <input type="checkbox" name="product_select">
  </td>

  <td class="text-center handle"><img src="<?php echo $product['image'] ?>"></td>
  <td class="text-left handle"><a href="<?php echo $product['edit_link'] ?>"><?php echo $product['name'] ?></td>
  <td class="text-left handle"><font size="1"><b><?php echo $product['main_category'] ?></b><?php if($product['main_category'] && $product['categories']){ echo ", ";} ?><?php echo $product['categories'] ?></font></td>
  <td class="text-right handle"><?php
  if($product['old_price'])
  {
  ?>
    <span style="text-decoration: line-through;"><?php echo $product['old_price'] ?></span><br>
    <div class="text-danger"><?php echo $product['price'] ?></div>
  <?php
  }
  else
  {
    echo $product['price'];
  }
  ?></td>
  <td class="text-center handle"><?php if($product['status']) echo("Вкл"); else echo("Выкл"); ?></td>
  <td class="hidden"><input type="text" value="0" class="text-center prod-order-sort-order" data-prod-id="<?php echo $product['product_id'] ; ?>" /></td>
  <td class="text-center handle"><?php if($product['viewed']){echo $product['viewed'];}else{echo '0';} ?></td>

  </form>
</tr>
<?php } ?>
  </tbody>
</table>
<div class="text-center"><?php echo $pagination; ?></div>
<script src="view/javascript/jquery/jquery-ui-2.1.1.min.js"></script>
<script>
    var fixHelper = function (e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    };

    var stopSort = function (e, ui) {
        var thisInput = $(ui.item).find('input.prod-order-sort-order');
        var prevInput = $(ui.item).prev().find('input.prod-order-sort-order');
        var nextInput = $(ui.item).next().find('input.prod-order-sort-order');
        if (nextInput.length === 0) {
            thisInput.val(parseInt(prevInput.val()) + 100);
        }
        else if (prevInput.length === 0) {
            thisInput.val(parseInt(nextInput.val()) - 100);
        }
        else {
            thisInput.val((parseInt(prevInput.val()) + parseInt(nextInput.val())) / 2);
        }
        $(thisInput).trigger('input');
    };

    $('tbody').sortable({
        helper: fixHelper,
        cancel: ".prod-order-group-name",
        cursor: "move",
        handle: ".handle",
        stop: stopSort,
        axis: "y"
    }).disableSelection();

    var arr = 0 ;

    var page = <?php if(isset($page) && $page != '') echo $page; else echo 1; ?>;

    arr = (page-1)*2500;

    $('table.table').find('input.prod-order-sort-order').each(function (i, elem) {
        arr += 100;
        $(elem).val(arr);
        $(elem).trigger('input');
    });
</script>