<?php



namespace App\Repository\Notification;



use App\Models\PanierLive;

use App\Models\Ambassadrice\Notification;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;



class NotificationRepository implements NotificationInterface

{

     

    

    private $datas =[];

    

    private $donnes = [];

    

    public function __construct()

    {

     

      

    }

    

    

       /**

   * @return array

    */

   public function getDatas(): array

   {

      return $this->datas;

   }

   

   

   public function setDatas(array $datas)

  {

     $this->datas = $datas;

    return $this;

  }

  

  

      /**

   * @return array

    */

   public function getDonnes(): array

   {

      return $this->donnes;

   }

   

   

   public function setDonnes(array $donnes)

  {

     $this->donnes = $donnes;

    return $this;

  }

  public function insert($id)
  {
     $notification = new Notification();
      $notifcation->id_ambassadrice = $id;
  }

  public function deleteid($id)
  {
      Notification::where('id_ambassadrice', $id)->delete();

   }

   public function livestat($id_commande,$id_ambassadrice)
   {
       $notification = new Notification();
        $notification->id_commande = $id_commande;
         $notification->id_ambassadrice = $id_ambassadrice;
        // insert dans bdd;
         $notification->save();
   }

   public function getNotification($id_ambassadrice)
   {
      return Notification::where(['id_ambassadrice' => $id_ambassadrice])->get()->toArray();
   }

    

    

    public function getdatapanierlive($code_live)
    {
       // recupérer les données choisir par 
      // recupérer le id_coupons si existe

        $data = DB::table('choix_panier_lives')->select('id_live','date_live','code_live','id_coupons','token_datas','actif')->where('code_live','=',$code_live)->get();

        $lis = json_encode($data);
        $list = json_decode($data,true);
       // traiter les données quand le champ actif est égale a 1;
         $donnes_recoive =[];
         $donnes =[];
         $donnes_token =[]; // recupérer le champs token dans un array de données.
          $token_choisis =[];

         foreach($list as $val)
         {
             $donnes_token[] = [
                             'id_live'=>$val['id_live'],
                             'code_live'=>$val['code_live'],
                              'id_coupons'=>$val['id_coupons'],
                               'date_live'=>$val['date_live'],
                                'token_data' => explode(',',$val['token_datas'])

                            ];

               // recupérer les token choisis
             $token_choisis = explode(',',$val['token_datas']);
          }

              // recupérer les données des paniers choisir par les emabassadrice
             $datas = PanierLive::all()->sortBy('num')->groupBy('pseudo')->toArray();
             // recupérer les tokens qui sont dans les paliers dans le tableau de palier
             $datas_niveau = [];
             $datas_panier = [];
             $data_nombre =[]; //nombre de produits choisir via un palier.

             foreach($datas as $keys => $values)
             {
                foreach($values as $valu)
                {
                  
                    if(in_array($valu['token'],$token_choisis))
                    {
                       $valu['choix'] ="selected";
                       $valu['choix1'] = $valu['panier_title'];
                     }
                      else{
                            $valu['choix']="";
                            $valu['choix1']="";
                         }

                           $panier_title = $valu['panier_title'];
                           $mont_max= $valu['mont_max'];
                           $mont_mini = $valu['mont_mini'];
                            $monnaie ="€";

                         $datas_panier[] =[
                             'title' => $panier_title.'  :  '.$mont_mini.''.$monnaie ,
                             'mont_max'=> $mont_max,
                              'mont_mini'=>$mont_mini,
                               'data' => $valu

                           ];

                          // recupérer le nombre de palier choisir par l'ambassadrice
                             if(in_array($valu['token'],$token_choisis))
                              {
                                   $panier_title = $valu['panier_title'];
                                   $mont_max= $valu['mont_max'];
                                   $mont_mini = $valu['mont_mini'];
                                    $monnaie ="€";
                                   $datas_niveau[] =[
                                     'title' => $panier_title ,
                                     'mont_max'=> $mont_max,
                                     'mont_mini'=>$mont_mini,
                                       'data' => $values
                                ];
                           }
                      }

                }

               // recupérer le nombre de palier ajoutés
               $this->setDatas($datas_niveau);
               // grouper le tableau par niveau palier. 
                 function groupByTile($datas_panier){
                  $final_array =[];
                foreach($datas_panier as $key=>$val)
                {
                   $final_array[$val['title']][] = $val;

                }
                 return $final_array;  
          }

            $data_panier_uniques = groupBytile($datas_panier);
            // recupérer les ids produits souhaités
             return $data_panier_uniques;

    }

     
    public function gettokendata($group_token)
    {
         // script contraint a une ambassadrice à remplir tout les paliers.
          // recupérer les données des paniers choisir par les emabassadriCE
          $datas = PanierLive::all()->groupBy('pseudo')->toArray();
         // recupérer les tokens qui sont dans les paliers dans le tableau de palier
         $datas_niveau = [];
          $datas_panier = [];

         foreach($datas as $keys => $values)
          {
               foreach($values as $valu)
               {
                  // recupérer le nombre de palier choisir par l'ambassadrice
                  if(in_array($valu['token'],$group_token))
                    {

                       if($valu['panier_title']!="")
                       {
                           $data_nombre[] = $valu['panier_title'];

                        }
                                  $panier_title = $valu['panier_title'];
                                  $mont_max= $valu['mont_max'];
                                  $mont_mini = $valu['mont_mini'];
                                  $monnaie ="€";
                                  $datas_niveau[] =[
                                  'title' => $panier_title ,
                                   'mont_max'=> $mont_max,
                                   'mont_mini'=>$mont_mini,
                                    'data' => $values

                             ];

                          }

                    }

                }

              // compter le nombre de fois la valeur est ajoutée

             $list_number = array_count_values($data_nombre);

             foreach($list_number as $ks =>$vm)
             {
                 if($ks!="")
                 {
                     $number_list[]  = $vm;

                 }

             }

            // recupérer le nombre de produit via palier
            $this->setDonnes($number_list);
            // grouper le tableau par niveau palier. 
        function groupByTiles($datas_niveau){

           $final_array =[];
          foreach($datas_niveau as $key=>$val)
          {
             $final_array[$val['title']][] = $val;
           }

           return $final_array;  

     }

       $datas_panier_niveau = groupBytiles($datas_niveau);
       // recupérer le nombre de palier ajoutés
        return $datas_panier_niveau;

    }


    public function getAll(){
        
      $data_live_notification = DB::table('notifications')->select('id_ambassadrice','created_at')->get();
      $lis = json_encode($data_live_notification);
      $list = json_decode($data_live_notification,true);

      return $list;
   
   }
    

}

     

    