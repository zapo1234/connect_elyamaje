<ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:black;">

    <!-- Sidebar - Brand -->
    <a href ="{{ route('superadmin.home') }}"><img  src="{{ asset('admin/img/elyamaje_logo_blanc.png')}}" width="95px";
					height="auto"; style="margin-top:20px;margin-left:15%";></a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('superadmin.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        
    </div>
    
    
     <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class='fas fa-user-friends' style='font-size:15px'></i>
            <span>Comptes Utilisateurs</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route ('account.list') }}">Gestion des comptes</a>
                <a class="collapse-item" href="u
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class='fas fa-database' style=''></i>
            <span>DATA API </span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Commandes Api</h6>
                <a class="collapse-item" href="{{ route('api.datacoupons') }}">Import coupons</a>
                 <a class="collapse-item" href="{{ route('api.giftcards') }}">Import code cartes cadeau</a>
                <a class="collapse-item" href="{{ route('api.dataorders') }}">Import orders <br/>Ambassadrice </a>
                 <a class="collapse-item" href="{{ route('api.distributeur') }}">Import orders <br/> Distributeur </a>
                <a class="collapse-item" href="{{ route('api.datastocks') }}">Mise à jour <br/> stocks Dolibar</a>
               <a class="collapse-item" href="{{  route('api.alertstocks') }}">Alerts stocks email</a>
            
            </div>
        </div>
    </li>
    
    
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwog"
            aria-expanded="true" aria-controls="collapseTwog">
            <i class='fas fa-database' style=''></i>
            <span>DATA Transfert(Dolibar) </span>
        </a>
        <div id="collapseTwog" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Commandes Api</h6>
                <a class="collapse-item" href="{{ route('api.datacoupons') }}">Gestion des produits<br/>Hors facture dolibar</a>
                 <a class="collapse-item" href="{{ route('api.giftcards') }}">Historique de transferts<br/>commande dolibar !</a>
            
            </div>
        </div>
    </li>

   

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

   
   
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePags"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Création de code  </span>
        </a>
        <div id="collapsePags" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion</h6>
                
                <a class="collapse-item" href="{{ route('account.codespeciale') }}">Créer un code <br/> spécifique</a>
                <a class="collapse-item" href="{{ route('account.codeeleves') }}">Lister les codes<br/>spécifique</a>
                <a class="collapse-item" href="{{ route('gestion.listcode') }}">Lister les codes<br/>crées par<br/> Ambassadrice/partenaire</a>
                
                <a class="collapse-item" href="{{ route('gestion.suivicode') }}">Suivi code élève</a>
                
        </div>
    </li>
   
   
   
   <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Ambassadrices </span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestion</h6>
                
                <a class="collapse-item" href="{{ route('ambassadrice.codelive') }}">Activation code live</a>
                 <a class="collapse-item" href="{{ route('ambassadrice.orders') }}">commandes élèves</a>
                <a class="collapse-item" href="{{ route('ambassadrice.statistiques') }}">Lister les ambassadrices</a>
                
                <a class="collapse-item" href="{{ route('gestion.listcode') }}">Lister les codes<br/>élèves</a>
                
                <div class="collapse-divider"></div>
                
            </div>
        </div>
    </li>
    
    

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwos"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class='fas fa-database' style=''></i>
            <span>Partenaires </span>
        </a>
        <div id="collapseTwos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
               <a class="collapse-item" href="{{ route('partenaire.dashboard') }}">Dashboard</a>
                <a class="collapse-item" href="{{ route('partenaire.list') }}">Lister Les partenaires</a>
                 <a class="collapse-item" href="{{ route('partenaire.dashboard') }}">Commandes partenaire</a>
            </div>
        </div>
    </li>
    
    
     <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoss"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class='fas fa-database' style=''></i>
            <span>Factures </span>
        </a>
        <div id="collapseTwoss" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
                 <a class="collapse-item" href="{{ route('ambassadrice.factures') }}">Lister les factures</a>
                 <a class="collapse-item" href="{{ route('ambassadrice.getfactures') }}">Mise à jour facture</a>
            </div>
        </div>
    </li>
 
    
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTws"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class='fas fa-database' style=''></i>
            <span>Agendas des lives </span>
        </a>
        <div id="collapseTws" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
               <a class="collapse-item" href="{{ route('partenaire.dashboard') }}">RDV LIVE</a>
                
            </div>
        </div>
    </li>
    
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwss"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class='fas fa-database' style=''></i>
            <span>Suivi sur le flux èléve </span>
        </a>
        <div id="collapseTwss" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
               <a class="collapse-item" href="{{ route('gestion.ambassadrice') }}">Gestion des adresses<br/>livraison des élèves<br/> des Ambassadrices</a>
                 <a class="collapse-item" href="{{ route('gestion.payment') }}">Suivi de paiement<br/>(cards)</a>
                
            </div>
        </div>
    </li>


</ul>

<div id="menu_mobile" style="display:none;width:400px;height:880px;background-color:white;position:absolute;z-index:5">
    
    <div id="pak" style="display:none"></div>   <span id="sidebrs" class="btnc" style="padding-left:80%;padding-top:20px">
        <i class="fa fa-times" style="color:black;font-size:18px"></i>
    
    </span>
    
 <div class="center"> <a href="{{  route('ambassadrice.user')   }}"><img  src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px";
					height="auto"; style="margin-top:10px;margin-left:29%"; margin-bottom:"";></a>       </h1>
    </div>

 <div class="content1" style="width:245%; margin-top:30px;">
 
 <div class="conts" style="color:white;background-color:black"><a href ="{{ route('superadmin.home') }}"><i class="fas fa-fw fa-tachometer-alt" style="font-size:20px;color:white;margin-left:-29%"></i> Dashboard </a></div>
 
 <div class="conts" style="color:white;background-color:black"><a href ="{{ route('account.list') }}"> <i class="fas fa-download" style="font-size:20px;color:white;margin-left:-10%"></i> Gestion de comptes</a></div>
 
<div class="conts" style="color:black;background-color:black"><a href ="{{ route('account.list') }}"><i class="fas fa-user-friends" style="font-size:20px;color:white;margin-left:-10%"></i> Lister des comptes  </a></div>
 
<div class="conts" style="color:black;background-color:black"><a href ="{{ route('gestion.listcode') }}"><i class="fas fa-user-friends" style="font-size:20px;color:white;margin-left:-5%"></i> Gestion des codes élèves  </a></div>

<div class="conts" style="color:black;background-color:black"><a href ="{{ route('ambassadrice.statistiques') }}"><i class="fas fa-user-friends" style="font-size:20px;color:white;margin-left:-5%"></i> Gestion Ambassadrices  </a></div>

<div class="conts" style="color:black;background-color:black"><a href ="{{ route('ambassadrice.codelive') }}"><i class="fas fa-user-friends" style="font-size:20px;color:white;margin-left:-10%"></i> Activer des codes lives  </a></div>

 <div class="conts" style="color:black;background-color:black"><a href ="{{ route('partenaire.list') }}"><i class="fas fa-user-friends" style="font-size:20px;color:white;margin-left:-10%"></i> Gestion Partenaires  </a></div>
    <div class="conts" style="color:black;background-color:black"><a href ="{{ route('ambassadrice.factures') }}"><i class="fas fa-user-friends" style="font-size:20px;color:white;margin-left:-10%"></i> Historique factures  </a></div>
 </div><br/><!--content1-->
 

<div class="content2" style="width:245%;">
    
   
    <div class="conts" style="color:white;background-color:black"><a href ="{{ route('api.dataorders') }}"><i class="fa fa-eye" style="font-size:20px;color:white;margin-left:-25%"></i> Action Api </a></div>
    
     <div class="conts" style="color:white;background-color:black"><a href ="{{ route('api.datacoupons') }}"><i class="fa fa-eye" style="font-size:20px;color:white;margin-left:-25%"></i> Action Api coupons </a></div>
    
    <div class="conts" style="color:white;background-color:black"><a href ="{{ route('api.giftcards') }}"><i class="fa fa-eye" style="font-size:20px;color:white;margin-left:-25%"></i> Action Api cardes cadeaux </a></div>
</div>

<div class="content3" style="width:260px;border-bottom:2px solid #eee;;margin-left:10%;margin-top:25px">


</div>
 
 <div class="contens" style="color:black;font-size:20px;font-weight:bold;margin-left:25%;margin-top:15px"><a href="{{ route('logout')}} " style="color:black"><i class="fa fa-power-off" style="font-size:20px"></i>  Se Déconnecter </a></div>
 
</div>

