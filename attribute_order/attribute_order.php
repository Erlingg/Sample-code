<?php
class ControllerCatalogAttributeOrder extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('catalog/attribute');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/attribute');
		$this->load->model('catalog/attribute_group');
		$this->load->model('catalog/category');
		
		$this->getList();
	}
	
	public function update() {
		$this->language->load('catalog/attribute');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/attribute');
		$this->load->model('catalog/attribute_group');
		$this->load->model('catalog/category');
		
		$sort_data = json_decode(stripslashes(htmlspecialchars_decode($this->request->post['sort_data'])));
		$text = print_r($sort_data, true);
		
		$attr_data = array();
		
		foreach($sort_data as $key => $value)
		{
			if ($value) {
				$attr_data[] = array(
					'attribute_id' => $value[0],
					'category_id' => $value[1],
					'sort_order' => $value[2],
					'visible' => $value[3],
					'delimiter_name' => $value[4]
				);
			}
		}

		$this->model_catalog_attribute->updateAttributeOrderFast($attr_data);
		
		$this->response->setOutput($text);
	}
	
	protected function getList() 
	{
		
		$attribute_order_list = array();
		$category_list = $this->model_catalog_category->getCategories();
		
		foreach($category_list as $category)
		{
		    if($category['parent_id'] == 0) {
                $category_group_list = array();

                $group_list = $this->model_catalog_attribute->getAttributesGroupIdByCategory($category['category_id']);
                foreach ($group_list as $group) {
                    $category_group_list[$group['name']] = $this->model_catalog_attribute->getAttributesByCategoryAndGroupId($category['category_id'], $group['attribute_group_id']);
                }

                $attribute_order_list[$category['name']] = $category_group_list;
                $delimiter_list[$category['name']] = $this->model_catalog_attribute->getAttributesDelimiterByCategory($category['category_id']);
                $category_id[$category['name']] = $category['category_id'];

            }
		}

		$data['delimiter_list'] = $delimiter_list;
		$data['attribute_order_by_category_list'] = $attribute_order_list;
		$data['category_id'] = $category_id;
		
		
		$attribute_order_list = array();
		$filter['sort'] = 'ag.sort_order';
		
		$group_list = $this->model_catalog_attribute_group->getAttributeGroups($filter);
		
		foreach($group_list as $group)
		{
			$filter['filter_attribute_group_id'] = $group['attribute_group_id'];
			$filter['sort'] = 'a.sort_order';
			$attribute_order_list[$group['name']] = $this->model_catalog_attribute->getAttributesByAttributeGroupId($filter);
		}
		
        $data['delimiter'] = $this->model_catalog_attribute->getAttributesDelimiter();


		$data['attribute_order_by_group_list'] = $attribute_order_list;
		
		$data['echo'] = '';
		$data['heading_title'] = $this->language->get('heading_title');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['update'] = $this->url->link('catalog/attribute_order/update', 'token=' . $this->session->data['token'], 'SSL');
		$this->response->setOutput($this->load->view('catalog/attribute_order.tpl', $data));
	}
}
