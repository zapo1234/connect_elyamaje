<?php

namespace App\Http\Controllers\Superadmin;
use Mail;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Service\CallApi\Apicall;
use App\Repository\Admin\ServiceFunctionAdmin;


class ControllerCalculManuel extends Controller
{
    public function __construct(
        
        ServiceFunctionAdmin $serviceFunctionAdmin
    )
        {
            
            $this->serviceFunctionAdmin = $serviceFunctionAdmin;
            
        }


    
  function faqAdmin(){

         $dataQuestions = $this->serviceFunctionAdmin->getAllFaqs();
       
        // dd($dataQuestions);
        return view('superadmin.faqAdmin',['dataQuestions'=>$dataQuestions]);
    }

    function faqAdminPost(Request $request){

        try {
            $input = $request->all();
            unset($input["_token"]);
            $tab_update = array();
            $tab_insert = array();

            

            if (isset($input["question"])) {
                array_push($tab_insert, ["question" => $input["question"], "reponse" => $input["reponse"]]);
            }
            unset($input["question"]);
            unset($input["reponse"]);


            // voir si au moins un champ existant a été modifié

            if ($input) {

                foreach ($input as $key => $value) {
                    $valueTab = explode("_",$key);
                    if ($valueTab[0] == "question") {
                        array_push($tab_update, ["id" => $valueTab[1], "type" => $valueTab[0], "contenu" => $value]);
                    }else {
                        array_push($tab_update, ["id" => $valueTab[1], "type" => $valueTab[0], "contenu" => $value]);
                    }
                }

                $questions_update = $this->serviceFunctionAdmin->updateFaqs($tab_update);
            }
            if ($tab_insert) {
                // inserer la nouvel question
                $questions_insert = $this->serviceFunctionAdmin->insertQuestion($tab_insert);
                
            }
            return redirect()->back()->with('success', 'L\'insertion a été faite avec succée');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Une erreur s\'est produite');
        }
        
    }

    function faqAdminDelete(){

        $id = $_POST['id'];

        $questions_delete = $this->serviceFunctionAdmin->deleteQuestion($id);

        return $questions_delete;
    }

    

}