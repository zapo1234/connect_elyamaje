<?php

namespace App\Http\Service\FilePdf;


class CreateCsv
{
        private $api;

        public function __construct()
        {
            
        }
        

  
        public function csvcreate(array $data)
        {
            
                $filename = "resort_produc_vente.csv";
                $fp = fopen('php://output', 'w');
                  // créer une entete du tableau .
                  $header = array('libelle','mois','quantite_vendu','stock_unique');
                  // gérer les entete du csv 
              
                header('Content-type: application/csv');
                header('Content-Disposition: attachment; filename=' . $filename);
                fputcsv($fp, $header);
                
                
                foreach ($data as $row) {
                fputcsv($fp, $row);
              }
              exit();
            
      }

      public function csvcreateentrepot(array $data)
      {
          
              $filename = "entrepot_stocks_vente.csv";
              $fp = fopen('php://output', 'w');
                // créer une entete du tableau .
                $header = array('id_product','entrepot','quantite','ref_product','categoris_name');
                // gérer les entete du csv 
               header('Content-type: application/csv');
              header('Content-Disposition: attachment; filename=' . $filename);
              fputcsv($fp, $header);
              
              
              foreach ($data as $row) {
              fputcsv($fp, $row);
            }
            exit();
          
    }


      public function statsventes(array $data)
      {
          
              $filename = "statistique_vente.csv";
              $fp = fopen('php://output', 'w');
                // créer une entete du tableau .
                $header = array('id_product','nom_produit','mois_vente','annee','total_vente');
                // gérer les entete du csv 
            
              header('Content-type: application/csv');
              header('Content-Disposition: attachment; filename=' . $filename);
              fputcsv($fp, $header);
              
              
              foreach ($data as $row) {
              fputcsv($fp, $row);
            }
            exit();
          
    }

    public function statsventess(array $data)
    {
        
            $filename = "vente_all.csv";
              $fp = fopen('php://output', 'w');
              // créer une entete du tableau .
              $header = array('id_product','nom_produit','mois_vente','annee','total_vente','categoris_name');
              // gérer les entete du csv 
          
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            
            
            foreach ($data as $row) {
            fputcsv($fp, $row);
          }
          exit();
        
  }



      public function create(array $data, $filename)
      {
             $fp = fopen('php://output', 'w');
              header('Content-type: application/csv');
              header('Content-Disposition: attachment; filename=' . $filename);

              foreach ($data as $row) {
                  fputcsv($fp, $row);
                }
              exit();
          
      }


      public function createentrepot(array $datas,$libelle)
      {
           $filename = "entrepot_vente.csv";
            $fp = fopen('php://output', 'w');
          // créer une entete du tableau .
          $header = $libelle;
          // gérer les entete du csv 
           header('Content-type: application/csv');
          header('Content-Disposition: attachment; filename=' . $filename);
           fputcsv($fp, $header);
        
        
        foreach ($datas as $row) {
        fputcsv($fp, $row);
      }
        exit();

      }
      
       
      public function csvcreatelive(array $data)
      {
          
              $filename = "stat_live.csv";
              $fp = fopen('php://output', 'w');
                // créer une entete du tableau .
               $header = array('date_live','ambassadrice','commission','nombre_vente');
                // gérer les entete du csv 
              header('Content-type: application/csv');
              header('Content-Disposition: attachment; filename=' . $filename);
              fputcsv($fp, $header);
              
               foreach ($data as $row) {
              fputcsv($fp, $row);
            }
            exit();
       }


       public function createcsvrapport(array $data){
        $filename = "rapport_vente.csv";
        $fp = fopen('php://output', 'w');
          // créer une entete du tableau .
         $header = array('Ambassadrice','commission live','commission élève','commission_total','chifffre_affaire_généré','Live(%)','élève(%)');
          // gérer les entete du csv 
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        
         foreach ($data as $row) {
        fputcsv($fp, $row);
        }
        exit();

       }


       public function createcsvrapports(array $data){
          $filename = "rapport_vente.csv";
          $fp = fopen('php://output', 'w');
           // créer une entete du tableau .
          $header = array('Ambassadrice','Période','commission live','commission élève','commission_total','chifffre_affaire_généré','Live(%)','élève(%)');
          // gérer les entete du csv 
           header('Content-type: application/csv');
           header('Content-Disposition: attachment; filename=' . $filename);
           fputcsv($fp, $header);
        
           foreach ($data as $row) {
             fputcsv($fp, $row);
            }
          exit();

       }


       public function createcsvstatseleve(array $data){
        $filename = "rapport_code_elve.csv";
        $fp = fopen('php://output', 'w');
         // créer une entete du tableau .
        $header = array('Période','Nom','Nombre de code crée','Code utilisé');
        // gérer les entete du csv 
         header('Content-type: application/csv');
         header('Content-Disposition: attachment; filename=' . $filename);
         fputcsv($fp, $header);
      
         foreach ($data as $row) {
           fputcsv($fp, $row);
          }
        exit();

     }


     public function csvcolliship(array $datas)
     {
  
       $filename = "colliship_tiers.csv";
       $fp = fopen('php://output', 'w');
        // créer une entete du tableau .
         $header = array('Nom client','Email','Telephone','date_de_dons','date_premier_achat_client','nombre_Achat_realisé','status');
         // gérer les entete du csv 
        header('Content-type: application/csv');
       header('Content-Disposition: attachment; filename=' . $filename);
         fputcsv($fp, $header);
       
       
       foreach ($datas as $row) {
       fputcsv($fp, $row);
     }
        exit();
  
   }



       public function createcsvcustomers(array $data){
        $filename = "rapport_vente_clients.csv";
        $fp = fopen('php://output', 'w');
         // créer une entete du tableau .
        $header = array('Departements','Nombre_client');
        // gérer les entete du csv 
         header('Content-type: application/csv');
         header('Content-Disposition: attachment; filename=' . $filename);
         fputcsv($fp, $header);
      
         foreach ($data as $row) {
           fputcsv($fp, $row);
          }
        exit();

     }




       
       
       public function csvcreatestatistique(array $datas)
      {
      
           $filename = "statistique_vente.csv";
           $fp = fopen('php://output', 'w');
            // créer une entete du tableau .
             $header = array('email_cllient','phone','nombre_achat','date');
             // gérer les entete du csv 
         
           header('Content-type: application/csv');
           header('Content-Disposition: attachment; filename=' . $filename);
          fputcsv($fp, $header);
           
           
           foreach ($datas as $row) {
           fputcsv($fp, $row);
         }
        exit();
      
       }
       
       
       
       public function csvcreate_product(array $datas)
       {
      
           $filename = "client_achat.csv";
           $fp = fopen('php://output', 'w');
            // créer une entete du tableau .
             $header = array('email_cllient','phone','code_client','produit_achete','date');
             // gérer les entete du csv 
             header('Content-type: application/csv');
              header('Content-Disposition: attachment; filename=' . $filename);
              fputcsv($fp, $header);
           
             foreach ($datas as $row) {
           fputcsv($fp, $row);
         }
        exit();
      
       }
       
       
        public function csvcreate_client(array $datas)
       {
      
           $filename = "client_achat.csv";
           $fp = fopen('php://output', 'w');
            // créer une entete du tableau .
             $header = array('nom','code_client','email','phone');
             // gérer les entete du csv 
             header('Content-type: application/csv');
              header('Content-Disposition: attachment; filename=' . $filename);
              fputcsv($fp, $header);
           
             foreach ($datas as $row) {
           fputcsv($fp, $row);
         }
        exit();
      
       }
       
       
       public function customerlocal(array $datas)
       {
            $filename = "client_paris_regions.csv";
           $fp = fopen('php://output', 'w');
            // créer une entete du tableau .
             $header = array('nom','prenom','adresse','code_postal','ville','code_client');
             // gérer les entete du csv 
             header('Content-type: application/csv');
              header('Content-Disposition: attachment; filename=' . $filename);
              fputcsv($fp, $header);
           
             foreach ($datas as $row) {
           fputcsv($fp, $row);
         }
        exit();
           
       }
       
       
       
       
        
       public function statsdons(array $datas)
       {
            $filename = "dons_gel_smoothie.csv";
           $fp = fopen('php://output', 'w');
            // créer une entete du tableau .
             $header = array('id_product','ref','product','quantite_dons');
             // gérer les entete du csv 
             header('Content-type: application/csv');
              header('Content-Disposition: attachment; filename=' . $filename);
              fputcsv($fp, $header);
           
             foreach ($datas as $row) {
           fputcsv($fp, $row);
         }
        exit();
           
       }
       
       
         public function statdons(array $datas)
         {
            $filename = "statistique_customer_dons.csv";
           $fp = fopen('php://output', 'w');
            // créer une entete du tableau .
             $header = array('nom','email','code_postal','montant_achetes','listes_produits_achetes');
             // gérer les entete du csv 
             header('Content-type: application/csv');
              header('Content-Disposition: attachment; filename=' . $filename);
              fputcsv($fp, $header);
           
             foreach ($datas as $row) {
           fputcsv($fp, $row);
         }
        exit();
           
       }
       
       
       
  
     }


?>

