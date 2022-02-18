<?php

class Product extends MY_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function getAllProducts() {
        $this->db->select(
            'p.id,
             p.product_name,
             p.product_barcode,
              p.product_sku,
             p.vendor_product_sku,
             p.category_id,
             p.subcategory_id,
             p.product_description,
             p.base_price,
             p.sale_price,
             p.size_id,
             p.color_id,
             p.push_demand_booked,
             p.sale_category,
             p.story_id,
             p.season_id,
             p.product_type,
             p.hsn_code,
             p.user_id,
             p.gst_inclusive,
             p.custom_product,
             p.arnon_product,
             p.supplier_name,
         
             p.product_rate_updated,
             p.status,
             p.is_deleted,
             p.created_at
            
            '
        );

        $this->db->from('pos_product_master as p');
        // $this->db->where('p.is_deleted =', 0);
        // $this->db->join('pos_product_images as i', 'p.id = i.product_id');
     

        // $this->db->offset(0);
        $this->db->limit(5);
        $this->db->order_by('p.id DESC');

        $products = $this->db->get()->result_array();

        
        foreach($products as $key => $p){
            // var_dump($p); exit;
            // $products[$key]['image_name'] = BASEURL.'upload/'.$p['image_name'];
            // $products[$key]['image_title'] = BASEURL.'upload/'.$p['image_title'];
            // $products[$key]['image_type'] = $p['image_type'];
            // $products[$key]['isAddedToCart'] = false;
            // $products[$key]['cartQuantity'] = null;

            $this->db->select(
                'i.image_name,
                 i.image_title,
                 i.image_type 
                '
            );
            
        $this->db->from('pos_product_images as i');
        $this->db->where('i.product_id =', $p["id"]);

        $image = $this->db->get()->result_array();

        $products[$key]['image'] =  $image;

        }

   

       
    
        echo json_encode($products);
        exit();
    }





     //  p.product_sku,
            //  p.vendor_product_sku,
            //  p.category_id,
            //  p.subcategory_id,
            //  p.product_description,
            //  p.base_price,
            //  p.sale_price,
            //  p.size_id,
            //  p.color_id,
            //  p.push_demand_booked,
            //  p.sale_category,
            //  p.story_id,
            //  p.season_id,
            //  p.product_type,
            //  p.hsn_code,
            //  p.user_id,
            //  p.gst_inclusive,
            //  p.custom_product,
            //  p.arnon_product,
            //  p.supplier_name,
            // i.image_name,
            // i.image_title,
            // i.image_type





//CLASS ENDS
}