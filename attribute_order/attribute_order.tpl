<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="button" data-toggle="tooltip" title="Сохранить" class="btn btn-primary bnt-save"
                        onclick=""><i class="fa fa-floppy-o"></i></button>
            </div>
            <h1><?php echo $heading_title; ?></h1>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($echo) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                <pre><?php print_r($echo); ?></pre>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i>Выставление порядка атрибутов</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <h4 class="col-sm-3 text-center" style="padding-top: 9px; width: 190px;">Новый разделитель:</h4>
                    <div class="panel col-sm-4" style="padding-left: 0px;">
                        <input type="text" id="add-delimiter-name" placeholder="Название разделителя:" class="form-control"/>
                    </div>
                        <button type="button" onclick="addDelimiter()" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Добавить разделитель"><i class="fa fa-plus-circle"></i></button>
                    <div class="col-sm-12">
                        <select class="form-control" id='tab-select'>
                            <option value='0'>По группам</option>
                            <?php $i = 1; foreach($attribute_order_by_category_list as $category_key => $category_value){ ?>
                            <option value="<?php echo $i++?>"><?php echo $category_key?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <ul class="nav nav-tabs hide">
                    <li class="active"><a data-toggle="tab" href="#att-order-tabs-1">По группам</a></li>
                    <?php $i = 2; foreach($attribute_order_by_category_list as $category_key => $category_value){ ?>
                    <li><a data-toggle="tab" href="#att-order-tabs-<?php echo $i++?>"><?php echo $category_key?></a>
                    </li>
                    <?php } ?>
                </ul>

                <div class="tab-content">
                    <div id="att-order-tabs-1" class="tab-pane fade in active" data-cat-id="1">
                        <h4 class="panel-title" style="text-align: center;padding: 10px;"><b>Все атрибуты по группам</b>
                        </h4>
                        <table id="sortable" class="table table-bordered table-hover at-order-table">
                            <thead>
                            <tr>
                                <td>
                                    Группа
                                </td>
                                <td>
                                    Атрибут
                                </td>
                                <td>
                                    Порядок сортировки
                                </td>
                                <td>
                                    Популярность
                                </td>
                                <td>
                                    Показывать атрибут
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $prev_order = 0; ?>
                            <?php $deli_id = 1; ?>
                            <?php foreach($attribute_order_by_group_list as $group_key => $group_value){ ?>
                            <?php foreach($group_value as $attrib_value){ ?>
                                <?php foreach($delimiter as $deli){ ?>
                                    <?php if(($prev_order <= $deli['sort_order']) && ($deli['sort_order'] < $attrib_value['sort_order'])){ ?>
                                        <tr class="at-order-delimiter-name">
                                            <td class="text-center handle delimiter-name"><?php echo $deli['delimiter_name']; ?></td>
                                            <td class="handle"></td>
                                            <td><input type="text" value="<?php echo $deli['sort_order']; ?>" class="text-center at-order-sort-order" data-del-id="<?php echo $deli_id ; ?>" /></td>
                                            <td></td>
                                            <td class="text-center"><button type="button" onclick="$(this).parent().parent().remove();" data-toggle="tooltip" title="Удалить разделитель" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                    <?php $deli_id++ ; ?>
                                    <?php }?>
                                <?php } ?>
                                <?php $prev_order = $attrib_value['sort_order'];?>
                                <tr>
                                    <td></td>
                                    <td class='handle'><?php echo $attrib_value['name']; ?></td>
                                    <td>
                                        <input type="text" value="<?php echo $attrib_value['sort_order']; ?>" class="text-center at-order-sort-order" data-at-id=<?php echo $attrib_value['attribute_id']; ?> />
                                    </td>
                                    <td class="text-center"><?php echo ($attrib_value['usability']) ? $attrib_value['usability'] : 0 ?></td>
                                    <td class="text-center"><input type="checkbox" class="at-order-visible" data-at-id=<?php echo $attrib_value['attribute_id']; ?> checked="true" /></td>
                                </tr>

                            <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <?php $i = 2; foreach($attribute_order_by_category_list as $category_key => $category_value){ ?>
                        <?php $prev_order = 0; ?>
                        <div id="att-order-tabs-<?php echo $i++?>" class="tab-pane fade" data-cat-id=<?php echo $category_id[$category_key]?>>
                            <h4 class="panel-title" style="text-align: center;padding: 10px;"><b><?php echo $category_key?></b></h4>
                            <table class="table table-bordered table-hover at-order-table">
                                <thead>
                                <tr>
                                    <td>
                                        Группа
                                    </td>
                                    <td>
                                        Атрибут
                                    </td>
                                    <td>
                                        Порядок сортировки
                                    </td>
                                    <td>
                                        Популярность
                                    </td>
                                    <td>
                                        Показывать атрибут
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($category_value as $group_key => $group_value){ ?>
                                <?php foreach($group_value as $attrib_value){ ?>
                                    <?php foreach($delimiter_list[$category_key] as $deli){ ?>
                                        <?php if(($prev_order <= $deli['sort_order']) && ($deli['sort_order'] < $attrib_value['sort_order'])){ ?>
                                        <tr class="at-order-delimiter-name">
                                            <td class="text-center handle delimiter-name"><?php echo $deli['delimiter_name']; ?></td>
                                            <td class="handle"></td>
                                            <td><input type="text" value="<?php echo $deli['sort_order']; ?>" class="text-center at-order-sort-order" data-del-id="<?php echo $deli_id ; ?>" /></td>
                                            <td></td>
                                            <td class="text-center"><button type="button" onclick="$(this).parent().parent().remove(); resort();" data-toggle="tooltip" title="Удалить разделитель" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $deli_id++ ; ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php $prev_order = $attrib_value['sort_order']; ?>
                                <tr>
                                    <td></td>
                                    <td class='handle'><?php echo $attrib_value['name']; ?></td>
                                    <td>
                                        <input type="text" value="<?php echo $attrib_value['sort_order']; ?>" class="text-center at-order-sort-order" data-at-id=<?php echo $attrib_value['attribute_id'];?> />
                                        <?php
                                        if( $attrib_value['sort_order'] == 99999999) echo('<i class="fa fa-question-circle" aria-hidden="true"></i>');
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo ($attrib_value['usability']) ? $attrib_value['usability'] : 0 ?>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" class="at-order-visible"  data-at-id=<?php echo $attrib_value['attribute_id']; ?> <?php if($attrib_value['visible']==0){echo "checked";}?> />
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="view/javascript/jquery/jquery-ui-2.1.1.min.js"></script>
<script>
    $('#tab-select').on('change', function (e) {
        $('.nav-tabs li a').eq($(this).val()).tab('show');
    });

    var fixHelper = function (e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    };

    var stopSort = function (e, ui) {
        var thisInput = $(ui.item).find('input.at-order-sort-order');
        var prevInput = $(ui.item).prev().find('input.at-order-sort-order');
        var nextInput = $(ui.item).next().find('input.at-order-sort-order');
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
        cancel: ".at-order-group-name",
        cursor: "move",
        handle: ".handle",
        stop: stopSort,
        axis: "y"
    }).disableSelection();

    $('input.at-order-sort-order').on('input', function () {
        var id = $(this).attr('data-at-id');
        var val = parseInt($(this).val());
        $(this).val(val);
    });


    function resort()
    {
        var arr = 0;
        $('div.tab-content').find('input.at-order-sort-order').each(function (i, elem) {
            arr += 100;
            $(elem).val(arr);
            $(elem).trigger('input');
        });
    }

    function fill_del() {
        var max_del = 0;

        $('[data-del-id]').each(function (i, elem) {
            if($(elem).attr('data-del-id') > max_del)
            {
                max_del = $(this).attr('data-del-id');
            }
        });

        $('div.tab-content').find('tr.at-order-group-name').each(function (i, elem) {
            if($(elem).next().attr('class') == "at-order-delimiter-name")
            {

            }
            else
            {
                var name = $(elem).find('td').first().text();
                var html = '<tr class="at-order-delimiter-name">';
                html +=         '<td class="text-center handle delimiter-name">' + name + '</td>';
                html +=         '<td class="handle"></td>';
                html +=         '<td><input type="text" value="" class="text-center at-order-sort-order" data-del-id=' + max_del + ' /></td>';
                html +=         '<td></td>';
                html +=         '<td class="text-center"><button type="button" onclick="$(this).parent().parent().remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
                html +=     '</tr>';
                $(elem).after(html);
                max_del++;
            }
        });

        resort();
    }

    $(document).ready(function () {
        resort();
    });

    $('.bnt-save').on('click', function () {
        var data = new Array();
        var i = 0;
        $('input.at-order-sort-order').each(function (i, elem) {
            if (parseInt($(elem).attr('data-at-id')) > 0) {
                var id = parseInt($(elem).attr('data-at-id'));
                var deli = '1';
            }else{
                var id = 0;
                var deli = $(elem).closest('tr').find('td.delimiter-name:first').text();
            }
            var val = parseInt($(elem).val());
            var cat = parseInt($(elem).parents('div.tab-pane.fade').attr('data-cat-id'));
            if($(elem).closest('tr').find('input.at-order-visible:first').prop('checked')){
                var vis = 0;
            }else{
                var vis = 1;
            }
            data[i] = [id, cat, val, vis, deli];
            i++;
        });

        $.ajax({
            url: '<?php echo htmlspecialchars_decode($update)?>',
            type: 'POST',
            async: false,
            data: {'action':'save', 'sort_data':JSON.stringify(data)},
            success: function (data) {
                location.reload();
            }
        });
    });

    var delimiter = <?php echo $deli_id; ?>;

    function addDelimiter() {
        var html = '<tr class="at-order-delimiter-name">';
        html +=         '<td class="text-center handle delimiter-name">' + $('#add-delimiter-name').val() + '</td>';
        html +=         '<td class="handle"></td>';
        html +=         '<td><input type="text" value="" class="text-center at-order-sort-order" data-del-id=' + delimiter + ' /></td>';
        html +=         '<td></td>';
        html +=         '<td class="text-center"><button type="button" onclick="$(this).parent().parent().remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html +=     '</tr>';

        $('#att-order-tabs-' + (parseInt($('#tab-select').val()) + 1) + ' tbody').prepend(html);
        $('#add-delimiter-name').val('');
        delimiter++;
    }

</script>
<style>
    .at-order-category-name {
        background-color: rgb(128, 128, 128) !important;;
        font-weight: bold;
        color: rgb(255, 255, 255);
    }

    .at-order-group-name {
        background-color: #f9b100 !important;
        font-weight: bold;
        color: rgb(255, 255, 255);
    }
    .at-order-delimiter-name {
        background-color: #f9b100 !important;
    }
    .at-order-delimiter-name .handle {
        font-weight: bold;
        color: rgb(255, 255, 255);
    }
    .at-order-delimiter-name td button {
        padding: 0px 3px;
    }

    .at-order-table td {
        padding: 4px 8px !important;
        line-height: 1 !important;
    }

    .at-order-table tr {
        line-height: 1;
    }

    .at-order-table tr:nth-child(odd) {
        background-color: rgb(249, 249, 249);
    }

    .at-order-table input {
        padding: 0px;
        font-size: 10px;
    }
</style>
<?php echo $footer; ?>
