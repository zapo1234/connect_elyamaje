<ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:black;">

    <!-- Sidebar - Brand -->
    <a href="{{  route('ambassadrice.user')   }}"><img i src="{{ asset('admin/img/elyamaje_logo_blanc.png')}}" width="95px";
					height="auto"; style="margin-top:20px;margin-left:15%";></a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('ambassadrice.user') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Suivi activté</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Codes promos</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('ambassadrice.account')  }}">Créer un code élève</a>
                <a class="collapse-item" href="{{ route('ambassadrice.list')  }}">Lister des codes élève</a>
                 <a id ="live{{  Auth()->user()->is_admin }}" class="collapse-item" href="{{ route('ambassadrice.liveforms')  }}">Demande d'activation<br/>code live</a>
            </div>
        </div>
    </li>
    
    

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Gestion de commission</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a id="lives{{  Auth()->user()->is_admin }}" class="collapse-item" href="{{ route('ambassadrice.orders')  }}">Achats code parainage</a>
                <a class="collapse-item" href="{{ route('ambassadrice.ordersparain')  }}">Achats code élève</a>
                 <a class="collapse-item" href="{{ route('ambassadrice.factures') }}">Historique des factures</a>
                
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        
    </div>


  

</ul>


<div id="menu_mobile" style="display:none;width:400px;height:680px;background-color:white;position:absolute;z-index:5">
    
    <div id="pak" style="display:none"></div>   <span id="sidebrs" class="btnc" style="padding-left:80%;padding-top:20px">
        <i class="fa fa-times" style="color:black;font-size:18px"></i>
    
    </span>
    
 <div class="center"> <a href="{{  route('ambassadrice.user')   }}"><img i src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px";
					height="auto"; style="margin-top:10px;margin-left:30%"; margin-bottom:"";></a>       </h1>
    </div>

 <div class="content1" style="width:245%; margin-top:30px;">
 
 <div class="conts" style="color:white;background-color:black"><a href ="{{ route('ambassadrice.user') }}"><i class="fas fa-fw fa-tachometer-alt" style="font-size:20px;color:white;margin-left:-34%"></i> Suivi activité </a></div>
 <div class="conts" id="live{{ Auth()->user()->is_admin }}" style="color:white;background-color:black"><a href ="{{ route('ambassadrice.liveforms') }}"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px;color:white;margin-left:-20%"></i> Programmer un live ? </a></div>
 
 <div class="conts" style="color:white;background-color:black"><a href ="{{ route('ambassadrice.account') }}"> <i class="fas fa-download" style="font-size:20px;color:white;margin-left:-19%"></i> Créer un code  élève </a></div>
 
<div class="conts" style="color:black;background-color:black"><a href ="{{ route('ambassadrice.list') }}"><i class="fas fa-user-friends" style="font-size:20px;color:white;margin-left:-5%"></i></i> Listes des Codes élèves  </a></div>
 

     
     
 </div><br/><!--content1-->
 

<div class="content2" style="width:245%;">
    <div class="conts" id="livet{{Auth()->user()->is_admin }}" style="color:white;background-color:black"><a href ="{{ route('ambassadrice.orders') }}"><i class="fa fa-eye" style="font-size:20px;color:white;margin-left:-3%"></i> Ventes code parainnage/live </a></div>
   
   <div class="conts" style="color:white;background-color:black"><a href ="{{ route('ambassadrice.ordersparain') }}"><i class="fa fa-eye" style="font-size:20px;color:white;margin-left:-20%"></i>  Ventes codes élèves </a></div>
   
    <div class="conts" style="color:white;background-color:black"><a href ="{{ route('ambassadrice.factures') }}"><i class="fa fa-eye" style="font-size:20px;color:white;margin-left:-20%"></i>  Historiques factures </a></div>
    
    
</div>

<div class="content3" style="width:260px;border-bottom:2px solid #eee;;margin-left:10%;margin-top:25px">


</div>
 
 <div class="contens" style="color:black;font-size:20px;font-weight:bold;margin-left:25%;margin-top:15px"><a href="{{ route('logout')}} " style="color:black"><i class="fa fa-power-off" style="font-size:20px"></i>  Se Déconnecter </a></div>
 
</div>

