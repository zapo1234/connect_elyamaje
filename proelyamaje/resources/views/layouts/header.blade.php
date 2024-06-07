<header>
            
            
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
            
            
            
            
            
            
            
            
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="top-menu-left d-none d-lg-block">
                        <ul class="nav">
                            LOGICIEL ERP ELYAMAJE
                          </ul>
                     </div>
                    <div class="search-bar flex-grow-1">
                        <div class="position-relative search-bar-box">
                           
                        </div>
                    </div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item mobile-search-icon">
                                <!--<a class="nav-link" href="#">   <i class='bx bx-search'></i>-->
                                </a>
                            </li>

                              @if(Auth()->user()->is_invite =="")
                                <li class="nav-item dropdown dropdown-large">
                                    <a class="nav_icon_{{ Auth()->user()->is_admin }} nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class='bx bx-category'></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" id="header-affich{{ Auth()->user()->is_admin }}">
                                        <div class="row row-cols-3 g-3 p-3">
                                        @if(Auth()->user()->id!=38  && Auth()->user()->id!=132 && Auth()->user()->id!=82 && Auth()->user()->id!=111 && Auth()->user()->id!=68)
                                            <div class="col text-center" id="f{{ Auth()->user()->is_admin}}">
                                                <a href="{{ route('ambassadrice.account') }}">
                                                <div class="app-box mx-auto bg-gradient-cosmic text-white"><i class='bx bx-group'></i>
                                                </div>
                                                <div class="app-title">Créer un code élève</a></div>
                                                @else
                                             <li> <a href="{{ route('error') }}"><i class="bx bx-right-arrow-alt"></i>Créer des codes</a>
                                            </li>
                            
                                          @endif
                                            </div>
                                            <div class="col text-center">
                                                <a href="{{  route('ambassadrice.list')  }}">
                                                <div class="app-box mx-auto bg-gradient-burning text-white"><i class='bx bx-atom'></i>
                                                </div>
                                                <div class="app-title">Lister des élèves</a></div>
                                            </div>
                                            
                                            <div class="col text-center">
                                                <a href ="{{ route('ambassadrice.fact')}}">
                                                <div class="app-box mx-auto bg-gradient-blues text-white"><i class='bx bx-file'></i>
                                                </div>
                                                <div class="app-title">Factures</a></div>
                                            </div>
                                            <div class="col text-center">
                                                <a href ="{{ route('ambassadrice.liveforms')}}">
                                                @if(Auth()->user()->is_admin!=4 && Auth()->user()->is_admin!=3 && Auth()->user()->is_admin!=1)
                                                <div class="app-box mx-auto bg-gradient-moonlit text-white"><i class='lni lni-timer'></i>
                                                </div>
                                                <div class="app-title"> Programmer un live </a> </div>
                                                @endif
                                               
                                                </div>

                                            <!-- <div class="col text-center">
                                                <a href ="{{ route('ambassadrice.activate_live')}}">
                                                <div class="app-box mx-auto bg-gradient-moonlit text-white"><i class='bx bx-video-recording'></i>
                                                </div>
                                                <div class="app-title"> Activer mon live </a> </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </li>
                            @endif
                            
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative nav_icon_{{ Auth()->user()->is_admin }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span data-id2 ="" class="alert-count">{{ $countline ?? '' }}</span>
                                    <i class='bx bx-bell'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    
                                    <div class="header-notifications-list">
                                         @if(Auth()->user()->is_admin == 2 OR Auth()->user()->is_admin ==4)
                                 <h3 class="dropdown-header" style="background-color:black;font-size:15px;border:2px solid black;text-align:center;color:white">
                                 Vu des commande !
                                  </h3>
                                        
                                     @foreach($array_list as $resultat)   
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-danger text-danger"><i class="bx bx-cart-alt"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">{{ $note   }}<span class="msg-time float-end"></h6>
                                                    <p class="msg-info">{{  $resultat['id_commande'] }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        
                                        @endforeach
                                    
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer"><a href="{{ route('ambassadrice.orderslists') }}"> Voir les commandes récentes</a></div>
                                    </a>
                                     @endif
                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                
                                    
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Messages</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a>
                                    <div class="header-message-list">
                                        
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    
                                                </div>
                                               
                                      
                                       
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Messages</div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown border-light-2">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(file_exists('admin/uploads/'.Auth()->user()->img_select))
                                <div class="img-profile rounded-circle" style=" background-size: contain;background-repeat: no-repeat;background-position: center center;background-image: url('{{ asset('admin/uploads/'.Auth()->user()->img_select )}}') ;width:45px;height:45px"></div>
                            @else 
                                <img class="img-profile rounded-circle" src="{{ asset('admin/uploads/default_avatar.png' )}}" ;="" height="auto" style="width:42px;height:42px;border-radius:30px;">
                            @endif
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">  {{ Auth()->user()->username }}</p>
                                
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('profil') }}"><i class='bx bx-user'></i><span> Profil</span></a>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('logout') }}"><i class='bx bx-log-out-circle'></i><span> Déconnexion</span></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>    
