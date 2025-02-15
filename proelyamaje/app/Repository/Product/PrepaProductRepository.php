<?php

namespace App\Repository\Product;

use Hash;
use Exception;
use Carbon\Carbon;
use App\Models\PrepaProduct;
use Illuminate\Support\Facades\DB;

class PrepaProductRepository implements PrepaProductInterface

{

   private $model;

   public function __construct(PrepaProduct $model){

      $this->model = $model;
   }

   public function getAllProducts(){
      return $this->model::all();
   }

   public function getAllProductsPublished(){
      return $this->model::select('*')->where('status', 'publish')->where('stock','>', 10)->get();
   }

   public function insertProductsOrUpdate($products){
      try{
         // Récupère les produits déjà existants
         try{
            $products_exists = $this->model::select('name', 'product_woocommerce_id')->get()->toArray();
         } catch(Exception $e){
            return $e->getMessage();
         }


         // Aucun existants
         if(count($products_exists) == 0){
           
            try{
               return $this->model->insert($products);
            } catch(Exception $e){
               return $e->getMessage();
            }
           
         } else {
               $difference = [];
               foreach ($products as $item1) {
                  $found = false;

                  foreach ($products_exists as $item2) {
                     if ($item1['product_woocommerce_id'] == $item2['product_woocommerce_id']) {
                           if($item1 != $item2){
                              $found = false;
                              break;
                           } else {
                              $found = true;
                              break;
                           }
                     }
                  }
                  
                  if (!$found) {
                     $difference[] = $item1;
                  }
               }

               if (!empty($difference)) {

                  foreach ($difference as $diff) {
                    
                     try{
                        $update = $this->model::where('product_woocommerce_id', $diff['product_woocommerce_id'])->update($diff);
                     } catch(Exception $e){
                        return $e->getMessage();
                     }
            
                     if($update == 0){
                        $this->model->insert($diff);
                     }
                  }
               } 

               return true;
         }
      } catch(Exception $e){
         return $e->getMessage();
      }

   }
}























