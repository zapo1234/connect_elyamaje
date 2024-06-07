<?php



namespace App\Http\Controllers\Ambassadrice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\PanierLive\PanierLiveRepository;
use Models\Models\Orderscommerce;

use App\Models\ConfigurationPanierLive;
use App\Models\ProductWoocommerce;
use App\Repository\Ambassadrice\OrdercodepromoaffichageRepository;
use App\Repository\Coupon\CouponRepository;
use App\Repository\Pointbilan\PointbilanRepository;

use  App\Repository\Users\UserRepository;

use  App\Repository\Caissenice\CaisseniceRepository;

use  App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;

use  App\Repository\Ambassadrice\AmbassadricecustomerRepository;

use App\Repository\Ambassadrice\CardscustomercontrolsRepository;

use App\Repository\Ambassadrice\LivestatistiqueRepository;

use App\Repository\Dashboardtiers\DashboardtiersRepository;

use App\Repository\Orders\OrderscommercesRepository;
use App\Repository\Factures\ControlefacturesRepository;
use App\Repository\Promotions\PromotionsumsRepository;
use App\Repository\Notification\NotificationRepository;

use App\Repository\PanierLive\ChoixPanierLiveRepository;
use App\Repository\Ambassadrice\HistoriquePanierLiveRepository;

use App\Http\Service\CallApi\Apicall;

use App\Http\Service\CallApi\NombreOrders;

use Illuminate\Support\Facades\DB;

use App\Models\Ambassadrice\Notification;

use Illuminate\Support\Facades\Auth;

use Mail;

use Carbon\Carbon;

use DateTime;



class GestionControlController extends Controller

{

    //

     private $choixpanierlive;
     private $historiquelive;

     private $panierlive;
     private $orderaffichage;
     private $users;
     private $customs;
     private $orders;
     private $api;

     private $live;
     private $cards;
     private $dash;
     private $ordre;

     private $point;

    

    public function __construct(

    ChoixPanierLiveRepository $choixpanierlive,

    HistoriquePanierLiveRepository $historiquelive,

    PanierLiveRepository $panierlive,

    OrdercodepromoaffichageRepository $orderaffichage,

    UserRepository $users,

    AmbassadricecustomerRepository $customs,

    OrderambassadricecustomsRepository $orders,

    CouponRepository $coupon,

    Apicall $api,

    LivestatistiqueRepository $live,

    CardscustomercontrolsRepository $cards,

    DashboardtiersRepository $dash,

    CaisseniceRepository $caissenice,

    NombreOrders $ordre,

    OrderscommercesRepository $ordercommerce,
    ControlefacturesRepository $invoice,
    NotificationRepository $notifications,
    PromotionsumsRepository $promotionsums,
    PointbilanRepository $point,
    HistoriquePanierLiveRepository $historique

    )

    {

        $this->panierlive = $panierlive;
        $this->choixpanierlive = $choixpanierlive;

        $this->historiquelive = $historiquelive;

          $this->orderaffichage = $orderaffichage;

          $this->users = $users;

          $this->customs = $customs;

          $this->orders = $orders;

          $this->coupon = $coupon;

          $this->api = $api;

          $this->live = $live;

          $this->cards = $cards;

          $this->dash = $dash;

          $this->caissenice = $caissenice;

          $this->ordre = $ordre;

          $this->ordercommerce = $ordercommerce;
          $this->invoice = $invoice;
          $this->promotionsums = $promotionsums;
          $this->notifications = $notifications;
          $this->point = $point;
          $this->historique = $historique;
    }

    

    

    public function getcontrol()
    {
       return view('gestion.ambassadrice');

    }

    public function views()
    {

         return view('livewire.calendars');
    }


     public function dashboards(Request $request)
     {
    
              // recupérer le nombre de ligne de la table
              $donnees_ids =  $this->ordercommerce->countOrder();
              $nombre_count_orders = $donnees_ids + 1;
            
              // recupérer le nombre de doublons susceptible dans les facture +  nombre de ligne de la table
              $date_actuel = date('Y-m-d');
              // recupérer les données y'a 5 jours .
              $date_co = date("Y-m-d", strtotime($date_actuel.'- 3 days'));
              $date_controle = $date_co;
              $donnees_id = $this->invoice->getAll(['socid','created_at']);
              $donnes_array_id =[];// recupérer id dans une table
        
               foreach($donnees_id as $vl) {
                $date_bd = $vl['created_at'];//date en bdd
                $date_s = explode(' ',$date_bd);
            
                if($date_s[0] > $date_controle) {
                    $donnes_array_id[] = $vl['socid'];
                }
            }

                $nombre_count_ordr = count($donnes_array_id);
                // recupérer les factures étidé sur nice !
           
                 // recupérer les informations sur le nombre de nouveaux clients
                 // du jour en cours et jours now -1 et -2j
                 // recupérer les données pour somme de la recette journalière!
                 $donnees_recette = $this->caissenice->getAlldata();
                 // recupérer le solde mensuel en cours .
                 $donnees_recettes = $this->caissenice->getDatanice();
                 //montants jiurnalier
                 $mts = array_sum($donnees_recette);
                 $mmts = number_format($mts,2,',','');
                 $somme_recette = $mmts;// recette journalière nice
                // montant menseul recupérer
                 //montants jiurnalier
                  $mtss = array_sum($donnees_recettes);
                  $mmtss = number_format($mtss,2,',','');
                   $somme_recettes = $mmtss;

                   $date_cours = date('d/m/Y');
                   $date_courss = date('m/Y');
                  // Recupere les data marseille
                  // recupérer les données pour somme de la recette journalière!
                  $donnees_recette_marseille = $this->caissenice->getAlldatas();
                  // recupérer le solde mensuel en cours .
                   $donnees_recette_marseilles = $this->caissenice->getDatanices();

                  //montants journalier
                   $mts_m = array_sum($donnees_recette_marseille);
                   $mmts_m = number_format($mts_m,2,',','');
                   $somme_recette_marseille = $mmts_m;// recette journalière marseille

                   // recette menseul en cours
                   $mts_ms = array_sum($donnees_recette_marseilles);
                   $mmts_ms = number_format($mts_ms,2,',','');
                   $somme_recette_marseilles = $mmts_ms;// recette menseulle marseille

                   // des données internet
                   // recupérer les données pour somme de la recette journalière!
                   $donnees_recette_internet = $this->caissenice->getAllinternets();
                   // recupérer le solde mensuel en cours .
                   $donnees_recette_internets = $this->caissenice->getDatainternet();
                   //montants jiurnalier site internet
                   $mts_ms = array_sum($donnees_recette_internet);
                   $mmts_ms = number_format($mts_ms,2,',','');
                    
                   // recette menseulle internet 
                   $mts_mss = array_sum($donnees_recette_internets);
                   $mmts_mss = number_format($mts_mss,2,',','');

                   
                   $somme_recette_internet = $mmts_ms;// recette journalière internet
                   $somme_recette_internets = $mmts_mss;// recette journalière internet


                   $statistique = $this->dash->getallsdate(); // nombre new tiers (ville et internet)
                   $last_statistique = $this->dash->selectOldDatadate();
                   $nombre_marseille = 0;
                   $nombre_nice= 0;
                   $nombre_internet= 0;

                   // nombre de client total
                   $nombre_customs =  $this->dash->getcountiers();

                      // nombre de nouveau client venu du site
                      $customer_internet = $this->dash->getnewcustomers();// actualiser les news client
                      // recupérer les nouveaux clients venant de la boutique
                      $customer_boutique = $this->dash->getdatac();
                      // recupérer le nombre clients total..
                      $nombre_customs =  $this->dash->getcountiers();

                   // recupérer les recette engendrés par les partenaire et ambassadrice sur le mois en cours
                    $date = date('Y-m-d');
                   $annee = date('Y');
                   $mois = date('m');
                   $mois_true = (int)$mois;

                  $montant_activite = $this->orders->getchiffreamba($mois_true,$annee);// recupérer le montant généré par l'activité

                foreach($statistique as $kl => $valis){
                   $nombre_marseille = $valis['nombre_marseille'];
                   $nombre_nice = $valis['nombre_nice'];
                   $nombre_internet = $valis['nombre_internet'];
               }

                if($last_statistique){
                    $nombre_last_marseille = $last_statistique[0]['nombre_marseille'] ?? 0;
                    $nombre_last_nice = $last_statistique[0]['nombre_nice'] ?? 0;
                    $nombre_last_internet = $last_statistique[0]['nombre_internet'] ?? 0;
                } else {
                    $nombre_last_marseille = 0;
                    $nombre_last_nice =  0;
                    $nombre_last_internet = 0;
                }
              


                $percent_marseille = $nombre_last_marseille > 0 ? round(abs(100 - (($nombre_marseille *100) / ($nombre_last_marseille))),2) : $nombre_marseille *100;
                $percent_nice = $nombre_last_nice > 0 ? round(abs(100 - (($nombre_nice *100) / ($nombre_last_nice))),2) : $nombre_nice *100;
                $percent_internet = $nombre_last_internet > 0 ? round(abs(100 - (($nombre_internet *100) / ($nombre_last_internet))),2) : $nombre_internet *100;
                $max_new_customer = max([$nombre_marseille, $nombre_nice, $nombre_internet]);

               

              $number =[];
              $message="";
              $messages="";
              $messagess="";

             if($this->dash->getallsnow()=="" OR $this->dash->getallsnow()==0){
                 $message ="Aucun  client aujourd'hui";
             }
             if($this->dash->getallsnow()=="1"){
                $message ="1 nouveau client aujourd'hui";
             }
             if($this->dash->getallsnow() !="1" && $this->dash->getallsnow()!="") {
                $message = $this->dash->getallsnow(). '  nouveaux client aujourd\'hui';
             }
              // client enregsitré now -1 days
             if($this->dash->getallsdatehier()=="" OR $this->dash->getallsnow()==0){
                $messages ="Auncun nouveau client hier";
             }

             if($this->dash->getallsdatehier()=="1"){
                 $messages ="1 nouveau client hier";
             }
             if($this->dash->getallsdatehier()!="1" && $this->dash->getallsdatehier()!=""){
                $messages = $this->dash->getallsdatehier().  '  nouveaux client Hier';
             }
             // client enregistré now -2 days

             if($this->dash->getalldatehiers()==""){
                 $messagess ="Auncun  client il y'a 2 jours..";
             }
             if($this->dash->getalldatehiers()=="1"){
                 $messagess ="1 nouveau client il y'a 2 jours..";
             }

              if($this->dash->getalldatehiers()!="1" && $this->dash->getalldatehiers()!=""){
                 $messagess = $this->dash->getalldatehiers(). '  nouveaux client il y\'a 2 jours';
              }



              // recuperer  les données de charts js
              $date =date('Y-m-d');
             // exploser les dates 
              $dat = explode('-',$date);

              // Data à changer pour avoir des données selon une autre année/mois
              $annee = $dat[0];
               $jour = (int)$dat[2];
               $mois = $dat[1];

              // mise à jours stocks !
              $mois1 = $request->get('mois_cours');
              $annee1 = $request->get('date_yearss');

              if($mois!="" && $annee1!="") {
                 $data_array = $this->dash->getdatacharjs($mois1,$annee1);
               }

               $data_array = $this->dash->getdatacharjs($mois,$annee);
               // definir deux tableau de données
               $jours =[]; // les jours du mois défini
               $nombreclient = []; // le nombre des clients en cours du mois
               $nombre_client = [];
                $mo = $mois;
             foreach($data_array as $ks=>$val){
                  $jours[] = $val['jour'].' '.$this->getmois($mo);
                  $nombre_client[] = $val['nombre'];
             }

            // recupérer les données pour afficher le top 3 produits les plus achétés lors des lives et code élève
              $data_ventes = $this->promotionsums->getAll(['id_product','id_commande','label_product','sku', 'somme', 'quantite']);
              $data_vente =[];
              $data_commande = []; // recupérer le nombre de commande depuis le 16/09/2022.les id_commande
                
              foreach($data_ventes as $kl=>$vb) {
                  if($vb['sku']!=""){
                      $data_vente[] = $vb['label_product'].' ,'.$vb['id_product'].' ,'.$vb['somme'];
                      $date_commande [] = $vb['id_commande'];
                  }
              }

                // compter le nombre de commande réalisé depuis le 13septembre 2022
                $nbrs_com = array_unique($date_commande);

                $nombre_commande = count($nbrs_com);
                // le nombre de de produit achété
                $nombre_line_product = count($date_commande);// nombre de produit achétes
                // calucler le kpi souhaite pour l'activité ambassadrice & partenaire.
                 $kpi_product = number_format($nombre_line_product/$nombre_commande,'2',',','');

                 $css="ok";

             
            
                 return view('gestion.home',['message'=>$message,'messages'=>$messages,'messagess'=>$messagess,'mois'=>$mois,'annee'=>$annee, 'max_new_customer' => $max_new_customer,
                 'css'=>$css,'percent_nice' => $percent_nice, 'percent_internet' => $percent_internet,'percent_marseille' => $percent_marseille,'nombre_marseille'=>$nombre_marseille,'nombre_nice'=>$nombre_nice, 'nombre_internet'=>$nombre_internet,
                 'nombre_last_marseille'=>$nombre_last_marseille,'nombre_last_nice'=>$nombre_last_nice, 'nombre_last_internet'=>$nombre_last_internet,'nombre_customs'=>$nombre_customs,'customer_internet'=>$customer_internet,'customer_boutique'=>$customer_boutique,
                  'somme_recette'=>$somme_recette,'somme_recettes'=>$somme_recettes,'somme_recette_marseille'=>$somme_recette_marseille,'somme_recette_marseilles'=>$somme_recette_marseilles,'somme_recette_internet'=>$somme_recette_internet,'somme_recette_internets'=>$somme_recette_internets,'date_cours'=>$date_cours,'date_courss'=>$date_courss,'nombre_commande'=>$nombre_commande,'nombre_line_product'=>$nombre_line_product,
                  'nombre_count_orders'=>$nombre_count_orders,'kpi_product'=>$kpi_product,'nombre_count_ordr'=>$nombre_count_ordr,'montant_activite'=>$montant_activite])
                 ->with('jours',json_encode($jours,JSON_NUMERIC_CHECK))
                 ->with('nombre_client',json_encode($nombre_client,JSON_NUMERIC_CHECK));

     }

    

     public function newcustomer(Request $request){

        if(str_contains($request->get('annee'), 'year')){
            $resultat = $this->dash->getdatacharjs(null, explode('_', $request->get('annee'))[1]);
        } else if (str_contains($request->get('annee'), 'month')){
            $mois = $request->get('annee');
            $resultat = $this->dash->getdatacharjs(explode('_', $request->get('annee'))[1], date('Y'));
        } else {
            $resultat = null;
        }

        $jours =[];
        $nombre_client = [];
      
        foreach($resultat as $ks=>$val) {  
           $jours[] = $val['jour'].' '.$this->getmois($val['mois']);
           $nombre_client[] = $val['nombre'];
        }
        

        echo json_encode(['jours' => $jours, 'nombre_client' => $nombre_client]);

     }

     public function getcards()
     {
        if(Auth()->user()->is_admin==1) {
             // recupérer les numero
             $this->cards->getAllidcommande();
             // recupérer les cards bancaire.
             $datas=$this->cards->getData();
             $data_cards = array_count_values($datas);
            // recupérer le numero en double
            $array_list_cards =[];
            foreach($data_cards as $ks=>$vals){
              if($vals > 1)
               {
                  $array_list_cards[]= $ks;

                }

            }

             // recupérer les numbrecars en doublons et ayant le status lecture en bdd
             $etat="lecture";
             $data = DB::table('cardscustomercontrols')
             ->whereIn('number_forms',$array_list_cards)
              ->where('etat','=',$etat)
             ->get();

              if(count($array_list_cards)==0){
                  $css="nocards";
                  $message ="Aucune carte detectée susceptible de fraude !";
                  $nombre_cards=0;
               }

              if(count($array_list_cards)>0) {
                  $css="truecards";
                  $nombre_cards = count($array_list_cards);
                  if(count($array_list_cards)==1)
                  {
                       $message =" une carte bancaire épinglée";
                   }
                  else{
                      $message="$nombre_cards cartes bancaires épinglées";
                    }

              }

                return view('gestion.payment',['css'=>$css, 'array_list_cards'=>$array_list_cards,'nombre_cards'=>$nombre_cards,'data'=>$data,'message'=>$message]);
            }

     }

    

    public function listcode(Request $request)

    {

       if(Auth()->user()->is_admin ==1) {

               // recupérer la listes des partenaire et ambassadrice
              $this->users->getUser();
               // recupérer les tableau des données ambassadrice et partenaire.
              $ambassadrice = $this->users->getdata();
              $partenaire = $this->users->getdatas();
              // recupérer les données à afficher en fonction de l'existence
             $search = $request->get('search_user');// recupérer l'ambassadrice;
              $partenaire_user = $request->get('partenaire_user');
                $partenaire_users = $request->get('partenaire_users');

               $list =[];
               $lists = [];
              $name_ambassadrice ="";
               $name_partenaire ="";
             foreach($ambassadrice as  $k =>$val){
                 $v = explode(',',$val);
                 $list[] = [
                    $k=> $v[0]
                  ];

                 if($k == $search){
                        $h = explode(',',$val);
                       $name_ambassadrice = $h[0];
                  }
            }

           foreach($partenaire as  $ks =>$vals){
               $vs = explode(',',$vals);
               $lists[] = [
                 $ks=> $vs[0]
               ];

                 if($ks == $partenaire_users){
                     $hs = explode(',',$vals);
                     $name_partenaire = $hs[0];

                 }

           }

         // recupérer la variable nom
        //   if($search=="tous")

        //   {

           $users = $this->orderaffichage->getdatapromo();

        //    }

         //   else{

        //       $id = $search;

        //       $users = $this->orderaffichage->getdatapromos($id);

        //    }
        
          if($partenaire_user !=""){
             $id = $partenaire_user;
             $users = $this->orderaffichage->getdatapromos($id);
          }

           if($partenaire_users !="") {
              $id = $partenaire_users;
              $users = $this->orderaffichage->getdatapromos($id);
           }
            $messages ="";
            // renvoi sur la view 

           return view('gestion.listcode',['users'=>$users, 'list'=>$list, 'lists'=>$lists, 'messages'=>$messages,'name_ambassadrice'=>$name_ambassadrice,'name_partenaire'=>$name_partenaire]);

    }

}

    
  public function getcodepromo(Request $request)
  {
       dd('zapo');
      // recuperer id du coupons
       $code = $request->get('id_codeleve');
       // recupérer le code promo depuis la bdd;
       $get_code = $this->coupon->getcode($code);
       // initialiser le code promo crée.
       $id_coupons ="";
        foreach($get_code as $values) 
        {
           $id_coupons = $values['id_coupons'];

        }

        // suprimier le coupons ainsi des données de la base de données table coupons et client.
       // delete le coupons de l'api woocomerce....
          $consumer_key = "ck_06dc2c28faab06e6532ecee8a548d3d198410969";
           $consumer_secret ="cs_a11995d7bd9cf2e95c70653f190f9feedb52e694";

           // recupérer les coupons
          $id_coupons = 77796;

           $catUrl = "https://www.staging.elyamaje.com/wp-json/wc/v3/coupons/";

           $catId = $id_coupons;  // id of the category which I want to delete
          $url = $catUrl.$catId."?_method=DELETE&consumer_key=".$consumer_key."&consumer_secret=".$consumer_secret;
          // appel à api.

           //$this->api->deletepostapi($url);

    
        // delete in table application
        $this->customs->deleteByCode($code);
        // delete database orderaffichafes
        $this->orderaffichage->deleteByCode($code);
        // delete database coupons
        $this->coupon->deleteByCoupon($id_coupons);
          // return vers la page 
        $messages ="le code promo de l'elève à eté bien supprimé";

        // recharger la page
         $name_ambassadrice="";
         $name_partenaire ="";
     // recupérer les tableau des données ambassadrice et partenaire.

           $ambassadrice = $this->users->getdata();

           $partenaire = $this->users->getdatas();

         $list =[];
         $lists = [];
          $name_ambassadrice ="";
          $name_partenaire ="";

           foreach($ambassadrice as  $k =>$val) {
               $v = explode(',',$val);
              $list[] = [
                  $k=> $v[0]

                  ];

             }

           foreach($partenaire as  $ks =>$vals){
               $vs = explode(',',$vals);
              $lists[] = [

                $ks=> $vs[0]

                  ];
             }

           $users = $this->orderaffichage->getdatapromo();
          // renvoi sur la view 
           return view('gestion.listcode',['users'=>$users, 'list'=>$list, 'lists'=>$lists, 'messages'=>$messages,'name_ambassadrice'=>$name_ambassadrice,'name_partenaire'=>$name_partenaire]);

    }

     public function suivicode()
     {

         // definir un tableau à renvoyer
          $array_donnees = [];
          // recupérer les infos des ambassadirece et partenaire
           $this->users->getUser();
           $data = $this->users->getListusers();
           // recupérer le nom de code élève créer en fonction de l'id de l'ambassadrcie
            $data1 = $this->customs->getdatacodepromo();
            // recupérer les orders et le nombre en fonctiond es id_ambassadrice
            $data2 = $this->orders->getcountcodeleve();
            $list =[];// recupérer  les infos et le nombre de code eleve créer dans un premier temps
            $list1 =[];// recupérer le nombre de code élève utilisé pour une commande
            $list2 = [];
           $list3 = []; // recupérer les ambassadrice et partenaire dont les codes élève n'ont jamais été utilisés
          // créer un tableau pour recupérer les valuers 
          foreach($data1 as $key => $values){
               foreach($data as $ks =>$vale){
                    if($ks == $values['id_ambassadrice']){
                        $list[$ks] = $vale.','.$values['codeleve_count'];

                           }
                 }

           }

        // recupérer les partenaire et ambassadrice dont les codes élève ont éte utilisés
        $list_id =[];
        foreach($data2 as $ky => $valus)
        {
             foreach($list as $kv =>$vales)
              {

                  if($kv == $valus['id_ambassadrice']){
                      $list1[$kv] = $vales.','.$valus['ordercode_count'];
                   }

                }

                // fournir le tableau
                 $list_id[] = $valus['id_ambassadrice'];

         }

         // trier les partenaire et ambassadrice qui n'ont pas de commande orders!

         foreach($data1 as $kyt => $vals){
              foreach($list as $kb =>$vales){
                     if(!in_array($kb,$list_id)) {
                             $num =0;
                             $list3[$kb] = $vales.','.$num;
                      }
               }

           }

            // recupérer des tableau à afficher dans la vue
            // recuperer les données qui ont des orders utilisés un  code élève qui sont null.
             $array_list1 =[];
            foreach($list3 as  $valm){
                $array_list1[] =  explode(',',$valm);

            }

             // recupérer les donnéees ambassadrice partenaire ayant créer des codes promo deja utilisés
             $array_list2 =[];
             foreach($list1 as $valk){
                 $array_list2[] = explode(',',$valk);
             }

             return view('gestion.suivicode',['array_list2'=>$array_list2, 'array_list1'=>$array_list1]);

    }

       public function suivilives($id)
       {
          if(Auth()->user()->is_admin==1 OR Auth()->user()->is_admin==3) {
               // recupérons le nom de l'ambassadrice;
               $name_user = $this->users->getUserId($id);
               // recupérer le nom
               $name = $name_user->name;
               return view('gestion.suivilives',['name'=>$name]);

            }
        }

    //historique recette journalière
    public function recettenice()
    {

        if(Auth()->user()->is_admin==1) {

             $data = $this->caissenice->getrecettenice();
             $date_actuel =  date('Y-m-d');
              $mois =explode('-',$date_actuel);
             $xx = (int)$mois[1];
              $list_data = [];

           foreach($data as $key =>$values) {
                $date_x = explode('-',$values['date']);
               // ECRIRE LA date au format francais
              $mois_x = (int)$date_x[1];
               if($mois_x == $xx OR $mois_x==$xx-1) {
                       $list_data[] =[
                        'date'=>$values['date'],
                         'montant'=>  number_format($values['total_montant'],2,',','')
                     ];
                }

         }

        }

         return view('gestion.nicerecette',['list_data'=>$list_data]);

    }

    
   public function recettemarseille()
   {

        if(Auth()->user()->is_admin==1)
        {

            $data = $this->caissenice->getrecettemarseille();

            $date_actuel =  date('Y-m-d');
             $mois =explode('-',$date_actuel);
               $xx = (int)$mois[1];
             $list_datas = [];
            foreach($data as $key =>$values) {
               $date_x = explode('-',$values['date']);
               // ECRIRE LA date au format francais
                $mois_x = (int)$date_x[1];

                if($mois_x == $xx OR $mois_x == $xx-1){
                         $list_datas[] =[
                         'date'=>$values['date'],
                         'montant'=>  number_format($values['total_montant'],2,',','')
                        ];
                 }
            }

        }

          return view('gestion.marseillerecette',['list_datas'=>$list_datas]);

    }

    public function recetteinternet()
    {
        if(Auth()->user()->is_admin==1) {
             $data = $this->caissenice->getinternetrecette();
             // recupérer l'historique des montant de recette qui ont été affecté par des lives.
            $result_date =  $this->historiquelive->getdatelivesomme();
            // recupérer pour les code élèves 
            $result_code_eleve = $this->historiquelive->getCodes();
             $date_actuel =  date('Y-m-d');
             $mois =explode('-',$date_actuel);
             $xx = (int)$mois[1];
             $list_datas = [];
             $result_data =[];
          
             foreach($data as $key =>$values){
               $date_x = explode('-',$values['date']);
                // ECRIRE LA date au format francais
               $mois_x = (int)$date_x[1];

               // recupérer le montant des lives 
               $montant_live = array_search($values['date'],$result_date);
               // recupérer les montant pour les codes élèves.
               $montant_code_eleve = array_search($values['date'],$result_code_eleve);
               
               if($montant_live==false){
                  $message="";
                  $monts_live ="";
                  $css="falsevue";
               }

               if($montant_code_eleve==false){
                $messages="";
                $monts_code ="";
                $css="falsevue";
             }


               if($montant_live ==true){
                $montant_s = explode(',',$montant_live);
                    $monts_live = $montant_s[0];
                  if($monts_live > $values['total_montant']){
                      $message="";
                      $monts_live="";
                      $css="falsevue";
                    }

                    else{
                       $message="Dont lives  $monts_live €";
                       $css="truevue";
                    }
               }


               if($montant_code_eleve ==true){
                $montant_ss = explode(',',$montant_code_eleve);
                    $monts_code = $montant_ss[0];
                  if($monts_code > $values['total_montant']){
                      $messages="";
                      $monts_code="";
                      $css="falsevue";
                    }

                    else{
                       $messages="Dont élève  $monts_code €";
                       $css="truevue";
                    }
               }


                if($mois_x == $xx OR $mois_xx = $xx-1){

                  $number_date = explode('-',$values['date']);
                  $number_id_date = $number_date[0].''.$number_date[1].''.$number_date[2];
                  $list_datas[] =[
                    'date'=>$values['date'],
                     'montant'=>  number_format($values['total_montant'],2,',',''),
                     'live_montant' => $message,
                     'code_montant' => $messages,
                     'css' => $css,
                     'number_id_date'=>$number_id_date
                    ];

             }

           }

        }


         return view('gestion.internetrecette',['list_datas'=>$list_datas,'css'=>$css]);

    }


    public function getlives(Request $request)
    {
          
          $id = $request->get('id');
          $date = $id;
          // recupérer les données les amabassadrice de ce live.
          $result = $this->historiquelive->getdatechecklive($date);
          $array_data =[];
          foreach($result as $key => $val){
             $array_data[] = $val['data'];
            }
             $somme = $array_data[0];
            echo json_encode(['somme' => $somme,'array_data'=>$array_data]);
          
       }


       public function  statsdata(Request $request)
       {
            // recupérer la liste des ambassadrice....
             $id= $request->get('ambassadrice');
             $annee = $request->get('annee');

             $custom = $request->get('customer_amba');
             // recupérer la nature de l'activité du code live ou eleve..
             $code =$request->get('nature_code');

             if($custom!="" && $code!==""){
                $this->historique->getcustomers($custom,$code);
             }
             
             if($id!="" && $annee!=""){
                $this->historique->gethistoriqueventes($id,$annee);
             }

             if($annee!="" && $id==""){
                $this->historique->gethistoriquevente($annee);
             }

             $result_datas = $this->historique->gethistorique();
             $result_name = $this->historique->getDataid();
            
            // recupérer les données 
            // recuper les infos des ambassadrice....
            //..............recupérer les données ...........
             $this->users->getUser();
             $users = $this->users->getUsrs();
             $data = $this->point->getAllfactures();
             $lis = json_encode($data);
             $list = json_decode($data,true);
             $result_data =[];
              
              dump($users);
              dd($list);
             // 
             // recupérer les chiffre 
             $result_somme_eleve =[];
             $result_somme_live =[];
             $result_data_mois =[];
             foreach($list as $val){

               // recupérer les montant...
                if($val['somme_live']!=0 OR $val['somme_eleve']!=0){
                   if($val['is_admin']==2){
                    $total = $val['somme_live']+$val['somme_eleve'];
                    $pourcentageeleve = $val['somme_eleve']*100/$total;
                    $pourcentagelive = $val['somme_live']*100/$total;
                    $montant_live = number_format($val['somme_live'],2,',',' ');
                    $montant_eleve = number_format($val['somme_eleve'],2,',',' ');
                    $pr_eleve = number_format($pourcentageeleve, 2, ',', ' ');
                    $pr_live = number_format($pourcentagelive, 2, ',',' ');
                    $donnees = " Gain live(%) : $pr_live% ; Gain élève(%) : $pr_eleve%";
                    // recupérer le nom de l'ambassadrice.
                    $chaine_name = array_search($val['id_ambassadrice'],$users);
                    if($chaine!=false){
                      $name = explode(',',$chaine_name);
                      $result_data[] =[
                        'periode'=> $val['mois'].'  '.$val['annee'],
                        'name' =>$name[1],
                        'commission_live'=> $montant_live,
                        'commission_eleve'=>$montant_eleve,
                        'pourcentage'=> $donnees
                
                     ];
                  }
                 
                    $result_somme_eleve[] = $val['somme_eleve'];
                     $result_somme_live[] = $val['somme_live'];
               }
              }

               
             return view('gestion.statsdata',['result_data'=>$result_data,'result_datas'=>$result_datas,'result_name'=>$result_name]);
        }

    
      public function assoc_product()
       {
           // lister les produits existant;
            $data = DB::table('product_woocommerces')->select('token','libelle','ids_product','id_variations')->get();
             $lis = json_encode($data);
             $list = json_decode($data,true);
             // créer des tableau associative entre ids_product et ids , libelle.
              $libelle_product =[];
              $ids_product_assoc =[];
                $id_variations_assoc =[];

               foreach($list as $values) {

                     $chaine = $values['libelle'].','.$values['ids_product'];
                    $chaine1 = $values['id_variations'].'%'.$values['ids_product'];
                     $array_data_soc[$chaine] = $values['ids_product'];
                     $array_data_assoc[$chaine1] = $values['ids_product'];
                }

                // recupérer le tableau des variation passés
                 $this->setData($array_data_assoc);
                return $array_data_soc;

        }

       public function panier()
       {

            // lister et compter le nombre de panier à incremente
             $data = DB::table('configuration_panier_live')->select('id','panier_title','mont_mini','mont_max','libelle')->get();
             $lis = json_encode($data);
             $list = json_decode($data,true);
             $data_donnees =[];
             foreach($data as $val){

                $data_donnees[] =[
                   'panier_title'=> $val['panier_title'],
                   'mont_mini'=> $val['mont_mini'],
                   'mont_max'=>$val['mont_max'],
                    'libelle'=> $val['libelle']
                    ];

            }

             $nombre = count($list);
             return $nombre;

       }

      
       public function postconfig(Request $request)
       {
             // traitement de données pour recupérer les donées du formulaire

            //construire les données pour les paniers actif.
             $array1 = $this->assoc_product();

            $array2 =  $this->getData();
            $donnees  = $request->get('data1'); // array de datas panier 1
            $panier = $request->get('panier');
            $mont_max = $request->get('montant_max');
             $mont_mini = $request->get('montant_mini');
              $ch ="%%%dar"; //slog des id_prduit
              $ch1 ="v@@@";// slog des ids produit
             $ids_product =array();
             $ids_variantes =[];
              $libelle = [];

            // recupérer des chaines
               foreach($panier as $key => $valc){
                  $chaine = explode(',',$donnees[$key]);

                 foreach($chaine as $valc){
                    foreach($valc as $p) {

                          if(strpos($p,$ch) !==false){
                             $x = substr($p,0,-6);
                             $ids_product[] = $x;// les ids_product
                        }

                      elseif(strpos($p,$ch1) !==false){
                       $ids_variantes[] = substr($p,0,-4);// les ids_variations

                       } else{
                               $libelle[] = $p;  // recupérer les libéllé forcement
                          }

                            // Recupérer les ids_variation

                 }

              }

                 $ids_product = implode(',',$ids_product);
                 $ids_variantes = implode(',',$ids_variantes);
                 $libelle = implode(',',$libelle);
                 // flus en bdd

                   $panierlive = new ConfigurationPanierLive();
                   $panierlive->panier_title = $panier[$key];
                   $panierlive->libelle = $libelle;
                   $panierlive->ids_produit =$ids_product;
                    $panierlive->ids_variation = $ids_variantes;
                   $panierlive->mont_mini = $mont_mini[$key];
                   $panierlive->mont_max = $mont_max[$key];
                   $panierlive->save();

               

            }

                
            dd('jolie code');

           

           

           

           /* $donnees1 = $request->get('data2'); //panier 2

            

            

            $donnees2 = $request->get('data3'); // panier 3

            

            // recupérer les id_produit , les ids_variant et libelle. 

            $ids_product =[];

            $ids_variantes =[];

            $libelle = [];

            

            

            // recupérer les id_produit , les ids_variant et libelle. 

            $ids_product2 =[];

            $ids_variantes2 =[];

            $libelle2 = [];

            

            

            $ch ="%%%dar"; //slog des id_prduit

            $ch1 ="v@@@";// slog des ids produit

            

            

            

            // PANIER 2

            foreach($donnees as $val2)

            {

                $chaine[] = explode(',',$val2);

                

            }

            

            

            

            foreach($chaine as $valc)

            {

                 foreach($valc as $p)

                 {

                 

                    if(strpos($p,$ch) !==false)

                      {

                          $ids_product[] = substr($p,0,-6);// les ids_product

                       }

                       

                     elseif(strpos($p,$ch1) !==false)

                      {

                          $ids_variantes[] = substr($p,0,-4);// les ids_variations

                       }

                       

                       else{

                           

                           $libelle[] = $p;  // recupérer les libéllé forcement

                       }

                       

                     

                     // Recupérer les ids_variation

                 }

            }

            

            

            

            $ch2 ="%%%dar"; //slog des id_prduit

            $ch12 ="v@@@";// slog des ids produit

            

            foreach($donnees1 as $val2)

            {

                $chaine2[] = explode(',',$val2);

                

            }

            

            

            

            foreach($chaine2 as $valc2)

            {

                 foreach($valc2 as $p2)

                 {

                 

                    if(strpos($p2,$ch2) !==false)

                      {

                          $ids_product2[] = substr($p2,0,-6);// les ids_product

                       }

                       

                     elseif(strpos($p2,$ch12) !==false)

                      {

                          $ids_variantes2[] = substr($p2,0,-4);// les ids_variations

                       }

                       

                       else{

                           

                           $libelle2[] = $p2;  // recupérer les libéllé forcement

                       }

                       

                     

                     

                 }

            }

            

            

            // Récuperer les ids_product et construire les données à manger dans le panier niveau1!

            $line_get_affich =[];

             $line_get_affich1 =[];

            $token = Str::random(60);

            foreach($ids_product as $vad)

            {

                $ids_pr = array_search($vad,$array1);

                

                $ids_p =  explode(',',$ids_pr); //LES LIBELLES

                

                $ids_var = array_search($vad,$array2);// les variation

                

                $ids_va  = explode('%',$ids_var);

                

                // créer un token utilie panier

                $code = str_shuffle($token.$vad);// create token unique via un produit par panier ....

                $line_get_affich[] = [

                    

                 'id_product' => $vad,

                 'ids_variation'=>$ids_va[0],

                 'libelle' =>$ids_p[0],

                 'token'=> $code,

                 'pseudo'=>"panier1"

                    

                    

                    ];

            }

            

            

            

            // PANIER 2

             foreach($ids_product2 as $vad)

             {

                $ids_pr = array_search($vad,$array1);

                

                $ids_p =  explode(',',$ids_pr); //LES LIBELLES

                

                $ids_var = array_search($vad,$array2);// les variation

                

                $ids_va  = explode('%',$ids_var);

                

                // créer un token utilie panier

                $code = str_shuffle($token.$vad);// create token unique via un produit par panier ....

                $line_get_affich2[] = [

                    

                 'id_product' => $vad,

                 'ids_variation'=>$ids_va[0],

                 'libelle' =>$ids_p[0],

                 'token'=> $code,

                 'pseudo'=>"panier2"

                    

                    

                    ];

             }

            

            

           dump($line_get_affich);

            

           dump($line_get_affich2);

            

            dd();

            

            /*

            // recupérer les données du panier

              $panier = $request->get('panier1');

              $ids_product1 = implode(',',$ids_product);

              $ids_variantes1 = implode(',',$ids_variantes);

              $libelle1 = implode(',',$libelle);

              $mont_max = $request->get('montant_max1');

              $mont_mini = $request->get('montant_mini1');

              

              

              // recupérer les données du panier2

              $panier2 = $request->get('panier2');

              $ids_product12 = implode(',',$ids_product2);

              $ids_variantes12 = implode(',',$ids_variantes2);

              $libelle12 = implode(',',$libelle2);

              $mont_max2 = $request->get('montant_max2');

              $mont_mini2 = $request->get('montant_mini2');

              

              // flus en bdd

               $panierlive = new ConfigurationPanierLive();

               $panierlive->panier_title = $panier;

               $panierlive->libelle = $libelle1;

               $panierlive->ids_produit =$ids_product1;

               $panierlive->ids_variation = $ids_variantes1;

               $panierlive->mont_mini = $mont_mini;

               $panierlive->mont_max = $mont_max;

               

               $panierlive->save();

               

               

               // flus en bdd PANIER 2

               $panierlive2 = new ConfigurationPanierLive();

               $panierlive2->panier_title = $panier2;

               $panierlive2->libelle = $libelle12;

               $panierlive2->ids_produit =$ids_product12;

               $panierlive2->ids_variation = $ids_variantes12;

               $panierlive2->mont_mini = $mont_mini2;

               $panierlive2->mont_max = $mont_max2;

               

               $panierlive2->save();

               

               

               // recupérer les ids des produits 

               

              

              // insert dans la bdd .

          

          */

    

    

    

      }

      
     public function listerpanier()
     {

           return view('ambassadrice.listerpanier');

      }

    
      public function getEventCalendarLive(Request $request){

        if(Auth()->user()->is_admin == 1 OR Auth()->user()->is_admin == 3){

            $id_live = $request->get('id_live');

          if($id_live){

            $data_live = $this->choixpanierlive->getByIdLive($id_live);
            if($data_live){
                $live = $data_live;
            } else {
                $live = $this->historiquelive->getByIdLive($id_live);
            }
            
            $tokens = explode(',', $live[0]['token_datas']);
            $list_products = $this->panierlive->getByTokens($tokens, ['libelle', 'panier_title', 'panier_title', 'mont_mini']);
            $products = [];

            foreach($list_products as $product){
                if(isset($products[$product['panier_title']])){
                  array_push($products[$product['panier_title']], $product);
                } else {
                  $products[$product['panier_title']] =  [$product];
                }
            }
                echo json_encode($products);  
          }
        } 
      }

      public function getEventCalendar(){
         // Adrien
        if(Auth()->user()->is_admin == 1 OR Auth()->user()->is_admin == 3){
            $lives_incoming = DB::table('codelives')->select('name as title','date_expire as start', 'choix_panier_lives.id_live as id')->join('users', 'users.id', '=', 'codelives.id_ambassadrice')
            ->join('choix_panier_lives', 'choix_panier_lives.code_live', '=', 'codelives.code_live')->where('css', 'activecode')->get()->toArray();
            $lives_past = DB::table('historique_panier_lives')->select('name as title','date_live as start','historique_panier_lives.id_live as id' )->join('users', 'users.code_live', '=', 'historique_panier_lives.code_live')->get()->toArray();
            
            $lives = array_merge($lives_incoming, $lives_past);
            $values_unique = array_unique($lives, SORT_REGULAR);

            $list = []; 
            foreach($values_unique as $value){
                $list [] = $value;
            }

            return $list;
        } else if(Auth()->user()->is_admin == 2){
            $lives_incoming = DB::table('codelives')->select('name as title','date_expire as start', 'choix_panier_lives.id_live as id', 'img_select as img')->join('users', 'users.id', '=', 'codelives.id_ambassadrice')
            ->join('choix_panier_lives', 'choix_panier_lives.code_live', '=', 'codelives.code_live')->where('css', 'activecode')->get()->toArray();
        
            $values_unique = array_unique($lives_incoming, SORT_REGULAR);

            $list = []; 
            foreach($values_unique as $value){
                $list [] = $value;
            }
            return $list;
        }
      }

       public function recettenices()
       {
           $data = $this->caissenice->getnicemensuel();
           return view('gestion.recettesnices',['data'=>$data]);
       }

       public function recettemarseilles()
       {
          //$data = $this->caissenice->getinternetmensuel();

          $data = $this->caissenice->getmarseillemenseul();
          return view('gestion.recettesmarseilles',['data'=>$data]);

       }

       public function recetteinternets()
       {
            $data = $this->caissenice->getinternetmensuel();
            return view('gestion.recettesinternets',['data'=>$data]);
       }
    

     public function viewcalendar(Request $request){
        return view('gestion.calendar');
     }


    public function getcontrols()
    {
        $data =  $this->customs->doublonscreate();
        dd($data);
        return view('gestion.controls');
    }
     
     public function getmois($moi)
     {

         if($moi=="01"){
           $mo ="Janvier";
         }

          if($moi=="02"){
             $mo="février";

         }

          if($moi=="03"){
             $mo ="Mars";
          }

         if($moi=="04"){
              $mo="Avril";

         }

          if($moi=="05"){
            $mo ="Mai";

         }

          if($moi=="06"){
              $mo="Juin";

         }

         if($moi=="07"){
            $mo="Juillet";

         }

          if($moi=="08"){
            $mo="Aout";

         }

         if($moi=="09"){
             $mo="septembre";
          }

          if($moi=="10"){
              $mo="Octobre";
           }

         if($moi=="11") {
            $mo="Novembre";

         }

          if($moi=="12"){
            $mo="Déc";

         }

         return $mo;

     }

     

    

    

      

}

    