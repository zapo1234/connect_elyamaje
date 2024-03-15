<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Service\CallApi\Api;
use App\Repository\Product\PrepaProductRepository;
use App\Http\Controllers\Controller;

class SynchroController extends Controller
{
    
    
    private $api;
    private $products;

    public function __construct(
        Api $api,
        PrepaProductRepository $products

    ){
        $this->api = $api;
        $this->products = $products;

    }



    public function syncProducts(){
        $per_page = 100;
        $page = 1;
        $products = $this->api->getAllProducts($per_page, $page);
        $count = count($products);
        $insert_products = [];

        // Check if others page
        if($count == 100){
          while($count == 100){
            $page = $page + 1;
            $products_other = $this->api->getAllProducts($per_page, $page);
           
            if(count($products_other ) > 0){
              $products = array_merge($products, $products_other);
            }
            $count = count($products_other);
          }
        }  


       
        foreach($products as $product){

            $barcode = $this->getValueByKey($product['meta_data'], "barcode");
            $category_name = [];
            $category_id = [];

            foreach($product['categories'] as $cat){
                $category_name[] = $cat['name'];
                $category_id[] = $cat['id'];
            }
            
            $variation = false;
            foreach($product['attributes'] as $attribut){
                if($attribut['variation']){
                    $variation = $attribut['name'];
                }
            }

            if($variation){
                $ids = array_column($product['attributes'], "name");
                $clesRecherchees = array_keys($ids,  $variation);
            }

            if($variation && count($product['variations']) > 0){
                $option = $product['attributes'][$clesRecherchees[0]]['options'];
                foreach($option as $key => $op){
                    if(isset($product['variations'][$key])){
                        $insert_products [] = [
                            'product_woocommerce_id' => $product['variations'][$key],
                            'category' =>  implode(',', $category_name),
                            'category_id' => implode(',', $category_id),
                            'variation' => 1,
                            'name' => $product['name'].' - '.$op,
                            'status' => $product['status'],
                            'price' => $product['variation_prices'][$key],
                            'barcode' => $product['barcodes_list'][$key],
                            'manage_stock' => $product['manage_stock_variation'][$key] == "yes" ? 1 : 0,
                            'stock' => $product['stock_quantity_variation'][$key]
                        ];
                    }
                }
            } else {
                $insert_products [] = [
                    'product_woocommerce_id' => $product['id'],
                    'category' =>  implode(',', $category_name),
                    'category_id' => implode(',', $category_id),
                    'variation' => 0,
                    'name' => $product['name'],
                    'status' => $product['status'],
                    'price' => $product['price'],
                    'barcode' => $barcode,
                    'manage_stock' => $product['manage_stock'],
                    'stock' => $product['stock_quantity']
                ];
            }
        }

        $sync = $this->products->insertProductsOrUpdate($insert_products);

        if($sync){
            return('true'); 
        } else {
            return('succes');
        }
    }

    
      // Fonction pour récupérer la valeur avec une clé spécifique
    private function getValueByKey($array, $key) {
        foreach ($array as $item) {
            if ($item['key'] === $key) {
                return $item['value'];
            }
        }
        return null; // Si la clé n'est pas trouvée
    }
    
    
}
