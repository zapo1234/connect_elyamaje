<?php

namespace App\Repository\Admin;

use DateTime;
use Illuminate\Http\Request;
use Automattic\WooCommerce\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use App\Repository\Users\UserRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;




class ServiceFunctionAdmin extends Model
{

    function getAllFaqs(){
        return DB::table('faqs')->get()->toArray();
    }

    Function updateFaqs($data){

        $ids1 = array();
        $ids2 = array();

        try {
            $updateQuery1 = "UPDATE faqs SET question = CASE";
            $updateQuery2 = "UPDATE faqs SET reponse = CASE";

            foreach ($data as $key => $value) {
                if ($value["type"] == "question") {
                    $updateQuery1 = $updateQuery1 . '  WHEN id = '. $value['id'].' THEN '. '"'.$value['contenu'].'"';
                    array_push($ids1,$value['id']);
                }else{
                    $updateQuery2 = $updateQuery2 . '  WHEN id = '. $value['id'].' THEN '. '"'.$value['contenu'].'"';
                    array_push($ids2,$value['id']);
                }
            }
            $ids1_str = implode(",",$ids1);
            $ids2_str = implode(",",$ids2);

            $updateQuery1 = $updateQuery1 .' ELSE "question" END WHERE id IN ('.$ids1_str.')';
            $updateQuery2 = $updateQuery2 .' ELSE "reponse" END WHERE id IN ('.$ids2_str.')';

                       

            if ($ids1_str) {
                $response1 = DB::statement($updateQuery1);
            }
            if ($ids2_str) {
                $response2 = DB::statement($updateQuery2);
            }
            return true;
        } catch (\Throwable $th) {

            dd($th);
            return false;
        }

        
    }

    function insertQuestion($tab_insert){
        return DB::table('faqs')
                ->insert($tab_insert);
    }

    function deleteQuestion($id){
        return DB::table('faqs')
                ->where('id', $id)
                ->delete();
    }

    

    
}