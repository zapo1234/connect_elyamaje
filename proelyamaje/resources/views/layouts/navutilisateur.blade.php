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
                
                 <!-- <li>
                    <a href="{{ route('utilisateurs.utilisateur') }}">
                        <div class="parent-icon"><i class='fadeIn animated bx bx-box'></i>
                        </div>
                        <div class="menu-title">Ajouter une commande</div>
                    </a>
                
                </li> -->

          

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='fadeIn animated bx bx-box'></i>
                        </div>
                        <div class="menu-title">Commandes</div>
                    </a>
                    <ul>
                        <li> <a href="{{ route('utilisateurs.utilisateur') }}"><i class="bx bx-right-arrow-alt"></i>Désactiver un code Élève</a>
                        
                        </li>
                        
                        
                        <li> <a href="{{ route('utilisateurs.verifypromo')  }}"><i class="bx bx-right-arrow-alt"></i>Suivi de code Élève</a>
                        
                        </li>
                        
                        <li> <a href="{{ route('utilisateurs.list') }}"><i class="bx bx-right-arrow-alt"></i>Commande enregistrée <br/> à la boutique</a>
                        
                        <li> <a href="{{ route('utilisateurs.codefidelite') }}"><i class="bx bx-right-arrow-alt"></i>Désactiver un code fidélité</a>
                        
                    </ul>
                </li>


                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fadeIn animated bx bx-store-alt"></i>
                        </div>
                        <div class="menu-title">Gérer des carte cadeaux</div>
                    </a>
                    <ul>
                        <li> <a href="{{ route('utilisateurs.cartecadeaux') }}"><i class="bx bx-right-arrow-alt"></i>Création de bons d'achat</a>
                        
                        </li>
                        
                        <li> <a href="{{ route('utilisateurs.cartecadeaux') }}"><i class="bx bx-right-arrow-alt"></i>Les cartes cadeaux</a>
                        
                        </li>

                        </ul>
                </li>
                

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-video-recording'></i>
                        </div>
                        <div class="menu-title">Lives</div>
                    </a>
                    <ul>
                        <li> <a href="{{ route('utilisateurs.codelive') }}"><i class="bx bx-right-arrow-alt"></i>Activer des lives</a>
                        
                        </li>
                        
                        
                        <li> <a href="{{ route('utilisateurs.historiquelive')  }}"><i class="bx bx-right-arrow-alt"></i>Historique des lives</a>
                        
                        </li>
                        
                        <li> <a href="{{ route('utilisateurs.paliercadeaux') }}"><i class="bx bx-right-arrow-alt"></i>Paliers live</a>
                        
                        <li>  <a href="{{ route('utilisateurs.calendar') }}"><i class="bx bx-right-arrow-alt"></i>Agendas des lives</a>

                        
                    </ul>
                </li>


                
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fadeIn animated bx bx-store-alt"></i>
                        </div>
                        <div class="menu-title">Codes élèves(crée)</div>
                    </a>
                    <ul>
                        <li> <a href="{{ route('utilisateurs.codecreateleve') }}"><i class="bx bx-right-arrow-alt"></i>Les codes Élèves</a>
                        
                        </li>
                        
                    </ul>
                </li>


                   <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fadeIn animated bx bx-store-alt"></i>
                        </div>
                        <div class="menu-title">Caisse</div>
                    </a>
                    <ul>
                        <li> <a href="{{ route('utilisateurs.cloturecaisse') }}"><i class="bx bx-right-arrow-alt"></i>Transférer un montant</a>
                        
                        </li>
                        
                        
                        <li> <a href="{{ route('utilisateurs.cloturelist')  }}"><i class="bx bx-right-arrow-alt"></i>Historique</a>
                        
                        </li>
                    
                        
                    </ul>
                </li>


                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bx bx-file"></i>
                        </div>
                        <div class="menu-title">Factures<br/>Ambassadrices & Partenaires</div>
                    </a>
                    <ul>
                        
                    <li> <a href="{{  route('ambassadrice.utilisateurfact')  }}"><i class="bx bx-right-arrow-alt"></i>Liste des factures</a>
                        </li>
                        
                        
                    </ul>

                </li>



                   <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bx bx-file"></i>
                        </div>
                        <div class="menu-title">Gestion des  Ambassadrices</div>
                    </a>
                    <ul>
                        
                        
                        </li>

                        <li> <a href="{{  route('utilisateurs.statsdatauser') }}"><i class="bx bx-right-arrow-alt"></i>Rapport de vente(commission)</a>
                        
                        </li>

                        <li> <a href="{{  route('utilisateurs.suivicode') }}"><i class="bx bx-right-arrow-alt"></i>Rapport code élève(transformation)</a>
                        
                        </li>

                        <li> <a href="{{  route('utilisateurs.ambassadricevente') }}"><i class="bx bx-right-arrow-alt"></i>Rapport de vente lives( historique mensuel)</a>
                        
                        </li>


                        <li> <a href="{{  route('utilisateurs.suivicodeamb') }}"><i class="bx bx-right-arrow-alt"></i>Rapport vente  élève(historique mensuel)</a>
                        
                        </li>
                        
                        
                        <!--<li> <a href="{{ route('utilisateurs.listdoublons') }}"><i class="bx bx-right-arrow-alt"></i>Doublons factures dolibar</a>
                        
                        </li><!-->
                    
                        
                    </ul>

                 </li>

                 <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bx bx-file"></i>
                        </div>
                        <div class="menu-title">Gestion des  Partenaire</div>
                    </a>
                    <ul>
                        
                      <li> <a href="{{  route('utilisateurs.suivicodepart') }}"><i class="bx bx-right-arrow-alt"></i>Rapport mensuel code lève(transformation)</a>
                        
                        </li>
                        
                        
                    </ul>

                   
                 </li>

                   @if(Auth()->user()->id == 91 OR Auth()->user()->id == 100)
                 <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fadeIn animated bx bx-store-alt"></i>
                        </div>
                        <div class="menu-title">Function dolibarr</div>
                    </a>
                    <ul>
                        <li> <a href="{{ route('api.dolibarrs') }}"><i class="bx bx-right-arrow-alt"></i>Accès</a>
                        
                        </li>
                        
                         </ul>
                </li>
                @endif




                <li>
                    <a href="{{ route('utilisateurs.faq') }}">
                        <div class="parent-icon"><i class="bx bx-help-circle"></i>
                        </div>
                        <div class="menu-title">FAQ</div>
                    </a>
                </li>


  
               
                
                
               
               
                
            </ul>
            <!--end navigation-->
        </div>