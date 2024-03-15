<?php

namespace App\Repository\Faq;
use Exception;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class FaqRepository implements FaqInterface
{
 
   private $model;

   public function __construct(Faq $model){
      $this->model = $model;
   }


   public function getAllFaqs(){
      return  $this->model::all()->toArray();
   }

   public function deleteQuestion($id){
      return  $this->model->where('id', $id)->delete();
   }

   public function updateFaqs($data){

      try {
          $updateQuery1 = "UPDATE faqs SET question = CASE";
          $updateQuery2 = "UPDATE faqs SET reponse = CASE";

          foreach ($data as $key => $value) {
          if ($value["type"] == "question") {
              $updateQuery1 = $updateQuery1 . "  WHEN id = ". $value['id']." THEN ". "'".$value['contenu']."'";
          }else{
              $updateQuery2 = $updateQuery2 . "  WHEN id = ". $value['id']." THEN ". "'".$value['contenu']."'";
          }
          }

          
          $updateQuery1 = $updateQuery1 ." ELSE 'question' END";
          $updateQuery2 = $updateQuery2 ." ELSE 'reponse' END";
          

          if ($updateQuery1 != "UPDATE faqs SET question = CASE ELSE 'question' END") {
              $response1 = DB::update($updateQuery1);
          }
          if ($updateQuery2 != "UPDATE faqs SET question = CASE ELSE 'question' END") {
              $response2 = DB::update($updateQuery2);
          }
          return true;
      } catch (Exception $e) {
            return $e->getMessage();
        }
  }

   public function insertQuestion($tab_insert){
      return $this->model::insert($tab_insert);
   }  
      
}      
