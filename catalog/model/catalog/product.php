<?php
class ModelCatalogProduct extends Model {
	public function updateViewed($product_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '" . (int)$product_id . "'");
	}

	public function getProduct($product_id) {
// 		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
        // update query for range discount on 29-04-2025
        $query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND '1' BETWEEN pd2.quantity AND IFNULL(pd2.max_quantity, 999999) AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "'  AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		if ($query->num_rows) {
			return array(
				'product_id'       => $query->row['product_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_title'       => $query->row['meta_title'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],
				'sku'              => $query->row['sku'],
				'upc'              => $query->row['upc'],
				'ean'              => $query->row['ean'],
				'jan'              => $query->row['jan'],
				'isbn'             => $query->row['isbn'],
				'mpn'              => $query->row['mpn'],
				'location'         => $query->row['location'],
				'quantity'         => $query->row['quantity'],
				'stock_status'     => $query->row['stock_status'],
				'image'            => $query->row['image'],
				'manufacturer_id'  => $query->row['manufacturer_id'],
				'manufacturer'     => $query->row['manufacturer'],
				'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
				'special'          => $query->row['special'],
				'reward'           => $query->row['reward'],
				'points'           => $query->row['points'],
				'tax_class_id'     => $query->row['tax_class_id'],
				'date_available'   => $query->row['date_available'],
				'weight'           => $query->row['weight'],
				'weight_class_id'  => $query->row['weight_class_id'],
				'length'           => $query->row['length'],
				'width'            => $query->row['width'],
				'height'           => $query->row['height'],
				'length_class_id'  => $query->row['length_class_id'],
				'subtract'         => $query->row['subtract'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed']
			);
		} else {
			return false;
		}
	}

	public function getProductsVariants($product_id)
	{
		$query = $this->db->query("SELECT product_id, variant_name, variant_image
			FROM " . DB_PREFIX . "product_variants
			WHERE variant_group_id = (
				SELECT variant_group_id
				FROM " . DB_PREFIX . "product_variants
				WHERE product_id = '" . (int)$product_id . "'
				LIMIT 1
			)
			AND product_id != '" . (int)$product_id . "'
		");

		return $query->rows;
	}

	public function getProducts($data = array()) {
		$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";
     
		if (!empty($data['filter_category_id']) ) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
			
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}
// Filter by category_level
if (!empty($data['filter_category_id']) && $data['filter_category_level'] !== '') {
	$level = (int)$data['filter_category_level'];
	if ($level >= 0 && $level <= 4) {
		$level_column = 'category_level_' . ($level + 1);
		$sql .= " LEFT JOIN " . DB_PREFIX . "vendor_product_category vpc ON (vpc.product_id = p.product_id AND vpc." . $level_column . " = '" . (int)$data['filter_category_id'] . "')";

	}
}

// if (!empty($data['filter_category_id']) && $data['filter_category_level'] !='') {
//     $level = (int)$data['filter_category_level'];
//     if ($level >= 0 && $level <= 4) {
//         $level_column = 'category_level_' . ($level + 1);

     
//         // Add JOIN
//         $sql .= " LEFT JOIN " . DB_PREFIX . "vendor_product_category vpc ON (vpc.product_id = p.product_id)";

//         // Add WHERE condition
//         $sql .= " AND vpc." . $level_column . " = '" . (int)$data['filter_category_id'] . "'";
    
//     }
// }
		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

// filter start  21/06/25 


		if (!empty($data['filter_sizes'])) {
			$sizes = array_map('intval', $data['filter_sizes']);
			$sql .= " AND p.product_id IN (
        SELECT pov.product_id FROM " . DB_PREFIX . "product_option_value pov
        WHERE pov.option_value_id IN (" . implode(',', $sizes) . ")
    )";
		}

		//  -------------------------------------------Rating Filter--------------------------------
		if (!empty($data['filter_ratings']) && is_array($data['filter_ratings'])) {
			$conditions = [];
			foreach ($data['filter_ratings'] as $rating) {
				$rating = (int)$rating;
				$conditions[] = "(SELECT AVG(rating) FROM " . DB_PREFIX . "review r WHERE r.product_id = p.product_id AND r.status = '1') >= {$rating}";
			}
			$sql .= " AND (" . implode(" OR ", $conditions) . ")";
		}




		// ---------------------------------------------color----------------------------------------------------

		if (!empty($data['filter_colors']) && is_array($data['filter_colors'])) {
			$escaped_colors = array_map([$this->db, 'escape'], $data['filter_colors']);
			$escaped_colors = array_map(function ($color) {
				return "'" . $color . "'";
			}, $escaped_colors);

			$sql .= " AND p.product_id IN (
			SELECT product_id FROM " . DB_PREFIX . "product_variants
			WHERE variant_name IN (" . implode(",", $escaped_colors) . ")
		)";
		}
		// ---------------------------------discount--------------------------------

		if (!empty($data['filter_discounts']) && is_array($data['filter_discounts'])) {
			$conditions = [];

			foreach ($data['filter_discounts'] as $percent) {
				$percent = (int)$percent;

				// Add SQL to filter by discount %
				$conditions[] = "
        (
            SELECT 
                ((p.price - ps.price) / p.price) * 100 
            FROM " . DB_PREFIX . "product_special ps 
            WHERE ps.product_id = p.product_id 
            AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
            AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
            AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
            ORDER BY ps.priority ASC, ps.price ASC 
            LIMIT 1
        ) >= {$percent}
        ";
			}

			$sql .= " AND (" . implode(" OR ", $conditions) . ")";
		}

		// Price Filter Fix
		if (!empty($data['min_price'])) {
			$sql .= " AND (
           CASE
            WHEN (
                SELECT price FROM " . DB_PREFIX . "product_special ps 
                WHERE ps.product_id = p.product_id 
                AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
                AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
                AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
                ORDER BY ps.priority ASC, ps.price ASC LIMIT 1
            ) IS NOT NULL
            THEN (
                SELECT price FROM " . DB_PREFIX . "product_special ps 
                WHERE ps.product_id = p.product_id 
                AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
                AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
                AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
                ORDER BY ps.priority ASC, ps.price ASC LIMIT 1
            )
            WHEN (
                SELECT price FROM " . DB_PREFIX . "product_discount pd 
                WHERE pd.product_id = p.product_id 
                AND pd.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
                AND pd.quantity = 1 
                AND ((pd.date_start = '0000-00-00' OR pd.date_start < NOW()) 
                AND (pd.date_end = '0000-00-00' OR pd.date_end > NOW())) 
                ORDER BY pd.priority ASC, pd.price ASC LIMIT 1
            ) IS NOT NULL
            THEN (
                SELECT price FROM " . DB_PREFIX . "product_discount pd 
                WHERE pd.product_id = p.product_id 
                AND pd.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
                AND pd.quantity = 1 
                AND ((pd.date_start = '0000-00-00' OR pd.date_start < NOW()) 
                AND (pd.date_end = '0000-00-00' OR pd.date_end > NOW())) 
                ORDER BY pd.priority ASC, pd.price ASC LIMIT 1
            )
            ELSE p.price 
        END
    ) >= " . (float)$data['min_price'];
		}

		if (!empty($data['max_price'])) {
			$sql .= " AND (
        CASE
            WHEN (
                SELECT price FROM " . DB_PREFIX . "product_special ps 
                WHERE ps.product_id = p.product_id 
                AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
                AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
                AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
                ORDER BY ps.priority ASC, ps.price ASC LIMIT 1
            ) IS NOT NULL
            THEN (
                SELECT price FROM " . DB_PREFIX . "product_special ps 
                WHERE ps.product_id = p.product_id 
                AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
                AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
                AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
                ORDER BY ps.priority ASC, ps.price ASC LIMIT 1
            )
            WHEN (
                SELECT price FROM " . DB_PREFIX . "product_discount pd 
                WHERE pd.product_id = p.product_id 
                AND pd.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
                AND pd.quantity = 1 
                AND ((pd.date_start = '0000-00-00' OR pd.date_start < NOW()) 
                AND (pd.date_end = '0000-00-00' OR pd.date_end > NOW())) 
                ORDER BY pd.priority ASC, pd.price ASC LIMIT 1
            ) IS NOT NULL
            THEN (
                SELECT price FROM " . DB_PREFIX . "product_discount pd 
                WHERE pd.product_id = p.product_id 
                AND pd.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
                AND pd.quantity = 1 
                AND ((pd.date_start = '0000-00-00' OR pd.date_start < NOW()) 
                AND (pd.date_end = '0000-00-00' OR pd.date_end > NOW())) 
                ORDER BY pd.priority ASC, pd.price ASC LIMIT 1
            )
            ELSE p.price
        END
    ) <= " . (float)$data['max_price'];
		}


		// Apply manufacturer filter if set (brand checkbox filter)
		if (!empty($data['filter_manufacturers']) && is_array($data['filter_manufacturers'])) {
			$ids = array_map('intval', $data['filter_manufacturers']);
			$sql .= " AND p.manufacturer_id IN (" . implode(',', $ids) . ")";
		}
// filter end 21/06/25 
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				// if (!empty($data['filter_description'])) {
				// 	$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				// }
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.quantity',
			'p.price',
			'rating',
			'p.sort_order',
			'p.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} elseif ($data['sort'] == 'p.price') {
				$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getProductSpecials($data = array()) {
		$sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getLatestProducts($limit) {
		$product_data = $this->cache->get('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$product_data) {
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	public function getPopularProducts($limit) {
		$product_data = $this->cache->get('product.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);
	
		if (!$product_data) {
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);
	
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			$this->cache->set('product.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}
		
		return $product_data;
	}

	public function getBestSellerProducts($limit) {
		$product_data = $this->cache->get('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$product_data) {
			$product_data = array();

			$query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	public function getProductAttributes($product_id) {
		$product_attribute_group_data = array();

		$product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($product_attribute_group_query->rows as $product_attribute_group) {
			$product_attribute_data = array();

			$product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($product_attribute_query->rows as $product_attribute) {
				$product_attribute_data[] = array(
					'attribute_id' => $product_attribute['attribute_id'],
					'name'         => $product_attribute['name'],
					'text'         => $product_attribute['text']
				);
			}

			$product_attribute_group_data[] = array(
				'attribute_group_id' => $product_attribute_group['attribute_group_id'],
				'name'               => $product_attribute_group['name'],
				'attribute'          => $product_attribute_data
			);
		}

		return $product_attribute_group_data;
	}

	public function getProductOptions($product_id) {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'name'                    => $product_option_value['name'],
					'image'                   => $product_option_value['image'],
					'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
					'price_prefix'            => $product_option_value['price_prefix'],
					'weight'                  => $product_option_value['weight'],
					'weight_prefix'           => $product_option_value['weight_prefix']
				);
			}

			$product_option_data[] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => $product_option['value'],
				'required'             => $product_option['required']
			);
		}

		return $product_option_data;
	}

	public function getProductDiscounts($product_id) {
	   // update query for range discount on 29-04-2025
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, max_quantity ASC, priority ASC, price ASC");

		return $query->rows;
	}

	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getProductRelated($product_id) {
		$product_data = array();


$query = $this->db->query("
        SELECT DISTINCT p2.product_id 
        FROM " . DB_PREFIX . "product_to_category p1
        JOIN " . DB_PREFIX . "product_to_category p2 ON p1.category_id = p2.category_id 
        WHERE p1.product_id = '" . (int)$product_id . "'
        AND p2.product_id != '" . (int)$product_id . "'
        GROUP BY p2.product_id 
        HAVING COUNT(DISTINCT p1.category_id) = (
            SELECT COUNT(*) FROM " . DB_PREFIX . "product_to_category 
            WHERE product_id = '" . (int)$product_id . "'
        )
        LIMIT 10");

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

	

		return $product_data;
	}

	public function getProductLayoutId($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return (int)$query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getCategories($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}

	public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

        // filter pagination  start  
            
            if (!empty($data['filter_manufacturers'])) {
            $ids = array_map('intval', $data['filter_manufacturers']);
            $sql .= " AND p.manufacturer_id IN (" . implode(',', $ids) . ")";
            }
            
            if (!empty($data['filter_colors'])) {
                $escaped_colors = array_map([$this->db, 'escape'], $data['filter_colors']);
                $escaped_colors = array_map(function($color) {
                    return "'" . $color . "'";
                }, $escaped_colors);
            
                $sql .= " AND p.product_id IN (
                    SELECT product_id FROM " . DB_PREFIX . "product_variants
                    WHERE variant_name IN (" . implode(",", $escaped_colors) . ")
                )";
            }
            
            if (!empty($data['filter_sizes'])) {
                $sizes = array_map('intval', $data['filter_sizes']);
                $sql .= " AND p.product_id IN (
                    SELECT product_id FROM " . DB_PREFIX . "product_option_value
                    WHERE option_value_id IN (" . implode(',', $sizes) . ")
                )";
            }
            
            if (!empty($data['filter_discounts'])) {
                $conditions = [];
                foreach ($data['filter_discounts'] as $percent) {
                    $percent = (int)$percent;
                    $conditions[] = "
                    (
                        SELECT 
                            ((p.price - ps.price) / p.price) * 100 
                        FROM " . DB_PREFIX . "product_special ps
                        WHERE ps.product_id = p.product_id
                        AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
                        AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
                        AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
                        ORDER BY ps.priority ASC, ps.price ASC 
                        LIMIT 1
                    ) >= {$percent}
                    ";
                }
                $sql .= " AND (" . implode(" OR ", $conditions) . ")";
            }
            
            if (!empty($data['filter_ratings'])) {
                $conditions = [];
                foreach ($data['filter_ratings'] as $rating) {
                    $rating = (int)$rating;
                    $conditions[] = "(SELECT AVG(rating) FROM " . DB_PREFIX . "review r WHERE r.product_id = p.product_id AND r.status = 1) >= {$rating}";
                }
                $sql .= " AND (" . implode(" OR ", $conditions) . ")";
            }
            
            if (!empty($data['min_price'])) {
                $sql .= " AND p.price >= " . (float)$data['min_price'];
            }
            if (!empty($data['max_price'])) {
                $sql .= " AND p.price <= " . (float)$data['max_price'];
            }
            
            
            // filter pagination  end 
            

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				// if (!empty($data['filter_description'])) {
				// 	$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				// }
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getProfile($product_id, $recurring_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r JOIN " . DB_PREFIX . "product_recurring pr ON (pr.recurring_id = r.recurring_id AND pr.product_id = '" . (int)$product_id . "') WHERE pr.recurring_id = '" . (int)$recurring_id . "' AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

		return $query->row;
	}

	public function getProfiles($product_id) {
		$query = $this->db->query("SELECT rd.* FROM " . DB_PREFIX . "product_recurring pr JOIN " . DB_PREFIX . "recurring_description rd ON (rd.language_id = " . (int)$this->config->get('config_language_id') . " AND rd.recurring_id = pr.recurring_id) JOIN " . DB_PREFIX . "recurring r ON r.recurring_id = rd.recurring_id WHERE pr.product_id = " . (int)$product_id . " AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getTotalProductSpecials() {
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
// 	check pincode
	public function getCustomerPostcode($customer_id)
	{
		$query = $this->db->query("
        SELECT a.postcode 
        FROM " . DB_PREFIX . "customer c 
        JOIN " . DB_PREFIX . "address a ON c.address_id = a.address_id 
        WHERE c.customer_id = '" . $customer_id . "'
    ");

		if ($query->num_rows) {
			return $query->row['postcode'];
		}

		return '';
	}


	public function getCourierCharges($product_id, $customer_pincode)
	{
		$query = $this->db->query("SELECT vendor_id FROM " . DB_PREFIX . "vendor_to_product WHERE product_id = '" . (int)$product_id . "'");

		$vendor_id = $query->num_rows ? $query->row['vendor_id'] : 0;
		$query = $this->db->query("SELECT postcode FROM " . DB_PREFIX . "vendor WHERE vendor_id = '" . (int)$vendor_id . "'");

		$vendor_pincode = $query->num_rows ? $query->row['postcode'] : '';
		// converting int to string 
		$vendor_pincode = trim((string)$vendor_pincode);
		$customer_pincode = trim((string)$customer_pincode);

		$vendorResult = $this->db->query("SELECT * FROM " . DB_PREFIX . "city_pincode WHERE pincode = " . (int)$vendor_pincode);

		$vendor_city = $vendorResult->row['city'] ?? '';
		$vendor_state = $vendorResult->row['state'] ?? '';

		// $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city_pincode WHERE pincode = '" . $this->db->escape($customer_pincode) . "'");
		$customer_result = $this->db->query("SELECT * FROM " . DB_PREFIX . "city_pincode WHERE pincode = " . (int)$customer_pincode);

		$customer_city = $customer_result->row['city'] ?? '';
		$customer_state = $customer_result->row['state'] ?? '';
		if ($vendor_city === $customer_city && $vendor_state === $customer_state) {
			$delivery_type = 'local';
		} elseif ($vendor_state === $customer_state) {
			$delivery_type = 'zonal';
		} else {
			$delivery_type = 'national';
		}

		// Step 6: Get courier charges for product
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_courier_charges WHERE product_id = " . (int)$product_id);
		// if (!$query->num_rows) return false;
		$charges = $query->row;

		// Step 8: Return only current delivery type charge
		
		$charge_map = [
			'local' => $charges['local_charges']?$charges['local_charges']:null,
			'zonal' => $charges['zonal_charges']?$charges['zonal_charges']:null,
			'national' => $charges['national_charges']?$charges['national_charges']:null
		];

		return [
			'delivery_type' => $delivery_type,
			'courier_charge' => (float)$charge_map[$delivery_type],
			'freeCharges' => $charges['courier_free_price']?$charges['courier_free_price']:null,
			'local_charges'=> $charges['local_charges']?$charges['local_charges']:0,
			'customer_city' => $customer_city,
			// 'customer_state' => $customer_state,
			'vendor_city' => $vendor_city,
			// 'vendor_state' => $vendor_state,
			'customer_pincode' => $customer_pincode,
			// 'vendor_pincode' => $vendor_pincode,
			// 'charges' => $charges,
			// 'product_id' => $product_id
			// 'is_free' => false
		];
	}
public function getProductFree(int $product_id) {
    $sql  = "SELECT courier_free_price
             FROM " . DB_PREFIX . "product_courier_charges
             WHERE product_id = " . $product_id;
    $query = $this->db->query($sql);
    return isset($query->row['courier_free_price'])
        ? $query->row['courier_free_price']
        : null;
}

		public function getProductByModel($model) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($model) . "' LIMIT 1");
    return $query->row;
}

// 		to display seller name on there product page 03-05-2025
public function getVendorInfoByProductId($product_id) {
		$query = $this->db->query("
			SELECT v.vendor_id, v.display_name, v.company 
			FROM " . DB_PREFIX . "vendor_to_product vtp 
			JOIN " . DB_PREFIX . "vendor v ON vtp.vendor_id = v.vendor_id 
			WHERE vtp.product_id = '" . (int)$product_id . "'
		");
	
		return $query->rows; // returns an array of vendor info
	}
	
// 	keyhighlights and faq 
 public function getProductDescription($product_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

    return $query->row;
}


// 	keyhighlights and faq  end

// warranty return replacement start 
	
public function getReplacementPolicyByProductId($product_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_replacement_policy WHERE product_id = '" . (int)$product_id . "'");

    if ($query->num_rows) {
        return $query->row;
    }

    return null;
}

public function getWarrantyByProductId($product_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_warranty WHERE product_id = '" . (int)$product_id . "'");

    if ($query->num_rows) {
        return $query->row;
    }

    return null;
}
public function getReturnPolicyByProductId($product_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_return_policy WHERE product_id = '" . (int)$product_id . "'");

    if ($query->num_rows) {
        return $query->row;
    }

    return null;
}

// warranty return replacement end 
// filter start 


	public function getAvailableSizes($category_id)
	{
		$sql = "SELECT DISTINCT pov.option_value_id, ovd.name
            FROM " . DB_PREFIX . "product_option_value pov
            LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON pov.option_value_id = ovd.option_value_id
            LEFT JOIN " . DB_PREFIX . "product_to_category pc ON pov.product_id = pc.product_id
            WHERE ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if ($category_id) {
			$sql .= " AND pc.category_id = '" . (int)$category_id . "'";
		}

		$sql .= " ORDER BY ovd.name";
		return $this->db->query($sql)->rows;
	}



	public function getAvailableSizesByMultipleCategories($category_ids = [])
	{
		if (empty($category_ids)) return [];

		$category_ids_str = implode(',', array_map('intval', $category_ids));

		$query = $this->db->query("
        SELECT DISTINCT pov.option_value_id, ovd.name
        FROM " . DB_PREFIX . "product_option_value pov
        LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON pov.option_value_id = ovd.option_value_id
        LEFT JOIN " . DB_PREFIX . "product_to_category pc ON pov.product_id = pc.product_id
        WHERE ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'
        AND pc.category_id IN ($category_ids_str)
    ");

		return $query->rows;
	}
	public function getSizesByKeyword($product_id0)
	{
		$language_id = (int)$this->config->get('config_language_id');

		$query = $this->db->query("
    SELECT DISTINCT ovd.option_value_id, ovd.name
    FROM " . DB_PREFIX . "product_option_value pov
    INNER JOIN " . DB_PREFIX . "option_value ov ON pov.option_value_id = ov.option_value_id
    INNER JOIN " . DB_PREFIX . "option_value_description ovd ON pov.option_value_id = ovd.option_value_id
    WHERE pov.product_id = '" . (int)$product_id0 . "'
      AND ovd.language_id = '" . (int)$language_id . "'
    ORDER BY ovd.name ASC
");

		return $query->rows;
	}
	
// -----------------------------------------------------------------------color-----------




public function getAvailableColorsByCategory($category_id) {
    $query = $this->db->query("
        SELECT DISTINCT pv.variant_name 
        FROM " . DB_PREFIX . "product_variants pv
        LEFT JOIN " . DB_PREFIX . "product_to_category pc ON pv.product_id = pc.product_id
        WHERE pc.category_id = '" . (int)$category_id . "'
          AND pv.variant_name != ''
        ORDER BY pv.variant_name ASC
    ");

    return $query->rows;
}



public function getAvailableColorsBySearch($search) {
    $query = $this->db->query("
        SELECT DISTINCT pv.variant_name 
        FROM " . DB_PREFIX . "product_variants pv
        LEFT JOIN " . DB_PREFIX . "product_description pd ON pv.product_id = pd.product_id
        WHERE pd.name LIKE '%" . $this->db->escape($search) . "%'
          AND pv.variant_name != ''
        ORDER BY pv.variant_name ASC
    ");

    return $query->rows;
}



public function getAllAvailableColors() {
    $query = $this->db->query("
        SELECT DISTINCT variant_name 
        FROM " . DB_PREFIX . "product_variants
        WHERE variant_name != ''
        ORDER BY variant_name ASC
    ");

    return $query->rows;
}



// -----------------------------------------------Brand---------------------------


public function getAvailableBrandsByCategory($category_id) {
    $query = $this->db->query("
        SELECT DISTINCT m.manufacturer_id, m.name
        FROM " . DB_PREFIX . "product p
        LEFT JOIN " . DB_PREFIX . "product_to_category pc ON p.product_id = pc.product_id
        LEFT JOIN " . DB_PREFIX . "manufacturer m ON p.manufacturer_id = m.manufacturer_id
        WHERE pc.category_id = '" . (int)$category_id . "' AND m.name IS NOT NULL
        ORDER BY m.name ASC
    ");
    return $query->rows;
}



public function getAvailableBrandsBySearch($search) {
    $query = $this->db->query("
        SELECT DISTINCT m.manufacturer_id, m.name
        FROM " . DB_PREFIX . "product p
        LEFT JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id
        LEFT JOIN " . DB_PREFIX . "manufacturer m ON p.manufacturer_id = m.manufacturer_id
        WHERE pd.name LIKE '%" . $this->db->escape($search) . "%' AND m.name IS NOT NULL
        ORDER BY m.name ASC
    ");
    return $query->rows;
}


public function getAllAvailableBrands() {
    $query = $this->db->query("
        SELECT DISTINCT m.manufacturer_id, m.name
        FROM " . DB_PREFIX . "manufacturer m
        LEFT JOIN " . DB_PREFIX . "product p ON m.manufacturer_id = p.manufacturer_id
        WHERE m.name IS NOT NULL
        ORDER BY m.name ASC
    ");
    return $query->rows;
}

public function getAvailableDiscountsByCategory($category_id) {
    $query = $this->db->query("
        SELECT DISTINCT
            FLOOR((p.price - ps.price) / p.price * 100) AS discount
        FROM " . DB_PREFIX . "product p
        LEFT JOIN " . DB_PREFIX . "product_special ps ON p.product_id = ps.product_id
        LEFT JOIN " . DB_PREFIX . "product_to_category pc ON p.product_id = pc.product_id
        WHERE ps.price > 0 AND p.price > 0 AND pc.category_id = '" . (int)$category_id . "'
        ORDER BY discount ASC
    ");

    return $query->rows;
}




public function getAvailableDiscountsBySearch($search) {
    $query = $this->db->query("
        SELECT DISTINCT
            FLOOR((p.price - ps.price) / p.price * 100) AS discount
        FROM " . DB_PREFIX . "product p
        LEFT JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id
        LEFT JOIN " . DB_PREFIX . "product_special ps ON p.product_id = ps.product_id
        WHERE pd.name LIKE '%" . $this->db->escape($search) . "%' 
        AND ps.price > 0 AND p.price > 0
        ORDER BY discount ASC
    ");

    return $query->rows;
}





public function getAllAvailableDiscounts() {
    $query = $this->db->query("
        SELECT DISTINCT
            FLOOR((p.price - ps.price) / p.price * 100) AS discount
        FROM " . DB_PREFIX . "product p
        LEFT JOIN " . DB_PREFIX . "product_special ps ON p.product_id = ps.product_id
        WHERE ps.price > 0 AND p.price > 0
        ORDER BY discount ASC
    ");

    return $query->rows;
}

// 	filter end 

// ---------------------------------------------------Rating-------------------------------------

public function getAvailableRatingsByCategory($category_id) {
    $query = $this->db->query("
        SELECT DISTINCT r.rating
        FROM " . DB_PREFIX . "review r
        LEFT JOIN " . DB_PREFIX . "product_to_category pc ON r.product_id = pc.product_id
        WHERE r.status = 1 AND pc.category_id = '" . (int)$category_id . "'
        ORDER BY r.rating DESC
    ");
    return $query->rows;
}




public function getAvailableRatingsBySearch($search) {
    $query = $this->db->query("
        SELECT DISTINCT r.rating
        FROM " . DB_PREFIX . "review r
        LEFT JOIN " . DB_PREFIX . "product_description pd ON r.product_id = pd.product_id
        WHERE r.status = 1 AND pd.name LIKE '%" . $this->db->escape($search) . "%'
        ORDER BY r.rating DESC
    ");
    return $query->rows;
}



public function getAllAvailableRatings() {
    $query = $this->db->query("
        SELECT DISTINCT rating
        FROM " . DB_PREFIX . "review
        WHERE status = 1
        ORDER BY rating DESC
    ");
    return $query->rows;
}



// ----------------------------------------------------Price-------------------------------------


// ✅ For search keyword
public function getPriceRangeBySearch($search) {
    $language_id = (int)$this->config->get('config_language_id');

    $sql = "
        SELECT MIN(p.price) AS min, MAX(p.price) AS max
        FROM " . DB_PREFIX . "product p
        LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
        WHERE p.status = 1 AND pd.language_id = '" . (int)$language_id . "'
          AND pd.name LIKE '%" . $this->db->escape($search) . "%'
    ";

    $query = $this->db->query($sql);
    return $query->row;
}

// ✅ For category
public function getPriceRangeByCategory($category_id) {
    $sql = "
        SELECT MIN(p.price) AS min, MAX(p.price) AS max
        FROM " . DB_PREFIX . "product p
        LEFT JOIN " . DB_PREFIX . "product_to_category pc ON (p.product_id = pc.product_id)
        WHERE p.status = 1 AND pc.category_id = '" . (int)$category_id . "'
    ";

    $query = $this->db->query($sql);
    return $query->row;
}




public function getAllPriceRange() {
    $query = $this->db->query("
        SELECT MIN(p.price) as min, MAX(p.price) as max
        FROM " . DB_PREFIX . "product p
        WHERE p.status = 1
    ");
    return $query->row;
}

//faq starts
public function getProductFaqs($product_id) {
    $query = $this->db->query("SELECT question, answer, date_added FROM " . DB_PREFIX . "product_faq 
                               WHERE product_id = '" . (int)$product_id . "' 
                               AND TRIM(question) != '' 
                               AND TRIM(answer) != '' 
                               AND status = 1");

    return $query->rows;
}


public function addProductFaq($data) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_faq SET 
        product_id = '" . (int)$data['product_id'] . "', 
        customer_id = '" . (int)$data['customer_id'] . "', 
        language_id = '" . (int)$data['language_id'] . "', 
        question = '" . $this->db->escape($data['question']) . "', 
        answer = '', 
        date_added = NOW(), 
        status = 0");
}
//faq ends
public function isProductPrepaid($product_id) {
    $query = $this->db->query("SELECT payment_method FROM " . DB_PREFIX . "product WHERE product_id = " . (int)$product_id);

    if ($query->num_rows && strtolower($query->row['payment_method']) == 'prepaid') {
        return true;
    }

    return false;
}

        // added on 05-07-5025 for geolocation
        
        public function getVendorPostcodeByProductId($product_id) {
            $query = $this->db->query("SELECT vendor_id FROM " . DB_PREFIX . "vendor_to_product WHERE product_id = '" . (int)$product_id . "'");
            if (!$query->num_rows) return '';
        
            $vendor_id = $query->row['vendor_id'];
        
            $vendor_query = $this->db->query("SELECT postcode FROM " . DB_PREFIX . "vendor WHERE vendor_id = '" . (int)$vendor_id . "'");
            if (!$vendor_query->num_rows) return '';
        
            return $vendor_query->row['postcode'];
        }
        public function getActiveFirstTimeOffer($customer_id) {
		// Check if the customer has any orders
		$order_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order WHERE customer_id = '" . (int)$customer_id . "'");
		if ($order_query->row['total'] == 0) {
			// Fetch the latest enabled first time offer
			$offer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ipoffer WHERE offer_type = 'first_time' AND status = 1 ORDER BY date_added DESC LIMIT 1");
			return $offer_query->row;
		}
		return false;
	}

	public function getActiveReferralOffer($customer_id) {
		// Check if customer has approved referral
		$referral_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ipoffer_referral_customers WHERE customer_id = '" . (int)$customer_id . "' AND status = 1");
		if ($referral_query->num_rows > 0) {
			// Fetch the latest enabled referral offer
			$offer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ipoffer WHERE offer_type = 'referral' AND status = 1 ORDER BY date_added DESC LIMIT 1");
			return $offer_query->row;
		}
		return false;
	}

	public function getOfferById($offer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ipoffer WHERE ipoffer_id = '" . (int)$offer_id . "'");
		return $query->row;
	}

    }
