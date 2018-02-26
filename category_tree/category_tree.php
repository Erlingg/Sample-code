<?php

class ControllerCatalogCategoryTree extends Controller
{
	private $error = array();
	private $category_id = 0;
	private $path = array();

	public function index()
	{
		$this->language->load('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		$this->getList();
	}

	protected function getList()
	{
		$this->document->addScript('view/javascript/jstree.min.js');
		$this->document->addStyle('view/stylesheet/jstree/style.css');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['heading_title'] = $this->language->get('heading_title');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['update_order_link'] = $this->url->link('catalog/category_tree/update_order', 'token=' . $this->session->data['token'], 'SSL');
		$data['load_products_link'] = $this->url->link('catalog/category_tree/load_products', 'token=' . $this->session->data['token'], 'SSL');
		$data['load_sort_type_link'] = $this->url->link('catalog/category_tree/load_sort_type', 'token=' . $this->session->data['token'], 'SSL');
		$data['add_category_link'] = $this->url->link('catalog/category/add', 'token=' . $this->session->data['token'], 'SSL');
		$data['get_categories_list_link'] = $this->url->link('catalog/category_tree/get_categories_list', 'token=' . $this->session->data['token'], 'SSL');
		$data['get_attributes_list_link'] = $this->url->link('catalog/category_tree/get_attributes_list', 'token=' . $this->session->data['token'], 'SSL');
		$data['process_action_link'] = $this->url->link('catalog/category_tree/process_category_action', 'token=' . $this->session->data['token'], 'SSL');
		$data['change_status_link'] = $this->url->link('catalog/category_tree/change_status', 'token=' . $this->session->data['token'], 'SSL');
		$data['change_sort_type_link'] = $this->url->link('catalog/category_tree/change_sort_type', 'token=' . $this->session->data['token'], 'SSL');
		$data['filter_products_link'] = $this->url->link('catalog/category_tree/filter_products', 'token=' . $this->session->data['token'], 'SSL');
		$data['save_order_link'] = $this->url->link('catalog/category_tree/save_order', 'token=' . $this->session->data['token'], 'SSL');
		$data['move_product_link'] = $this->url->link('catalog/category_tree/move_product', 'token=' . $this->session->data['token'], 'SSL');


		$test = $this->getCategoriesTree(0);

		$data['category_list'] = json_encode($test);

		$this->response->setOutput($this->load->view('catalog/category_tree.tpl', $data));
	}

	private function getCategoriesTree($parent_id)
	{

		$this->load->model('catalog/product');

		$category_array = array();

		$this_category = array();
		$this_category['text'] = 'Все категории';

		$this_category['li_attr'] = array(
			'category_id' => 0,
			'parent_id' => 0,
		);

		$this_category['state'] = array('opened' => true);
		$this_category['type'] = 'category';

		$this_category['children'] = $this->getCategoriesTree2(0);


		$this_category['children'][] = array('text' => 'Без категории', 'li_attr' => array('category_id' => -1, 'parent_id' => -1), 'state' => array('opened' => true), 'type' => 'category');

		$category_array[] = $this_category;

		return $category_array;
	}

	private function getCategoriesTree2($parent_id)
	{
		$categories = $this->model_catalog_category->getCategoriesByParentId($parent_id);

		$category_array = array();

		foreach ($categories as $category)
		{
			$this_category = array();
			$this_category['text'] = $category['name'];

			$products_count = $this->model_catalog_product->getTotalProductsByCategoryId($category['category_id']);
			$this_category['text'] .= ' (' . $products_count . ')';
			if ($category['status'] == 0)
			{
				$this_category['text'] .= ' (Выключено)';
			}


			$this_category['li_attr'] = array(
				'category_id' => $category['category_id'],
				'parent_id' => $parent_id,
			);

			$this_category['state'] = array('opened' => true);
			$this_category['type'] = 'category';

			if ($category['children'] > 0)
			{
				$this_category['children'] = $this->getCategoriesTree2($category['category_id']);
			}

			$category_array[] = $this_category;
		}

		return $category_array;
	}

	public function update_order()
	{
		$this->load->model('catalog/category');
		foreach ($this->request->post['categories'] as $category_data)
		{
			if ($category_data['category_id'] > 0)
			{
				$this->model_catalog_category->editCategoryOrder($category_data);
			}
		}
	}


	public function get_attributes_list()
	{
		$this->load->model('catalog/attribute');
		$category_id = $this->request->get['category_id'];

		$attributes_array = array();
		if ($category_id == 0)
		{
			$attributes = $this->model_catalog_attribute->getAttributes();
			foreach ($attributes as $attribute)
			{
				$attributes_array[] = array('attribute_id' => $attribute['attribute_id'], 'attribute_name' => $attribute['name']);
			}
		} else
		{
			$attributes_groups = $this->model_catalog_attribute->getAttributesGroupIdByCategory($category_id);
			foreach ($attributes_groups as $attribute_group)
			{
				$attributes = $this->model_catalog_attribute->getAttributesByCategoryAndGroupId($category_id, $attribute_group['attribute_group_id']);
				foreach ($attributes as $attribute)
				{
					$attributes_array[] = array('attribute_id' => $attribute['attribute_id'], 'attribute_name' => $attribute['name']);
				}
			}
		}
		echo(json_encode($attributes_array));
	}

	public function get_categories_list()
	{
		$this->load->model('catalog/category');
		$categories = $this->model_catalog_category->getCategories();
		$categories_array = array();
		foreach ($categories as $category)
		{
			$categories_array[] = array(
				'category_id' => $category['category_id'],
				'category_name' => $category['name'],
			);
		}

		echo(json_encode($categories_array));
	}


	public function change_status()
	{
		$products = $this->request->post['products'];
		$status =  $this->request->post['status'];

		foreach ($products as $product)
		{
			$this->db->query("UPDATE " . DB_PREFIX . "product SET status = '" . (int)$status . "' WHERE product_id = '" . (int)$product['product_id'] . "'");
		}
	}

	public function change_sort_type()
	{
		$category_id = $this->request->post['category_id'];
		$sort_type =  $this->request->post['sort_type'];

        $this->db->query("UPDATE " . DB_PREFIX . "category SET sort_type = '" . (int)$sort_type . "' WHERE category_id = '" . (int)$category_id . "'");
	}

	public function save_order()
	{
		$products = $this->request->post['products'];
		$page =  $this->request->post['page'];
		if($page == 0){$page = 1;}
		$category_id =  $this->request->post['category_id'];
        $sort_order = ($page-1)*2500;
		foreach ($products as $product)
		{
            $sort_order +=100;
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category_order WHERE product_id = '" . (int)$product['product_id'] . "' AND category_id = '" . (int)$category_id . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category_order SET product_id = '" . (int)$product['product_id'] . "', category_id = '" . (int)$category_id . "', sort_order = '" . (int)$sort_order . "'");
		}
	}

	public function move_product()
	{
		$products = $this->request->post['products'];
		$page =  $this->request->post['page'];
        $category_id =  $this->request->post['category_id'];
        $position = ($page-1)*25;
        $move_prod = array();
        foreach ($products as $product){
            $move_prod[] = (int)$product['product_id'];
        }
        $query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = ptc.product_id LEFT JOIN " . DB_PREFIX . "product_to_category_order ptco ON (ptco.product_id = ptc.product_id AND ptco.category_id = '" . (int)$category_id . "') WHERE ptc.category_id = '" . (int)$category_id . "' AND p.product_id NOT IN ('" . implode ("','", $move_prod) . "') ORDER BY p.status DESC, IFNULL(ptco.sort_order, 9999999), p.sort_order");
        $results = array();
        foreach ($query->rows as $row){
            $results[] = $row['product_id'];
        }
        $results = array_chunk($results, 25,true);
        $page_index = 1;
        $prod_order = array();
        foreach ($results as $result){
            if($page_index == $page){
                foreach ($products as $product) {
                    $prod_order[] = $product['product_id'];
                }
            }
            foreach ($result as $prod) {
                $prod_order[] = $prod;
            }
            $page_index++;
        }
        if($prod_order == NULL){
            foreach ($products as $product) {
                $prod_order[] = $product['product_id'];
            }
        }
        $sort_order = 0;
        foreach ($prod_order as $product)
		{
            $sort_order +=100;
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category_order WHERE product_id = '" . (int)$product . "' AND category_id = '" . (int)$category_id . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category_order SET product_id = '" . (int)$product . "', category_id = '" . (int)$category_id . "', sort_order = '" . (int)$sort_order . "'");
		}
	}

	public function process_category_action()
	{
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');

		$new_category_id = $this->request->post['new_category_id'];
		$old_category_id = $this->request->post['old_category_id'];
		$products = $this->request->post['products'];
		$action = $this->request->post['action'];

		$new_category_info = $this->model_catalog_category->getCategory($new_category_id);

		if ($new_category_id == -1)
		{
			return;
		}

		if ($action == 'add')
		{
			foreach ($products as $product)
			{
				$main_category = 0;
				if ($new_category_info['parent_id'] == 0)
				{
					$main_category = 1;
				}
				$this->model_catalog_product->addProductCategory($product['product_id'], $new_category_id, $main_category);
			}
		}
		else if ($action == 'remove')
		{
			foreach ($products as $product)
			{
				$this->model_catalog_product->deleteProductCategory($product['product_id'], $old_category_id);
			}
		}
		else if ($action == 'move')
		{
			foreach ($products as $product)
			{
				$this->model_catalog_product->deleteProductCategory($product['product_id'], $old_category_id);
				$this->model_catalog_product->deleteProductCategory($product['product_id'], $new_category_id);
			}

			foreach ($products as $product)
			{
				$main_category = 0;
				if ($new_category_info['parent_id'] == 0)
				{
					$main_category = 1;
				}
				$this->model_catalog_product->addProductCategory($product['product_id'], $new_category_id, $main_category);
			}
		}
	}

	public function filter_products()
	{
		$category_id = $this->request->get['category_id'];
		$filter_type = $this->request->get['filter_type'];
		$filter_param_1 = $this->request->get['filter_param_1'];
		$filter_param_2 = $this->request->get['filter_param_2'];
		$filter_attrib = $this->request->get['filter_attrib'];

		$products = array();

		if ($filter_type == 'name')
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "product p 
			LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) 
			WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND UPPER(pd.name) LIKE UPPER('%" . trim($filter_param_1) . "%')";

			if ($category_id != 0)
			{
				$sql .= " AND p2c.category_id = '" . (int)$category_id . "'";
			}

			$sql .= " GROUP BY p.product_id";
			$sql .= " ORDER BY p.sort_order ASC";

			$query = $this->db->query($sql);
			$products = $query->rows;
            $product_total = count($products);
		}

		if ($filter_type == 'cost-between')
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "product p 
			LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) 
			WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND p.price > " . (int)$filter_param_1 . " 
			AND p.price < " . (int)$filter_param_2;

			if ($category_id != 0)
			{
				$sql .= " AND p2c.category_id = '" . (int)$category_id . "'";
			}

			$sql .= " GROUP BY p.product_id";
			$sql .= " ORDER BY p.sort_order ASC";

			$query = $this->db->query($sql);
			$products = $query->rows;
            $product_total = count($products);
		}

		if ($filter_type == 'attr-between')
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "product p 
			LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) 
			LEFT JOIN oc_product_attribute pat ON (p.product_id = pat.product_id) 
			WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND pat.attribute_id = " . (int)$filter_attrib . " 
			AND pat.text > " . (int)$filter_param_1 . " 
			AND pat.text < " . (int)$filter_param_2;

			if ($category_id != 0)
			{
				$sql .= " AND p2c.category_id = '" . (int)$category_id . "'";
			}

			$sql .= " GROUP BY p.product_id";
			$sql .= " ORDER BY p.sort_order ASC";

			$query = $this->db->query($sql);
			$products = $query->rows;
            $product_total = count($products);
		}

		if ($filter_type == 'attr-contain')
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "product p 
			LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) 
			LEFT JOIN oc_product_attribute pat ON (p.product_id = pat.product_id) 
			WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND pat.attribute_id = " . (int)$filter_attrib . " 
			AND UPPER(pat.text) LIKE UPPER('%" . $filter_param_1 . "%')";

			if ($category_id != 0)
			{
				$sql .= " AND p2c.category_id = '" . (int)$category_id . "'";
			}

			$sql .= " GROUP BY p.product_id";
			$sql .= " ORDER BY p.sort_order ASC";

			$query = $this->db->query($sql);
			$products = $query->rows;
            $product_total = count($products);
		}

		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		foreach ($products as $product)
		{
			if (is_file(DIR_IMAGE . $product['image']))
			{
				$image = $this->model_tool_image->resize($product['image'], 40, 40);
			} else
			{
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$special = false;

			$product_specials = $this->model_catalog_product->getProductSpecials($product['product_id']);

			foreach ($product_specials as $product_special)
			{
				if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time()))
				{
					$special = $product_special['price'];

					break;
				}
			}

			$price = $product['price'];
			$old_price = false;

			if ($special)
			{
				$price = $special;
				$old_price = $product['price'];
			}
			
			$price = str_replace('.0000', '', $price);
			$old_price = str_replace('.0000', '', $old_price);

			$list_cat = '';
			$main_cat = '';
			$main_category = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN " . DB_PREFIX . "category_description cd ON (ptc.category_id = cd.category_id) WHERE ptc.product_id = '" . (int)$product['product_id'] . "' AND ptc.main_category = '1' LIMIT 1");
			if(isset($main_category->row['name'])) {
				$main_cat = $main_category->row['name'];
			}
			$categories = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN " . DB_PREFIX . "category_description cd ON (ptc.category_id = cd.category_id) WHERE  ptc.product_id = '" . (int)$product['product_id'] . "' AND ptc.main_category != '1'");

			foreach ($categories->rows as $val){
				$list_cat .= "<br>" . trim($val['name']);
			}

			$data['products'][] = array(
				'product_id'    => $product['product_id'],
				'image'         => $image,
				'status'        => $product['status'],
				'name'          => $product['name'],
				'main_category' => $main_cat,
				'categories'    => $list_cat,
				'price'         => $price,
				'old_price'     => $old_price,
				'edit_link'     => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'] . $url, 'SSL')
			);
		}

		$data['pagination'] = '';
		$data['page'] = 1;
        $data['results'] = "Найдено ". $product_total . " товаров.";

        $this->response->setOutput($this->load->view('catalog/category_tree_products.tpl', $data));
	}

    public function load_sort_type()
    {
		$sort_type = array();
        $category_id = $this->request->get['category_id'];
        $query = $this->db->query("SELECT sort_type FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
        foreach ($query->rows as $row){
            $sort_type[] = array(
                'sort_type' => $row['sort_type']
            );
        }
        echo(json_encode($sort_type));
    }

	public function load_products()
	{
		if (isset($this->request->get['page']))
		{
			$page = $this->request->get['page'];
		} else
		{
			$page = 1;
		}

		if (isset($this->request->get['products_count']))
		{
			$products_count = $this->request->get['products_count'];
		} else
		{
			$products_count = $this->config->get('config_limit_admin');
		}

		if (isset($this->request->get['category_id']))
		{
			$category_id = $this->request->get['category_id'];
		} else
		{
			$category_id = 0;
		}

		if (isset($this->request->get['date_start']))
		{
			$data['date_start'] = $this->request->get['date_start'];
		} else
		{
            $data['date_start'] = '';
		}

		if (isset($this->request->get['date_end']))
		{
            $data['date_end'] = $this->request->get['date_end'];
		} else
		{
            $data['date_end'] = '';
		}

		$filter_data = array(
			'start' => ($page - 1) * $products_count,
			'limit' => $products_count,
			'order' => 'p.sort_order',
			'sort_category' => true,
			'filter_category' => $category_id
		);

		$url = '';

		if (isset($this->request->get['page']))
		{
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['category_id']))
		{
			$url .= '&category_id=' . $this->request->get['category_id'];
		}

		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$products = $this->model_catalog_product->getProductsByCategoryId($category_id, $filter_data);
		$products_total = $this->model_catalog_product->getTotalProducts($filter_data);

		if ($category_id == 0)
		{
			$products = $this->model_catalog_product->getProducts($filter_data);
			$products_total = $this->model_catalog_product->getTotalProducts($filter_data);
		}

		if ($category_id == -1)
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "product p 
			LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
			WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND p.product_id NOT IN (SELECT product_id FROM " . DB_PREFIX . "product_to_category)
			ORDER BY p.sort_order ASC";

			$query = $this->db->query($sql);

			$products = $query->rows;
			$products_total = count($products);
		}

		$data['products'] = array();

		foreach ($products as $product)
		{
			if (is_file(DIR_IMAGE . $product['image']))
			{
				$image = $this->model_tool_image->resize($product['image'], 40, 40);
			} else
			{
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$special = false;

			$product_specials = $this->model_catalog_product->getProductSpecials($product['product_id']);

			foreach ($product_specials as $product_special)
			{
				if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time()))
				{
					$special = $product_special['price'];

					break;
				}
			}

			$price = $product['price'];
			$old_price = false;

			if ($special)
			{
				$price = $special;
				$old_price = $product['price'];
			}

			$price = str_replace('.0000', '', $price);
			$old_price = str_replace('.0000', '', $old_price);

            $viewed = $this->model_catalog_product->getProductViewedByDate($product['product_id'], $data['date_start'], $data['date_end']);

            $list_cat = '';
            $main_cat = '';
            $main_category = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN " . DB_PREFIX . "category_description cd ON (ptc.category_id = cd.category_id) WHERE ptc.product_id = '" . (int)$product['product_id'] . "' AND ptc.main_category = '1' LIMIT 1");
            if(isset($main_category->row['name'])) {
                $main_cat = $main_category->row['name'];
            }
            $categories = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN " . DB_PREFIX . "category_description cd ON (ptc.category_id = cd.category_id) WHERE  ptc.product_id = '" . (int)$product['product_id'] . "' AND ptc.main_category != '1'");

            foreach ($categories->rows as $val){
                $list_cat .= "<br>" . trim($val['name']);
            }
			
			$data['products'][] = array(
				'product_id'    => $product['product_id'],
				'image'         => $image,
				'status'        => $product['status'],
				'name'          => $product['name'],
				'main_category' => $main_cat,
				'categories'    => $list_cat,
				'price'         => $price,
				'old_price'     => $old_price,
				'viewed'        => $viewed,
				'edit_link'     => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'] . $url, 'SSL')
			);
		}

		$pagination = new Pagination();
		$pagination->total = $products_total;
		$pagination->page = $page;
		$pagination->limit = $products_count;
		$pagination->url = 'javascript:load_products(\'' . $category_id . '\', \'{page}\');';

		$data['page'] = $page;
		$data['pagination'] = $pagination->render();

		$this->response->setOutput($this->load->view('catalog/category_tree_products.tpl', $data));
	}
}