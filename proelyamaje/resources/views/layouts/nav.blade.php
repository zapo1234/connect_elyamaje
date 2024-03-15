<div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                <img class="img-profile" src="https://www.connect.elyamaje.com/admin/uploads/Logo_elyamaje.png" ;="" height="auto" style="margin-top: 3px;width: 50px;height: 33px;">
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
                @if(Auth::user()->rib=="xx11")
                    <a href="{{ route ('gestion.home') }}">
                        <div class="parent-icon">
                            <i class='bx bx-home'></i>
                        </div>
                     
                        <div class="menu-title">Dashboard</div>
                      
                    </a>
                    @endif
                    <!-- <ul>
                         <li> <a href="{{ route ('gestion.home') }}"><i class="bx bx-right-arrow-alt"></i>Activité Elyamaje</a>
                        </li>
                        
                        <li> <a href="{{ route ('superadmin.home') }}"><i class="bx bx-right-arrow-alt"></i> Ambassadrices</a>
                        </li>
                        
                        <li> <a href="{{ route('partenaire.dashboard') }}"><i class="bx bx-right-arrow-alt"></i> Partenaires</a>
                        </li>
                    </ul> -->
                </li>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="lni lni-users"></i>
                        </div>
                        <div class="menu-title">Utilisateurs</div>
                    </a>
                    <ul>
                        <!-- <li> <a href="{{ route ('account.list') }}"><i class="bx bx-right-arrow-alt"></i>Gestion des comptes</a>
                        </li> -->
                        <li> <a href="{{ route ('account.users') }}"><i class="bx bx-right-arrow-alt"></i>Créer un compte</a>
                        </li>
                        <li> <a href="{{ route ('account.list') }}"><i class="bx bx-right-arrow-alt"></i>Liste des comptes</a>
                        </li>
                    </ul>
                </li>


                <li class="menu_nav">
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-lock-open-alt'></i>
                        </div>
                        <div class="menu-title">Fonctions</div>
                    </a>
                    <ul>
                        <li> <a href="{{ route ('api.woocommerce') }}"><i class="bx bx-right-arrow-alt"></i>WooCommerce</a>
                        </li> 
                        <li> <a href="{{ route ('api.dolibarr') }}"><i class="bx bx-right-arrow-alt"></i>Dolibarr</a>
                        </li>

                        <li> <a href="{{ route ('gestion.controls') }}"><i class="bx bx-right-arrow-alt"></i>Control(flux code élève)</a>
                        </li>
                    </ul>
                </li>
                
                
                <!-- <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon">
                        <i class='bx bx-lock-open-alt'></i>
                        </div>
                        <div class="menu-title">Fonctions Dolibarr</div>
                    </a>
                    <ul>
                        <li> <a href="{{ route('api.datacoupons') }}"><i class="bx bx-right-arrow-alt"></i>Import coupons(code promo)</a>
                        </li>
                        
                        <li> <a href="{{ route('api.giftcards') }}"><i class="bx bx-right-arrow-alt"></i>Import  cartes cadeaux (gifts cards)</a>
                        </li>
                        
                        <li> <a href="{{ route('api.dataorders') }}"><i class="bx bx-right-arrow-alt"></i>Import Orders<br/>Ambassadrices</a>
                        </li>
                        
                         <li> <a href="{{ route('api.doublonsfact') }}"><i class="bx bx-right-arrow-alt"></i>Doublons<br/> facture Dolibar Clients</a>
                        </li>
                        
                         <li> <a href="{{ route('api.newtiers') }}"><i class="bx bx-right-arrow-alt"></i>Import new<br/>Clients</a>
                        </li>
                        
                        <li> <a href="{{ route('api.distributeur') }}"><i class="bx bx-right-arrow-alt"></i>Import orders<br/>Distributeur</a>
                        </li>
                        
                        <li> <a href="{{ route('api.datastocks') }}"><i class="bx bx-right-arrow-alt"></i>Mise à jour<br/>stocks dolibars</a></li>
                         
                         <li> <a href="{{  route('api.alertstocks') }}"><i class="bx bx-right-arrow-alt"></i>Alerts<br/>stocks email</a>
                         
                          <li> <a href="{{  route('api.alertstocks') }}"><i class="bx bx-right-arrow-alt"></i>Transfert de fonds <br/> caisse Boutique</a>
                          
                          
                           <li> <a href="{{  route('superadmin.cloturelist') }}"><i class="bx bx-right-arrow-alt"></i>Historique de transfert <br/> caisse Boutique</a>
                         
                        
                        </li>
                    </ul>
                </li> -->
                
                
                
                <li class="menu-label">Codes promos</li>
                
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><svg class="bx " xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-percent text-primary"><line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg>
                        </div>
                        <div class="menu-title">Codes élèves</div>
                    </a>
                    <ul>
                        <li> <a href=" {{ route('account.codespeciale') }}"><i class="bx bx-right-arrow-alt"></i>Créer un code spécifique</a>
                        </li>
                        <li> <a href="{{ route('account.codeeleves') }}"><i class="bx bx-right-arrow-alt"></i>Liste des codes spécifiques</a>
                        </li>
                        
                        <li> <a href="{{ route('gestion.codecreateleve') }}"><i class="bx bx-right-arrow-alt"></i>Lister des codes ambassadrice & partenaire</a>
                        </li>
                        
                        <li> <a href="{{ route('gestion.suivicode') }}"><i class="bx bx-right-arrow-alt"></i>Statistique elèves</a>
                        </li>
                        
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class='bx bx-gift'></i>
                        </div>
                        <div class="menu-title">Ambassadrices</div>
                    </a>
                    <ul>

                     
                     <li> <a href="{{ route('superadmin.ambassadricedashbord') }}"><i class="bx bx-right-arrow-alt"></i>Dashboard</a>
                        </li>
                      
                        <li> <a href="{{ route('superadmin.ambassadricevente') }}"><i class="bx bx-right-arrow-alt"></i>Statistique vente lives</a>
                        </li>

                        <li> <a href="{{ route('gestion.statsdata') }}"><i class="bx bx-right-arrow-alt"></i>Rapport vente</a>
                        </li>


                        <li> <a href="{{ route('account.create_ambassadrice') }}"><i class="bx bx-right-arrow-alt"></i>Créer ambassadrice</a>
                        </li>

                        <li> <a href="{{ route ('superadmin.home') }}"><i class="bx bx-right-arrow-alt"></i> Suivi Activité</a>
                        </li>

                        <li> <a href="{{ route('ambassadrice.statistiques') }}"><i class="bx bx-right-arrow-alt"></i>Liste des ambassadrices</a>
                        </li>

                        <li> <a href="{{ route('ambassadrice.codelive') }}"><i class="bx bx-right-arrow-alt"></i>Programmer des lives</a>
                        </li>
 
                        <li> <a href="{{ route('ambassadrice.configuration') }}"><i class="bx bx-right-arrow-alt"></i>Configurer des paliers</a>
                        </li>
                        
                          <li> <a href="{{ route('ambassadrice.listerpanier') }}"><i class="bx bx-right-arrow-alt"></i>Lister les paniers</a>
                        </li>

                        <li> <a href="{{ route('ambassadrice.orders') }}"><i class="bx bx-right-arrow-alt"></i>Commandes élèves</a>
                        <li>
                    
                         
                        </li>
                        
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class='bx bx-command' ></i>
                        </div>
                        <div class="menu-title">Partenaires</div>
                    </a>
                    <ul>

                        <li> <a href="{{ route('account.create_partenaire') }}"><i class="bx bx-right-arrow-alt"></i>Créer partenaire</a>
                        </li>

                        <li> <a href="{{ route('partenaire.dashboard') }}"><i class="bx bx-right-arrow-alt"></i> Suivi activité</a>
                        </li>
                        
                        <li> <a href="{{ route('partenaire.list') }}"><i class="bx bx-right-arrow-alt"></i>Liste des partenaires</a>
                        </li>
                        <!-- <li> <a href="{{ url('content-text-utilities') }}"><i class="bx bx-right-arrow-alt"></i>Commandes partenaires</a>
                        </li> -->
                    </ul>
                </li>


                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class='bx bx-command' ></i>
                        </div>
                        <div class="menu-title">Distributeurs</div>
                    </a>
                    <ul>

                        <!--<li> <a href="{{ route('distributeur.orders') }}"><i class="bx bx-right-arrow-alt"></i>Lister les commandes</a>
                        </li> -->

                        <!-- <li> <a href="{{ url('content-text-utilities') }}"><i class="bx bx-right-arrow-alt"></i>Commandes partenaires</a>
                        </li> -->
                    </ul>
                </li>



               
                <li class="menu-label">Facture et paiments</li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class='fadeIn animated bx bx-file' ></i>
                        </div>
                        <div class="menu-title">Factures</div>
                    </a>
                    <ul>
                        <li><a href="{{ route('ambassadrice.factures') }}"><i class="bx bx-right-arrow-alt"></i>Gestion des factures</a>
                        </li>

                        <li> <a href="{{ route('ambassadrice.getfactures') }}"><i class="bx bx-right-arrow-alt"></i>Regénération facture</a>
                        </li>
                        
                        <!-- <li> <a href="{{ route('ambassadrice.paimentnotif') }}"><i class="bx bx-right-arrow-alt"></i>Notifier des paiments</a>
                        </li> -->
                        
                        
                        
                        
                    </ul>
                </li>
                
                <li class="menu-label">Agenda</li>
                <li>
                    <a href="{{ route('gestion.calendar') }}">
                        <div class="parent-icon"><i class='bx bx-calendar'></i>
                        </div>
                        <div class="menu-title">Agenda des lives </div>
                    </a>
                    <!-- <ul>
                        <li> <a href="{{ route('gestion.calendar') }}"><i class="bx bx-right-arrow-alt"></i>Calendrier des lives</a>
                        </li>
                    
                    </ul> -->
                </li>

                
                <li class="menu-label">Agenda</li>
                <li>
                    <a href="{{ route('superadmin.faqAdmin') }}">
                        <div class="parent-icon"><i class='bx bx-calendar'></i>
                        </div>
                        <div class="menu-title">FAQ</div>
                    </a>
                    <!-- <ul>
                        <li> <a href="{{ route('gestion.calendar') }}"><i class="bx bx-right-arrow-alt"></i>Calendrier des lives</a>
                        </li>
                    
                    </ul> -->
                </li>



                <li>
                    <a href="{{ route('gestion.checkingCommandes') }}">
                        <div class="parent-icon">
                            <i class='fadeIn animated bx bx-list-check'></i>
                        </div>
                        <div class="menu-title">Cheking commandes</div>
                    </a>
                </li>
                
                
                
               
               
                
            </ul>
            <!--end navigation-->
        </div>