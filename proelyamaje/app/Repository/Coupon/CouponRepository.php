<?php


namespace App\Repository\Coupon;

use Exception;
use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\FemFidelite;
use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\DB;
use App\Http\Service\CallApi\GetDataCoupons;



class CouponRepository implements CouponInterface
{

     private $model;

     private $orders;

     private $data =[];

     private $codes =[];

     private $status =[];
     private $arraycode =[];

     public function __construct(Coupon $model, 
     GetDataCoupons $orders,
     Apicall $api)
     {
         $this->model = $model;
          $this->orders = $orders;
          $this->api =$api;
    }

    public function getcode($code){
        $customer =  DB::table('coupons')->select('id_coupons')->where('code_promos','=',$code)->get();
         // transformer les retour objets en tableau
         $list = json_encode($customer);
         $lists = json_decode($customer,true);
         return $lists;

    }

    public function  getcode_promo($code_promo){
          $customer = DB::table('ambassadricecustomers')
           ->join('coupons', 'ambassadricecustomers.code_promo', '=', 'coupons.code_promos')
            ->where('coupons.code_promos', $code_promo)
            ->get();
         // transformer les retour objets en tableau
          $list = json_encode($customer);
         $lists = json_decode($customer,true);
         return $lists;

    }

    /**

   * @return array

    */

   public function getData(): array{
       return $this->data;

   }

   public function setData(array $data){
       $this->data = $data;
       return $this;

   }


    /**

   * @return array

    */

    public function getCodes(): array{
       return $this->codes;
    }
 
    public function setCodes(array $codes)
    {
        $this->codes = $codes;
        return $this;
    }


   /**

   * @return array

    */

    public function getStatus(): array
    {
       return $this->status;
    }
 
    public function setStatus(array $status)
    {
        $this->status = $status;
        return $this;
    }


     /**

   * @return array

    */

    public function getArraycode(): array
    {
       return $this->arraycode;
    }
 
    public function setArraycode(array $arraycode)
    {
        $this->arraycode = $arraycode;
        return $this;
    }
    
    /**

   * @return array

   */

    public function donnes(): array
    {
        //recupérer les données sous forme de tableau dans la vairable array data les codes promos
         return $this->getData();

    }

     public function getIdcodepromo()
     {

        $data =  DB::table('coupons')->select('id_coupons','code_promos')->get();
        // transformer les retour objets en tableau
        $list = json_encode($data);
        $lists = json_decode($data,true);
        $array_code =[];
        $array_codepromo = [];
         $array_data_code =[];

        foreach($lists as $kl =>$valu) {
                $array_code[] = $valu['id_coupons'];
                $array_codepromo[$valu['code_promos']] = $kl;
                $array_data_code[$valu['id_coupons']] = $kl;
                
                
          }

       // recupére les code promo
        $this->setData($array_codepromo);
        $this->setArraycode($array_codepromo);
        $this->setCodes($array_data_code);
        return $array_code;

    }

    public function insert()
     {

        try{
            $array_id_coupons = $this->getIdcodepromo();
            $data = $this->orders->getDatacoupons();

            foreach($data as $keys => $values) {

                foreach($values as $k => $val) {
                   // recupérer LES CODES PROMO pas encore utilisé
                   if(!in_array($val['id'], $array_id_coupons)) {

                           $coupons = new Coupon();
                           $coupons->id_coupons = $val['id'];
                           $coupons->code_promos = $val['code'];
                           $coupons->date_created = $val['date_created'];
                           $coupons->save();

                    }
                }

                return true;

            }
        } catch (Exception $e) {
            return $e->getMessage();
      }

    }

    public function datacouponsWoocommerce($data){

        $customer_key="ck_06dc2c28faab06e6532ecee8a548d3d198410969";
        $customer_secret ="cs_a11995d7bd9cf2e95c70653f190f9feedb52e694";
         // Cache commenté car peux poser problème
          // $result = Cache::remember('orders', 15, function () use ($status, $page, $per_page, $customer_key, $customer_secret) {
          
            $response = Http::withBasicAuth($customer_key, $customer_secret)->post("https://www.staging.elyamaje.com/wp-json/wc/v3/coupons/" ,[
              'data' => $data,
            ]);
    
            return $response->json();
    
        }

    function deleteByCoupon($coupon){
        return Coupon::where('id_coupons', $coupon)->delete();
    }

    public function getcodefem()
    {


    }


    public function getDatafemcode()
    {
     
         // traiter les données venant de woocomerce
          //$date_after ="2023-06-01T09:01:00";
           $current = Carbon::now();
           $curents = Carbon::now();
          // ajouter un intervale plus un jour de 10jours.
            $current1 = $curents->addDays(2);
            $add_curent = $current->subDays(3);
            $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d\TH:i:s',$current1);
            $current3 =  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$add_curent)->format('Y-m-d\TH:i:s',$add_curent);
            $date_pw_card = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d H:i:s',$current1);
            $date_pw_card1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$add_curent)->format('Y-m-d H:i:s',$add_curent);
            $date_after = $current3;
            $date_before = $current2;
             // initiliaser un array...
            $donnees = [];
            $public_key = $this->api->getApikeywopublic();
            $secret_key =  $this->api->getApikeysecret();
          
           // boucle sur le nombre de paginations trouvées..
          for($i=1; $i<4; $i++) {
            $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons?orderby=date&order=desc&after=$date_after&before=$date_before&consumer_key=$public_key&consumer_secret=$secret_key&page=$i&per_page=100";
           // recupérer des donnees orders de woocomerce depuis api
           $donnes = $this->api->getDataApiWoocommerce($urls);
           if($donnes){
             $donnees[] = array_merge($donnes);
           }
        }


       // fusionner les deux tableau.
      // recupérer tous les codes du programme de fidélité crée...
        $data_code_fem =[];
        $chaine ="fem-";
        $date =date('Y-m-d');
        $status="0";
        $data_codes = $this->getdatapromofem();
        foreach($donnees as $val){
               foreach($val as $values){
                
                if(strpos($values['code'],$chaine) !==false) {
                       if(isset($data_codes[$values['code']])==false){
                         // insert dans la bdd
                         $codefem = new FemFidelite();
                         $codefem->code_fem = $values['code'];
                         $codefem->id_coupons = $values['id'];
                         $codefem->date = $date;
                         $codefem->status = $values['usage_count'];
                         $codefem->save();
                    }  
                }

             }

        }

      }


      public function getdatapromofem()
      {
        $list =  DB::table('fem_fidelites')->select('code_fem','id_coupons','status')->get();
        // transformer les retour objets en tableau
         $list = json_encode($list);
         $lists = json_decode($list,true);
          $data_code =[];
          $list_key_code =[];
          $list_status_code =[];

        foreach($lists as $key => $value){
          $data_code[$value['code_fem']]=$key;
          $list_key_code[$value['id_coupons']] = $value['code_fem'];
          $status_chaine = $value['status'].','.$value['code_fem'];
          $list_status_code[$status_chaine] = $value['code_fem'];
        }

         $this->setCodes($list_key_code);
         $this->setStatus($list_status_code);
         return $data_code;

      }



}

     

    