<?php

namespace App\Http\Service\FilePdf;

use App\Models\Article;
use App\Repository\Article\ArticleRepository;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use App\Repository\Pointbilan\PointbilanRepository;
use PDF;

class CreatePdf
{
    private $articleRepository;
    
    private $orders;
    
    private $points;

    public function __construct(ArticleRepository $articleRepository, 
    OrderambassadricecustomsRepository $orders, PointbilanRepository $points)
    {
       $this->articleRepository = $articleRepository;
       $this->orders = $orders;
       $this->points = $points;
    }

    public function invoicespdf($id,$code,$annee)
    {
      
         $datas = $this->orders->getDataPdf($id,$code,$annee);
        // recupérer les orders n'etant pas remboursés
         $data =[];
        foreach($datas as $kl=> $vals) {
        
            
           if($vals['status']!="refunded") {
               $data[] = [
                             'datet' => $vals['datet'],
                             'customer'=>$vals['customer'],
                            'email' => $vals['email'], 
                            'adresse'=> $vals['adresse'], 
                            'telephone' => $vals['telephone'],
                            'total_ht' => $vals['total_ht'],
                            'somme' => $vals['somme'],
                            'id_commande'=> $vals['id_commande']
                                     
                            ];
               
           }
       }
       
        
        $a = $code-1;//data pour le mois précédent
        $datas_refunded =  $this->orders->getDataPdf($id,$a,$annee);
        $status ="refunded";
       // recupérer les données annulés et remboursés sur les orders
       $array_list_refunded =[];
       $array_somme_refunded = [];
       
       foreach($datas_refunded as $key =>$valus){
           
           if($valus['status'] == $status){
              
              if($valus['somme']=!"0.00000000000"){
                $entier = intval($valus['somme']);
                dd($entier);
                if($entier >0){
               $array_list_refunded[] = [
                                      'datet' => $valus['datet'],
                                     'customer'=>$valus['customer'],
                                     'email' => $valus['email'], 
                                    'adresse'=> $valus['adresse'], 
                                    'telephone' => $valus['telephone'],
                                    'total_ht' => $valus['total_ht'],
                                    'somme' => $valus['somme'],
                                    'id_commande'=> $valus['id_commande']
                                     
                                ];
               $array_somme_refunded[] = $valus['somme'];
             }

           }

        }
           
       }
       
       // renvoyer un tableau unique
       $chaine_array_refunded = $array_list_refunded;
       // recupérer le somme remboursés
       $somme_refunded = array_sum($array_somme_refunded);
       $somme_refunded1 = $somme_refunded;
     
       $array_data = [];
       $array_somme = [];
       foreach($datas as  $keys => $values){
           
               $array_data[]= $values['name'].', '.$values['email'].' , '.$values['addresse'].' , '.$values['telephone']. ', '.$values['ville'].' , '.$values['code_postal'].', '.$values['siret'].' , '.$values['code_giftcards'].', '.$values['account_societe'].', '.$values['denomination'].', '.$values['is_admin'];
               $array_somme[] = $values['somme'];
        }
       
       $chaine_array = array_unique($array_data);
       $chaine_arrays = implode(',',$chaine_array);
       
       $chaine = explode(', ',$chaine_arrays);
        // defini les variable
         $type= $chaine[10];// type de user
         
         
         if($type==4){
             $deno= $chaine[0];
             $foot="tab";
         }
         
         if($type==2){
             $deno = $chaine[9];
             $foot ="tabs";
         }
         
       $nom = $chaine[0];
       $adresse = $chaine[2];
       $email = $chaine[1];
       $telephone = $chaine[3];
       $ville = $chaine[4];
       $code_postal = $chaine[5];
       $siret = $chaine[6];
       $account_societe = $chaine[8];
       $denomination = $chaine[9];
     
     
      
       if($chaine[7]=="") {
           $codecards="";
       }
       else{
         $codecards="N° bon  : $chaine[7]";
         
       }
       
       // recupérer dans un array list.
       $array_list1 = array('SARL','SASU','SAS');
       
       $array_list2 = array('EI','xxxx','');
       
       $tva="";
       $lecture="";
       $ttc="";
       if(in_array($account_societe,$array_list2)) {
           $lecture = "TVA non applicable art 293 B du CGI";
           $tva ="";
           $ttc="";
           $ht="Total HT";
       }
       
       if(in_array($account_societe, $array_list1)){
           $lecture="";
           $tva ="TVA";
           $ttc="Total TTC";
           $ht="Total HT";
       }
       
       
       // factue data
       $datas = $this->points->getDatainvoices($id,$code,$annee);
      // recupérer l'année en cours
       $date =date('Y-m-d');
       $datet = explode('-',$date);
       $annee = $datet[1];
       
       $anneee = $datet[0];
       // variable
        $somme_reel ="";
        $sommettc="";
        $sommet="";
        $annee_fix ="";
        $somme_live="";
        $somme_eleve="";
        $nombre_vente_eleve="";
        $nombre_vente_live ="";
       foreach($datas as $values){
          $periode = $values['mois'].' '.$values['annee'];
          $annee_fix = $values['annee'];
          $numero_facture = $values['id_ambassadrice'].'-00-'.$values['annee'];
          $somme = $values['somme'];
          $sommet = $values['somme']*20/100;
          $sommettc = $somme+$sommet;
          $status = $values['status'];
          $somme_reel = $values['somme'];
          $somme_live =   number_format($values['somme_live'],2,",","");
          $somme_eleve =  number_format($values['somme_eleve'],2,",","");
          $nombre_vente_eleve = $values['nbrseleve'];
          $nombre_vente_live  = $values['nbrslive'];
           // en cas de regule de facture changement de status 
          $somt = $somme-$sommet;

          
        }
        
         // recupérer dans un array list.
          $array_list1 = array('SARL','SASU','SAS');
          $array_list2 = array('EI','xxxx','');
          $array_list3 =  array('SASS');
       
       $tva="";
       $lecture="";
       $ttc="";
       if(in_array($account_societe,$array_list2)){
           $lecture = "TVA non applicable art 293 B du CGI";
           $tva ="";
           $ttc="";
           $ht="Total HT";
           $sommetc =0;
           $som="0";//tva
           $css1="aei";
       }
       
       if(in_array($account_societe, $array_list1)) {
           $lecture="";
           $tva ="TVA 20%";
           $ttc="Total TTC";
           $ht="Total HT";
           $sommetc = $sommettc;
           $som = $sommet; //tva
           $css1="asas";
       }

        // dans le cas d'une regule de facture changement de status sociéte.
       if(in_array($account_societe, $array_list3)) {
        $lecture="";
        $tva ="TVA 20%";
        $ttc="Total TTC";
        $ht="Total HT";
        $sommetc = $somme;
        $som = $sommet; //tva
        $css1="asas";
        $somme =  $somme-$somme*20/100;
    }

     //Montant payé le jour
        $somme_reel_final = $somme_reel - $somme_refunded1;
        $titre="";
        $details="";
        $final="";
        $css="xxxx";
        if(count($chaine_array_refunded)!=0){
            $titre="Liste des commandes annulées par les  clients/élèves";
            $details="Total retenu ventes";
            $final = "Total à payé";
            $css ="refunded";
        }
        
        
        $count_ids =[];// tableau pour compter les ids
        
        foreach($data as $kn =>$vag) {
            $count_ids[] = $vag['id_commande'];
        }
        
        if(count($count_ids)>11){
            $csscount ="tabs";
            $csscounts="tabsc";
        }
        
         if(count($count_ids)==11) {
            $csscount ="tabs";
            $csscounts="tabsc";
        }
        
        
        if(count($count_ids)<11) {
            $csscount ="tab";
            $csscounts="tabsc";
        }
        
        if(count($count_ids) >40){
            
            $csscounts="tabss";
            $csscount="tabs";
        }
        
        
        if(count($count_ids) < 40  && count($count_ids) >11){
            
            $csscounts="tabsc";
            $csscount="tabs";
        }
    
       // recupérer le mois souhaite en chaine de caractère !
       $mois_fact = $this->getMois($code);
       // choix na exempe em-octobre-2022;
       $nom_fichier = "$nom-$mois_fact-$anneee.pdf";
       // nombre le dossier
       $name_dossier ="$mois_fact-$anneee-facture";

       // pour les mois inférieur au 1 er janvier 2024
        $array_annee = array('2022','2023');
       if(in_array($annee_fix,$array_annee)){
           return PDF::loadView('ambassadrice.invoices', ['data'=>$data, 'nom'=>$nom, 'adresse'=>$adresse, 'email'=>$email,'ville'=>$ville, 'code_postal'=>$code_postal, 'telephone'=>$telephone, 'siret'=>$siret,'codecards'=>$codecards, 'periode' => $periode, 'numero_facture'=>$numero_facture, 
          'somme'=>$somme, 'status'=>$status,'chaine_array_refunded'=>$chaine_array_refunded,'somme_reel'=>$somme_reel,'somme_refunded1'=>$somme_refunded1,'somme_reel_final'=>$somme_reel_final,'titre'=>$titre,'details'=>$details,
          'final'=>$final,'css'=>$css,'css1'=>$css1,'tva'=>$tva,'lecture'=>$lecture, 'ttc'=>$ttc, 'ht'=>$ht, 'sommetc'=>$sommetc,'som'=>$som,'csscount'=>$csscount,'csscounts'=>$csscounts,'denomination'=>$denomination,'foot'=>$foot])
          ->setPaper('a4', 'Portrait')
          ->setWarnings(false)
          ->download('invoice.pdf');

         }
         else{
            // dés  janvier 2024
            return PDF::loadView('ambassadrice.invoicesnews', ['data'=>$data, 'nom'=>$nom, 'adresse'=>$adresse, 'email'=>$email,'ville'=>$ville, 'code_postal'=>$code_postal, 'telephone'=>$telephone, 'siret'=>$siret,'codecards'=>$codecards, 'periode' => $periode, 'numero_facture'=>$numero_facture, 
            'somme'=>$somme, 'status'=>$status,'chaine_array_refunded'=>$chaine_array_refunded,'somme_reel'=>$somme_reel,'somme_refunded1'=>$somme_refunded1,'somme_reel_final'=>$somme_reel_final,'titre'=>$titre,'details'=>$details,
            'final'=>$final,'css'=>$css,'css1'=>$css1,'tva'=>$tva,'lecture'=>$lecture, 'ttc'=>$ttc, 'ht'=>$ht, 'sommetc'=>$sommetc,'som'=>$som,'csscount'=>$csscount,'csscounts'=>$csscounts,'denomination'=>$denomination,'foot'=>$foot,'somme_live'=>$somme_live,'somme_eleve'=>$somme_eleve,'nombre_vente_eleve'=>$nombre_vente_eleve,'nombre_vente_live'=>$nombre_vente_live])
            ->setPaper('a4', 'Portrait')
            ->setWarnings(false)
            ->download('invoicenews.pdf');
               
         }

        
    }
    
    
    
    
     public function invoicespdfs($id,$code,$annee)
    {
       $datas = $this->orders->getDataPdf($id,$code,$annee);
       
       // recupérer les orders n'etant pas remboursés
       $data =[];
       foreach($datas as $kl=> $vals){
           if($vals['status']!="refunded") {
               $data[] = [
                             'datet' => $vals['datet'],
                             'customer'=>$vals['customer'],
                            'email' => $vals['email'], 
                            'adresse'=> $vals['adresse'], 
                            'telephone' => $vals['telephone'],
                            'total_ht' => $vals['total_ht'],
                            'somme' => $vals['somme'],
                            'id_commande'=> $vals['id_commande']
                                     
                            ];
               
           }
       }
       
       $a = $code-1;//data pour le mois précédent
       $datas_refunded =  $this->orders->getDataPdf($id,$a,$annee);
        $status ="refunded";
       
       // recupérer les données annulés et remboursés sur les orders
       $array_list_refunded =[];
       $array_somme_refunded = [];
       
       foreach($datas_refunded as $key =>$valus) {
           
           if($valus['status'] == $status){
               $array_list_refunded[] = [
                                      'datet' => $valus['datet'],
                                     'customer'=>$valus['customer'],
                                     'email' => $valus['email'], 
                                    'adresse'=> $valus['adresse'], 
                                    'telephone' => $valus['telephone'],
                                    'total_ht' => $valus['total_ht'],
                                    'somme' => $valus['somme'],
                                    'id_commande'=> $valus['id_commande']
                                     
                                ];
               $array_somme_refunded[] = $valus['somme'];
           }
           
       }
       
       // renvoyer un tableau unique
       $chaine_array_refunded = $array_list_refunded;
     // recupérer le somme remboursés
       $somme_refunded = array_sum($array_somme_refunded);
       $somme_refunded1 = $somme_refunded;
     
       $array_data = [];
       $array_somme = [];
       foreach($datas as  $keys => $values){
               $array_data[]= $values['name'].', '.$values['email'].' , '.$values['addresse'].' , '.$values['telephone']. ', '.$values['ville'].' , '.$values['code_postal'].', '.$values['siret'].' , '.$values['code_giftcards'].', '.$values['account_societe'].', '.$values['denomination'].', '.$values['is_admin'];
               $array_somme[] = $values['somme'];
          
       }
       
       $chaine_array = array_unique($array_data);
       $chaine_arrays = implode(',',$chaine_array);
       
       $chaine = explode(', ',$chaine_arrays);
       
       // defini les variable
         $type= $chaine[10];// type de user
         
         if($type==4)
         {
             $deno= $chaine[0];
             $foot="tab";
         }
         
         if($type==2)
         {
             $deno = $chaine[9];
             $foot ="tabs";
         }
         
       $nom = $chaine[0];
       $adresse = $chaine[2];
       $email = $chaine[1];
       $telephone = $chaine[3];
       $ville = $chaine[4];
       $code_postal = $chaine[5];
       $siret = $chaine[6];
       $account_societe = $chaine[8];
       $denomination = $chaine[9];
     
     
      
       if($chaine[7]==""){
           $codecards="";
       }
       else{
         $codecards="N° bon  : $chaine[7]";
         
       }
       
       // recupérer dans un array list.
       $array_list1 = array('SARL','SASU','SAS');
       
       $array_list2 = array('EI','xxxx','');
       
       $tva="";
       $lecture="";
       $ttc="";
       if(in_array($account_societe,$array_list2)){
           $lecture = "TVA non applicable art 293 B du CGI";
           $tva ="";
           $ttc="";
           $ht="Total HT";
       }
       
       if(in_array($account_societe, $array_list1)) {
           $lecture="";
           $tva ="TVA";
           $ttc="Total TTC";
           $ht="Total HT";
       }
       
       
       // factue data
        $datas = $this->points->getDatainvoices($id,$code,$annee);
         // recupérer l'année en cours
        $date =date('Y-m-d');
        $datet = explode('-',$date);
        $annee = $datet[1];
        $anneee = $datet[0];
       
       // variable
        $somme_reel ="";
        $sommettc="";
        $sommet="";
        $annee_fix ="";
        foreach($datas as $values){
          $periode = $values['mois'].' '.$values['annee'];
          $annee_fix = $values['annee'];
          $numero_facture = $values['id_ambassadrice'].'-00-'.$values['annee'];
          $somme = $values['somme'];
          $sommet = $values['somme']*20/100;
          $sommettc = $somme+$sommet;
          $status = $values['status'];
          $somme_reel = $values['somme'];
          
        }
        
        // recupérer dans un array list.
         $array_list1 = array('SARL','SASU','SAS');
         $array_list2 = array('EI','xxxx','');
       
       $tva="";
       $lecture="";
       $ttc="";
       if(in_array($account_societe,$array_list2)) {
           $lecture = "TVA non applicable art 293 B du CGI";
           $tva ="";
           $ttc="";
           $ht="Total HT";
           $sommetc =0;
           $som="0";//tva
           $css1="aei";
       }
       
       if(in_array($account_societe, $array_list1)){
           $lecture="";
           $tva ="TVA 20%";
           $ttc="Total TTC";
           $ht="Total HT";
           $sommetc = $sommettc;
           $som = $sommet; //tva
           $css1="asas";
       }
       
        
        
        
        //Montant payé le jour
        $somme_reel_final = $somme_reel - $somme_refunded1;
        $titre="";
        $details="";
        $final="";
        $css="xxxx";
        if(count($chaine_array_refunded)!=0) {
            $titre="Liste des commandes annulées par les  clients/élèves";
            $details="Total retenu ventes";
            $final = "Total à payé";
            $css ="refunded";
        }
        
        
        $count_ids =[];// tableau pour compter les ids
        
        foreach($data as $kn =>$vag){
            $count_ids[] = $vag['id_commande'];
        }
        
        if(count($count_ids)>11){
            $csscount ="tabs";
            $csscounts="tabsc";
        }
        
         if(count($count_ids)==11){
            $csscount ="tabs";
            $csscounts="tabsc";
        }
        
        
        if(count($count_ids)<11){
            $csscount ="tab";
            $csscounts="tabsc";
        }
        
        if(count($count_ids) >40){
            
            $csscounts="tabss";
            $csscount="tabs";
        }
        
        
        if(count($count_ids) < 40  && count($count_ids) > 11){
            
            $csscounts="tabsc";
            $csscount="tabs";
        }
    
      // recupérer le mois souhaite en chaine de caractère !
      $mois_fact = $this->getMois($code);
       
       // choix na exempe em-octobre-2022;
       $nom_fichier = "$nom-$mois_fact-$anneee.pdf";
       // nombre le dossier
       $name_dossier ="$mois_fact-$anneee-facture";
      
       return PDF::loadView('ambassadrice.invoices', ['data'=>$data, 'nom'=>$nom, 'adresse'=>$adresse, 'email'=>$email,'ville'=>$ville, 'code_postal'=>$code_postal, 'telephone'=>$telephone, 'siret'=>$siret,'codecards'=>$codecards, 'periode' => $periode, 'numero_facture'=>$numero_facture, 
       'somme'=>$somme, 'status'=>$status,'chaine_array_refunded'=>$chaine_array_refunded,'somme_reel'=>$somme_reel,'somme_refunded1'=>$somme_refunded1,'somme_reel_final'=>$somme_reel_final,'titre'=>$titre,'details'=>$details,
       'final'=>$final,'css'=>$css,'css1'=>$css1,'tva'=>$tva,'lecture'=>$lecture, 'ttc'=>$ttc, 'ht'=>$ht, 'sommetc'=>$sommetc,'som'=>$som,'csscount'=>$csscount,'csscounts'=>$csscounts,'denomination'=>$denomination,'foot'=>$foot])
       ->setPaper('a4', 'Portrait')
       ->setWarnings(false)
       ->save(public_path("storage/$name_dossier/$nom_fichier"));
    }
    
    
    
      
      public function getexcel($id,$code,$annee)
      {
        
         $datas = $this->orders->getDataPdf($id,$code,$annee);
        // recupérer les orders n'etant pas remboursés
        echo'
	    <table class="tb" border="1">
         <tr>
	 
	       <th>Date</th>
           <th>ID-commande</th>
	       <th>Client</th>
	       <th>Montant(HT)</th>
	        <th>Commission générée</th>
           </tr>';
      
      
       $data =[];
       $outpout="";
       foreach($datas as $kl=> $vals)
       {
           if($vals['status']!="refunded")
           {
               $data[] = [
                             'datet' => $vals['datet'],
                             'customer'=>$vals['customer'],
                            'email' => $vals['email'], 
                            'adresse'=> $vals['adresse'], 
                            'telephone' => $vals['telephone'],
                            'total_ht' => $vals['total_ht'],
                            'somme' =>  number_format($vals['somme'],2,',',''),
                            'id_commande'=> $vals['id_commande']
                                     
                            ];
               
           }
       }
       
       foreach($data as $donnees)
       {
           $outpout.='
	   	<tr>
	     <td>'.$donnees['datet'].'</td>
		 <td>'.$donnees['id_commande'].'</td>
		 <td>'.$donnees['customer'].'</td>
		 <td>'.$donnees['total_ht'].'</td>
		 <td>'.$donnees['somme'].'</td>
		 </tr>';
           
           
       }
       
         $outpout.='</table>';
         
          header("Content-Type: application/xls");
	      header("Content-Disposition: attachement; filename=liste_commande.xls");
         
       
         return $outpout;
       
        
    }
    
    
    
    
      public function store(){
         
         
         $file = $request->file('file'); // l'extension du fichier 
         
         $name = $file->getClientOriginalName();
         if($name) {
           $extension = $file->getClientOriginalExtension();
          // renommer le fichier
          $array = array('png','jpg','jpeg');
          
          // taille du fichier
          $size = Storage::size('public/picture'.$file);
          
          if(in_array($extension,$array) AND $size <10000){
              $name = $file->getClientOriginalName();
              $path = $file->store('public/picture');
    
            $error ="succes";
            return $error;
        }
        
        
        if(!in_array($extension, $array)) {
             
             $error ="denied";
            return $error;
             
         }
        
         if($size > 10000){
            
            $error ="denie";
            return $error ;
        }
        
        
        
    }
    
    else{
        
        $error ="";
        return $error;
    }
   
   
}

  public function getMois($moi)
  {
       
         if($moi=="1"){
             $mo ="Janvier";
         }
         
         if($moi=="2"){
             $mo="février";
         }
         
         if($moi=="3"){
             $mo ="Mars";
         }
         
         if($moi=="4") {
             $mo="Avril";
         }
         
         if($moi=="5") {
             $mo ="Mai";
         }
         
         if($moi=="6"){
             $mo="Juin";
         }
         
         if($moi=="7") {
             $mo="Juillet";
         }
         
         if($moi=="8"){
             $mo="Aout";
         }
         
         
         if($moi=="9"){
             $mo="Septembre";
         }
         
         if($moi=="10"){
             $mo="Octobre";
         }
         
         if($moi=="11"){
             $mo="Novembre";
         }
         
         if($moi=="12"){
             $mo="Decembre";
         }
         
         return $mo;
     }
      
  }









