<?php
// File: catalog/model/catalog/category_group.php

class ModelCatalogCategoryGroup extends Model { // Changed class name
    public function getChildCategoriesWithProduct($parent_id) {
        $categories = [];

        // Step 1: Get all child categories of the given parent from standard category tables
       
        $query = $this->db->query("
            SELECT c.category_id, cd.name, c.image, c.parent_id, c.level
            FROM " . DB_PREFIX . "category c
            LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
            WHERE c.parent_id = '" . (int)$parent_id . "' AND c.status = '1' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
            ORDER BY c.sort_order ASC
        ");

        foreach ($query->rows as $category) {
            
              $category_id = (int)$category['category_id'];
            $level = (int)$category['level'];
                $columnLevels = [
        'category_level_1',
        'category_level_2',
        'category_level_3',
        'category_level_4',
        'category_level_5'
    ];
  $column_name = $columnLevels[$level] ?? 0;
            // Step 2: Get ANY one product in this category (lowest price with status 1)
            $product = $this->db->query("
                SELECT p.product_id, p.price, p.image
                FROM " . DB_PREFIX . "vendor_product_category vpc
                LEFT JOIN " . DB_PREFIX . "product p ON (vpc.product_id = p.product_id)
                WHERE vpc." . $column_name . " = '" . $category_id . "'  AND p.status = '1' AND p.price > 0
                ORDER BY p.price ASC, p.product_id ASC
                LIMIT 1
            ");

            if ($product->num_rows > 0) {
                $product_id = (int)$product->row['product_id'];
                $product_image = $product->row['image'];

                // Step 3: Fallback to additional product image if main is missing or placeholder
                if (empty($product_image) || $product_image == 'no_image.png') {
                    $image_query = $this->db->query("
                        SELECT image FROM " . DB_PREFIX . "product_image
                        WHERE product_id = '" . $product_id . "'
                        ORDER BY sort_order ASC LIMIT 1
                    ");

                    if ($image_query->num_rows) {
                        $product_image = $image_query->row['image'];
                    }
                }

                // Step 4: Append product info to category
                $categories[] = [
           
                    'category_id' => $category['category_id'],
                    'level' => $category['level'],
                    'name'        => $category['name'],
                    'image'       => $category['image'], // Category's main image
                    'parent_id'   => $category['parent_id'],
                    'product'     => [
                        'product_id' => $product_id,
                        'price'      => $product->row['price'],
                        'image'      => $product_image
                    ]
                ];
            } else {
                 // If no product found, still add the category with null product info
                $categories[] = [
                    'category_id' => $category['category_id'],
                    'level' => $category['level'],
                    'name'        => $category['name'],
                    'image'       => $category['image'], // Category's main image
                    'parent_id'   => $category['parent_id'],
                    'product'     => [
                        'product_id' => null,
                        'price'      => null,
                        'image'      => null
                    ]
                ];
            }
        }

        return $categories;
    }
}