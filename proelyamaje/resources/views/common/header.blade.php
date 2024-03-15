<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <!--<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>-->
    </button>
    
     <span id="sidebar" class="btns">
        <i class="fa fa-bars" style="color:black"></i>
    </span>
    
    <button id="sidebars" class="btnc" style="display:none">
        <i class="fa fa-times" style="color:black"></i>
    
    </button>


    <!-- Topbar Search -->
     @if(auth()->user()->is_admin == 1)
    <h1 style="color:black;font-weight:800;font-size:25px;"></h1>
    @endif
    
     @if(auth()->user()->is_admin == 2)
     
     <!-- <h1>Ambassadrice Elyamaje</h1> -->
     
     @endif
    
    <!-- Topbar Navbar -->
    
           @php
            use App\Models\Ambassadrice\Ordersambassadricecustom;
            use App\Models\Ambassadrice\Notification;
            
            if(Auth()->user()->is_admin == 2 OR Auth()->user()->is_admin ==4)
            {
              $id = Auth()->user()->id;
              
              
              $count_line = Notification::where('id_ambassadrice',$id)->get();
              
               // transformer les retour objets en tableau
                 $count_list = json_encode($count_line);
                 $count_lists = json_decode($count_line,true);
                
                 $array_list = [];
                 $id = Auth()->user()->id;
                 foreach($count_lists as $val)
                 {
                   $array_list[] = [
                   
                    'id_commande'=> $val['id_commande'],
                    'id_ambassadrice' => $val['id_ambassadrice']
                    
                   ];
                 }
                 
                 if(count($array_list)==0)
                 {
                   $css ="noneno";
                   $countline = 0;
                   $note = "Aucune nouvelle commande !";
                   $note1 ="";
                   
                   $array_list[] = [
                   
                    'id_commande'=> "",
                    'id_ambassadrice' => "",
                    'note'=> $note
                   ];
                 }
                 
                 else{
                     $css ="datano";
                      $countline= count($array_list);
                      $note="vous avez une nouvelle commande N°";
                      
                   $orders= Ordersambassadricecustom::where('id_ambassadrice', $id)->orderBy('id','desc')->limit($countline)->get();
                   $note="vous avez une nouvelle commande N°";
                   
                 }
            }
            
            if(Auth()->user()->is_admin == 3)
            {
            
               $orders =[];
               $note="";
               $id="";
               $css="";
               $count_line="";
            }
            
            if(Auth()->user()->is_admin == 1)
            {
               $orders = [];
               $id="";
               $note="";
               $css="";
               $countline="";
            }
            @endphp
    
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter" data-id2 ="{{ $id }}" id="{{ $css  }}"><span class="{{ $css }}">{{ $countline ?? '' }}</span></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                @if(Auth()->user()->is_admin == 2 OR Auth()->user()->is_admin ==4)
                <h3 class="dropdown-header" style="background-color:black;font-size:15px;border:2px solid black">
                 commande !
                </h3>
                
                @foreach($array_list as $resultat)
                
                <a class="dropdown-item d-flex align-items-center" href="details/commande/{{ $resultat['id_commande'] }}/{{ $resultat['id_ambassadrice']}}">
                    <div class="mr-3">
                    
                    </div>
                    <div>
                        <div class="small" style="color:black;font-size:14px;"> {{ $note  }} <br/><span class="id_commade{{ $css }}"> {{ $resultat['id_commande'] }}</span>
                        </div>
                        <span class="font-weight-bold"> </span>
                    </div>
                </a>
                
                @endforeach
                
            
                
                <a class="dropdown-item text-center small text-gray-500" href="{{ route('ambassadrice.list') }}" style="font-size:20px">voir tout</a>
                @endif
            </div>
        </li>

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge"></span>
            </a>
            <!-- Dropdown - Messages -->
            
            
            
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
				{{ Auth()->user()->email }}</span>
                <img class="img-profile rounded-circle" src="{{ asset('admin/uploads/'.Auth()->user()->img_select )}}";
					height="auto"; style="margin-top:20px;%";></a>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    {{ Auth()->user()->name }}
                </a>
               
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('logout')}}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Deconnexion
                    
                </a>
            </div>
        </li>

    </ul>

</nav>