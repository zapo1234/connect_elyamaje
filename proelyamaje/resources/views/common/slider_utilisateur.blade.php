<ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:black;">

    <!-- Sidebar - Brand -->
    <a href ="{{ route('utilisateurs.utilisateur') }}"><img  src="{{ asset('admin/img/elyamaje_logo_blanc.png')}}" width="95px";
					height="auto"; style="margin-top:20px;margin-left:15%";></a>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    
    <li class="nav-item active">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Utilisateur elyamaje</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        
    </div>

  
   <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseT">
            <i class="fas fa-fw fa-cog"></i>
            <span>Activer code live </span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{  route('utilisateurs.codelive')  }}">Activer des lives </a>
        
            
            </div>
        </div>
    </li>


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwos"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Gérer des commande </span>
        </a>
        <div id="collapseTwos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="{{  route('utilisateurs.verifypromo')  }}">Suivi code elève </a>
                <a class="collapse-item" href="{{  route('utilisateurs.utilisateur')  }}">Ajouter une commande </a>
                <a class="collapse-item" href="{{ route('utilisateurs.list') }}">Lister les commdandes </a>
            
            </div>
        </div>
    </li>
    
    
    
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTws"
            aria-expanded="true" aria-controls="collapseTw">
            <i class="fas fa-fw fa-cog"></i>
            <span>Historiques activité </span>
        </a>
        <div id="collapseTws" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="{{ route('ambassadrice.factures') }}">Facture Ambassadrice<br/>partenaire </a>
                <a class="collapse-item" href="">Achat bon cadeaux  </a>
            
            </div>
        </div>
    </li>

    
</ul>


<div id="menu_mobile" style="display:none;width:400px;height:680px;background-color:white;position:absolute;z-index:5">
    
    <div id="pak" style="display:none"></div>   <span id="sidebrs" class="btnc" style="padding-left:80%;padding-top:20px">
        <i class="fa fa-times" style="color:black;font-size:18px"></i>
    
    </span>
    
 <div class="center"> <a href="{{  route('ambassadrice.user')   }}"><img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px";
					height="auto"; style="margin-top:10px;margin-left:30%"; margin-bottom:"";></a>       </h1>
    </div>

 <div class="content1" style="width:245%; margin-top:30px;">
 
 <div class="conts" style="color:white;background-color:black"><a href ="{{ route('ambassadrice.codelive') }}"><i class="fas fa-fw fa-tachometer-alt" style="font-size:20px;color:white;margin-left:-34%"></i> Activer des lives </a></div>
 <div class="conts" style="color:white;background-color:black"><a href ="{{ route('utilisateurs.utilisateur') }}"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px;color:white;margin-left:-20%"></i> Enregistrer commande</a></div>
 
 <div class="conts" style="color:white;background-color:black"><a href ="{{ route('utilisateurs.list') }}"> <i class="fas fa-download" style="font-size:20px;color:white;margin-left:-20%"></i> lister des commandes </a></div>
 
     
 </div><br/><!--content1-->
 


<div class="content3" style="width:260px;border-bottom:2px solid #eee;;margin-left:10%;margin-top:25px">


</div>
 
 <div class="contens" style="color:black;font-size:20px;font-weight:bold;margin-left:25%;margin-top:15px"><a href="{{ route('logout')}} " style="color:black"><i class="fa fa-power-off" style="font-size:20px"></i>  Se Déconnecter </a></div>
 
</div>



