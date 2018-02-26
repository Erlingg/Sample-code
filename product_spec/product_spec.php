<?php
include_once DIR_SYSTEM . 'library/PHPExcel/Classes/PHPExcel.php';

class ControllerCatalogProductSpec extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		$this->add();
	}

	public function add() {
		$this->language->load('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->addProduct($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

      if (isset($this->request->get['filter_category'])) {
        $url .= '&filter_category=' . $this->request->get['filter_category'];
      }

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->post['attribute_default'])) {
				$url .= '&att_def=' . $this->request->post['attribute_default'];
			}
			$this->response->redirect($this->url->link('catalog/product_add', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	protected function getForm() {
    //CKEditor
    if ($this->config->get('config_editor_default')) {
        $this->document->addScript('view/javascript/ckeditor/ckeditor.js');
        $this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
    }

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_option'] = $this->language->get('text_option');
		$data['text_option_value'] = $this->language->get('text_option_value');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_h1'] = $this->language->get('entry_meta_h1');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_upc'] = $this->language->get('entry_upc');
		$data['entry_ean'] = $this->language->get('entry_ean');
		$data['entry_jan'] = $this->language->get('entry_jan');
		$data['entry_isbn'] = $this->language->get('entry_isbn');
		$data['entry_mpn'] = $this->language->get('entry_mpn');
		$data['entry_location'] = $this->language->get('entry_location');
		$data['entry_minimum'] = $this->language->get('entry_minimum');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_date_available'] = $this->language->get('entry_date_available');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_points'] = $this->language->get('entry_points');
		$data['entry_option_points'] = $this->language->get('entry_option_points');
		$data['entry_subtract'] = $this->language->get('entry_subtract');
		$data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$data['entry_weight'] = $this->language->get('entry_weight');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['entry_length_class'] = $this->language->get('entry_length_class');
		$data['entry_length'] = $this->language->get('entry_length');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_download'] = $this->language->get('entry_download');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_related'] = $this->language->get('entry_related');
		$data['entry_attribute'] = $this->language->get('entry_attribute');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_option_value'] = $this->language->get('entry_option_value');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_priority'] = $this->language->get('entry_priority');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_reward'] = $this->language->get('entry_reward');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_recurring'] = $this->language->get('entry_recurring');
		$data['entry_main_category'] = $this->language->get('entry_main_category');


		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_attribute_add'] = $this->language->get('button_attribute_add');
		$data['button_attribute_add_list'] = $this->language->get('button_attribute_add_list');
		$data['button_option_add'] = $this->language->get('button_option_add');
		$data['button_option_value_add'] = $this->language->get('button_option_value_add');
		$data['button_discount_add'] = $this->language->get('button_discount_add');
		$data['button_special_add'] = $this->language->get('button_special_add');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_recurring_add'] = $this->language->get('button_recurring_add');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['model'])) {
			$data['error_model'] = $this->error['model'];
		} else {
			$data['error_model'] = '';
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->post['attribute_default'])) {
			$url .= '&att_def=' . $this->request->post['attribute_default'];
		}
        if (isset($this->request->get['att_def'])) {
            $data['attribute_default'] = $this->request->get['att_def'];
        }else{
            $data['attribute_default'] = 0;
        }
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['product_id'])) {
			$data['action'] = $this->url->link('catalog/product_add/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['load_list'] = $this->url->link('catalog/product_spec/excel', 'token=' . $this->session->data['token'], 'SSL');
		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		}

		$data['token'] = $this->session->data['token'];
		$data['ckeditor'] = $this->config->get('config_editor_default');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['lang'] = $this->language->get('lang');

/////////////////////////////////////////////////////////////////////////////////////////
        $this->load->model('catalog/attribute_default');

        $data['product_attributes_default'] = array();
        $data['product_attributes_default'] = $this->model_catalog_attribute_default->getAttributeDefaultList();


        $data['excel'] = $this->url->link('catalog/product_spec/excel', 'token=' . $this->session->data['token'], 'SSL');


        $this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/product_spec.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['product_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['product_id']) && $url_alias_info['query'] != 'product_id=' . $this->request->get['product_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['product_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
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

    public function excel() {

        if ($this->request->server['HTTPS']) {
            $data['base'] = HTTPS_SERVER;
        } else {
            $data['base'] = HTTP_SERVER;
        }

        if (isset($this->request->get['list'])) {
            $list = $this->request->get['list'];
        }

        $this->load->model('catalog/attribute_default');

        $data['product_attributes_default'] = array();
        $data['product_attributes_default'] = $this->model_catalog_attribute_default->getAttributeDefault($list);
        $data['product_attributes_default_name'] = $this->model_catalog_attribute_default->getAttributeDefaultDescriptions($list);

        $this->load->model('catalog/attribute');

        $attributes = explode("\n", $data['product_attributes_default']['attributes']);
        $attribute_list = array();
        foreach( $attributes as $id) {
            $result = $this->model_catalog_attribute->getAttribute($id);
            $attribute_list[] = array(  'name'          => $result['name'],
                                        'id'          => $id,
                                        'list_values'   => explode( "\n",$result['list_values']));
        }
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set document properties
        $objPHPExcel->getProperties()
            ->setCreator("...")
            ->setLastModifiedBy("...")
            ->setTitle("Specification")
            ->setSubject("Specification")
            ->setDescription("Document for specification products.")
            ->setCategory("Specification");

        function transpose($value) {
            return array($value);
        }

        $attrColumn = 'D';
        $column = 'BA';

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Спецификация для заполнения информации о товарах');

        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Категория товара: Акриловые ванны');
        $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Дата заполнения спецификации:');
        $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Название компани поставщика: ');
        $objPHPExcel->getActiveSheet()->setCellValue('A10', 'Фамилия Имя Отчество заполнявшего спецификацию: ');
        $objPHPExcel->getActiveSheet()->setCellValue('A11', 'Контактный телефон сотрудника заполнявшего спецификацию:');
        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'E-mail сотрудника заполнявшего спецификацию');

        $objPHPExcel->getActiveSheet()->setCellValue('A14', 'Требования к заполнению спецификации');
        $objPHPExcel->getActiveSheet()->setCellValue('A15', 'Спецификация заполнятся не более чем на 500 единиц (SKU) товара');
        $objPHPExcel->getActiveSheet()->setCellValue('A16', 'При заполнении спецификации в тех полях где есть выпадающий список значений требуется выбирать значения из выпадающего списка');
        $objPHPExcel->getActiveSheet()->setCellValue('A17', 'Требуется корректно заполнить все значения указанные в спецификации');

        $objPHPExcel->getActiveSheet()->setCellValue('A19', 'Название');
        $objPHPExcel->getActiveSheet()->setCellValue('B19', 'Цена');
        $objPHPExcel->getActiveSheet()->setCellValue('C19', 'Описание');
// Set data for dropdowns
        foreach($attribute_list as $key => $value) {
            $attribute = $value['name'];
            $list_values = $value['list_values'];
            $list_valuesCount = count($list_values);
            if($list_valuesCount > 1 && $value['id'] != '90') {
                // Transpose $countries from a row to a column array
                $list_values = array_map('transpose', $list_values);
                $objPHPExcel->getActiveSheet()
                    ->fromArray($list_values, null, $column . '1');

                $objPHPExcel->addNamedRange(
                    new PHPExcel_NamedRange(
                        'Attr' . $key,
                        $objPHPExcel->getActiveSheet(), $column . '1:' . $column . $list_valuesCount
                    )
                );
                $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($column)
                    ->setVisible(false);
                for ($i = 20; $i < 521; $i++) {
                    $objValidation = $objPHPExcel->getActiveSheet()
                        ->getCell($attrColumn . $i)
                        ->getDataValidation();
                    $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                        ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                        ->setAllowBlank(false)
                        ->setShowInputMessage(true)
                        ->setShowErrorMessage(true)
                        ->setShowDropDown(true)
                        ->setErrorTitle('Ошибка ввода')
                        ->setError('Введенного значения нет в списке.')
                        ->setPromptTitle('Нажмите на выпадащий список')
                        ->setPrompt('В открывшемся списке выберите значение.')
                        ->setFormula1('=' . 'Attr' . $key);

                }
                $objPHPExcel->getActiveSheet()->setCellValue($attrColumn . (19), $attribute.' (список)');
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue($attrColumn . (19), $attribute);
            }
            if($value['id'] == '142' || $value['id'] == '144' || $value['id'] == '164'){
                for ($i = 20; $i < 521; $i++) {
                    $objPHPExcel->getActiveSheet()->getStyle($attrColumn . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                }
            }

            ++$column;
            ++$attrColumn;
        }

        $objPHPExcel->getActiveSheet()
            ->setCellValue($attrColumn . (19), 'Изображение');
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A19:'.$attrColumn .'520')->applyFromArray($styleArray);

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A14')->getFont()->getColor()->applyFromArray(array('rgb' => 'FF0000'));



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Спецификация-'.$data['product_attributes_default_name'][1]['name'].'.xlsx"');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $objWriter->save('php://output');

    }

}
