<?php

namespace App\Http\Controllers\Utilisateurs;

use File;
use Mail;
use DateTime;
use Exception;
use ZipArchive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Dashboardtier;
use App\Models\Controlefacture;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\CallApi\Diffproduct;
use App\Http\Service\CallApi\NombreOrders;
use App\Repository\Dashboardtiers\DashboardtiersRepository;

class SuiviController extends Controller
{
    
    
    private $diffproduct;
    
    private $dash;

    private $api;

    private $orders;

    
    public function __construct(
    Diffproduct $diffproduct, 
    DashboardtiersRepository $dash, 
    NombreOrders $orders,
    Apicall $api)
    {
        
        $this->diffproduct = $diffproduct;
        $this->dash = $dash;
        $this->orders = $orders;
        $this->api = $api;
        
    }
    
    
    public function newtiers(Request $request)
    {

        try{

         $data = $this->diffproduct->getDatatiers();
    
         $this->orders->getDataorder();
         
         // recupérer le nom de commande avec le status processing en cours actuel dans bdd
          // recupérer des emails 
         /*$x1=[]; //email
         $x2 = []; //phone
         foreach($data as $key=>$lm)
         {
            if($lm['email']!="")
            {
              $x1[]= $lm['email'].'  '.$lm['phone'];
              $x2[] =$lm['phone'];
              $x5[] = $lm['email'];
            }
         }
         
         //
         // faire des tableau count values pour compter les index similaiee au sein du tableau
         $x3 = array_count_values($x1);
         $x6 =  array_count_values($x5);
        
         
        // recupérer les index qui sont plus de deux !
        $x4 =[];
        $x7 =[];
        foreach($x3 as $kc=>$ml)
        {
            if($ml > 1)
            {
                $x4[]= $kc;
            }
        }
    
        
        foreach($x6 as $kn=>$valc)
        {
            if($valc > 1)
            {
                $x7[]= $kn;
            }
        }
        
        
        // recupérer les emails en doublons ayant utiliser un phone unique.
        
        foreach($x4 as $vd)
        {
            $dd = explode(' ',$vd);
            
            $x11[]= $dd[0];
        }
        
      
       // faire resortir la liste des email
       $liste_email = [];
      
      $liste_email = array_diff($x7,$x11);
       dd($liste_email);
     */  
         $data_code_client = [];
         
         $data_client_now = [];
         // recupérer la date actuel
         $date_actuel  = date('Y-m-d');
         
         $date_statique ='2022-09-01';// à partir du 1 er septembre !
         
         // initialiser les tableau
         
         $data_client_marseille = [];
         $data_client_nice = [];
         $data_client_internet =[];
         
        foreach($data as $key => $values) {
            
           if($values['client']==1){

            $timestamp = $values['date_creation'];
                     // Le format
                      $timestamp = $values['date_creation'];
                       $format = "Y-m-d";
                    // Formatage en jour, mois, année, heure, minutes et secondes
                     $datefixe = date($format, $timestamp); 
                 if($date_actuel==$datefixe){
                    
                    if($values['name_alias']=="woocommerce"){
                        $data_client_internet[] = $values['code_client'];
                    }
                 }
            
            foreach($values['array_options'] as $valc) {
                 // convertir la date au format souhaite
                 $date=date('Y-m-d');
                 // recupére la date courate actuel(format date) .
                 $date_jour = date("Y-m-d", strtotime($date.'+ 0 days'));
                // recupérer le mois le jour et la date
                 $dat = explode('-',$date);
                 $annee = $dat[0];
                 $jour = $dat[2];
                 $mois = $dat[1];
                 $dates = $values['date_creation'];
          
                if($dates!=""){
                     // Timestamp
                     $timestamp = $values['date_creation'];
                     // Le format
                       $format = "Y-m-d";
                    // Formatage en jour, mois, année, heure, minutes et secondes
                     $datefixe = date($format, $timestamp); 
                 
                   if($datefixe > $date_statique) {
                       $data_code_client[]= [
                        $datefixe=>$values['code_client']
                         
                         ];
                   }

                  if($datefixe == $date_actuel){
                        $data_client_now[] = $values['code_client'];// via nice
                         // recupérer les nombre pour les ville.(MARSEILLE,NICE,Internet)
                          
                         if($valc ==1) {
                            $data_client_internet[] = $values['code_client'];
                         }
                     
                         if($valc ==2){
                           $data_client_marseille[] = $values['code_client'];
                         }
                     
                        if($valc ==3) {
                            $data_client_nice[] = $values['code_client'];
                        }

                        
                     }
               }
             }
          }
        }

        
           $x = array_unique($data_client_now);
           // recupére le nombre de nouveau client à ce jour
           // compte le nombre de client  par ville
            $nombre_new_marseille = count($data_client_marseille); // via marseille.
            $nombre_new_nice = count($data_client_nice);// via nice
            $nombre_new_internet = count(array_unique($data_client_internet)); // via internet
            $nombre_new_now = $nombre_new_marseille + $nombre_new_nice+$nombre_new_internet;
            $number = $nombre_new_now;
            // verifier si la date existe dans la bdd faire un update sur le nombre
            $data_date = $this->dash->getallsdate();
            $count_data =[];// compter le nombre d'iteration du tableau
            $number = $nombre_new_now;
            foreach($data_date as $val) {
                $count_data[] = $val['date'];
            }
        
             // recupérer le nombre existant
             $nombre_existant ="";
         
              foreach($this->dash->getalldate($date) as $key => $vali){
                  $nombre_existant = $vali['nombre'];
                  $nombre_marseille_existant = $vali['nombre_marseille'];
                  $nombre_nice_existant = $vali['nombre_nice'];
                  $nombre_internet_existant = $vali['nombre_internet'];
             
              }
        
              // si une ligne existe dans la bdd faire un update du nombre
             if(count($count_data)!=0) {
                    // faire un update du number dans ces cas 
                   // modifier le nombre equivalent à la date.
                 if($nombre_existant!=$nombre_new_now) {
                     $nombre_client = $nombre_existant+($nombre_new_now-$nombre_existant);
                     $nombre_marseille_client = $nombre_marseille_existant + ($nombre_new_marseille-$nombre_marseille_existant);
                     $nombre_nice_client = $nombre_nice_existant +($nombre_new_nice -$nombre_nice_existant);
                      $nombre_internet_client = $nombre_internet_existant +($nombre_new_internet - $nombre_internet_existant);
                       $this->dash->updatenumber($date,$nombre_client,$nombre_marseille_client,$nombre_nice_client,$nombre_internet_client);
                 }
                else{

                }
              }
          else{
            if($nombre_new_now !=0){
                // insert dans la bdd les infos dashboardtiers
                $this->dash->insert($date,$mois,$annee,$number,$nombre_new_marseille,$nombre_new_nice,$nombre_new_internet,$jour);
             }
             //    dd('de nouveaux client recupérer à la date');
            }

        if($request->from_cron){
            $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
        } else {
            $from_cron = true;
        }


        $data = ['name' => 'update_dashboard_dolibarr', 'origin' => 'connect', 'error' => 0,
        'message' =>  null, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
        echo $this->api->insertCronRequest($data);
       

    } catch (Exception $e) {
        if($request->from_cron){
            $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
        } else {
            $from_cron = true;
        }

        $data = ['name' => 'update_dashboard_dolibarr', 'origin' => 'connect', 'error' => 1,
        'message' => $e->getMessage(), 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
        echo $this->api->insertCronRequest($data);
    } 

     
         // recupérer un email 
        //  return view('api.newtiers');
    }
    
    
    
    public function doublonsfact(Request $request)
    {
        
              // recuperer les données api dolibar propers prod tous les clients.
              // actualisation de la table categorie-products...
               $datas_facture = DB::connection('mysql2')->select("SELECT fk_categorie,fk_product,import_key  FROM llxyq_categorie_product");
               $datas = json_encode($datas_facture);
               $datas = json_decode($datas,true);
                $resultat =[];

               foreach($datas as $values){
                    $resultat[] = [

                     'fk_categorie'=>$values['fk_categorie'],
                     'fk_product' => $values['fk_product'],
                     'import_key'=> $values['import_key']
                  ];

               }

                // suprimer la table .
                DB::table('categorie_products')->truncate();

               // la remplie par les nouveaux.
                DB::table('categorie_products')->insert($resultat);

                dd('ok');
              

            /*   $method = "GET";
               $apiKey = env('KEY_API_DOLIBAR_PROD');
               $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
               //Recuperer les ref et id product dans un tableau
               $produitParam = ["limit" => 10000, "sortfield" => "rowid","sortorder" => "DESC"];
                $data = $this->diffproduct->getFacturedol2();
               // taitement des doublons
              // recupérer les données créer un tableau associatives entre les ids client et le montant,et ref facture
                $data_customer =[]; // recupérer ids avec le montant de la facture.
               $data_customer_ref_facture =[];// recupérer ids client et la ref facture
            
               $data_date =[];// recupérer les date des facture pour les socids;
            
              $facture ="TC4-";
              $facture1 ="TC1-";
              $facture2 ="PROV";

             foreach($data as $key => $values){
                
                if(strpos($values['ref'],$facture)==false OR strpos($values['ref'],$facture1)==false  OR strpos($values['ref'],$facture2)==false) {

                        $x = date('d-m-Y', $values['date']);
                        $x_true = date('Y-m-d', $values['date']);// recupérer la date au format souhaité
                        
                        $date_comparate="2022-10-09"; // recupérer les données après le 04 octobre 2022// initialisation la récupération des données.
                    
                        if($x_true > $date_comparate){
                            // convertir la date au format souhaite
                            $x1  = date("Y-m-d", strtotime($x.'+ 1 days'));
                            // recupérer les données dans les array .
                            $ligne_montant = $values['socid'].','.$values['total_ht'];
                            $data_ligne[$ligne_montant] = $values['socid'];
                            $data_customer[] = $values['socid'].','.$values['total_ht']; // fixer les socid client avec le montant de la facture.
                    
                            $data_customer_ref_facture[] = $values['socid'].','.$values['ref']; // recupérer les socid et les ref facture.
                    
                                $data_date[] = [ 
                                                $values['socid'].','.$x1.','.$values['ref']// socid et date de creéation de facture..
                                            ];
                        }
                   }
              }

               // verifier les doublous trouvers
               $data_doublons = array_count_values($data_customer);
               // recupérer les doublons 
               $data1 =[];
               //
              foreach($data_doublons as $kx => $val){
                   // recupére les doublons de ligne dans un array $data1
                  if($val == 2) {
                      $data1[] = $kx.','.$val;
                      $d = explode(',',$kx);
                      // recupérer les ids client qui respecte les doublons intégrer au meme montant
                      $a1[] = $d[0];
                   }
               }

            
                if(count($data1)){
                     // recupérer les données de controle dans une bdd
                     // recupérer depuis dans les données depuis la bdd;
                     $donnees_ids =  DB::table('controlefactures')->select('socid','montant')->get();
                     // transformer en tableau 
                     $list = json_encode($donnees_ids);
                     $lists = json_decode($donnees_ids,true);
                     $tab_control =[];// recuperer les montant et socid dans un tableau
                
                     foreach($lists as $vec){
                         $tab_control[] = $vec['socid'];
                     }
                
                     foreach($data1 as $cal){
                        $tabc = explode(',',$cal);
                        $chaine = $tabc[0].','.$tabc[1];
                        // faire un appel  pour recupérer les code_client ou nom des clients 
                        // susceptible d'un controle de facture en doublons.
                        $i = $tabc[0];
                        $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties/$i", $produitParam);
                        $lists_data[] = json_decode($listproduct,true);
                    
                     }
                
                    // verfier
                     // enregistrer les données dans la table.
                        foreach($lists_data as $donnees){
                                $chaine  = $donnees['id'];
                                $montant = array_search($donnees['id'],$data_ligne);
                                $montants = explode(',',$montant);
                              if(!in_array($chaine,$tab_control)){
                                     $control = new Controlefacture();
                                     $control->socid = $donnees['id'];
                                      $control->montant =$montants[1];
                                      $control->code_client = $donnees['code_client'];
                                      $control->nom = $donnees['name'];
                                      // insert bdd
                                      $control->save();
                               }
                        }
                  }


 
                if($request->from_cron){
                    $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
                } else {
                    $from_cron = true;
                }
        
        
                $data = ['name' => 'detect_double_dolibarr', 'origin' => 'connect', 'error' => 0,
                'message' =>  null, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
                echo $this->api->insertCronRequest($data);
       
            } catch (Exception $e) {
                if($request->from_cron){
                    $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
                } else {
                    $from_cron = true;
                }
        
                $data = ['name' => 'detect_double_dolibarr', 'origin' => 'connect', 'error' => 1,
                'message' => $e->getMessage(), 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
                echo $this->api->insertCronRequest($data);
            } 
       // recupérer les données $tab1
       
       */
        // return view('api.doublonsfact');
    }


    public function doublonslist()
    {
        if(Auth()->user()->is_admin ==3)
        {
           // verifier si le token est dans notre base de données.
             // tranformer le retour json en array tableau...
             $name_l = DB::table('controlefactures')->select('id','nom','code_client','created_at')->orderBy('id','desc')->take(20)->get();
             $name_lists = json_encode($name_l);
             $name_list = json_decode($name_l,true);
             $data_donnes =[];
             // traiter le retour .
             foreach($name_list as $val)
             {
                // recupérer la date du live +48h  pour passer l'actif en 0 après l'activation de live
                  $date = date('Y-m-d H:i:s');
                  $end_date = date("Y-m-d H:i:s", strtotime($val['created_at'].' +3 days'));  

                  $date2 = date("d-m-Y H:i:s", strtotime($val['created_at']));  
                    // convertir en francais la date
                     // recupérer la date du live +48h  pour passer l'actif en 0 après l'activation de live
                      // lister des données.

                      $data_donnes[] =[
                         'code_client'=>$val['code_client'],
                         'nom'=>$val['nom'],
                         'date'=>$date2 ,
                         'id' => $val['id'],
                     
                       ];

                    

                 }
             

              return view('utilisateurs.listdoublons',['data_donnes'=>$data_donnes]);
        }
    }
    
     // telecharger les facture mensuel dans un dossier zip
    
    public function downloadZip(Request $request)
    {
         // recupérer les données
         $number_mois = $request->get('mois_cours');
         $annee = $request->get('date_year');
         // recupérer le type de mois en varchar
         $datets = date('Y-m-d');
         $datet = explode('-',$datets);
         
         if($annee=="selected")
         {
             if($number_mois=="selected")
             {
                 $number_mois = 1;
                 $mois = "Janvier";
                 
                 $annee = $datet[0];
             }
         }
         
         
         // recupérer le type de mois en varchar
         
         $mois = $this->getMois($number_mois);
         $zip = new ZipArchive;
         // le nom du dossier
         $name_dossier ="$mois-$annee-facture";
   
        $fileName = "$mois-$annee-facture.zip";
        
        $path = "storage/$name_dossier";
   
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
        {
            $files = File::files(public_path("storage/$name_dossier"));
   
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
             
            $zip->close();
        }
    
        return response()->download(public_path($fileName));
        
        
    }


    public function datactioncron7($token,Request $request)
    {
       
        if($token=="67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb")
           {
               
        
            try{
                // recuperer les données api dolibar propers prod tous les clients.
                  $method = "GET";
                  $apiKey ="9W8P7vJY9nYOrE4acS982RBwvl85rlMa";
                  $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
                 //Recuperer les ref et id product dans un tableau
                   $produitParam = ["limit" => 500, "sortfield" => "rowid","sortorder" => "DESC"];
          
                   $data = $this->diffproduct->getFacturedol2();
                    // taitement des doublons
                     // recupérer les données créer un tableau associatives entre les ids client et le montant,et ref facture
                    $data_customer =[]; // recupérer ids avec le montant de la facture.
                    $data_customer_ref_facture =[];// recupérer ids client et la ref facture
                    $data_date =[];// recupérer les date des facture pour les socids;..
              
                    $facture ="TC4-";
                    $facture1 ="TC1-";
                    $facture2 ="PROV";
                    $facture3 ="FA";
  
               foreach($data as $key => $values)
               {
                  
                  if(strpos($values['ref'],$facture)==false OR strpos($values['ref'],$facture1)==false  OR strpos($values['ref'],$facture2)==false)
                  {
  
                          $x = date('d-m-Y', $values['date']);
                          $x_true = date('Y-m-d', $values['date']);// recupérer la date au format souhaité
                          
                          $date_comparate="2022-10-09"; // recupérer les données après le 04 octobre 2022// initialisation la récupération des données.

                          if($x_true > $date_comparate)
                          {
                              // convertir la date au format souhaite
                              $x1  = date("Y-m-d", strtotime($x.'+ 1 days'));
                              // recupérer les données dans les array .

                              $ligne_montant = $values['socid'].','.$values['total_ht'];
                              $data_ligne[$ligne_montant] = $values['socid'];
                             
                              $data_customer[] = $values['socid'].','.$values['total_ht']; // fixer les socid client avec le montant de la facture.
                      
                              $data_customer_ref_facture[] = $values['socid'].','.$values['ref']; // recupérer les socid et les ref facture.
                      
                                  $data_date[] = [ 
                                                  $values['socid'].','.$x1.','.$values['ref']// socid et date de creéation de facture
                                              ];
                      }
                  
                  }
              
              }
  
               // verifier les doublous trouvers
                $data_doublons = array_count_values($data_customer);
                // recupérer les doublons 
                $data1 =[];
                 //
                foreach($data_doublons as $kx => $val)
                {
                     // recupére les doublons de ligne dans un array $data1
                    if($val == 2)
                    {
                        $data1[] = $kx.','.$val;
                        $d = explode(',',$kx);
                        // recupérer les ids client qui respecte les doublons intégrer au meme montant
                        $a1[] = $d[0];
                     }
                 }
  
              
                  if(count($data1))
                  {
                       // recupérer les données de controle dans une bdd
                       // recupérer depuis dans les données depuis la bdd;
                       $donnees_ids =  DB::table('controlefactures')->select('socid','montant')->get();
                       // transformer en tableau 
                       $list = json_encode($donnees_ids);
                       $lists = json_decode($donnees_ids,true);
                       $tab_control =[];// recuperer les montant et socid dans un tableau
                  
                       foreach($lists as $vec)
                       {
                           $tab_control[] = $vec['socid'];
                       }
                  
                       foreach($data1 as $cal)
                       {
                          $tabc = explode(',',$cal);
                          $chaine = $tabc[0].','.$tabc[1];
                          // faire un appel  pour recupérer les code_client ou nom des clients 
                          // susceptible d'un controle de facture en doublons.
                          $i = $tabc[0];
                          $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties/$i", $produitParam);
                          $lists_data[] = json_decode($listproduct,true);
                      
                       }
                  
                        // verfier
                        // enregistrer les données dans la table.
                          foreach($lists_data as $donnees)
                          {
                                  $chaine  = $donnees['id'];
                                  $montant = array_search($donnees['id'],$data_ligne);
                                  $montants = explode(',',$montant);
                                  
                                if(!in_array($chaine,$tab_control))
                                {
                                       $control = new Controlefacture();
                                       $control->socid = $donnees['id'];
                                        $control->montant = $montants[1];
                                        $control->code_client = $donnees['code_client'];
                                        $control->nom = $donnees['name'];
                                        // insert bdd
                                        $control->save();
                                 }
                          }
                    }
  
  
   
                  if($request->from_cron){
                      $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
                  } else {
                      $from_cron = true;
                  }
          
          
                  $data = ['name' => 'detect_double_dolibarr', 'origin' => 'connect', 'error' => 0,
                  'message' =>  null, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
                  echo $this->api->insertCronRequest($data);
         
              } catch (Exception $e) {
                  if($request->from_cron){
                      $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
                  } else {
                      $from_cron = true;
                  }
          
                  $data = ['name' => 'detect_double_dolibarr', 'origin' => 'connect', 'error' => 1,
                  'message' => $e->getMessage(), 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
                   $this->api->insertCronRequest($data,false);
           }
       }

}


    // cron 
     public function getMois($moi)
     {
       
         if($moi=="1")
         {
             $mo ="Janvier";
         }
         
         if($moi=="2")
         {
             $mo="février";
         }
         
         if($moi=="3")
         {
             $mo ="Mars";
         }
         
         if($moi=="4")
         {
             $mo="Avril";
         }
         
         if($moi=="5")
         {
             $mo ="Mai";
         }
         
         if($moi=="6")
         {
             $mo="Juin";
         }
         
         if($moi=="7")
         {
             $mo="Juillet";
         }
         
         if($moi=="8")
         {
             $mo="Aout";
         }
         
         
         if($moi=="9")
         {
             $mo="Septembre";
         }
         
         if($moi=="10")
         {
             $mo="Octobre";
         }
         
         if($moi=="11")
         {
             $mo="Novembre";
         }
         
         if($moi=="12")
         {
             $mo="Decembre";
         }
         
         
         return $mo;
     }
    
    
}
      
      

    