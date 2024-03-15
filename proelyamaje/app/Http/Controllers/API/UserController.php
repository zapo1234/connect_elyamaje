<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Historiquecommande;
use App\Models\Article;
use App\Mail\TestMail;
use App\Repository\Article\ArticleRepository;
use App\Repository\Alerts\AlertstocksRepository;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\FilePdf\CreatePdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $api;
    private $pdf;
    private $articleRepository;
    private $stocks;

    public function __construct(
     Apicall $api,
     CreatePdf $pdf,
     ArticleRepository $articleRepository,
     AlertstocksRepository $stocks
     )
    {
       $this->api = $api;
       $this->pdf = $pdf;
       $this->articleRepository = $articleRepository;
       $this->stocks = $stocks;
    }
    
    /**
     * 
     *@return \Illuminate\Http\Response
     */
     public function list()
     {
         if(Auth::check())
         {
            //$x = Auth::user()->id;
            //dd($x);
         }
         // recupérer les données de l'api
         $data = $this->api->getDataJson();
         if(count($data) >1)
         {
           $ref ='bonjour';
         }
         else{
          $ref ='bonsoir';
        }
         // insert into bdd (articles)
         $this->articleRepository->Insert();
         // renvoi de la vue
         return view('article.list', compact('ref'));
      }

     /**
     * Return list des articles.
     * @return $this
     */

      public function Pdfdata()
      {
        return $this->articleRepository->getAll();
      }
      
     /**
     * Send email.
     *
     * @return $this
     */

      public function SendEmail()
      {
        // envoi mail

      }
      
      
      public function alertstocks(Request $request)
      {
          // envoi mail 
          if(Auth()->user()->is_admin==1){
               // afficher les produits à commander
               // recupérer le variable de search product
               $name = $request->get('product');
              
              if($name!=""){
                  $name = $request->get('product');
                  $data = $this->stocks->getSearch($name);
              }
              if($name==""){
                 $data = $this->stocks->getAll();
              }
              
              $message="";
              return view('api.alertstocks',['data'=>$data,'message'=>$message]);
          }
      }
      
      public function createalerte()
      {
          if(Auth()->user()->is_admin==1) {
              
              // traitement des données 
              $this->stocks->insert();
              // afficher les produits à commander
              $data = $this->stocks->getAll();
              $message="";
              
              return view('api.alertstocks',['data'=>$data,'message'=>$message]);
          }
          
      }
      
      
      public function actioncommande(Request $request)
      {
          // recupérer la variable passer en cours
         if(Auth()->user()->is_admin==1){
           $id_product = $request->get('ids_product');
            // recupere la date
           $date_commande = $request->get('date_c');
          if($date_commande==""){
            $date= date('d-m-Y');
          }
          
          else{
              $date = date('d-m-Y', strtotime($date_commande));
          }
          
          $action =" ✓ Produit commandé le $date (Chez le fournisseur)";
          $css ="commandeproduit";
          // update sur les champs action et
           DB::table('alertstocks')
                   ->where('product_id', $id_product)
                    ->update(array('action' =>$action,
                                   'css'=>$css
                    ));
                    
           // insert dans une table ..
           $dates = date('Y-m-d');
           $product = new Historiquecommande();
          $product->name_product = $request->get('products');
          $product->date_fournisseur = $dates;
          $product->save();
        
           $message="commande du produit bien notifié";
           $data = $this->stocks->getAll();
          return view('api.alertstocks',['data'=>$data, 'message'=>$message]);
      }
      
      }
      
      
      
       public function updatecommande(Request $request)
       {
              // faire des update mutiple sur les chexbox
             $checkids = $request->get('checkids');
              // recupere la date
             $date_commande = $request->get('date_commande');
              if($date_commande=="") {
                $date=date('d-m-Y');
              }
          
             else{
                $date = date('d-m-Y', strtotime($date_commande));
          }
            $action =" ✓ Produit commandé le $date (Chez le fournisseur)";
            $css ="commandeproduit";
          
            // faire une boucle sur les update
              foreach($checkids as $values){
               // update sur les champs action et
                    DB::table('alertstocks')
                   ->where('product_id', $values)
                    ->update(array('action' =>$action,
                                   'css'=>$css
                    ));
          }
         
           $message="commande du produit bien notifié";
           $data = $this->stocks->getAll();
         return view('api.alertstocks',['data'=>$data, 'message'=>$message]);
     }



     public function error(){
      return view('error.error');
     }
    
      
      
      
      

}
