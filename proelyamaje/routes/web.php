<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ApiSystemcallController;
use App\Http\Controllers\API\ApiSystemOrdersController;
use App\Http\Controllers\API\PanierLiveController;
use App\Http\Controllers\API\SynchroController;
use App\Http\Controllers\Ambassadrice\AmbassadriceController;
use App\Http\Controllers\Ambassadrice\AmbassadriceOrdercustomsController;
use App\Http\Controllers\Ambassadrice\AmbassadriceCodeliveController;
use App\Http\Controllers\Ambassadrice\GestionControlController;
use App\Http\Controllers\Ambassadrice\NotificationController;
use App\Http\Controllers\ChartJsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CreateAccountController;
use App\Http\Controllers\UserAmbassadriceController;
use App\Http\Controllers\Utilisateurs\UtilisateursController;
use App\Http\Controllers\Utilisateurs\SuiviController;
use App\Http\Controllers\Superadmin\AdminController;
use App\Http\Controllers\Superadmin\ControllerCalculManuel;
use App\Http\Controllers\Superadmin\StocksController;
use App\Http\Controllers\Partenaire\PartenaireController;
use App\Models\User;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


// route accésible par les utilisateurs connéctés
Route::group(['middleware' => ['auth']], function () {
// redirection home

Route::get('/', function () {
  switch (Auth()->user()->is_admin) {
    case 1 :
      return redirect()->route('superadmin.home');
      break;
    case 2 || 4 :
      return redirect()->route('ambassadrice.user');
      break;
    default:
      return redirect()->route('logout');
      break;
  }  
});

//sper admin
Route::get("/home", [HomeController::class, "index"])->name('superadmin.home');

Route::get("/getChartAmba", [AdminController::class, "getChartAmba"])->name('superadmin.getChartAmba');

// route ajax pour afficher chiffre affaire réaliser par amabssadrice
Route::get("/getchifffre", [AdminController::class, "getChiffre"])->name('superadmin.getchiffre');


// ajax retour recette live
Route::get("/getlives", [GestionControlController::class, "getlives"])->name('gestion.getlives');

// route ajax pour afficher les sommes des lives...
Route::get("/getsomlive", [AdminController::class, "getsomlive"])->name('superadmin.getsomlive');
// super admin dashboard activité
Route::get("/dashboard/activite", [GestionControlController::class, "dashboards"])->name('gestion.home');
Route::get("/dashboard/newcustomer", [GestionControlController::class, "newcustomer"])->name('gestion.newcustomer');

// Dashbord Ambassadrice
Route::get("/dashboard/general", [AdminController::class, "dashamba"])->name('superadmin.ambassadricedashbord');

// Statisque des ventes rapport Ambassadrice.
Route::get("/dashboard/general/vente", [AdminController::class, "dashventes"])->name('superadmin.ambassadricevente');


// post statistique  export csv 
Route::post("/dashboard/general/vente", [AdminController::class, "dashventes"])->name('superadmin.postcventeslive');

// post rapport de vente live/code eleve

 // utilisateurs
 Route::get("/dashboard/general/vente/utilisateur", [UtilisateursController::class, "dashventes"])->name('utilisateurs.ambassadricevente');

 // créer des carte cadeaux N°
 Route::get("/Utilisateur/cartescado", [UtilisateursController::class, "cado"])->name('utilisateurs.cartecadeaux');

// route post pour traiter les carde cadeaux 
Route::post("/Utilisateur/cartescado", [UtilisateursController::class, "postcado"])->name('utilisateurs.cartecadeaux');

// Dashbord Partenaire...
Route::get("/dashboards/partenaire", [AdminController::class, "dashpartenaire"])->name('superadmin.partenairedash');


// Créé des route pour les recette journalière deux dernière des point de ventes

Route::get("/dashboard/Recette/nice", [GestionControlController::class, "recettenice"])->name('gestion.nicerecette');
Route::get("/dashboard/Recette/marseille", [GestionControlController::class, "recettemarseille"])->name('gestion.marseillerecette');

Route::get("/dashboard/Recette/internet", [GestionControlController::class, "recetteinternet"])->name('gestion.internetrecette');

// gestion du chiffrage mensuelle.....
Route::get("/dashboard/Recette/mensuel/nice", [GestionControlController::class, "recettenices"])->name('gestion.recettesnice');
Route::get("/dashboard/Recette/mensuel/marseille", [GestionControlController::class, "recettemarseilles"])->name('gestion.recettesmarseilles');
Route::get("/dashboard/Recette/mensuel/internet", [GestionControlController::class, "recetteinternets"])->name('gestion.recettesinternets');


Route::get("/api/products", [UserController::class, "product"])->name('product');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
//amabassadrice
Route::get("/user", [HomeController::class, "homes"])->name('amabassadrice.user')->middleware('is_admin');
Route::get("/profil", [AmbassadriceController::class, "profil"])->name('ambassadrice.profil');
Route::post("/profil", [AmbassadriceController::class, "updateProfil"])->name('ambassadrice.profil');

//utilisateur
Route::get("/comptable", [HomeController::class, "compta"])->name('comptable.comptas')->middleware('is_admin');

Route::get("/admin/account", [HomeController::class, "admins"])->name('superadmin.admin')->middleware('is_admin');

Route::get("/utilisateur/account", [HomeController::class, "utilisateurs"])->name('utilisateurs.utilisateur')->middleware('is_admin');


// create account get user
Route::get('create/account', [CreateAccountController::class, 'create'])->name('account.users');

Route::get('create/account/ambassadrice', [CreateAccountController::class, 'create_ambassadrice'])->name('account.create_ambassadrice');
Route::get('create/account/partenaire', [CreateAccountController::class, 'create_partenaire'])->name('account.create_partenaire');



// create account post user
Route::post('/createaccount', [CreateAccountController::class, 'createaccount'])->name('account.create');

// route response form
// create account get user
Route::get('account/confirm', [CreateAccountController::class, 'confirmaccount'])->name('account.confirm');
// list des utilisateurs
// create account get user
Route::get('account/list', [CreateAccountController::class, 'list'])->name('account.list');
// lister des élève crée
// edit compte permission user
// create account get user
Route::get('account/edit/{id}/{token}', [CreateAccountController::class, 'edit'])->name('account.edit');


// post edit compte permission user
// create account get user
Route::post('account/edit/{id}/{token}', [CreateAccountController::class, 'editaction']);


// post edit compte permission user
// delete account
Route::delete('/users/{id}', [CreateAccountController::class, 'destroy']);



// update acces user request ajax id
Route::post('/updateacces/{id}', [CreateAccountController::class, 'updateacces']);


// route ambassarice
// create cuqstomer account get user
Route::get('ambassadrice/customer', [AmbassadriceController::class, 'account'])->name('ambassadrice.account');


// create cuqstomer account get user
Route::get('ambassadrice/add/codepromo', [AmbassadriceController::class, 'addcode'])->name('ambassadrice.addcode');

// aJAX POUR AFFICHER LES bon d'achat des partenaire
Route::get('ambassadrice/add/bon/achat', [AmbassadriceController::class, 'bongift'])->name('ambassadrice.bongift');

// Route pour ajax  choix paiement
Route::get('ambassadrice/add/choix', [AmbassadriceController::class, 'choixpaie'])->name('ambassadrice.choixpaie');

// route superadmin dashboard

// route dansbord ambassadrice
Route::get('/home', [AdminController::class, 'homeadmin'])->name('superadmin.home');

//list les transfert de fonds 
Route::get('/home/caisse/tranfert', [AdminController::class, 'cloturelist'])->name('superadmin.cloturelist');
// route pour les activités de elyamaje dashboard
Route::post('/home', [AdminController::class, 'homeadmin']);

// route post select data ambassadrice

// route dansbord ambassadrice
Route::post('data/ambassadrice', [AdminController::class, 'homedatas']);

// route dansbord ambassadrice
Route::get('ambassadrice/user', [AmbassadriceController::class, 'user'])->name('ambassadrice.user');

// route dansbord ambassadrice
Route::get('ambassadrice/userstatistique', [AmbassadriceController::class, 'userstat'])->name('ambassadrice.userstatistique');
// route liste customer Ambassadrice
// route dansbord ambassadrice
Route::get('/ambassadrice/customer/list', [AmbassadriceController::class, 'list'])->name('ambassadrice.list');

Route::post('/ambassadrice/customer/list', [AmbassadriceController::class, 'list']);
// route 
Route::get('/ambassadrice/customer/account', [AmbassadriceController::class, 'listeleve'])->name('ambassadrice.listeleve');

// post renvoyer le code eleve par email à l'eleve
Route::post('/ambassadrice/customer/account', [AmbassadriceController::class, 'listeleve']);

//post recherche by name
Route::post('/ambassadrice/customer/list', [AmbassadriceController::class, 'list']);

//post 
Route::post('/ambassadrice/customer/list', [AmbassadriceController::class, 'list']);

// route liste customer Ambassadrice
// route dansbord ambassadrice
Route::get('/ambassadrice/customer/lists', [AmbassadriceController::class, 'lists'])->name('ambassadrice.lists');

// route edit customer of amabassadrice
// route dansbord ambassadrice
Route::get('ambassadrice/customer/edit/{id}', [AmbassadriceController::class, 'editaction'])->name('ambassadrice.edit');

// route edit customer of amabassadrice
// route dansbord ambassadrice
Route::get('ambassadrice/customer/add/{id}', [AmbassadriceController::class, 'addaction'])->name('ambassadrice.addcode');

// route edit customer of amabassadrice
// route dansbord ambassadrice
Route::get('account/ambassadrice/{id}', [UserAmbassadriceController::class, 'views'])->name('account.userambassadrice');
// route dansbord ambassadrice
Route::get('account/partenaire/{id}', [UserAmbassadriceController::class, 'views'])->name('account.userpatenaire');

// post sur edit
// create account get user
Route::post('/ambassadrice/edit/{id}', [AmbassadriceController::class, 'editpost']);

// add codepromo sur contanct existant
// create account get user
Route::post('/ambassadrice/add/{id}', [AmbassadriceController::class, 'addpost']);


// create post customer amabassadrice
// create cuqstomer account get user
Route::post('/createcustomer', [AmbassadriceController::class, 'createcustomer']);


// create route post add code pro contact existant
Route::post('/createexistant', [AmbassadriceController::class, 'createexsitant']);

// route dansbord ambassadrice
Route::post('/createcustom', [AmbassadriceController::class, 'customers']);

// route response create customer
// route dansbord ambassadrice
// route orders get Api data
Route::get('/customer/confirm', [AmbassadriceController::class, 'confirm'])->name('ambassadrice.confirm');

// lister et gérer  les code éléve créer 
Route::get('/collaborateur/list/code', [GestionControlController::class, 'listcode'])->name('gestion.listcode');

// route post de traitement de formulaire search select.
Route::post('/collaborateur/list/code', [GestionControlController::class, 'listcode'])->name('gestion.listcode');

// traiter le formualire
Route::post('/collaborateur/delete/code', [GestionControlController::class, 'getcodepromo']);

// suivi des statistique de code promo
Route::get('/collaborateur/suivi/code', [GestionControlController::class, 'suivicode'])->name('gestion.suivicode');

// utilisateur suivi de taux de transformation
Route::get('/collaborateur/suivi/code/eleve', [UserAmbassadriceController::class, 'suivicode'])->name('utilisateurs.suivicode');

//AMBASSADRICE suivi code eleve mensuel.
Route::get('/collaborateur/suivi/codes/eleve/menseul', [UserAmbassadriceController::class, 'suivicodeambas'])->name('utilisateurs.suivicodeamb');

// post csv genere l'activité menseul des ambassadrice pour les code eleve
Route::post('/amba/eleve/menseul', [UserAmbassadriceController::class, 'elevemabapostcsv'])->name('utilisateurs.postambacsveleve');


//Partenaire suivi code eleve mensuel.
Route::get('/collaborateur/suivi/code/eleve/menseuls', [UserAmbassadriceController::class, 'suivicodepart'])->name('utilisateurs.suivicodepart');

// post Partenaire
// rapport mensuel sur les codes élève Ambassadrice 
Route::get('/suivi/code/menseul/eleve', [UserAmbassadriceController::class, 'elevestatds'])->name('utilisateurs.elevestats');

// suivi des statistique de code promo
Route::get('/collaborateur/suivi/live/{id}', [GestionControlController::class, 'suivilives'])->name('gestion.suivilives');
// suivi de creation de code

// gestion des statistique rapport de commission 
Route::get('/statistique/user', [GestionControlController::class, 'statsdata'])->name('gestion.statsdata');

// utilisateur vue rapport de vente
Route::get('/statistique/users', [UserAmbassadriceController::class, 'statsdata'])->name('utilisateurs.statsdatauser');

// rapport de ventes  partenaire
// post rapport vente stats %
Route::post('/statistique/user', [GestionControlController::class, 'statsdata'])->name('gestion.postcsvstats');
// post 

// traitement du formulaire.

// activation de code promo
// route pour achat de code promo éleves
Route::get('/ambassadrice/activate/code_live', [AmbassadriceCodeliveController::class, 'index_codelive'])->name('ambassadrice.codelive');

// route pour achat de code promo éleves
Route::post('/ambassadrice/activate/code_live', [AmbassadriceCodeliveController::class, 'index_codelive'])->name('index_codelive');


// activation de code promo
// route pour achat de code promo éleves
Route::get('/ambassadrice/activate/code_live/{id_code}', [AmbassadriceCodeliveController::class, 'index_codelive'])->name('ambassadrice.activatelive');

// configuration des cadeaux dans un live
Route::get('/ambassadrice/configuration/pannier', [AmbassadriceCodeliveController::class, 'configuration'])->name('ambassadrice.configuration');


// lister les panier cadeaux lives

// configuration des cadeaux dans un live
Route::get('/ambassadrice/lister/pannier', [AmbassadriceCodeliveController::class, 'listerpanier'])->name('ambassadrice.listerpanier');

// edit un panier de cadeaux live
Route::get('/ambassadrice/lister/pannier/{id}', [AmbassadriceCodeliveController::class, 'editpanier'])->name('ambassadrice.editpanier');

// traiter le retour des formulaire

Route::post('/ambassadrice/panier/edit/{id}', [AmbassadriceCodeliveController::class, 'editpaniers'])->name('ambassadrice.savenewpanier');


// editer les palier de cadeaux par les ambassadrice
Route::post('/ambassadrice/panier/edit/choix/', [AmbassadriceCodeliveController::class, 'updatepanierlive']);

// gerer vos live ambassadrice
Route::get('/ambassadrice/configuration/live', [AmbassadriceCodeliveController::class, 'gestionlive'])->name('ambassadrice.gestionlive');

// annuler la date post du live  ambassadrice
Route::post('/ambassadrice/annul/live', [AmbassadriceCodeliveController::class, 'anullive'])->name('anullive');

// Ambassadrice changer la date de live

Route::post('/edit/choix', [AmbassadriceCodeliveController::class, 'updatelivedate'])->name('edit.choix');


// editer les palier de cadeaux  live par les ambassadrice
Route::post('/panier/edit/choix/live', [AmbassadriceCodeliveController::class, 'updatepanierlive'])->name('ambassadrice.updatepanierlive');
// post de confirmation panier 
Route::post('/ambassadrice/postconfig/pannier', [AmbassadriceCodeliveController::class, 'postconfig']);
// demander à faire un live depuis formulaire
Route::get('/ambassadrice/activate/add_forms', [AmbassadriceCodeliveController::class, 'index_give'])->name('ambassadrice.liveforms');
// route post formulaire de traitement de la demande
// demander à faire un live depuis formulaire
Route::post('/ambassadrice/activate/add_forms', [AmbassadriceCodeliveController::class, 'add_livesforms'])->name('ambassadrice.addliveforms');
// activate live
// route pour achat de code promo éleves
Route::post('/ambassadrice/activate', [AmbassadriceCodeliveController::class, 'active_codelive'])->name('ambassadrice.activate');

Route::get('/ambassadrice/activate_live', [AmbassadriceCodeliveController::class, 'force_active_codelive'])->name('ambassadrice.activate_live');
//forcer le live avec le systeme de palier .
Route::post('/ambassadrice/activate/forcer', [AmbassadriceCodeliveController::class, 'active_force_live'])->name('ambassadrice.activate_forcer');

// historique de live  
// Historique des paliers live ambassadrice.
Route::get('ambasssadrice/panier/historique/', [AmbassadriceCodeliveController::class, 'historiquepalier'])->name('ambassadrice.historiquepalierlive');

// afficher l'historique de live et palier de l'ambassadrice
// Historique des paliers live ambassadrice...
Route::get('/ambasssadrice/palier/live/historique/{id}', [AmbassadriceCodeliveController::class, 'historiquelivepalier'])->name('ambassadrice.livehistorique');

// superadmin  vue
// Historique des paliers live ambassadrice...
// Route::get('/ambasssadrice/palier/live/historique/{id}', [AmbassadriceCodeliveController::class, 'historiquelivepalier'])->name('ambassadrice.livehistorique');

// route customer order amabassadrice
// route pour achat de code promo éleves
Route::get('/ambassadrice/orders/customs', [AmbassadriceOrdercustomsController::class, 'listorders'])->name('ambassadrice.orders');

// liste des commandes(orders) de distributeurs à transférer dans woocomerce.
Route::get('/distributeur/orders/transfert', [AmbassadriceOrdercustomsController::class, 'orderdistributeur'])->name('distributeur.orders');

// traiter le post pour transferer une commande distributeur vers woocomerce.
Route::post('/distributeur/orders/transfert', [AmbassadriceOrdercustomsController::class, 'orderdistributeur']);

// details de la commande de distributeur à envoyer dans woocomerce
Route::get('/distributeur/orders/transfert/{id}', [AmbassadriceOrdercustomsController::class, 'orderiddistributeur'])->name('distributeur.ordersiddistributeur');

// route des commande recupérer depuis woocomerce code promo
Route::get('/ambassadrice/orders/codepromo/vente', [AmbassadriceOrdercustomsController::class, 'listcodepromo'])->name('utilisateurs.orderscodepromo');

// route pour recupérer les oders par id ambassadrice ou partenaire / controle de vente sur dolibarr
Route::get('/ambassadrice/orders/accounts', [AmbassadriceOrdercustomsController::class, 'listord'])->name('ambassadrice.orderaccount');

// route dolibarr 


// partenaire notification 200 euro .
Route::get('/paiments/notification/fact', [AmbassadriceOrdercustomsController::class, 'getpaiementpartenaire'])->name('ambassadrice.paimentnotif');
Route::post('/paiments/notification/fact', [AmbassadriceOrdercustomsController::class, 'getpaiementpartenaire'])->name('post_ambassadrice.paimentnotif');


// route pour achat de code promo éleves
Route::post('/ambassadrice/orders/customs', [AmbassadriceOrdercustomsController::class, 'change_status']);


// route pour achat code parainage
Route::get('/ambassadrice/orders/parainage', [AmbassadriceOrdercustomsController::class, 'listordersparain'])->name('ambassadrice.ordersparain');


//lister toutes les commandes avec code pro ou parainage
Route::get('/ambassadrice/orders/list', [AmbassadriceOrdercustomsController::class, 'lists'])->name('ambassadrice.orderslists');


// gestion create code speciale èléve aabssadrice
Route::get('/account/create/code', [AmbassadriceOrdercustomsController::class, 'codespecial'])->name('account.codespeciale');

// post create  
Route::post('/account/create/code', [AmbassadriceOrdercustomsController::class, 'createcode']);

// gerer les vues des codes élè et promo
// gestion create code speciale èléve aabssadrice
Route::get('/account/list/codespecifique', [AmbassadriceOrdercustomsController::class, 'viewcode'])->name('account.codeeleves');

// edit code specifique 
Route::get('/account/list/codespecifique/{id}', [AmbassadriceOrdercustomsController::class, 'editcodespecifique'])->name('account.editcodespecifique');

//post  edit code specifique 
Route::post('/account/list/codespecifique/{id}', [AmbassadriceOrdercustomsController::class, 'posteditcode']);

// gestion de order revenus

Route::get('/ambassadrice/list/activite', [AmbassadriceOrdercustomsController::class, 'getprice'])->name('ambassadrice.statistiques');

//top 3 des produits les plus vendus
Route::get('/ambassadrice/list/top3/{id}', [AmbassadriceOrdercustomsController::class, 'getop3'])->name('ambassadrice.top3produits');


// route pour pour bloquer et restreint 
Route::get('/ambassadrice/echec/supsdend', [AmbassadriceOrdercustomsController::class, 'getsuspend'])->name('ambassadrice.suspend');


// gestion de order revenus facture

Route::get('/ambassadrice/factures', [AmbassadriceOrdercustomsController::class, 'getfacture'])->name('ambassadrice.factures');


// post sur facture mutiple validation
Route::post('/ambassadrice/factures/validateds', [AmbassadriceOrdercustomsController::class, 'getvalidationmutiple'])->name('factures.validateds');


// recupérer les facture coté ambassadrice par id
Route::get('/ambassadrice/factures/account', [AmbassadriceOrdercustomsController::class, 'getfactures'])->name('ambassadrice.fact');

// route facture pour les utilisateurs ERP elyamaje
Route::get('/ambassadrice/factures/accounts', [AmbassadriceOrdercustomsController::class, 'facturesusers'])->name('ambassadrice.utilisateurfact');

// search name post
Route::post('/ambassadrice/factures', [AmbassadriceOrdercustomsController::class, 'invoicespay'])->name('ambassadrice.factures');

Route::get('/ambassadrice/factures/{id}', [AmbassadriceOrdercustomsController::class, 'getfactureid'])->name('ambassadrice.idfacture');

// Route id pour notification ambassadrice partenaire
Route::get('/ambassadrice/details/commande/{id_commande}/{id}', [AmbassadriceOrdercustomsController::class, 'getnotificationid'])->name('ambassadrice.notificationid');


// delete notification bdd
Route::delete('/notifications/{id}', [AmbassadriceOrdercustomsController::class, 'destroy']);

// générer un pdf pour les facture

Route::get('/ambassadrice/invoice/pdf/{id}/{code}/{annee}', [AmbassadriceOrdercustomsController::class, 'getinvoices'])->name('ambassadrice.invoices');

Route::get('/ambassadrice/invoices/pdf/{id}/{code}/{annee}', [AmbassadriceOrdercustomsController::class, 'getinvoicess'])->name('ambassadrices.invoicesnews');

Route::get('/ambassadrice/factures/invoice/pdf/{id}/{code}/{annee}', [AmbassadriceOrdercustomsController::class, 'getinvoices'])->name('ambassadrice.invoices');


// tirer le excel des données correspondant au click de la facture pour le mois et l'anne ée en cours
Route::get('/ambassadrice/factures/invoice/csv/{id}/{code}/{annee}', [AmbassadriceOrdercustomsController::class, 'getexcelinvoices'])->name('ambassadrice.excel');

// tirer le csv
Route::get('ambassadrice/facture/invoice/excel/{id}/{code}/{annee}', [AmbassadriceOrdercustomsController::class, 'getexcelinvoices'])->name('ambassadrice.excel');



// route ajax pour payer une facture ambassadrice
Route::post('/ambassadrice/factures', [AmbassadriceOrdercustomsController::class, 'invoicespay']);

// gérer le telechargement zip des facture mensuel
Route::post('/download-zip/facture', [SuiviController::class, 'downloadZip']);

// route ajax pour payer une facture ambassadrice
Route::post('/ambassadrice/factures1', [AmbassadriceOrdercustomsController::class, 'invoicespays']);

//route pour git cards cadeau bon achat
Route::post('/ambassadrice/factures2', [AmbassadriceOrdercustomsController::class, 'invoicescards'])->name('ambassadrice.factures2');

// route search name
// route ajax pour payer une facture ambassadrice
Route::post('/search', [AmbassadriceOrdercustomsController::class, 'search'])->name('ambassadrice.search');

// gestion controle sur le flux elève
Route::get('/ambassadrice/gestion/control', [GestionControlController::class, 'getcontrol'])->name('gestion.ambassadrice');


// gestion des payements via cartes bancaire

Route::get('/ambassadrice/customer/cards', [GestionControlController::class, 'getcards'])->name('gestion.payment');

// retour de controle sur la gestion des flux de création de code élève ou partenaire,ambassadrice.

Route::get('/ambassadrice/code/control', [GestionControlController::class, 'getcontrols'])->name('gestion.controls');


// rdv live utilisateur internes
Route::get('/gestion/calendar/lives', [UtilisateursController::class, 'viewcalendars'])->name('utilisateurs.calendar');
//rdv live utilisateur 
Route::get('/gestion/calendar/getEventCalendars', [UtilisaterusController::class, 'getEventCalendar'])->name('utilisateurs.getEventCalendar');

Route::get('/gestion/calendar/getEventCalendarLives', [UtilisateursController::class, 'getEventCalendarLive'])->name('utilisateurs.getEventCalendarLive');
Route::get('/gestion/livewire/lives', [UtilisateursController::class, 'views'])->name('livewire.calendar');



// gestion calendar rdv lives 
Route::get('/gestion/calendar/live', [GestionControlController::class, 'viewcalendar'])->name('gestion.calendar');

Route::get('/gestion/calendar/getEventCalendar', [GestionControlController::class, 'getEventCalendar'])->name('gestion.getEventCalendar');

Route::get('/gestion/calendar/getEventCalendarLive', [GestionControlController::class, 'getEventCalendarLive'])->name('gestion.getEventCalendarLive');

Route::get('/gestion/livewire/live', [GestionControlController::class, 'views'])->name('livewire.calendar');

Livewire::component('calendar', Calendar::class);

// génréres des factures
Route::get('/ambassadrice/get/factures', [AmbassadriceOrdercustomsController::class, 'createfacture'])->name('ambassadrice.getfactures');

// request post sur la génération de facture pour ambassadrice/partenaire
Route::post('/ambassadrice/get/factures', [AmbassadriceOrdercustomsController::class, 'getfamabassadrice'])->name('ambassadrice.post_factures');

// dashord partenaire
Route::get('/partenaire/data', [PartenaireController::class, 'user'])->name('partenaire.user');


// route partenaire à construire

Route::get('/partenaire/list', [PartenaireController::class, 'list'])->name('partenaire.list');


Route::get('/partenaire/dashboard', [PartenaireController::class, 'dashboard'])->name('partenaire.dashboard');
Route::post('/partenaire/dashboard', [PartenaireController::class, 'dashboard'])->name('partenaire.dashboard');
Route::get('/partenaire/getChartParte', [PartenaireController::class, 'getChartParte'])->name('partenaire.getChartParte');




// error si le patenaire a deja valide un moyen de paiments.
Route::get('/partenaire/paiement/error', [PartenaireController::class, 'paiementeror'])->name('partenaire.error');


// post pour dashboard paretaneaire
Route::post('/partenaire/dashboard', [PartenaireController::class, 'dashboard']);

// gestion de utilisateur enregsitrement des orders code promo utilisateur

Route::post('/createcodepromo', [UtilisateursController::class, 'userscode'])->name('createcodepromo');

// gestion de list des orders des utilisateurs
Route::get('/orders/list/code_promo', [UtilisateursController::class, 'list'])->name('utilisateurs.list');

// gestion et desactivation des codes fidélités 
// gestion des codes filidélité désactive les codes du programe fidélité
Route::get("/utilisateur/prgramme/fidelite", [UtilisateursController::class, "codefide"])->name('utilisateurs.codefidelite');

// route désactiver le code fem via l'api.
Route::post("/utilisateur/prgramme/fidelite", [UtilisateursController::class, "postcodefide"]);

// activer les lives des ambassadrice
// gestion de list des orders des utilisateurs
Route::get('/utilisateur/active/lives', [UtilisateursController::class, 'activelive'])->name('utilisateurs.codelive');

//// gestion de list des orders des utilisateurs
Route::get('/utilisateur/historique/lives', [UtilisateursController::class, 'historiquelive'])->name('utilisateurs.historiquelive');


// route cloture de caisse dolibar
// gestion de list des orders des utilisateurs
Route::get('/utilisateur/caisse/cloture', [UtilisateursController::class, 'cloturecaisse'])->name('utilisateurs.cloturecaisse');

// traiter les commande de distributeur pour envoyer sur woocommcerce


// post traitement de la cloture de caisse
Route::post('/utilisateur/caisse/cloture', [UtilisateursController::class, 'postcaisse']);

// Liste des faq 
Route::get('/utilisateur/faq', [UtilisateursController::class, 'faq'])->name('utilisateurs.faq');
// Create faq
Route::post('/utilisateur/faqAdminPost', [UtilisateursController::class, 'faqAdminPost'])->name('faqAdminPost');
// Delete faq
Route::post('/utilisateur/faqAdminDelete', [UtilisateursController::class, 'faqAdminDelete'])->name('faqAdminDelete');

// Faq ambas & partenaires
Route::get('/ambassadrice/faqs', [AmbassadriceController::class, 'faq'])->name('ambassadrice.getFaqs');

// Faq admin
Route::get("/faqAdmin", [ControllerCalculManuel::class, "faqAdmin"])->name('superadmin.faqAdmin');
Route::post('/faqAdminPost', [ControllerCalculManuel::class, 'faqAdminPost'])->name('faqAdminPost');
Route::post('/faqAdminDelete', [ControllerCalculManuel::class, 'faqAdminDelete'])->name('faqAdminDelete');

//Ambassadrice demande aide.
Route::get('/ambassadrice/aide', [AmbassadriceController::class, 'aideforms'])->name('ambassadrice.aideforms');
// traitement d'envoi de formulaire demande aide ambassadrice.
Route::post('/ambassadrice/aide', [AmbassadriceController::class, 'aideforms'])->name('ambassadrice.postaideforms');



// route utilisateur voir les palier live configurés

Route::get('/utilisateur/palier/cadeaux/live', [UtilisateursController::class, 'palier'])->name('utilisateurs.paliercadeaux');


// list l'historique des cloture de caisse

Route::get('/utilisateur/list/caisse/cloture', [UtilisateursController::class, 'caisselist'])->name('utilisateurs.cloturelist');


// edit list orders utilisateur
// gestion de list des orders des utilisateurs
Route::get('/orders/caisse/edit/{id}', [UtilisateursController::class, 'editaction'])->name('utilisateurs.edit');

// gestion controle code promo
// gestion de list des orders des utilisateurs
Route::get('/utilisateur/verify/code_promo', [UtilisateursController::class, 'codeverify'])->name('utilisateurs.verifypromo');

// post serarch
Route::post('/utilisateur/verify/code_promo', [UtilisateursController::class, 'codeverify'])->name('utilisateurs.verifypromo');

// route post pour
// gestion de list des orders des utilisateurs
Route::post('/editcaisse', [UtilisateursController::class, 'editcaisse']);


// api coupons dans woocomerce transferer erp
// lancer une fonction Ajax
Route::post('/datas/coupons', [ApiSystemOrdersController::class, 'datacodepromo'])->name('datas.coupon');


// fonction ajax pour recupérer les oders codes promo dans erp
Route::post('/datas/api/code_promos', [ApiSystemOrdersController::class, 'dataapicodepromo'])->name('api.code_promos');

// post pour recuperer les orders refunded ou cancelled
Route::post('/datas/refunded/A', [ApiSystemOrdersController::class, 'orderrefunded']);

// recupérer les données pour les bilans ambassadrice mensuel
// route dansbord ambassadrice
Route::post('/create/date', [AmbassadriceController::class, 'datadate']);



//import Api Ordercodepromo woocomerce avec orders
// csv imports
Route::post('/data/Api/code_promo', [ApiSystemcallController::class, 'codepromoapi']);

//import Api wooommerce status refunded et cancelled
Route::post('/datas/refunded', [ApiSystemcallController::class, 'codecancelled']);

// api datasotcks dolibar 
// route orders get Api data
Route::get('/data/dolibar/stocks', [ApiSystemcallController::class, 'datastocks'])->name('api.datastocks');


// post action orders stocks dolibar
// api datasotcks dolibar 
// route orders get Api data
// Route::get('/data/dolibar/stocks', [ApiSystemcallController::class, 'datastocks'])->name('api.datastocks');

// post action orders stocks dolibar

// traitement en post de mise a jour du stocks vers dolibars
Route::post('/data/dolibar/miseajours', [ApiSystemcallController::class, 'misejoursstocks'])->name('misejoursstocks');

// post Mise a jours produit 
Route::post('/data/product/all', [ApiSystemOrdersController::class, 'list_product'])->name('data.product_all');


// mise a jour des categories
Route::post('/data/categorie/all', [ApiSystemOrdersController::class, 'categoriespost'])->name('data.categories_all');

// symchroniser les datas. categoris et product dolibarr woocomerce.
Route::post('/data/post/all', [ApiSystemOrdersController::class, 'synchroapi'])->name('data.synchro');


// mise a jour des categories
Route::post('/data/categorie/all/dol', [ApiSystemOrdersController::class, 'categorisall'])->name('data.categorie_all_dol');


// data full.


// traitement en post de mise a jour du stocks vers dolibars
Route::post('/product/dolibar/pmp', [ApiSystemcallController::class, 'misejourpmp']);

//route mise à jours en post des status
Route::post('/status/orders/dol', [ApiSystemcallController::class, 'statusmisejours']);


// route api import nouvellle et progression client .
Route::post('/data/new/customer', [SuiviController::class, 'newtiers'])->name('api.newtiers');
Route::get('/data/new/customer', [SuiviController::class, 'newtiers'])->name('api.newtiers');


// route api sur les dounlons de facture dolibarr
Route::get('/data/new/doublons/fact', [SuiviController::class, 'doublonsfact'])->name('api.doublonsfact');
Route::post('/data/new/doublons/fact', [SuiviController::class, 'doublonsfact'])->name('api.doublonsfact');

// import recette 
Route::get('/data/recette/chiffre/fact', [AdminController::class, 'cronchifres'])->name('api.chiffre');

// stats code élève utilisation et création.
Route::get('/code/eleve/creates', [AdminController::class, 'codecreateleve'])->name('gestion.codecreateleve');

// post pour traiter le cumul des ventes sur des périodiquement
Route::post('/data/ventes', [AdminController::class, 'statvente'])->name('api.statsvente');

// suivi des doublons par les utilisatrice utilisateur 3
Route::get('/data/list/doublons', [SuiviController::class, 'doublonslist'])->name('utilisateurs.listdoublons');


// route orders get Api data
Route::get('/data/society/order', [ApiSystemcallController::class, 'data'])->name('api.orders');

// modele de messages 
Route::get('/models/message/create', [AmbassadriceController::class, 'models'])->name('ambassadrice.models');

Route::post('/models/message/create/affich', [AmbassadriceController::class, 'model'])->name('ambassadrice.modelss');


// list des messages
Route::get('/models/message/list', [AmbassadriceController::class, 'modelist'])->name('ambassadrice.modelslist');

// Ajax edit ....
Route::get('/models/message/list', [AmbassadriceController::class, 'modeledit'])->name('ambassadrice.modeledit');

// post edit un model
Route::post('/models/message/edit', [AmbassadriceController::class, 'modeledits'])->name('ambassadrice.modeledits');

// ajax afficher le message de l'ambassadrice à partir du  models.
Route::get('/models/message/affiche', [AmbassadriceController::class, 'modelaffich'])->name('ambassadrice.modeleaffiche');

// envoi des messages à l'elève 
Route::post('/models/envoi/model', [AmbassadriceController::class, 'modelenvois'])->name('ambassadrice.modelenvois');

// function pour Notifier le point mensuelle chez les ambassadrice && partenaire.

Route::get('/Notification/bilan/mensuel', [AdminController::class, 'cloturepoint'])->name('superadmin.clourepoint');

// route de notification pour envoi du modéle à l'elève

Route::get('/confirm/model/message', [AdminController::class, 'confirmodels'])->name('ambassadrice.confirmmodels');

// gift_cards code cdeaau bon achat
Route::get('/data/gift/cards', [ApiSystemOrdersController::class, 'giftcards'])->name('api.giftcards');

// post 
Route::post('/data/gift/cards', [ApiSystemOrdersController::class, 'addgiftcards'])->name('data.gift_card');


// post 
Route::post('/data/product/jour', [ApiSystemOrdersController::class, 'reviewproduct'])->name('data.product_jour');



// csv export
Route::post('/data/society/orders', [ApiSystemcallController::class, 'filecsv']);

// csv imports
Route::post('/data/society/order', [ApiSystemcallController::class, 'data']);

//csv export stock dolibar

Route::post('data/dolibar/stocks', [ApiSystemcallController::class, 'exportstocks'])->name('data.exportstocks');


// exports csv des ventes sur dolibar
Route::post('data/dolibars/ventes', [ApiSystemcallController::class, 'exportventes'])->name('data_dolibars.ventes');
// recupérer le csv pour les stocks par entrepots.
Route::post('/data/dolibar/entreport/stocks/csv', [ApiSystemcallController::class, 'entrepotstock'])->name('data_dolibarcsv');


// mise à jours stocks
Route::get('data/dolibar-mise-a-jour/stocks', [StocksController::class, 'index_stocks'])->name('api.stocksdol');

// data orders via api woocomerce
Route::get('/data/society/dataorders', [ApiSystemOrdersController::class, 'datas'])->name('api.dataorders');


// data orders via api woocomerce import coupons
Route::get('/data/coupons', [ApiSystemOrdersController::class, 'coupons'])->name('api.datacoupons');


// route api order distributeur
// data orders via api woocomerce import coupons
Route::get('/data/distributed/order', [ApiSystemOrdersController::class, 'distributed'])->name('api.distributeur');

// post des distributeur 
Route::post('/datas/distributed', [ApiSystemOrdersController::class, 'postdistributeur'])->name('datas.distributed');

// post transfert api orders ditributeur woocomerce vers dolibar
Route::post('/order/distributeds', [ApiSystemOrdersController::class, 'apidistributeur']);

// route post orders préparer en boutique.
Route::post('/order/boutique/prepared', [ApiSystemOrdersController::class, 'apidordersboutique'])->name('order_boutique.prepared');

// route api Transfer des orders woocomerce vers dolibar
// data orders via api woocomerce
//lancer requete Ajax
Route::post('/data/apiaction', [ApiSystemOrdersController::class, 'actionapi']);


// trier 
Route::post('/data/apiaction', [ApiSystemOrdersController::class, 'actionapi']);

// recupérer les TansfertDataController
// gestion des alertes stocks Dolibarr Api
  Route::get("/api/list/product/transfert", [TransferDataController::class, "transfertapi"])->name('api.transfertdata');
  
  // route historique reception
  // gestion des alertes stocks Dolibarr Api
  Route::get("/api/transfert/historique", [TransferDataController::class, "alertstocks"])->name('api.transferthistorique');

// route api ORDER WOOCOMERCE DOLIBAR

 // gestion des alertes stocks Dolibarr Api
  Route::get("/api/alerts/stocks", [UserController::class, "alertstocks"])->name('api.alertstocks');
  // route post traitement 
   Route::post("/api/stocks/post", [UserController::class, "createalerte"]);
   
   // route post 
    Route::post("/api/product/commande", [UserController::class, "actioncommande"]);
   
   // faire un update mutiple pour notifier les commande 
     Route::post("/api/commande/updatemutiple", [UserController::class, "updatecommande"]);
   
 // afficher historique de commande fournisseur
     Route::get("/api/historiques/commmande", [UserController::class, "historique"])->name('api.historiquecommande');

 // les route de confirmation de tranferer orders
Route::get('/data/null', [ApiSystemOrdersController::class, 'action1'])
->name('api.nullorders');

// données importé avec succès
 // les route de confirmation de tranferer orders
Route::get('/data/import', [ApiSystemOrdersController::class, 'action2'])
->name('api.confirmtransferorder');


Route::get('/data/woocommerce', [ApiSystemOrdersController::class, 'woocommerce'])->name('api.woocommerce');
Route::get('/data/dolibarr', [ApiSystemOrdersController::class, 'dolibarr'])->name('api.dolibarr');

Route::get('/data/dolibarrs', [ApiSystemOrdersController::class, 'dolibarrs'])->name('api.dolibarrs');


// route en post mise a jour jointure dolibarr category, product
Route::get('/data/dolibarr/schyncro', [ApiSystemOrdersController::class, 'synchroapi'])->name('api.synchro');

// Vérification des commandes échouées Lyes
Route::get('/gestion/checkingCommandes', [AdminController::class, 'checkingCommandes'])->name('gestion.checkingCommandes');

Route::get('error', [UserController::class, 'error'])->name('error');

// envoi mail
Route::get('/data/email/notification', [AmbassadriceController::class, 'envoimailnot'])->name('ambassadrice.envoimailnot');

// Notification push 

});
 // désactiver des routes reset password
 Auth::routes([
    'verify' => false,
    'reset' => false,
    'register'=>false
    
  ]);


// confirmation de choix de paiment partenaire
Route::get('/confirm/notif/paiments/', [PartenaireController::class, 'confirmpay'])->name('partenaire.confirmpay');


// route pour valider les forms.
Route::post('/notification/choix/paiments', [PartenaireController::class, 'postpaiments']);

// route pour valider les forms. pour les carte cadeaux
Route::post('/notifications/choix/paiments', [PartenaireController::class, 'postpaimentss']);


// route tache cron pour notification  order distributeur .....
Route::get('/data/order/notification/distributeur/{user}', [ApiSystemOrdersController::class, 'datadistributeur'])->name('api.dataords');

// declerche une route de notification de paiment des partenaire

Route::get('/partenaire/notif/paiments/{code_amba}', [PartenaireController::class, 'paiementpar'])->name('partenaire.paiementuser');

Route::get('/partenaire/notifs/paiments/{code_amba}', [PartenaireController::class, 'paiementpars'])->name('partenaire.paiementusers');
// api live panier amabassadrice


// construire des route pour des tache crons
// data orders via api woocomerce // test une tache cron
Route::get('/data/code/cron/action/{user}', [ApiSystemOrdersController::class, 'datactioncron'])->name('api.dataord');

// tash cron qui va importer les recettes journaliers (internets, boutique nice et boutique marseille).
Route::get('/data/recette/chiffre/{user}', [AdminController::class, 'cronchifre'])->name('api.dataord');

// import de facture et recupéreration de ventes pour des stats(cumul de vente article par mois.....
Route::get('/data/import/ventes/stats/{user}', [AdminController::class, 'statsventes'])->name('api.statvente');

// statisque des utilisateurs departement et régions.
Route::get('/data/statistique/customers', [AdminController::class, 'reporting'])->name('gestion.usercustomer');

// import tiers woomcerce
Route::get('/data/import/tiers/wc/{user}', [AdminController::class, 'importierswc'])->name('api.importierswc');

// tache crom ambassadrice orders seconds
Route::get('/data/code/cron2/action2/{user}', [ApiSystemOrdersController::class, 'datactioncron1'])->name('api.dataords');


// tache cron sur mise a jours des cartes cadeaux git card
Route::get('/data/gitf/cards/cron2/{token}', [ApiSystemOrdersController::class, 'datactioncron3'])->name('api.dataords');


// Notifier des paiements au ambassadrice et partenaire tache chaque 5 du mois.
Route::get('/data/facture/paiement/cron2/{token}', [AmbassadriceOrdercustomsController::class, 'datactioncron4'])->name('api.dataords');

// tache cron pour actualiser le dasbords  fidelite 2 fois par jours.
Route::get('/data/refresh/dasbord/cron2/{token}', [SuiviController::class, 'datactioncron5'])->name('api.dataords');


// tache crons detection des doublons facture dolibar.data.
Route::get('/data/doublons/fact/cron2/{token}', [SuiviController::class, 'datactioncron7'])->name('api.dataords');


// tache api cron panier cadeaux live ambassadrice choix panier .
Route::get('/api/panier/choix/live', [PanierLiveController::class, 'getpanierlive'])->name('api.getpanierlive');


// Notifier les live qui n'ont été excutés 2h et lever les restriction...
Route::get('/ambasssadrice/notif/lives/{user}', [NotificationController::class, 'notiflive'])->name('ambassadrice.notiflive');
// construire des route pour des tache crons.

// tache cron succes change status orders boutique customer
Route::get('/order/cron/prepared/{user}', [ApiSystemOrdersController::class, 'datacronorder'])->name('api.dataapiordercron');

// tache cron pour les colliship dolibarr...
Route::get('/data/colliship/{token}', [ApiSystemOrdersController::class, 'datacollishp'])->name('api.datacollishp');

// tache cron pour recupérer les codes fidélité et les désactivez dans l'api utilisé en boutique.
Route::get('/order/fidelite/code/boutique/{user}', [UtilisateursController::class, 'postfem'])->name('api.datafem');

// recupérer la liste de tous codes élèves
Route::get('/code/eleve/create', [UtilisateursController::class, 'codecreateleve'])->name('utilisateurs.codecreateleve');



// reset password
 Route::get("/reset/password", [ResetPasswordController::class, "reset_pass"])->name('auth.passwords.reset');
// reset post email
Route::post("/sendmail", [ResetPasswordController::class, 'sendEmail']);
 // update password
Route::get("/update/password/{token}", [ResetPasswordController::class, 'updatepass'])->name('auth.passwords.resetpassword');


// confirmation de reset password
// create password
Route::get("/reset/password/new", [ResetPasswordController::class, 'newpass'])->name('auth.passwords.confirm');

// create password
Route::get("/create/password/{token}/{email}", [ResetPasswordController::class, 'createpass'])->name('auth.passwords.confirmaccount');

// create post password compte

Route::post("/createpassword", [LoginController::class, 'createpassword']);

// update post email
Route::post("/updatepassword", [ResetPasswordController::class, 'updatepassword']);

 // example data json Api 
  Route::get("/api/listes", [UserController::class, "list"])->name('list');

 // chart js exemple mini dashboard excercie Elyamaje 
 Route::get('chartjs', [ChartJsController::class, 'chartjs'])->name('chartjs.index');

 // chart js exemple mini dashboard excercie Elyamaje 
 Route::get('data', [UserController::class, 'Pdfdata'])->name('pdfdata');

 // cron qui remplir la table des factures et ses lines pour des stats.









 