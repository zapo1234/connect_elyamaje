<?php

// recuperer des utilitaires

namespace App\Http\Service\CallApi;



use Exception;

use Illuminate\Http\Request;

use Automattic\WooCommerce\Client;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Storage;
use Automattique\WooCommerce\HttpClient\HttpClientException;



class Apicall

{

     /** 

     *@return array

     */

     public function getData(string $url): array

     {

         $response = Http::get($url);

         return $response->json();

     }


    public function insertCronRequest($data, $return = true){

      $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiMjkyZmIwNDY5NmQ2MDE5NDU1MDNiZTA2NTVkZTExNWM1MDIxYmIzOTNjNDk4MWZmZjk4MjA4ZGY5ZmE4NGNjOGI4N2M1MmVhMDkzYTdjZmEiLCJpYXQiOjE2ODIzMjYyOTEuMjMwNTE3LCJuYmYiOjE2ODIzMjYyOTEuMjMwNTQxLCJleHAiOjQ4MzgwMDM0OTAuODExMTM3LCJzdWIiOiIiLCJzY29wZXMiOlsiKiJdfQ.Gk2PIxGYUHsvwRuTMxzmZ8o4iip8qdoaowIgDbBceAXqic9Kb_MmflUKkcGSKiICSR8DvcRjVCuF5waFyyEkvQ";
      $url = "https://www.cron.elyamaje.com/api/cron";
      $ch = curl_init(); 
      curl_setopt($ch, CURLOPT_URL, $url); 
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token)); 
      $response = curl_exec($ch); 
      curl_close($ch); 

      if($return){
        echo $response;
      }

    }

    public function getCronRequest($field = false, $value = false){

      $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiMjkyZmIwNDY5NmQ2MDE5NDU1MDNiZTA2NTVkZTExNWM1MDIxYmIzOTNjNDk4MWZmZjk4MjA4ZGY5ZmE4NGNjOGI4N2M1MmVhMDkzYTdjZmEiLCJpYXQiOjE2ODIzMjYyOTEuMjMwNTE3LCJuYmYiOjE2ODIzMjYyOTEuMjMwNTQxLCJleHAiOjQ4MzgwMDM0OTAuODExMTM3LCJzdWIiOiIiLCJzY29wZXMiOlsiKiJdfQ.Gk2PIxGYUHsvwRuTMxzmZ8o4iip8qdoaowIgDbBceAXqic9Kb_MmflUKkcGSKiICSR8DvcRjVCuF5waFyyEkvQ";
      if($field && $value){
        $url = "https://www.cron.elyamaje.com/api/cron?field=".$field."&value=".$value."";
      } else {
        $url = "https://www.cron.elyamaje.com/api/cron";
      }
      $ch = curl_init(); 
      curl_setopt($ch, CURLOPT_URL, $url); 
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token)); 
      $response = curl_exec($ch); 
      curl_close($ch); 
      
      return json_decode($response,true);
    }



     public function getCustomers(string $url,string $apikey, string $apikeys)

     {

          // getdata api rest woocommerce 
           //apikey customer keys , apikeys clé secret
           $woocommerce = new Client(
            $url,
            $apikey,
             $apikeys,

        [

         'wp_api'=> true,

         'version' => 'wc/v3',

         'query_string_auth' => true

        ]

     );

        // renvoi les données en json
         $data = $woocommerce->get('customers');

        return json_encode($data);

        }



      public function getDataDolibar(string $dolaapikey,string $urls): array
       {

          // recupération des données de l'api dolibar
            $curl = curl_init();
             $httpheader = ['DOLAPIKEY: '.$dolaapikey];
              curl_setopt($curl, CURLOPT_URL, $urls);
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
             $result = curl_exec($curl);
               curl_close($curl);
               // transformer en array les données
               return json_decode($result,true);
         }

        // api get

       public function getDataApiWoocommerce(string $urls)
        {
             // keys authentification API data woocomerce dev copie;
            $customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
            $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
           
            $headers = array(
              'Authorization'=> 'Basic' .base64_encode($customer_key.':'.$customer_secret)

               );
            
             $curl = curl_init();
             curl_setopt($curl, CURLOPT_URL, $urls);
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
             curl_setopt($curl, CURLOPT_USERPWD, "$customer_key:$customer_secret");

             $resp = curl_exec($curl);
             
            $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
             curl_close($curl);
             // afficher les données dans array
            $data = json_decode($resp,true);
            return $data;

      }

       
  // api post
  
  
  
      public function InsertPost(string $urls,array $datas)
      {
          
           // keys authentification API data woocomerce dev copie;
             $customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
             $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
          
           $headers = array(

        'Authorization' => 'Basic ' . base64_encode($customer_key.':'.$customer_secret )

       );

      

          $curl = curl_init();

         curl_setopt($curl, CURLOPT_URL, $urls);

         curl_setopt($curl, CURLOPT_POST, true);

         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

         curl_setopt($curl, CURLOPT_TIMEOUT, 30);
         curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($datas));
        //for debug only!
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

          curl_setopt($curl, CURLOPT_USERPWD, "$customer_key:$customer_secret");
          $resp = curl_exec($curl);
          $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); 

          if (curl_errno($curl)) {
            switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
              case 200:  # OK
                break;
              default:
                return false;
                // echo json_encode(['success' => false, 'message'=> 'Erreur code : '. $http_code.' !']);
                break;
              exit;
                
            }
          }
      
          curl_close($curl);
           
          // renvoi le resultat sous forme de json
          return $resp;  
          
          
          
      }

       

       public function InsertPosts(string $urls,$datas)
        {


          $json = json_encode($datas);
           // keys authentification API data woocomerce dev copie;
             $customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
             $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
          
           $headers = array(
          'Authorization' => 'Basic ' . base64_encode($customer_key.':'.$customer_secret ),
            'Content-Type: application/json',
           'Content-Length: ' . strlen($json)
        );

      

          $curl = curl_init();

         curl_setopt($curl, CURLOPT_URL, $urls);

         curl_setopt($curl, CURLOPT_POST, true);

         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

         curl_setopt($curl, CURLOPT_TIMEOUT, 2000000);
         curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($curl, CURLOPT_POSTFIELDS,$json);
        //for debug only!
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

          curl_setopt($curl, CURLOPT_USERPWD, "$customer_key:$customer_secret");
          $resp = curl_exec($curl);
          $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
        
           if(curl_errno($curl)) {
            switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
              case 200:  # OK
                break;
              default:
              echo json_encode(['success' => false, 'message'=> 'Erreur code : '. $http_code.' !']);
              exit;
                
            }

          }

          curl_close($curl);

        }

       

       

       // delete api woocoommerce..

       public function deletepostapi($url)
        {
            // keys authentification API data woocomerce dev copie;

              $data = array(
              "force" => true

             );

              $ch = curl_init($url);

              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

               curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

             $result = curl_exec($ch);

             curl_close($ch);

             



      }


      public function deletecode()
      {





        
      }

          public function insertDatadolibarr($url,$apikey,$data)
          {

                // recupération des données de l'api dolibar
                 $curl = curl_init();
                 $httpheader = ['DOLAPIKEY: '.$apikey];
                 curl_setopt($curl, CURLOPT_URL, $url);
                 curl_setopt($curl, CURLOPT_POST, 1);
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                  curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
                 $result = curl_exec($curl);

               curl_close($curl);

             }

       

       

     public function CallAPI($method, $key, $url, $data = false)
     {
            $curl = curl_init();
            $httpheader = ['DOLAPIKEY: '.$key];

            switch ($method)
            {

                 case "POST":
                 curl_setopt($curl, CURLOPT_POST, 1);
                 $httpheader[] = "Content-Type:application/json";
                 if ($data)

                  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;

                 case "PUT":

               curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');

               $httpheader[] = "Content-Type:application/json";

                if ($data)

                  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

               break;

          default:

              if ($data)

                  $url = sprintf("%s?%s", $url, http_build_query($data));

         }

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);

            $result = curl_exec($curl);

             curl_close($curl);

          // renvoi le resultat sous forme de json

          return $result;

    }  

       
    public function getApikeywopublic()
     {
       $customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
       return $customer_key;
      }

      public function getApikeysecret()
      {
        $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
        return $customer_secret;
      }
       

    /** 

    *@return array

    */

    public function getDataJson(): array
    {
          $file = public_path() . "/Upload/project.json";
           // renvoi le fichier sous forme de chaine de caractères
          $data = file_get_contents($file);
          // renvoi les données sous formes de tableau(array)
          $data = json_decode($data,true);

         return $data;

     }



    /** 

    *@return array

    */

    public function getDataJson1(): array
     {

        $file = public_path() . "/Upload/project1.json";
         // renvoi le fichier sous forme de chaine de caractères
          $data = file_get_contents($file);
         // renvoi les données sous formes de tableau(array)
        $data = json_decode($data,true);

        return $data;

     }

     

     

     public function store($file, $filename, $rib = false) {

         if($file) {
          $name = $file->getClientOriginalName();
          $size = $file->getClientMimeType();
            
          $extension = $file->getClientOriginalExtension();
        // renommer le fichier
        if(!$rib){
          $array = array('png','jpg','jpeg','PNG','JPG');
          $destinationPath ='admin/uploads/';
        } else {
          $array = array('pdf');
          $destinationPath ='admin/uploads/rib';
        }

         if(in_array($extension,$array)) {
            $file->move($destinationPath, $filename);
             $error ="succes";
              return $error;
          }
      
      
        if(!in_array($extension, $array))  {
            $error ="denied";
            return $error;
            
        }
        
        if($size > 1000) {
            $error ="deni";
            return $error;
        }
      
        } else {
        
        $error ="";
        return $error;
     }

    }



   public function uploadstock($file){

        if($file){

            $name = $file->getClientOriginalName();
            $size = $file->getClientMimeType();
            $extension = $file->getClientOriginalExtension();
            // renommer le fichier
            $array = array('csv');
          if(!in_array($extension, $array)){
              $error ="denied";
              return $error;
           }

          if($size > 1000) {
            $error ="deni";
            return $error;
         }

        }
         else{

        $error="succes";
         return $error;

    }

   }


}







