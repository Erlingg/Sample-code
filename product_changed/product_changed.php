<?php

class ControllerReportProductChanged extends Controller
{
	public function index()
	{
		$this->load->language('report/product_changed');

		$data['help_user'] = $this->language->get('help_user');
		$data['help_product'] = $this->language->get('help_product');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['filter_product_id'])) {
			$filter_product_id = $this->request->get['filter_product_id'];
		} else {
			$filter_product_id = '';
		}

		if (isset($this->request->get['filter_change_type'])) {
			$filter_change_type = $this->request->get['filter_change_type'];
		} else {
			$filter_change_type = '';
		}

		if (isset($this->request->get['filter_user_id'])) {
			$filter_user_id = $this->request->get['filter_user_id'];
		} else {
			$filter_user_id = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['filter_change_type'])) {
			$url .= '&filter_change_type=' . $this->request->get['filter_change_type'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('report/product_changed', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		$this->load->model('report/product');

		$user_list = $this->model_report_product->getUsers();

		$data['user_list'][] = array(
			'id'   => '',
			'name' => ''
		);

		foreach ($user_list as $user) {
			$data['user_list'][] = array(
				'id'   => $user['user_id'],
				'name' => $user['firstname'] . ' ' . $user['lastname']
			);
		}


		$data['products'] = array();

		$filter_data = array(
			'filter_change_type' => $filter_change_type,
			'filter_date_start' => $filter_date_start,
			'filter_date_end'   => $filter_date_end,
			'filter_product_id' => $filter_product_id,
			'filter_user_id'    => $filter_user_id,
			'start'             => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'             => $this->config->get('config_limit_admin')
		);

		$objects = array();
		$objects['product'] = array(
			'added'           => 'Добавлен товар',
			'image'           => 'Изображение товара',
			'model'           => 'Модель',
			'sku'             => 'Артикул',
			'upc'             => 'UPC',
			'ean'             => 'EAN',
			'jan'             => 'JAN',
			'isbn'            => 'ISBN',
			'mpn'             => 'MPN',
			'location'        => 'Расположение',
			'quantity'        => 'Количество',
			'minimum'         => 'Минимальное количество',
			'subtract'        => 'Вычитать со склада',
			'stock_status_id' => 'Отсутствие на складе',
			'date_available'  => 'Дата поступления',
			'manufacturer_id' => 'Производитель',
			'shipping'        => 'Необходима доставка',
			'price'           => 'Цена',
			'points'          => 'Баллы',
			'weight'          => 'Вес',
			'weight_class_id' => 'Единица веса',
			'length'          => 'Длина',
			'width'           => 'Ширина',
			'height'          => 'Высота',
			'length_class_id' => 'Единица длины',
			'status'          => 'Статус',
			'tax_class_id'    => 'Налог',
			'sort_order'      => 'Порядок сортировки');

		$objects['description'] = array(
			'name'             => 'Наименование',
			'description'      => 'Описание',
			'meta_title'       => 'HTML-тег Title',
			'meta_h1'          => 'HTML-тег H1',
			'meta_description' => 'Мета-тег Description',
			'meta_keyword'     => 'Мета-тег Keywords',
			'tag'              => 'Теги товара',
		);

		$this->load->model('tool/image');
		$this->load->model('catalog/category');
		$this->load->model('catalog/attribute');
		$attributes = $this->model_catalog_attribute->getAttributes();


		$filter_data_cat = array(
			'sort'  => 'name',
			'order' => 'ASC'
		);

		$categories = $this->model_catalog_category->getCategories($filter_data_cat);

		$changes_total = $this->model_report_product->getTotalChanged($filter_data);
		$distinct_changes = $this->model_report_product->getDistinctChanges($filter_data);
		$results = $this->model_report_product->getChanged($filter_data);
		
		$data['change_types'] = array();
		$data['change_types'][] = array('id' => '', 'name' => '');

		foreach ($distinct_changes as $distinct_change) {
			$obj = $distinct_change['object'];

			$pars_obj = explode(':', $distinct_change['object']);
			if ($pars_obj[0] == 'product') {
				foreach ($objects['product'] as $key => $val) {
					if ($key == $pars_obj[1]) {
						$obj = $val;
					}
				}
			}
			if ($pars_obj[0] == 'description') {
				foreach ($objects['description'] as $key => $val) {
					if ($key == $pars_obj[1]) {
						$obj = $val;
					}
				}
			}
			if ($pars_obj[0] == 'main_category_id') {
				$obj = 'Главная категория';
			}
			if ($pars_obj[0] == 'category') {
				$obj = 'Показывать в категориях';
			}
			if ($pars_obj[0] == 'discount') {
				$obj = 'Скидки';
			}
			if ($pars_obj[0] == 'special') {
				$obj = 'Акции';
			}

			if ($pars_obj[0] == 'image') {
				$obj = 'Изображение';
			}

			if ($pars_obj[0] == 'attribute') {
				$obj = 'Атрибут:';
				foreach ($attributes as $att) {
					if ($pars_obj[1] == $att['attribute_id']) {
						$obj .= $att['name'];
					}
				}
			}

			if ($pars_obj[0] == 'attribute_list_values') {
				$obj = 'Список значений атрибута:';
				foreach ($attributes as $att) {
					if ($pars_obj[1] == $att['attribute_id']) {
						$obj .= $att['name'];
					}
				}
			}

			$data['change_types'][] = array('id' => $distinct_change['object'], 'name' => $obj);
		}

		foreach ($results as $result) {
			$obj = $result['object'];
			$old = $result['old'];
			$new = $result['new'];
			$pars_obj = explode(':', $result['object']);
			if ($pars_obj[0] == 'product') {
				foreach ($objects['product'] as $key => $val) {
					if ($key == $pars_obj[1]) {
						$obj = $val;
					}
				}
			}
			if ($pars_obj[0] == 'description') {
				foreach ($objects['description'] as $key => $val) {
					if ($key == $pars_obj[1]) {
						$obj = $val;
					}
				}
			}
			if ($pars_obj[0] == 'main_category_id') {
				$obj = 'Главная категория';
				foreach ($categories as $cat) {
					if ($old == $cat['category_id']) {
						$old = $cat['name'];
					}
					if ($new == $cat['category_id']) {
						$new = $cat['name'];
					}
				}
			}
			if ($pars_obj[0] == 'category') {
				$obj = 'Показывать в категориях';
				foreach ($categories as $cat) {
					if ($old == $cat['category_id']) {
						$old = $cat['name'];
					}
					if ($new == $cat['category_id']) {
						$new = $cat['name'];
					}
				}
			}
			if ($pars_obj[0] == 'discount') {
				$obj = 'Скидки';
			}
			if ($pars_obj[0] == 'special') {
				$obj = 'Акции';
			}

			if ($pars_obj[0] == 'image') {
				$obj = 'Изображение';
				if ($old != '') {
					$old = "<img src='" . $this->model_tool_image->resize($old, 100, 100) . "'>";
				}
				if ($new != '') {
					$new = "<img src='" . $this->model_tool_image->resize($new, 100, 100) . "'>";
				}
			}

			if ($pars_obj[0] == 'attribute') {
				$obj = 'Атрибут:';
				foreach ($attributes as $att) {
					if ($pars_obj[1] == $att['attribute_id']) {
						$obj .= $att['name'];
					}
				}
			}

			if ($pars_obj[0] == 'attribute_list_values') {
				$obj = 'Список значений атрибута:';
				foreach ($attributes as $att) {
					if ($pars_obj[1] == $att['attribute_id']) {
						$obj .= $att['name'];
					}
				}
			}

			$event = '';
			if ((int)$result['type_event'] == 1) {
				$event = 'Редактирование';
			} elseif ((int)$result['type_event'] == 2) {
				$event = 'Удаление';
			} elseif ((int)$result['type_event'] == 3) {
				$event = 'Добавление';
			}

			$data['changes'][] = array(
				'date_changes' => $result['date_changes'],
				'name'         => $result['name'],
				'username'     => $result['username'],
				'event'        => $event,
				'object'       => $obj,
				'old'          => $old,
				'new'          => $new);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');

		$data['column_product'] = $this->language->get('column_product');
		$data['column_date_end'] = $this->language->get('column_date_end');
		$data['column_date_start'] = $this->language->get('column_date_start');
		$data['column_object'] = $this->language->get('column_object');
		$data['column_old'] = $this->language->get('column_old');
		$data['column_new'] = $this->language->get('column_new');
		$data['column_date'] = $this->language->get('column_date');
		$data['column_user'] = $this->language->get('column_user');
		$data['column_event'] = $this->language->get('column_event');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_user'] = $this->language->get('entry_user');
		$data['entry_product'] = $this->language->get('entry_product');

		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_user_id'])) {
			$url .= '&filter_user_id=' . $this->request->get['filter_user_id'];
		}

		if (isset($this->request->get['filter_change_type'])) {
			$url .= '&filter_change_type=' . $this->request->get['filter_change_type'];
		}
		
		$pagination = new Pagination();
		$pagination->total = $changes_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('report/product_changed', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($changes_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($changes_total - $this->config->get('config_limit_admin'))) ? $changes_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $changes_total, ceil($changes_total / $this->config->get('config_limit_admin')));

		$data['filter_change_type'] = $filter_change_type;
		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_user_id'] = $filter_user_id;
		$data['filter_product_id'] = $filter_product_id;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('report/product_changed.tpl', $data));
	}

	public function autocomplete()
	{
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);

					if ($option_info) {
						$product_option_value_data = array();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);

							if ($option_value_info) {
								$product_option_value_data[] = array(
									'product_option_value_id' => $product_option_value['product_option_value_id'],
									'option_value_id'         => $product_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $product_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'product_option_id'    => $product_option['product_option_id'],
							'product_option_value' => $product_option_value_data,
							'option_id'            => $product_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $product_option['value'],
							'required'             => $product_option['required']
						);
					}
				}

				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}