<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class product_model extends MY_Model
{
    protected $_table = 'products';
    protected $soft_delete = TRUE;

    function __construct()
    {
        parent::__construct();
    }


    public function defaultSettings()
    {
        $product = new stdClass();
        $product->pinyin = '';
        $product->latin_name = '';
        $product->common_name = '';
        $product->brand_id = '';
        $product->concentration = '';
        $product->costPerGram = '';
        $product->id = 0;

        return $product;
    }

    public function filter($input)
    {

        if (is_array($input) AND !empty($input)) {

            foreach ($input as $key => $value) {
                $input[$key] = trim(strip_tags($value));
            }

            return $input;

        } else {
            return FALSE;
        }

    }

    public function fetch_products($limit, $start)
    {
        $sql = "SELECT
                products.id,
                products.pinyin,
                products.latin_name,
                products.common_name,
                products.brand_id,
                brands.name as brand_name,
                products.concentration,
                products.costPerGram,
                products.deleted
                FROM `products`
                JOIN `brands` ON products.brand_id = brands.id
                WHERE products.deleted = 0
                ORDER BY products.pinyin
                LIMIT $start , $limit";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }

            return $data;

        }

        return false;

    }

    public function getProductsApi()
    {

//        $this->db->select('pinyin,common_name,	');
        $sql = "SELECT
                products.id,
                products.pinyin,
                products.common_name,
                
                products.concentration,
                products.costPerGram,
                brands.name as brand_name
                FROM `products`
                JOIN `brands` ON products.brand_id = brands.id
                WHERE products.deleted = 0";
		$query = $this->db->query($sql);
		$data = $query->result_array();
        return $data;
    }

    public function fetchByCategory($category,$limit,$start)
    {

        $sql = "SELECT
                products.id,
                products.pinyin,
                products.latin_name,
                products.common_name,
                products.brand_id,
                products.concentration,
                products.costPerGram,
                brands.name as brand_name
                FROM `products`
                JOIN `brands` ON products.brand_id = brands.id
                WHERE products.type_id = $category
                AND products.deleted = 0
                LIMIT $start , $limit";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }

            return $data;

        }

        return false;
    }

    public function getProductsJson(){

        $products = $this->getProductsApi();

        $data = array();
        foreach($products as $row){

            $data[] = array(
                'label' => $row['pinyin'],
								'brand' => $row['brand_name'],
								'concentration' => "Concentration: " . $row['concentration'], 
                'value' => $row['pinyin'],
                'cost_per_gram' => $row['costPerGram'],
                'id' => $row['id']
            );

        }

        return json_encode($data);

    }



} 