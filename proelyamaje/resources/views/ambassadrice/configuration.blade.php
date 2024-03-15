@extends("layouts.apps")



@section("style")

	<link href="{{asset('admin/assets/assets/plugins/highcharts/css/highcharts.css')}}" rel="stylesheet" />

	<link href="{{asset('admin/assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet" />

	



    <link href="  {{asset('admin/assets/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

	<link href="  {{asset('admin/assets/assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />

    
@endsection

		

		@section("wrapper")

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-sm-flex align-items-center">

          <div class="breadcrumb-title pe-3">Ambassadrices</div>
          <div class="ps-3">
              <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 pe-3">
                      <li class="breadcrumb-item active" aria-current="page">Configurer des palier</li>
                  </ol>
              </nav>
          </div>

					<div class="ms-auto">

						<div class="btn-group">

							

							

							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>

								<a class="dropdown-item" href="javascript:;">Another action</a>

								<a class="dropdown-item" href="javascript:;">Something else here</a>

								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>

							</div>

						</div>

					</div>

				</div>

				<!--end breadcrumb-->

				

				

				    

				</div><!--partie affichage mobile code promo-->

				

				

			  

				<div style="margin: 25px;" class="card " id="account_body">

					<div class="card-body">

						<div class="d-lg-flex align-items-center mb-4 gap-3">

							<div class="position-relative">

								

							

							</div>

						

						</div>

						

						<h1 style="font-size:18px;">Créer des paniers de cadeaux lives Limités<br/></h1>

						

						 <div id="erros" style="color:red;font-family:arial;"></div>

                <div id="erros_phone" style="color:red;font-family:arial;"></div>

                <div id="erros_email" style="color:red;font-family:arial;"></div>

                <div id="erros_prenom" style="color:red;font-family:arial;"></div>

                <div id="erros_adresse" style="color:red;font-family:arial;"></div>

                

                <div class="cards_content" style="margin-top:50px;">

                   

                    <form method="post" id="forms_panier"  action="/ambassadrice/postconfig/pannier">

                    

                          @csrf

                       

   

                   <table id="adds">

                <th>Palier</th>

                <th>Montant mini</th>

                <th>Montant max</th>

                <th>Choix des produits</th>

                 <tr style="margin-top:4px;height:70px">

                 <td><input type="text"  class="form-control nom"  name="panier1"  required placeholder="Libéllé"></td>

                 <td><input type="text" class="form-control prenom"  name="montant_mini1"  required></td>

               <td><input type="text" class="form-control email"  name="montant_max1"></td>

              <td><select class="multiple-select" data-placeholder="Choose anything" multiple="multiple" name="data1[]" style="width:600px">

                                 @foreach($list as $vals)

                                 

                                 <option value="{{$vals['ids_product']}}%%%dar,{{ $vals['id_variations'] }}v@@@,{{ $vals['libelle'] }}">{{ $vals['libelle'] }}</option>

                                 

                                 

                                 @endforeach

                                </select></td>

                

                

                

                

                <td><select class="multiple-select" data-placeholder="Choose anything" multiple="multiple" name="datas12[]" style="width:200px"> 

                 

                  @foreach($lists as $val)

                                 

                                 <option value="{{$val['rowid']}},{{ $val['label'] }}">{{ $val['label'] }}</option>

                                 

                                 

                                 @endforeach

                                </select></td>

                 

                 

                 

                 

                 </select></td>    

                

                

                

                

                </tr>

                                

               

               

               

                <tr style="margin-top:10px;height:70px">

                 <td><input type="text"  class="form-control nom"  name="panier2" placeholder ="Libéllé"></td>

                 <td><input type="text" class="form-control prenom"  name="montant_mini2"></td>

               <td><input type="text" class="form-control email"  name="montant_max2"></td>

              <td><select class="multiple-select" data-placeholder="Choose anything" multiple="multiple" name="data2[]" style="width:600px">

                                 @foreach($list as $vals)

                                 

                                 <option value="{{$vals['ids_product']}}%%%dar,{{ $vals['id_variations'] }}v@@@,{{ $vals['libelle'] }}">{{ $vals['libelle'] }}</option>

                                 

                                 

                                 @endforeach

                                </select></td>

                                

                                

                      <td><select class="multiple-select" data-placeholder="Choose anything" multiple="multiple" name="data23[]" style="width:200px">  

                       @foreach($lists as $val)

                          <option value="{{$val['rowid']}},{{ $val['label'] }}">{{ $val['label'] }}</option>

                        @endforeach

                                </select></td>

                      </select></td>              

                     </tr>
                    </tr>
                 </table><!--ajouter des clients -->

      

      

          

          <div class="row">

            <button type="submit" id="create_customer_ambas" style="margin-top:15px;margin-left:1%;background-color:black;color:white;width:150px">Enregistrer</button>

          </div>

	

	    </form>

						

						

		

	    

	   

	   

	   

	   

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

<div class="spiner" style="margin-left:5%;margin-top:20px"><h4 style="font-weight:bold;color:black;margin-top:60px;">Vos confuguration en cours</h4>

<div class="spiners" style=""><h4 style="font-weight:bold;color:black">Recherche en cours</h4>

<div class="data" style="margin-left:30%;">

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



		

		<!--end page wrapper -->

		@endsection

		

		

	@section("script")

	

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="{{asset('admin/assets/assets/plugins/select2/js/select2.min.js')}}"></script>

  

	<script type="text/javascript">

    $(document).ready(function() {

        $('select').selectpicker();

    });

    $('.single-select').select2({

			theme: 'bootstrap4',

			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',

			placeholder: $(this).data('placeholder'),

			allowClear: Boolean($(this).data('allow-clear')),

		});

		$('.multiple-select').select2({

			theme: 'bootstrap4',

			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',

			placeholder: $(this).data('placeholder'),

			allowClear: Boolean($(this).data('allow-clear')),

		});

    
</script>



	

	@endsection

	