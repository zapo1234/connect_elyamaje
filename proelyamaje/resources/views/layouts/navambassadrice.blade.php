<div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                <img class="img-profile" src="{{asset('admin/img/logo_elyamaje_horiz.png')}}" ;="" height="auto" style="margin-top: 3px;width: 100px;">
                </div>
                <div>
                    <h4 class="logo-text"></h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="{{ route('ambassadrice.user') }}">
                        <div class="parent-icon"><i class='bx bx-home'></i>
                        </div>
                        <div class="menu-title">Tableau de bord</div>
                    </a>
                
                </li>
                
                
                 <li>
                    <a href="{{ route('ambassadrice.userstatistique') }}">
                        <div class="parent-icon"><i class='bx bx-table'></i>
                        </div>
                        <div class="menu-title">Statistiques</div>
                    </a>
                
                </li>
                
                
                
                 <li>
                    <a href="{{ route('ambassadrice.listeleve') }}">
                        <div class="parent-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="currentColor" stroke-width="1" width="24" height="24" x="0px" y="0px" viewBox="0 0 64 64" stroke-linecap="round" stroke-linejoin="round">
                                <g>
                                    <path d="M21.8,36.8c6.9,0,12.4-5.6,12.4-12.4s-5.6-12.4-12.4-12.4S9.4,17.5,9.4,24.4S15,36.8,21.8,36.8z M21.8,16.4   c4.4,0,7.9,3.6,7.9,7.9s-3.6,7.9-7.9,7.9c-4.4,0-7.9-3.6-7.9-7.9S17.4,16.4,21.8,16.4z"></path>
                                    <path d="M21.8,39.9c-7.2,0-14.1,2.9-19.4,8.3c-0.9,0.9-0.9,2.3,0,3.2c0.4,0.4,1,0.7,1.6,0.7c0.6,0,1.2-0.2,1.6-0.7   c4.4-4.5,10.2-7,16.2-7c5.9,0,11.7,2.5,16.2,7c0.9,0.9,2.3,0.9,3.2,0c0.9-0.9,0.9-2.3,0-3.2C35.9,42.9,29,39.9,21.8,39.9z"></path>
                                    <path d="M47.3,36.8c4,0,7.3-3.3,7.3-7.3c0-4-3.3-7.3-7.3-7.3s-7.3,3.3-7.3,7.3C39.9,33.5,43.2,36.8,47.3,36.8z M47.3,26.6   c1.6,0,2.8,1.3,2.8,2.8c0,1.6-1.3,2.8-2.8,2.8s-2.8-1.3-2.8-2.8C44.4,27.9,45.7,26.6,47.3,26.6z"></path>
                                    <path d="M61.5,45.6c-5.3-4.9-12.6-6.9-19.9-5c-1.2,0.3-1.9,1.5-1.6,2.7c0.3,1.2,1.6,1.9,2.7,1.6c5.8-1.5,11.6,0,15.7,3.9   c0.4,0.4,1,0.6,1.5,0.6c0.6,0,1.2-0.2,1.6-0.7C62.5,47.9,62.4,46.5,61.5,45.6z"></path>
                                </g>
                        </svg>

                        </div>
                        <div class="menu-title">Vos élèves</div>
                    </a>
                
                </li>


                 <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><svg class="bx " xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-percent text-primary"><line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg>
                        </div>
                        <div class="menu-title">Codes promos</div>
                    </a>
                    <ul>
                        @if(Auth()->user()->id!=9 OR Auth()->user()->id!=38)
                            <li> <a href="{{ route('ambassadrice.account') }}"><i class="bx bx-right-arrow-alt"></i>Création de codes</a>
                            
                            </li>
                            
                            
                            <li> <a href="{{ route('ambassadrice.list') }}"><i class="bx bx-right-arrow-alt"></i>Vos codes Élèves</a>
                            
                            </li>
                        @else
                             <li> <a href="{{ route('error') }}"><i class="bx bx-right-arrow-alt"></i>Création de codes</a>
                            
                            </li>
                            
                            
                            <li> <a href="{{ route('error') }}"><i class="bx bx-right-arrow-alt"></i>Vos codes Élèves</a>
                            
                            </li>
                        @endif

                        
                    </ul>
                </li>
                
                
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-cart-alt' ></i>
                        </div>
                        <div class="menu-title">Commissions</div>
                    </a>
                    <ul>
                        <li> <a href="{{ route('ambassadrice.ordersparain')  }}"><i class="bx bx-right-arrow-alt"></i>Achats code Élève</a>
                        </li>
                        
                        <li> <a  id="lives{{  Auth()->user()->is_admin }}"  href="{{ route('ambassadrice.orderaccount')  }}"><i class="bx bx-right-arrow-alt"></i>Achats code Parrainage</a>
                        </li>
                        
                    </ul>
                </li>
                
            
                
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fadeIn animated bx bx-file"></i>
                        </div>
                        <div class="menu-title">Factures </div>
                    </a>
                    <ul>
                        <li> <a href="{{ route('ambassadrice.fact') }}"><i class="bx bx-right-arrow-alt"></i>Historique des factures</a>
                        </li>
                        
                    </ul>
                </li>
               
                
            
            
            
                
                <li id="vues{{ Auth()->user()->is_admin  }}">
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bx bx-video-recording"></i>
                        </div>
                        <div class="menu-title">Lives</div>
                    </a>
                    <ul>
                    @if(Auth()->user()->id!=9 OR Auth()->user()->id!=38)
                        <li class="vue{{ Auth()->user()->is_admin }}"> <a href="{{ route('ambassadrice.liveforms') }}"><i class="bx bx-right-arrow-alt"></i>Programmer un live</a>
                        </li>

                        <li> <a href="{{ route('ambassadrice.gestionlive') }}"><i class="bx bx-right-arrow-alt"></i>Gérer vos lives</a>
                        </li>
                        
                    </ul>
                </li>

                @else
                        <li> <a href="{{ route('error') }}"><i class="bx bx-right-arrow-alt"></i>Création de codes</a>
                            
                            </li>
                            
                            
                            <li> <a href="{{ route('error') }}"><i class="bx bx-right-arrow-alt"></i>Vos codes élèves</a>
                            
                            </li>
                        @endif


                <li>
                    <a href="{{ route('ambassadrice.models') }}">
                        <div class="parent-icon"><i class='bx bx-message-detail'></i>
                        </div>
                        <div class="menu-title">Modèle de messages</div>
                    </a>
                
                </li>
                
                
                
                <!-- <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-chevron-right-circle'></i>
                        </div>
                        <div class="menu-title">Gestion des lives </div>
                    </a>
                    <ul>
                        <li> <a href="{{ route('ambassadrice.gestionlive') }}"><i class="bx bx-right-arrow-alt"></i>Gérer vos lives</a>
                        </li>
                        
                    </ul>
                </li> -->
               
                <li>
                    <a href="{{ route('ambassadrice.aideforms') }}">
                        <div class="parent-icon"><i class='bx bx-help-circle'></i>
                        </div>
                        <div class="menu-title">Aide</div>
                    </a>
                
                </li>
               
               

                <li>
                    <a href="{{ route('ambassadrice.getFaqs') }}">
                        <div class="parent-icon"><i class='bx bx-help-circle'></i>
                        </div>
                        <div class="menu-title">Règles d'utilisation</div>
                    </a>
                
                </li>
               
                
                
                
                
                
                 <li>
                    <a href="{{ route('logout') }}">
                        <div class="parent-icon"><i class='bx bx-log-out-circle'></i>
                        </div>
                        <div class="menu-title">Déconnexion</div>
                    </a>
                
                </li>
               
               
                
            </ul>
            <!--end navigation-->
        </div>