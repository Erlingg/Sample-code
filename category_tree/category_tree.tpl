<?php echo $header; ?><?php echo $column_left; ?>
	<div id="content">
		<div class="page-header">
			<div class="container-fluid">
				<div class="pull-right">
					<a id="add_category_button" data-toggle="tooltip" title="<?php echo $button_add; ?>"
					   class="btn btn-primary"><i class="fa fa-plus"></i></a>
					<a id="repair_category_button" data-toggle="tooltip" title="<?php echo $button_rebuild; ?>"
					   class="btn btn-default"><i class="fa fa-refresh"></i></a>
				</div>
				<h1><?php echo $heading_title; ?></h1>
				<ul class="breadcrumb">
					<?php foreach ($breadcrumbs as $breadcrumb)
					{ ?>
						<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div class="container-fluid">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
				</div>

				<div class="well">
					<div class="row">
						<div class="col-md-2">
							<div><label>Отображение:</label></div>
							<select id="input-products-count" class="form-control">
								<option value="25" selected="selected">Отображать по 25</option>
								<option value="999999">Отображать всё</option>
							</select>
							<div><label>Отображение просмотров:</label></div>
								<div class="form-group">
									<div class="input-group date">
										<input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" placeholder="С даты" data-date-format="YYYY-MM-DD" id="input-date-start" class="form-control" />
										<span class="input-group-btn">
										<button type="button" form="form-product" class="btn btn-default"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
									<div class="input-group date">
										<input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" placeholder="По дату" data-date-format="YYYY-MM-DD" id="input-date-end" class="form-control" />
										<span class="input-group-btn">
										<button type="button" form="form-product" class="btn btn-default"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								</div>
						</div>
						<div class="col-md-2">
							<div><label>Перенос товаров по категориям:</label></div>
							<a id="add_to_category_button" data-toggle="tooltip" title="" class="btn btn-default form-control"
							   data-original-title="">Добавить в категорию</a>
							<a id="move_to_category_button" data-toggle="tooltip" title="" class="btn btn-default form-control"
							   data-original-title="">Перенести в категорию</a>
							<a id="remove_from_category_button" data-toggle="tooltip" title="" class="btn btn-default form-control"
							   data-original-title="">Убрать из категории</a>
						</div>
						<div class="col-md-2">
							<div><label>Управление статусом:</label></div>
							<a id="set_status_on_button" data-toggle="tooltip" title="" class="btn btn-default form-control" data-original-title="">Статус Вкл</a>
							<a id="set_status_off_button" data-toggle="tooltip" title="" class="btn btn-default form-control" data-original-title="">Статус Выкл</a>
						</div>
						<div class="col-md-3">
							<div><label>Сортировка категории:</label></div>
							<a id="save_order_button" data-toggle="tooltip" title="" class="btn btn-default form-control" data-original-title="">Сохранить сортировку</a>
							<a id="move_product_button" style="width: 60%;" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="">Переместить на </a>
							<input id="move_product_page" class="form-control" value="1" maxlength="2"><b> стр.</b>
							<div class="text-center">
								<label for="sort-type">У категории своя сортировка: </label>
								<a data-toggle="tooltip" data-placement="right" title="Если галочки нет - выбранная категория сортируется по сортировке родительской категории."><input type="checkbox" style="margin-top: 10px;" id="sort-type" name="sort_type" value="1"></a>
							</div>
						</div>
						<div class="col-md-3">
							<span class="pull-right"><a id="filter_products" data-toggle="tooltip" title=""
														class="btn btn-default" data-original-title="">Фильтр</a></span>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">

						<div class="col-md-3">
							<div class="row">

								<div id="category_div"></div>

								<div id="category_loader" class="cssload-precontainer">
									<div class="cssload-container">
										<div class="cssload-whirlpool"></div>
									</div>
								</div>

							</div>
						</div>

						<div class="col-md-9">
							<div id="products_loader" class="cssload-precontainer">
								<div class="cssload-container">
									<div class="cssload-whirlpool"></div>
								</div>
							</div>
							<div id="products_list">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="modalCategorySelect" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Выбор категории</h4>
					</div>
					<div class="modal-body">
						<label>Выберите категорию куда нужно перенести продукты</label>
						<select id="input-category-select" class="form-control">

						</select>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Выбрать</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
					</div>
				</div>
			</div>
		</div>

		<div id="modalFilter" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div id="filter_loader" class="cssload-precontainer">
						<div class="cssload-container">
							<div class="cssload-whirlpool"></div>
						</div>
					</div>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Настройка фильтрации</h4>
					</div>
					<div class="modal-body">
						<label>Фильтровать по:</label>
						<select id="filter-type-select" class="form-control">
							<option value="name">Имя содержит</option>
							<option value="attr-between">Атрибут между</option>
							<option value="attr-contain">Атрибут содержит текст</option>
							<option value="cost-between">Цена между</option>
						</select>
						<br>
						<div class="well">
							<div class="row">
								<div id="filter-name-group">
									<div class="col-md-12">
										<label>Имя содержит:</label>
										<input id="filter-name-contain" type="text" class="form-control"/>
									</div>
								</div>

								<div id="filter-attr-group">
									<div class="col-md-12">
										<label>Атрибут</label>
										<select id="filter-attr-select" class="form-control">
										</select>
										<br>
									</div>
								</div>

								<div id="filter-attr-between-group">
									<div class="col-md-6">
										<label>больше чем</label>
										<input type="text" id="filter-attr-start" class="form-control"/>
									</div>
									<div class="col-md-6">
										<label>и меньше чем</label>
										<input type="text" id="filter-attr-end" class="form-control"/>
									</div>
								</div>

								<div id="filter-attr-contain-group">
									<div class="col-md-12">
										<label>содержит текст</label>
										<input type="text" id="filter-attr-contain" class="form-control"/>
									</div>
								</div>

								<div id="filter-cost-between-group">
									<div class="col-md-6">
										<label>Цена больше чем</label>
										<input type="text" id="filter-cost-start" class="form-control"/>
									</div>
									<div class="col-md-6">
										<label>и меньше чем</label>
										<input type="text" id="filter-cost-end" class="form-control"/>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Отфильтровать</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
					</div>
				</div>
			</div>
		</div>

	</div>
	<script type="text/javascript">

		// скрываем подразделы в фильтре
		$('#filter-attr-group').hide();
		$('#filter-attr-between-group').hide();
		$('#filter-attr-contain-group').hide();
		$('#filter-cost-between-group').hide();

		// показываем подразделы если выбран нужный элемент в списке
		$("#filter-type-select").change(function () {
			$('#filter-name-group').hide();
			$('#filter-attr-group').hide();
			$('#filter-attr-between-group').hide();
			$('#filter-attr-contain-group').hide();
			$('#filter-cost-between-group').hide();

			if ($("#filter-type-select").val().indexOf('attr') != -1) {
				$('#filter-attr-group').show();
			}

			$('#filter-' + $("#filter-type-select").val() + '-group').show();
		});

		// если нажата кнопка фильтровать
		$("#modalFilter .btn-primary").click(function () {
			$("#products_loader").show();

			var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');

			if (typeof category_id == "undefined") {
				category_id = 0;
			}

			var filter_type = $("#filter-type-select").val();
			var filter_attrib = $("#filter-attr-select").val();
			var filter_param_1 = 0;
			var filter_param_2 = 0;

			if (filter_attrib == null) filter_attrib = -1;

			// загружаем данные фильтра в зависимости от способа фильтрования
			switch (filter_type) {
				case 'name':
					filter_param_1 = $("#filter-name-contain").val();
					break;
				case 'attr-between':
					filter_param_1 = $("#filter-attr-start").val();
					filter_param_2 = $("#filter-attr-end").val();
					break;
				case 'attr-contain':
					filter_param_1 = $("#filter-attr-contain").val();
					break;
				case 'cost-between':
					filter_param_1 = $("#filter-cost-start").val();
					filter_param_2 = $("#filter-cost-end").val();
					break;
			}

			// выполняем запрос фильтрации
			$.ajax({
				url: '<?php echo htmlspecialchars_decode($filter_products_link) ?>',
				type: "GET",
				data: {
					'category_id': category_id,
					'filter_type': filter_type,
					'filter_param_1': filter_param_1,
					'filter_param_2': filter_param_2,
					'filter_attrib': filter_attrib
				},
				success: function (data) {
					$('#products_list').html(data);
					$("#products_loader").hide();
				}
			});
		});

		$('#sort-type').change(function() {
			if(this.checked) {
				var sort_type = 1;
                $("#sort-type").prop( "checked", true );
			}else{
                var sort_type = 0;
                $("#sort-type").prop( "checked", false );
            }
            var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');

            $.ajax({
                url: '<?php echo htmlspecialchars_decode($change_sort_type_link) ?>',
                type: "POST",
                data: {
                    "sort_type": sort_type,
                    "category_id": category_id
                },
                success: function (data) {
                    var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');
                    if (typeof category_id !== "undefined") {
                        load_products(category_id, page);
                    }
                }
            });
		});

		// нажата кнопка вызова фильтра
		$("#filter_products").click(function () {
			$('#modalFilter').modal();

			$("#filter_loader").show();

			// получаем требуемую категорию
			var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');
			if (typeof category_id == "undefined") {
				category_id = 0;
			}

			// и загружаем в выпадающий список атрибуты встречающиеся в этой категории
			$.ajax({
				url: '<?php echo htmlspecialchars_decode($get_attributes_list_link) ?>',
				type: "GET",
				data: {'category_id': category_id},
				dataType: "json",
				success: function (data) {
					$('#filter-attr-select').html('');

					for (var k in data) {
						$('#filter-attr-select').html($('#filter-attr-select').html() + '<option value="' + data[k].attribute_id + '">' + data[k].attribute_name + '</option>');
					}

					$("#filter_loader").hide();
				}
			});
		});

		// получаем список категорий
		var category_tree_data = <?php echo $category_list ?> ;

		// скрываем модальные окна загрузки
		$("#category_loader").hide();
		$("#products_loader").hide();
		$("#filter_loader").hide();

		// загружаем дерево категорий
		$("#category_div").jstree({
			"core": {
				"themes": {"stripes": true},
				"check_callback": true,
				"data": category_tree_data
			},
			"types": {
				"#": {
					"max_depth": 3,
					"max_children": 9999,
					"valid_children": ["all", "category"]
				}
			},
			"plugins": [
				"dnd", "types"
			]
		}).bind("move_node.jstree", function (e, data) {
			// при перемещении ноды дерева

			var new_parent = 0;
			// меняем ей родителя
			if (data.parent != '#') {
				new_parent = $("#" + data.parent).attr('category_id')
			}

			if (new_parent != '-1') {
				$("#" + data.node.id).attr('parent_id', new_parent);
			}

			update_categories();

		}).bind("select_node.jstree", function (e, data) {
			// при выборе ноды загружаем соответствующий список продуктов
			load_products(data.node.li_attr.category_id, 1);
			load_sort_type(data.node.li_attr.category_id);
		});

		// по готовности документа
		$(document).ready(function () {
			// выделяем первую ноду дерева
			$('#category_div').jstree(true).deselect_all();
			setTimeout(function () {
				$('#category_div').jstree(true).select_node('j1_1');
			}, 1000);
		});


		$("#repair_category_button").click(function () {
			update_categories();
		});

		$("#add_category_button").click(function () {
			add_category();
		});

		function update_categories() {
			$("#category_loader").show();
			var categories = [];

			$("#category_div li").each(function (key, item) {
				categories.push({
					sort_order: key,
					category_id: $(item).attr('category_id'),
					parent_id: $(item).attr('parent_id')
				});
			});

			$.ajax({
				url: '<?php echo htmlspecialchars_decode($update_order_link) ?>',
				type: "POST",
				data: {"categories": categories},
				success: function (data) {
					$("#category_loader").hide();
				}
			});
		}

		function load_products(category_id, page_id = 0) {
			$("#products_loader").show();
			if (page_id === 0) {
				page_id = $('.pagination .active').text();
				if (typeof page_id == "undefined") page_id = 1;
			}
			else {
				page_id = parseInt(page_id, 10);
				if (page_id !== parseInt(page_id, 10)) page_id = 1;
			}
            var date_start = $("#input-date-start").val();
			var date_end = $("#input-date-end").val();
			$.ajax({
				url: '<?php echo htmlspecialchars_decode($load_products_link) ?>',
				type: "GET",
				data: {"category_id": category_id, "page": page_id, "date_start": date_start, "date_end": date_end, "products_count": $('#input-products-count').val()},
				success: function (data) {
					$('#products_list').html(data);
					$("#products_loader").hide();
				}
			});
		}
        function load_sort_type(category_id){
			if(category_id == 0){
                $("#sort-type").prop( "checked", false );
			}
            $.ajax({
                url: '<?php echo htmlspecialchars_decode($load_sort_type_link) ?>',
                type: "GET",
                data: {"category_id": category_id},
                dataType: "json",
                success: function (data) {
                    for (var k in data) {
                        if(data[k].sort_type == 1){
                            $("#sort-type").prop( "checked", true );
                        }else{
                            $("#sort-type").prop( "checked", false );
                        }
                    }
                }
            });
		}

		function add_category() {
			var parent_category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');

			if (typeof parent_category_id == "undefined") {
				parent_category_id = 0;
			}

			location.href = '<?php echo htmlspecialchars_decode($add_category_link) ?>' + '&parent_id=' + parent_category_id;
		}

		$("#input-products-count").change(function () {
			var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');

			if (typeof category_id !== "undefined") {
				load_products(category_id);
			}
		});

		$('#input-date-start').datetimepicker({
			onChangeDateTime: function(){
				$(this).change();
			}
		});

		$('#input-date-end').datetimepicker({
			onChangeDateTime: function(){
				$(this).change();
			}
		});

        $('#input-date-start').on('change paste input',function() {
			console.log('1');
            var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');
            var page = $('.pagination .active').text();
            if (typeof category_id !== "undefined") {
                load_products(category_id, page);
            }
        });
		
        $('#input-date-end').on('change paste input',function() {
			console.log('2');
            var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');
            var page = $('.pagination .active').text();
            if (typeof category_id !== "undefined") {
                load_products(category_id, page);
            }
        });

		$("#set_status_on_button").click(function () {
			var products = [];
			$('input[name="product_select"]:checked').parent().find('input[name="product_id"]').each(function (k, e) {
				products.push({'product_id': $(e).val()});
			});
			
			$.ajax({
				url: '<?php echo htmlspecialchars_decode($change_status_link) ?>',
				type: "POST",
				data: {
					"status": 1,
					"products": products
				},
				success: function (data) {
					var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');

					if (typeof category_id !== "undefined") {
						load_products(category_id);
					}
				}
			});
		});

		$("#set_status_off_button").click(function () {
			var products = [];
			$('input[name="product_select"]:checked').parent().find('input[name="product_id"]').each(function (k, e) {
				products.push({'product_id': $(e).val()});
			});

			$.ajax({
				url: '<?php echo htmlspecialchars_decode($change_status_link) ?>',
				type: "POST",
				data: {
					"status": 0,
					"products": products
				},
				success: function (data) {
					var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');

					if (typeof category_id !== "undefined") {
						load_products(category_id);
					}
				}
			});
		});

        $("#move_product_button").click(function () {
            $("#products_loader").show();
            var products = [];
            $('input[name="product_select"]:checked').parent().find('input[name="product_id"]').each(function (k, e) {
                products.push({'product_id': $(e).val()});
            });
            var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');
            var page = $('#move_product_page').val();

            $.ajax({
                url: '<?php echo htmlspecialchars_decode($move_product_link) ?>',
                type: "POST",
                data: {
                    "category_id": category_id,
                    "page":  page,
                    "products": products
                },
                success: function (data) {
                    var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');

                    if (typeof category_id !== "undefined") {
                        load_products(category_id);
                    }
                }
            });
        });

		$("#save_order_button").click(function () {
            $("#products_loader").show();
			var products = [];
			$('input[name="product_id"]').each(function (k, e) {
				products.push({'product_id': $(e).val()});
			});
            var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');

			var page = $('.pagination .active').text();
			if (typeof page == "undefined") page = 1;

			$.ajax({
				url: '<?php echo htmlspecialchars_decode($save_order_link) ?>',
				type: "POST",
				data: {
					"category_id": category_id,
					"page":  page,
					"products": products
				},
				success: function (data) {
					var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');
					if (typeof category_id !== "undefined") {
						load_products(category_id, page);
					}
				}
			});
		});

		$("#add_to_category_button").click(function () {
			$.ajax({
				url: '<?php echo htmlspecialchars_decode($get_categories_list_link) ?>',
				type: "GET",
				data: {},
				dataType: "json",
				success: function (data) {
					$('#input-category-select').html('');

					for (var k in data) {
						$('#input-category-select').html($('#input-category-select').html() + '<option value="' + data[k].category_id + '">' + data[k].category_name + '</option>');
					}

					$('#modalCategorySelect .btn-primary').unbind('click');
					$('#modalCategorySelect .btn-primary').click(function () {

						var new_category_id = $('#input-category-select').val();

						var old_category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');
						if (typeof old_category_id == "undefined") {
							old_category_id = 0;
						}

						var products = [];
						$('input[name="product_select"]:checked').parent().find('input[name="product_id"]').each(function (k, e) {
							products.push({'product_id': $(e).val()});
						});

						$.ajax({
							url: '<?php echo htmlspecialchars_decode($process_action_link) ?>',
							type: "POST",
							data: {
								"new_category_id": new_category_id,
								"old_category_id": old_category_id,
								"products": products,
								'action': 'add'
							},
							success: function (data) {
								var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');

								if (typeof category_id !== "undefined") {
									load_products(category_id);
								}
							}
						});
					});

					$('#modalCategorySelect').modal();
				}
			});
		});

		$("#move_to_category_button").click(function () {
			alert('Внимание. Вы точно хотите "ПЕРЕНЕСТИ в категорию", а не "добавить в категорию"?');
			$.ajax({
				url: '<?php echo htmlspecialchars_decode($get_categories_list_link) ?>',
				type: "GET",
				data: {},
				dataType: "json",
				success: function (data) {
					$('#input-category-select').html('');

					for (var k in data) {
						$('#input-category-select').html($('#input-category-select').html() + '<option value="' + data[k].category_id + '">' + data[k].category_name + '</option>');
					}

					$('#modalCategorySelect .btn-primary').unbind('click');
					$('#modalCategorySelect .btn-primary').click(function () {

						var new_category_id = $('#input-category-select').val();

						var old_category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');
						if (typeof old_category_id == "undefined") {
							old_category_id = 0;
						}

						var products = [];
						$('input[name="product_select"]:checked').parent().find('input[name="product_id"]').each(function (k, e) {
							products.push({'product_id': $(e).val()});
						});

						$.ajax({
							url: '<?php echo htmlspecialchars_decode($process_action_link) ?>',
							type: "POST",
							data: {
								"new_category_id": new_category_id,
								"old_category_id": old_category_id,
								"products": products,
								'action': 'move'
							},
							success: function (data) {
								var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');

								if (typeof category_id !== "undefined") {
									load_products(category_id);
								}
							}
						});
					});

					$('#modalCategorySelect').modal();
				}
			});
		});

		$("#remove_from_category_button").click(function () {
			var new_category_id = 0;

			var old_category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');
			if (typeof old_category_id == "undefined") {
				old_category_id = 0;
			}

			var products = [];
			$('input[name="product_select"]:checked').parent().find('input[name="product_id"]').each(function (key, value) {
				products.push({'product_id': $(value).val()});
			});

			$.ajax({
				url: '<?php echo htmlspecialchars_decode($process_action_link) ?>',
				type: "POST",
				data: {
					"new_category_id": new_category_id,
					"old_category_id": old_category_id,
					"products": products,
					'action': 'remove'
				},
				success: function (data) {
					var category_id = $('#' + $('#category_div').jstree('get_selected').pop()).attr('category_id');

					if (typeof category_id !== "undefined") {
						load_products(category_id);
					}
				}
			});
		});

        $('.date').datetimepicker({
            pickTime: false
        });


	</script>
	<style>
		.cssload-precontainer {
			position: absolute;
			display: inline-block;
			width: 100%;
			height: 100%;
			top: 0;
			background-color: rgba(0, 0, 0, 0.4);
			text-align: center;
			font-size: 50px;
			color: rgb(255, 255, 255);
			vertical-align: middle;
			border-radius: 10px;
			box-shadow: 1px 1px 20px rgb(74, 74, 74);
			z-index: 1;
		}

		.cssload-container {
			position: relative;
			width: 100%;
			height: 100%;
		}

		#move_product_page {
			width: 15%;
			float: unset;
			display: unset;
			padding-left: 8px;
			padding-right: 8px;
		}

		.cssload-whirlpool,
		.cssload-whirlpool::before,
		.cssload-whirlpool::after {
			position: absolute;
			top: 50%;
			left: 50%;
			border: 1px solid rgba(153, 153, 153, 0);
			border-left-color: rgb(255, 255, 255);
			border-width: 10px;
			border-radius: 999px;
			-o-border-radius: 999px;
			-ms-border-radius: 999px;
			-webkit-border-radius: 999px;
			-moz-border-radius: 999px;
		}

		.cssload-whirlpool {
			margin: -30px 0 0 -30px;
			height: 61px;
			width: 61px;
			animation: cssload-rotate 1000ms linear infinite;
			-o-animation: cssload-rotate 1000ms linear infinite;
			-ms-animation: cssload-rotate 1000ms linear infinite;
			-webkit-animation: cssload-rotate 1000ms linear infinite;
			-moz-animation: cssload-rotate 1000ms linear infinite;
		}

		.cssload-whirlpool::before {
			content: "";
			margin: -23px 0 0 -23px;
			height: 44px;
			width: 44px;
			animation: cssload-rotate 1000ms linear infinite;
			-o-animation: cssload-rotate 1000ms linear infinite;
			-ms-animation: cssload-rotate 1000ms linear infinite;
			-webkit-animation: cssload-rotate 1000ms linear infinite;
			-moz-animation: cssload-rotate 1000ms linear infinite;
		}

		.cssload-whirlpool::after {
			content: "";
			margin: -29px 0 0 -29px;
			height: 56px;
			width: 56px;
			animation: cssload-rotate 2000ms linear infinite;
			-o-animation: cssload-rotate 2000ms linear infinite;
			-ms-animation: cssload-rotate 2000ms linear infinite;
			-webkit-animation: cssload-rotate 2000ms linear infinite;
			-moz-animation: cssload-rotate 2000ms linear infinite;
		}

		@keyframes cssload-rotate {
			100% {
				transform: rotate(360deg);
			}
		}

		@-o-keyframes cssload-rotate {
			100% {
				-o-transform: rotate(360deg);
			}
		}

		@-ms-keyframes cssload-rotate {
			100% {
				-ms-transform: rotate(360deg);
			}
		}

		@-webkit-keyframes cssload-rotate {
			100% {
				-webkit-transform: rotate(360deg);
			}
		}

		@-moz-keyframes cssload-rotate {
			100% {
				-moz-transform: rotate(360deg);
			}
		}

		.ui-sortable tr:nth-child(25n)
		{
			border-bottom: 5px solid black;
		}
	</style>
<?php echo $footer; ?>