<?php

namespace App\Repository\Customer;
use App\Models\Customer;
use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerInterface
{
    private $api;

    public function __construct(Apicall $api)
    {
      $this->api = $api;
    }

    public function getCustomers()
    {
      return Customer::all();
    }
    
    
     public function insert()
     {
        
        // Api Woocomerce Data get
       // recupere tout les données sur le uri
         // initialiser des array
         $arrs =[];
         
         // boucle sur le nombre de paginations trouvées
          for($i=1; $i<30; $i++){
              $url="https://www.elyamaje.com/wp-json/wc/v3/customers?consumer_key=ck_fe466034e44eddd0be2b90f944f1f2eda9bf66b6&consumer_secret=cs_d48d2f81e8d3b686e70fbf194ac630e53d30a773&page=$i&per_page=100";
             //$url="https://www.dev14x.elyamaje.com/wp-json/wc/v3/customers?consumer_key=ck_a76f7bbc5173a596c00faa88f8d34b6ba7768f4c&consumer_secret=cs_a4e4d6a993356e979713e95259803986c96fd403&page=$i&per_page=100";
              $donnees = $this->api->getDataApiWoocommerce($url);
              //merger les array issus de la boucle
              $arrss[] = array_merge($donnees);
           }
         
           
         
          foreach($arrss as $values){
             
             foreach($values as $val) {
                 // recupérer les données dans un tableau associatives
                 // recupérer les personnes localisé par un code postal
                 // commencant par 13,20......
                 $code_postal = $val['billing']['postcode'];
                 //exploser la chaine en tableau
                 
                 $code_postals = str_split($code_postal);
                 
                  // recuperer les 2 chiffre du code postal
                 $code_p = substr($code_postal,0,2);
                 //lister des codes postal à recupérer
                  $code_array = array('09','11', '12','13','83','84','04','20','30','31','32','34','46','48','65','66','81','82','05','06','38','42','43','63','69','73','74');
                if(in_array($code_p, $code_array)){
                
                      $d='\'';
                     $arrs[] = [ 'email' =>$val['email'],
                             'phone' => $d.$val['billing']['phone'],
                             'name' =>$val['first_name'].' '.$val['last_name'],
                             'code_postal'=>$val['billing']['postcode'],
                      
                        ];
               }
             }
             
             
         }
           // Recupere data api Dolibar tiers ;
           // api Dolibar 
           //$dolaapikey = "Q8Vu04WbYw5hBi77K1CwJT1roTe8pe6F";
           //$urls = "https://www.transfertx.elyamaje.com/api/index.php/thirdparties?sortfield=t.rowid&sortorder=ASC&limit=3045";
           
           $dolaapikey ="305ZB714CPxxYqHgk5w7Ah1i1aTtOHFe";
            $urls ="https://www.poserp.elyamaje.com/api/index.php/thirdparties?sortfield=t.rowid&sortorder=ASC&limit=5000";
           
            // recupération des data
            //$customer =[];
            //$customerParam = ["limit" =>5000, "sortfield" =>"rowid"];
           //$listcustomer = $this->api->CallApi("GET",$key,$apiUrl."thirdparties",$customerParam);
            //$data1 = json_decode($listcustomer,true);
           
             //appelle de la fonction  Api
            $data = $this->api->getDatadolibar($dolaapikey,$urls);
           // domp affichage test
           
            // initialiser un array recuperer les ref client// dolibar
             $datas = [];
             $a = [];
             
             // recupérer les emails dans un tableau 
             $donnees = $this->getEmail();
           // on boucle sur le tableau des valeurs
          foreach($data as $values){
          // recupérer les données des ref_client orders existants dolibar dans un tableau
          // recupérer les données sans email vide
              if($values['email']!="" AND !in_array($values['email'],$donnees)) {
                       
                 $code_postal = $values['zip'];
                 // transformer en tableau mla chaine de caractères
                 $code_postals = str_split($code_postal);
                 
                 // recuperer les 2 chiffre du code postal
                  $code_p = substr($code_postal,0,2);
                 //lister des codes postal à recupérer
                  $code_array = array('09','11', '12','13','83','84','04','20','30','31','32','34','46','48','65','66','81','82','05','06','38','42','43','63','69','73','74');
                      
                      if(in_array($code_p, $code_array))
                      {
                        if($values['phone']=="")
                         {
                          $phone="";
                         }
                      else{
                         $d='\'';
                          $phone = $d.$values['phone'];
                      }
                      
                      $datas[] = [ 
                      'email'  =>  $values['email'],
                      'phone' => $phone,
                      'name' => $values['name'],
                      'code_postal' =>$values['zip'],
                   ];
                   
               }
             }
             
         }
         
        
       
           //MERGE LES DEUX TABLEAU
           $dones = array_merge($arrs,$datas);
           // renvoyer un tableau associative  unique par email
           $array_data = array_unique(array_column($dones, 'email'));
           $array_data_unique = array_intersect_key($dones, $array_data);
           //
           $array_datas = array_unique(array_column($arrs, 'email'));
           $array_data_uniques = array_intersect_key($arrs, $array_datas);
            // insert données dans la base de données
          foreach($array_data_uniques as $donnes){
             if($donnes['email']!="" AND $donnes['email']!="bikoumou.chanel@live.fr" AND !in_array($donnes['email'],$donnees)){
                //insert database
                  $customer = new Customer();
                   $customer->name = $donnes['name'];
                   $customer->phone = $donnes['phone'];
                   $customer->email = $donnes['email'];
                   $customer->code_postal = $donnes['code_postal'];
                    //insert into bdd
                    $customer->save();
                 
                 
             }
          }
          
        
    }
    
    
    /**
 * 
 *@return array
 */

   public function getEmail(): array
   {
        // recupérer les names dans la base de données 
        $name_list = DB::table('customers')->select('email')->get();
        // transformer les retour objets en tableau
        $name_list = json_encode($name_list);
        $name_list = json_decode($name_list,true);
        // recupérer dans unn tableau les données email
        $donnees = [];
        foreach($name_list as $key => $values){
           foreach($values as $val){
              $donnees[] = $val;
           }
        }
         // renvoi un tableau array de valeurs
         return $donnees;
    }
  
  
}

   