@extends("layouts.apps_ambassadrice")
		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
          <div class="breadcrumb-title pe-3">Codes promos</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 pe-3">
                        <li class="breadcrumb-item active" aria-current="page">Créez des codes nouveaux Élèves</li>
                    </ol>
                </nav>
            </div>
          <!-- <div class="ms-auto"  id="add_customer"><a class="btn btn-primary radius-5 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Ajouter une ligne code au formulaire</a></div> -->
          <div id="add_customer" class="responsive_button ms-auto d-flex justify-content-end">
						<a class="btn btn-primary radius-5 mt-2 mt-lg-0" >
							<i class="bx bxs-plus-square"></i><span class="responsive_button_text">Ajouter une ligne code au formulaire</span>
						</a>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="cards_mobile">
				    <h1 style="font-size:18px; font-weight: 500; margin-bottom:20px;">Créez des codes nouveaux Élèves</h1>
            @if (!empty($message))
              <div class="alert alert-danger" role="alert"  id="{{ $css }}" style="max-width:370px;text-align:center;margin-top:-10px;">
                <div style="color:black;font-size:15px;"> {{ $message }}</div>
                  <table style="margin-left:6%">
                    @foreach($emailc as $resultat)
                      <tr>
                        <td class="{{ $resultat  }}"> <i class="bx bx-x-circle"  style="color:red;font-size:20px;"></i> </td> <td class="{{ $resultat  }}" style="color:black;font-size:14px;">{{ $resultat }}</td>
                      </tr>
                    @endforeach
                  </table>
                  <div style="color: #000;font-size: 12px;margin:15px 0;">{{ $precision  }}</div>
              </div>  
            @endif
            @if (!empty($messages))
            <div class="alert alert-success" role="alert" style="max-width:370px;text-align:center;margin-top:-10px;">
              <div style="color:black;font-size:15px;">{{ $messages }} </div>
                  <table style="margin-left:6%">
                  @foreach($emailc2 as $resultats)
                    <tr>
                      <td>
                        <i class="bx bx-checkbox-checked"  style="color:green;font-size:20px"></i>
                      </td>
                      <td style="color:black;font-size:14px;"> {{ $resultats  }} </td>
                    <tr>
                  @endforeach
                </table>
                <div> 
                  <a class="collapse-item" href="{{ route('ambassadrice.list')  }}">
                      <span style="color:black; text-decoration:underline;">Cliquez ici(voir les codes élève)</span>
                  </a>
                </div>
              </div>
            </div>
            @endif
            @if (session('errors'))
              <div class="alert alert-danger" role="alert" id="alert_emails" style="width:300px;text-align:center;margin-top:5px;margin-left:2%;border:2px solid red">
                {{ session('errors') }}
              </div>
            @elseif(session('failed'))
              <!-- Ajout d'une alerte pour 'failed' -->
              <div class="alert alert-warning" role="alert" style="width:300px;text-align:center;margin-top:5px;margin-left:2%;border:2px solid orange">
                  {{ session('failed') }}
              </div>
            @endif

		 <form method="post" id="forms_ambassadrice_customer" style="width:100%;"  action="/createcustom">
         @csrf	
          <div class="" id="">
                    <!-- Card Body -->
                <div id="erross" style="color:red;font-family:arial;"></div>
                <div id="required_champ" style="color:red;font-family:arial"></div>
                <div id="required_champ1" style="color:red;font-family:arial"></div>
                <div id="required_champ2" style="color:red;font-family:arial"></div>
                <div id="erros_phones" style="color:red;font-family:arial;"></div>
                <div id="erros_emails" style="color:red;font-family:arial;"></div>
                <div id="erros_prenoms" style="color:red;font-family:arial;"></div>
                <div id="erros_adresses" style="color:red;font-family:arial;"></div>
          </div>
				   <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6" id="cards_mobile1">
            <div id="card_mobile1" class="card border-left-success shadow h-100"style="width:100%;height:50px;border-left:2px solid white;border-left: .25rem solid white!important;cursor:pointer; padding: 1em 0; margin-bottom: 10px !important;">
                       <div class="col mr-2">
                        <label style="margin-left:5%;">Élève 1</label><span id="der0"></span></span> <span class="info1"> <i class="bx bx-chevron-down" style="font-size:16px"></i></span><span class="info2" style="display:none"><i style='font-size:14px' class='fas'>&#xf077;</i></span>
             </div>
           </div>
        </div>
                <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6" id="cards_mobils1" style="display:none">
            <div id="card_mobile1" class="card border-left-success shadow h-100"style="width:100%;height:50px;border-left:2px solid white;border-left: .25rem solid white!important;cursor:pointer; margin-bottom: 10px !important; padding: 1em 0;">
                       <div class="col mr-2">
                        <label style="margin-left:5%;"><span class="der">Élève 1</span> <span id="der1"></span></span></label><span class="info2"><i class="bx  bx-chevron-up" style="font-size:16px"></i></span>
             </div>
           </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4 p-2" id="cards_mobile12" style="display:none;width: 100%; height: 320px; background-color: white; margin-bottom: 40px; border-top: 0.25rem solid black !important;">
            <div class="card_mobile2">
                 <div class="form-row">
                    <div class="form-group col-md-6" style="margin-top:10px;">
                   <label for="inputEmail4">Nom de l'élève *</label>
                    <input type="text"  class="form-control nom"  name="nom[]" id="nom1"  required placeholder="">
                   </div>
                   <div class="form-group col-md-6" style="margin-top:10px;">
                   <label for="inputPassword4">Prénom de l'élève *</label>
                   <input type="text" class="form-control prenom"  id="prenom1" name="prenom[]" required>
                  <div><span class class="error_userna"></span></div>        
                 </div>
                  <div class="form-group col-md-6"  style="margin-top:10px;">
                 <label for="inputEmail4">Adresse e-mail(identifiant)*</label>
                <input type="email" class="form-control email" id="email1" name="email[]" required>
                 <div><span class class="error_email"></span></div>   
                </div>
                 <div class="form-group col-md-6"  style="margin-top:10px;">
               <label for="inputPassword4">Numéro de téléphone</label>
                <input type="text" class="form-control phone"  id="phone1" name="phone[]" required placeholder="(optionnel)">
                   <div><span class class="error_phone"></span></div>        
                </div>
                 <div class="form-group col-md-6">
                <input type="hidden" class="form-control adresse" name="adresse[]" placeholder=" (optionnel)">
                    <div><span class class="error_adresse"></span></div>               
                </div>
                </div>
           </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6" id="cards_mobile3">
            <div id="card_mobile3" class="card border-left-success shadow h-100"style="width:100%;height:20px;border-left:2px solid white;border-left: .25rem solid white!important; padding: 1em 0; margin-bottom: 10px !important;" class="cards_mobile2">
                       <div class="col mr-2">
                        <label style="margin-left:5%">Élève 2 </label><span id="der2"></span> <span class="info2"><i class="bx bx-chevron-down" style="font-size:16px"></i></span>
             </div>
           </div>
        </div>
         <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6" id="cards_mobils13" style="display:none">
            <div id="card_mobile13" class="card border-left-success shadow h-100"style="width:100%;height:50px;border-left:2px solid white;border-left: .25rem solid white!important;cursor:pointer;margin-bottom: 10px !important; padding: 1em 0;">
                       <div class="col mr-2">
                        <label style="margin-left:5%">Élève 2</label> <span id="der3"></span><span class="info2"><i class="bx  bx-chevron-up" style="font-size:16px"></i></span>
             </div>
           </div>
        </div>
         <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4 p-2" id="cards_mobile23" style="display:none;width: 100%; height: 320px; background-color: white; margin-bottom: 40px; border-top: 0.25rem solid black !important;">
            <div class="card_mobile23" class="card border-left-success shadow h-100 py-2"style="width:100%;">
          <div class="form-row">
                    <div class="form-group col-md-6"  style="margin-top:10px;">
                   <label for="inputEmail4">Nom de l'élève *</label>
                    <input type="text"  class="form-control nom"  name="nom[]" id="nom2"  placeholder="">
                   </div>
                   <div class="form-group col-md-6"  style="margin-top:10px;">
                   <label for="inputPassword4">Prénom de l'élève *</label>
                   <input type="text" class="form-control prenom" id="account_userna" name="prenom[]">
                  <div><span class class="error_userna"></span></div>        
                 </div>
                  <div class="form-group col-md-6"  style="margin-top:10px;">
                 <label for="inputEmail4">Adresse e-mail (identifiant)*</label>
                <input type="email" class="form-control email" name="email[]">
                </div>
                 <div class="form-group col-md-6"  style="margin-top:10px;">
               <label for="inputPassword4">Numéro de téléphone</label>
                <input type="text" class="form-control phone"  name="phone[]" placeholder="(optionnel)">
                </div>
                 <div class="form-group col-md-6">
                <input type="hidden" class="form-control adresse" name="adresse[]" placeholder="(optionnel)">
                </div>
                </div>
          </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6" id="cards_mobils14" style="display:none">
            <div id="card_mobile14" class="card border-left-success shadow h-100"style="width:100%;height:20px;border-left:2px solid white;border-left: .25rem solid white!important;cursor:pointer; padding: 1em 0; margin-bottom: 10px !important;">
                       <div class="col mr-2">
                        <label style="margin-left:5%">Élève 3</label><span id="der4"></span><span class="info2"><i class="bx bx-chevron-up" style="font-size:16px"></i></span>
             </div>
           </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6" id="cards_mobile34">
            <div id="card_mobile34" class="card border-left-success shadow h-100"style="width:100%;height:50px;border-left:2px solid white;border-left: .25rem solid white!important;cursor:pointer; padding: 1em 0;margin-bottom:10px !important;" class="cards_mobile2">
                       <div class="col mr-2">
                        <label style="margin-left:5%">Élève 3</label><span id="der5"></span> <span class="info2"><i class="bx bx-chevron-down" style="font-size:16px"></i></span>
             </div>
           </div>
        </div>
         <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4 p-2" id="cards_mobile24" style="display:none;width: 100%; height: 320px; background-color: white; margin-bottom: 40px; border-top: 0.25rem solid black !important;">
            <div class="card_mobile24" class="card border-left-success shadow h-100 py-2"style="width:100%;">
          <div class="form-row">
                    <div class="form-group col-md-6"  style="margin-top:10px;">
                   <label for="inputEmail4">Nom de l'élève *</label>
                    <input type="text"  class="form-control nom"  name="nom[]" id="nom3"  placeholder="">
                   </div>
                   <div class="form-group col-md-6"  style="margin-top:10px;">
                   <label for="inputPassword4">Prénom de l'élève *</label>
                   <input type="text" class="form-control prenom" id="account_userna" name="prenom[]" required>
                  <div><span class class="error_userna"></span></div>        
                 </div>
                  <div class="form-group col-md-6"  style="margin-top:10px;">
                 <label for="inputEmail4">Adresse e-mail (identifiant)*</label>
                <input type="email" class="form-control email" name="email[]">
                </div>
                 <div class="form-group col-md-6"  style="margin-top:10px;">
               <label for="inputPassword4">Numéro de téléphone</label>
                <input type="text" class="form-control phone"  name="phone[]" placehoder=" (optionnel)">
                </div>
                 <div class="form-group col-md-6">
                <input type="hidden" class="form-control adresse" name="adresse[]" placeholder=" (optionnel)">
                </div>
                </div>
                 <div class="form-row">
                    <div class="form-group col-md-6" style="margin-top:20px;">
                      <input type="hidden"  class="form-control nom"  name="nom[]" id="nom3"  placeholder="">
                    </div>
                    <div class="form-group col-md-6" style="margin-top:20px;">
                      <input type="hidden" class="form-control prenom" id="account_userna" name="prenom[]">
                    <div>
                    <span class class="error_userna"></span>
                  </div>        
                 </div>
                  <div class="form-group col-md-6">
                <input type="hidden" class="form-control email" name="email[]">
                </div>
                 <div class="form-group col-md-6">
                <input type="hidden" class="form-control phone"  name="phone[]">
                </div>
                 <div class="form-group col-md-6">
                <input type="hidden" class="form-control adresse" name="adresse[]">
                </div>
                </div>
          </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6" id="cards_mobils91" style="display:none">
            <div id="card_mobile91" class="card border-left-success shadow h-100"style="width:100%;height:20px;border-left:2px solid white;border-left: .25rem solid white!important;cursor:pointer; padding: 1em 0; margin-bottom: 10px !important;">
                       <div class="col mr-2">
                        <label style="margin-left:5%">Élève 4 </label><span id="der4"></span><span class="info2"><i class="bx  bx-chevron-up" style="font-size:16px"></i></span>
             </div>
           </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6" id="cards_mobils18" style="">
            <div id="card_mobile18" class="card border-left-success shadow h-100"style="width:100%;height:50px;border-left:2px solid white;border-left: .25rem solid white!important;cursor:pointer;margin-bottom: 10px !important; padding: 1em 0;">
                       <div class="col mr-2">
                       <label style="margin-left:5%">Élève 4  </label><span id="der6"></span> <span class="info2"><i class="bx bx-chevron-down" style="font-size:16px"></i></span>
             </div>
           </div>
        </div>
       <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4 p-2" id="cards_mobile28" style="display:none;width: 100%; height: 320px; background-color: white; margin-bottom: 40px; border-top: 0.25rem solid black !important;">
            <div class="card_mobile28" class="card border-left-success shadow h-100 py-2"style="width:100%;">
          <div class="form-row">
                    <div class="form-group col-md-6"  style="margin-top:10px;">
                   <label for="inputEmail4">Nom de l'élève *</label>
                    <input type="text"  class="form-control nom"  name="nom[]" id="nom4"  placeholder="">
                   </div>
                   <div class="form-group col-md-6"  style="margin-top:10px;">
                   <label for="inputPassword4">Prénom de l'élève *</label>
                   <input type="text" class="form-control prenom" id="account_userna" name="prenom[]" required>
                  <div><span class class="error_userna"></span></div>        
                 </div>
                  <div class="form-group col-md-6"  style="margin-top:10px;">
                 <label for="inputEmail4">Adresse e-mail (identifiant)*</label>
                <input type="email" class="form-control email" name="email[]">
                </div>
                 <div class="form-group col-md-6"  style="margin-top:10px;">
               <label for="inputPassword4">Numéro de télephone</label>
                <input type="text" class="form-control phone"  name="phone[]">
                </div>
                 <div class="form-group col-md-6">
                <input type="hidden" class="form-control adresse" name="adresse[]" style="">
                </div>
                </div>
          </div>
        </div>
         <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6" id="cards_mobils35" style="display:none">
            <div id="card_mobile19" class="card border-left-success shadow h-100 "style="width:100%;height:20px;border-left:2px solid white;border-left: .25rem solid white!important;cursor:pointer; padding: 1em 0; margin-bottom: 10px !important;">
                       <div class="col mr-2">
                        <label style="margin-left:5%">Élève 5</label><span id="der4"></span><span class="info2"><i class="bx  bx-chevron-up" style="font-size:16px"></i></span>
             </div>
           </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6" id="cards_mobils33" style="">
            <div id="card_mobile38" class="card border-left-success shadow h-100 "style="width:100%;height:50px;border-left:2px solid white;border-left: .25rem solid white!important;cursor:pointer;    margin-bottom: 10px !important; padding: 1em 0;">
                       <div class="col mr-2">
                       <label style="margin-left:5%">Élève 5</label><span id="der6"></span> <span class="info2"><i class="bx bx-chevron-down" style="font-size:16px"></i></span>
             </div>
           </div>
        </div>
         <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4 p-2" id="cards_mobile38" style="display:none;width:100%;height:480px;background-color:white;border-top: .25rem solid black!important;">
            <div class="card_mobile28" class="card border-left-success shadow h-100 py-2"style="width:100%">
          <div class="form-row">
                    <div class="form-group col-md-6"  style="margin-top:10px;">
                   <label for="inputEmail4">Nom de l'élève *</label>
                    <input type="text"  class="form-control nom"  name="nom[]" id="nom5"  placeholder="">
                   </div>
                   <div class="form-group col-md-6"  style="margin-top:10px;">
                   <label for="inputPassword4">Prénom de l'élève *</label>
                   <input type="text" class="form-control prenom" id="account_userna" name="prenom[]" required>
                  <div><span class class="error_userna"></span></div>        
                 </div>
                  <div class="form-group col-md-6"  style="margin-top:10px;">
                 <label for="inputEmail4">Adresse e-mail (identifiant)*</label>
                <input type="email" class="form-control email" name="email[]">
                </div>
                 <div class="form-group col-md-6"  style="margin-top:10px;">
               <label for="inputPassword4">Numéro de télephone</label>
                <input type="text" class="form-control phone"  name="phone[]">
                </div>
                 <div class="form-group col-md-6">
                <input type="hidden" class="form-control adresse" name="adresse[]" style="">
                </div>
                </div>
          </div>
        </div>
         <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4" id="cards_mobile26" style="display:none;width: 100%; height: 320px; background-color: white; margin-bottom: 40px; border-top: 0.25rem solid black !important;">
            <div class="card_mobile24" class="card border-left-success shadow h-100 py-2"style="width:140%;height:20px;border-left:2px solid white;margin-left:-10%;;margin-top:-3px">
         </div>
        </div>
             <div class="row">
            <button type="button" id="creates_customer_amba" style="width:320px;border-radius:5px">Créer les codes Élèves</button>
          </div>
        </form> 
				</div><!--partie affichage mobile code promo-->
				<div class="card" id="account_body">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
							</div>
						</div>
						<h1 style="font-size:18px;">Formulaire de création de code nouveaux Élèves <br/><span style="font-size:15px;">NB: 10 codes maxi à créer simultanément </span></h1>
						 <div id="erros" style="color:red;font-family:arial;"></div>
                <div id="erros_phone" style="color:red;font-family:arial;"></div>
                <div id="erros_email" style="color:red;font-family:arial;"></div>
                <div id="erros_prenom" style="color:red;font-family:arial;"></div>
                <div id="erros_adresse" style="color:red;font-family:arial;"></div>
                <div class="cards_content" style="margin-top:50px;">
                    <form method="post" id="forms_ambassadrice_customers"  action="/createcustom">
                          @csrf
                   <table class="table_code_eleve w-100 d-flex justify-content-between" id="add">
                 <tr style="margin-top:4px">
                 <td><input type="text"  class="form-control nom"  name="nom[]" placeholder="Nom" required></td>
                 <td><input type="text" class="form-control prenom"  name="prenom[]" placeholder="Prénom" required></td>
               <td><input type="text" class="form-control email"  name="email[]" placeholder="Email-client"></td>
              <td><input type="text" class="form-control phone" name="phone[]" placeholder="Numéro de tel (optionnel)" required></td>
             <td><input type="text" class="form-control adresse"  name="adresse[]" placeholder="Adresse (optionnel)"></td>
              </tr>
            <tr style="margin-top:4px">
           <td><input type="hidden"  class="form-control "  name="nom[]" placeholder="Nom" required></td>
            <td><input type="hidden" class="form-control "  name="prenom[]" placeholder="Prénom" required></td>
           <td><input type="hidden" class="form-control "  name="email[]" placeholder="Email-client" ></td>
            <td><input type="hidden" class="form-control " name="phone[]" placeholder="Numéro de tel" required></td>
              <td><input type="hidden" class="form-control "  name="adresse[]" placeholder="adresse"></td>
            </tr>
      </table><!--ajouter des clients -->
          <div class="row">
            <button type="button" id="create_customer_amba" style="margin-top:15px;margin-left:1%">Enregistrer</button>
          </div>
	    </form>
			<div class="alert alert-" role="alert"  id="{{ $css }}" style="width:370px;text-align:center;margin-top:-30px;border:2px solid green;margin-top:20px;">
	    <div style="color:black;font-size:16px;"> {{ $message }}</div>
	    <table style="margin-left:6%;margin-top:20px" >
	    @foreach($emailc as $resultat)
	    <tr>
	       <td class="{{ $resultat}}"> <i class="bx bx-x-circle"  style="color:red;font-size:20px;"></i> </td> <td class="{{ $resultat  }}">{{ $resultat }}</td>
	    </tr>
	    @endforeach
	    </table>
	    <div style="color:#0000FF;font-size:14px;margin-bottom:5px;">{{ $precision  }}</div>
	      <div style="color:black;font-size:16px;"> {{ $messages }}</div>
	     <table style="margin-left:6%">
	      @foreach($emailc2 as $resultats)
	     <tr>
	         <td class="{{ $resultats }}"><i class="bx bx-checkbox-checked"  style="color:green;font-size:25px"></i></td><td> {{ $resultats  }} </td>
	    <tr>
	       @endforeach
	     </table>
	   <div style="color:black;font-size:16px;">{{ $messages3 }} <a class="collapse-item" href="{{ route('ambassadrice.list')  }}">voir liste de code élève</a></div>
	     <table style="margin-left:6%">
	      @foreach($array_emailc1 as $resultatss)
	     <tr>
	         <td class="{{ $resultats   }}"><i class="bx bx-checkbox-checked"  style="color:green;font-size:20px"></i></td><td> {{ $resultatss  }} </td>
	    <tr>
	       @endforeach
	     </table>
	    </div>
	     @if (session('error'))
         <div class="alert alert-" role="alert" id="alert_email" style="width:370px;text-align:center;margin-top:-30px;border:2px solid green">
	      {{ session('error') }}
          </div>
        @elseif(session('failed'))
                                 @endif
         @if (session('errors'))
         <div class="alert alert-danger" role="alert" id="alert_email" style="width:350px;text-align:center;margin-top:-30px;border:2px solid red">
	      {{ session('errors') }}
          </div>
        @elseif(session('failed'))
                                 @endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="pask" style="display:none;background-color:black;opacity:0.9;position:absolute;z-index:2;width:100%;height:100%;"></div>
<div id="pakss" style="display:none;background-color:white;opacity:0.9;position:absolute;z-index:2;width:100%;height:100%;"></div>
<div class="spiner" style="margin:0 auto;">
  <h4 style="font-weight:bold;color:black;margin-top:60px;">Création de code promo éléves en cours</h4>
  <div class="spiners" style="">
    <h5 style="font-weight:bold;color:black">Recherche en cours</h5>
    <div class="data" style="">
      <div class="spinner-grow text-primary" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-grow text-secondary" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-grow text-success" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-grow text-danger" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
</div> 
		<!--end page wrapper -->
		@endsection
