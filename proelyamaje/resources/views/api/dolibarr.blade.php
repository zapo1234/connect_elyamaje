
@extends("layouts.apps")

@section("style")

	<link href="{{ asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
  <style>
.der,#ders,.derr{float:left;} .der{margin-left:3%}
#search_date,#search_dats{height:50px;border-radius:5px;border-color:1px solid #eee;}

 </style>

	@endsection	

		@section("wrapper")

		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
                <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Fonctions</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 pe-3">
                                <li class="breadcrumb-item active" aria-current="page">Dolibarr</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            
				<!--end breadcrumb-->
                @if($messages)
                    <div style="position:relative" class="mb-1 mt-2 w-100 d-flex justify-content-center">
                        <div style="position:absolute; bottom:-1px" class="alert alert-info border-0 bg-info alert-dismissible fade show">
                            <div class="text-dark">{{ $messages }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
               

				<div class="card card_table_mobile_responsive no_dataTable_bordered">

					<div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table_mobile_responsive table table-striped table-bordered">

                                <thead>
                                    <tr>
                                        <th class="col-md-4" scope="col">Nom</th>
                                        <th scope="col">Dernière exécution</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Origine</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg_black">
                                        <th colspan="5">Produits</th>
                                    </tr>
                                    <tr id="update_categories_dolibarr">
                                        <td data-label="Nom">Mise à jour des catégories et produits</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['update_categories_dolibarr']) ? $cron['update_categories_dolibarr']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['update_categories_dolibarr']))
                                                    @if($cron['update_categories_dolibarr']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['update_categories_dolibarr']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['update_categories_dolibarr']))
                                                        @if($cron['update_categories_dolibarr']['from_cron'] == "0")
                                                            <span class="manually">Manuellement</span>
                                                        @else 
                                                            <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        <td class="col-md-1">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('data.categorie_all_dol') }}">Exécuter</button>
                                        </td>
                                    </tr>
                                    <tr class="bg_black">
                                        <th colspan="5">Clients</th>
                                    </tr>
                                    <tr id="update_dashboard_dolibarr">
                                        <td data-label="Nom">Mise à jour tableau de bord</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['update_dashboard_dolibarr']) ? $cron['update_dashboard_dolibarr']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['update_dashboard_dolibarr']))
                                                    @if($cron['update_dashboard_dolibarr']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['update_dashboard_dolibarr']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['update_dashboard_dolibarr']))
                                                        @if($cron['update_dashboard_dolibarr']['from_cron'] == "0")
                                                             <span class="manually">Manuellement</span>
                                                        @else 
                                                            <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                             </td>
                                        <td class="col-md-1">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('api.newtiers') }}">Exécuter</button>
                                        </td>
                                    </tr>
                                    <tr class="bg_black">
                                        <th colspan="5">Commandes</th>
                                    </tr>
                                    <tr id="detect_double_dolibarr">
                                        <td data-label="Nom">Mise a jours des categoris/products</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['detect_double_dolibarr']) ? $cron['detect_double_dolibarr']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['detect_double_dolibarr']))
                                                    @if($cron['detect_double_dolibarr']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['detect_double_dolibarr']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['detect_double_dolibarr']))
                                                        @if($cron['detect_double_dolibarr']['from_cron'] == "0")
                                                             <span class="manually">Manuellement</span>
                                                        @else 
                                                            <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        <td class="col-md-1">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('api.doublonsfact') }}">Exécuter</button>
                                        </td>
                                    </tr>


                                    <tr class="bg_black">
                                        <th colspan="5">Import chiffre d'affaire</th>
                                    </tr>
                                    <tr id="import_chiffre">
                                        <td data-label="Nom">Import des recettes journalières</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['import_chiffre']) ? $cron['import_chiffre']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['import_chiffre']))
                                                    @if($cron['import_chiffre']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['import_chiffre']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['import_chiffre']))
                                                        @if($cron['import_chiffre']['from_cron'] == "0")
                                                             <span class="manually">Manuellement</span>
                                                        @else 
                                                            <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        <td class="col-md-1">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('api.chiffre') }}">Exécuter</button>
                                        </td>
                                    </tr>

                                    



                                    <tr class="bg_black">
                                        <th colspan="5">Imports des catégories et produits</th>
                                    </tr>
                                    <tr id="export_csv_1">
                                        <td data-label="Nom">

                                            <select class="form-select" name="id_categoris" id="id_categoris" aria-label="Default select example" style="height:40px;">
                                                <option value="none" selected>Choisir la catégorie</option>
                                                @foreach($data as $resultat)
                                                    <option value="{{ $resultat['rowid'] }},{{ $resultat['label']}}">{{ $resultat['label'] }}</option>
                                                @endforeach
                                            </select>
                                             <input type="hidden" id="cat_id">
                                             <input type="hidden" id="fich_name">
                                        </td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['update_stocks_dolibarr']) ? $cron['update_stocks_dolibarr']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['update_stocks_dolibarr']))
                                                    @if($cron['update_stocks_dolibarr']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['update_stocks_dolibarr']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                        <td class="origin" data-label="Origine">
                                            @if($cron)
                                                @if(isset($cron['update_stocks_dolibarr']))
                                                    @if($cron['update_stocks_dolibarr']['from_cron'] == "0")
                                                         <span class="manually">Manuellement</span>
                                                    @else 
                                                        <span class="cron">Tâche Cron</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                              
                                        <td class="col-md-1">
                                            <button title="Génère un csv" id="export_csv_1" type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('data.exportstocks') }}">Générer</button>
                                        </td>
                                    </tr>
                                    <tr class="bg_black">
                                        <th colspan="5">Stocks de produit par Entrepot</th>
                                    </tr>
                                    <tr id="export_csv_2">
                                        <td data-label="Nom">
                                            <select class="form-select" name="id_categoris" id="id_categoriss" aria-label="Default select example" style="height:40px;">
                                                <option value="none" selected>Choisir la catégorie</option>
                                                @foreach($data as $resultat)
                                                    <option value="{{ $resultat['rowid'] }}">{{ $resultat['label'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['update_stocks_warehouse_dolibarr']) ? $cron['update_stocks_warehouse_dolibarr']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['update_stocks_warehouse_dolibarr']))
                                                    @if($cron['update_stocks_warehouse_dolibarr']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['update_stocks_warehouse_dolibarr']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                        <td class="origin" data-label="Origine">
                                            @if($cron)
                                                @if(isset($cron['update_stocks_warehouse_dolibarr']))
                                                    @if($cron['update_stocks_warehouse_dolibarr']['from_cron'] == "0")
                                                         <span class="manually">Manuellement</span>
                                                    @else 
                                                        <span class="cron">Tâche Cron</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                              
                                        <td class="col-md-1">
                                            <button title="Génère un csv" type="button" id="export_csv_2" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('data_dolibarcsv') }}">Générer</button>
                                        </td>
                                    </tr>
                                    <tr class="bg_black">
                                        <th colspan="5">Importer votre fichier de mise à jour de stocks vers dolibar</th>
                                    </tr>
                                    <tr id="import_stock_with_file_dolibarr">
                                        <form method="post" id="imports_stocks" action="{{ route('misejoursstocks') }}" enctype="multipart/form-data">
                                            @csrf
                                            <td style="border-left:none" data-label="Nom">
                                                <input type="file" id="file" name="file" hidden required>
                                                <label class="upload_stock_to_dolibarr" for="file">Choisir un fichier</label>
                                                <span id="file-chosen">Aucun fichier choisi</span>

                                            </td>
                                            <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['import_stock_with_file_dolibarr']) ? $cron['import_stock_with_file_dolibarr']['updated_at'] : ''}}</td>
                                            
                                            <td class="status" data-label="Status">  
                                                @if($cron)
                                                    @if(isset($cron['import_stock_with_file_dolibarr']))
                                                        @if($cron['import_stock_with_file_dolibarr']['error'] == "0")
                                                            <span class="badge bg-success">Success</span>
                                                        @else 
                                                            <span class="badge bg-danger">{{ $cron['import_stock_with_file_dolibarr']['message'] }}</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['import_stock_with_file_dolibarr']))
                                                        @if($cron['import_stock_with_file_dolibarr']['from_cron'] == "0")
                                                             <span class="manually">Manuellement</span>
                                                        @else 
                                                            <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="col-md-1">
                                                <button type="submit" class="p-1 px-1 btn btn-primary">Importer</button>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr class="bg_black">
                                        <th colspan="5">Categorisation des produits dolibarr !</th>
                                    </tr>
                                    <tr id="synchto_product_and_categories">
                                            <form method="post" action="{{ route('data.synchro') }}">
                                            @csrf
                                            <td style="border-left:none" data-label="Nom">
                                                <select   class="form-select" name="ids" style="height:40px">  
                                                    @foreach($list_product as $val)
                                                        <option value="{{$val['id_product']}}">{{ $val['libelle'] }}</option>
                                                    @endforeach  
                                                </select>
                                            </td>
                                            <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['synchto_product_and_categories']) ? $cron['synchto_product_and_categories']['updated_at'] : ''}}</td>
                                            
                                            <td class="status" data-label="Status">  
                                                @if($cron)
                                                    @if(isset($cron['synchto_product_and_categories']))
                                                        @if($cron['synchto_product_and_categories']['error'] == "0")
                                                            <span class="badge bg-success">Success</span>
                                                        @else 
                                                            <span class="badge bg-danger">{{ $cron['synchto_product_and_categories']['message'] }}</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['synchto_product_and_categories']))
                                                        @if($cron['synchto_product_and_categories']['from_cron'] == "0")
                                                             <span class="manually">Manuellement</span>
                                                        @else 
                                                            <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="col-md-1">
                                                <button type="submit" class="p-1 px-1 btn btn-primary">Synchroniser</button>
                                            </td>
                                        </form>
                                    </tr>

                                   
                                    




                                </tbody>
                            </table>
                            
                           
                           <h1 style="border-bottom: 1px solid black !important;border-top: 1px solid black !important;font-size: 16px !important;height:50px;font-weight:bold;margin-top:10px;">Import de cummul de ventes(périodique)</h1>
                           <form method="post" id="form_stats" action="/data/ventes">
                           @csrf
                           <select id="ders" class="form-select" name="id_cate" id="id_categ" aria-label="Default select example" style="height:40px;width:250px;">
                                 <option value="none" selected>Choisir la catégorie</option>
                                   @foreach($data as $resultat)
                                    <option value="{{ $resultat['rowid'] }}">{{ $resultat['label'] }}</option>
                                     @endforeach
                                     </select>
                                     
								  <span class="der"><select id="date_from" name="search_dates" class="form-select" aria-label="Default select example" style="width:200px;float:left;" required>
                                 <option selected>Date start(mois)</option>
                                  <option value="1">Janvier</option>
                                  <option value="2">Février</option>
                                  <option value="3">Mars</option>
                                  <option value="4">Avril</option>
                                  <option value="5">Mai</option>
                                  <option value="6">Juin</option>
                                  <option value="7">Juillet</option>
                                  <option value="8">Aout</option>
                                   <option value="9">Septembre</option>
                                  <option value="10">Octobre</option>
                                  <option value="11">Novembre</option>
                                  <option value="12">Décembre</option>
                                   </select>

                                     <select id="date_year" name="date_year" class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:2%" required>
                                     <option selected>Choisir l'année</option>
                                     <option value="2022">2022</option>
                                     <option value="2023">2023</option>
                                     </select>
						
							        <select id="date_from" name="search_date" class="form-select" aria-label="Default select example" style="width:200px;float:left;" required>
                                  <option selected>Date end(mois)</option>
                                  <option value="1">Janvier</option>
                                  <option value="2">Février</option>
                                  <option value="3">Mars</option>
                                  <option value="4">Avril</option>
                                  <option value="5">Mai</option>
                                  <option value="6">Juin</option>
                                  <option value="7">Juillet</option>
                                  <option value="8">Aout</option>
                                   <option value="9">Septembre</option>
                                   <option value="10">Octobre</option>
                                   <option value="11">Novembre</option>
                                    <option value="12">Décembre</option>
                                     </select>

                                     <select id="date_years" name="date_years" class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:2%" required>
                                     <option selected>Choisir l'année</option>
                                     <option value="2022">2022</option>
                                     <option value="2023">2023</option>
                                     <option value="2024">2024</option>
                                     <option value="2025">2025</option>
                                     <option value="2026">2026</option>
                       
                                   </select>
						
                                <button type="submit" class="p-1 px-1 btn btn-primary" style="margin-left:30%">Générer un csv</button>
                                </span>
                                     
                            </form>
                          </div>

                          <h2 style="border-bottom: 1px solid black !important;border-top: 1px solid black !important;font-size: 16px !important;height:50px;font-weight:bold;margin-top:10px;">Imports des ventes (Internet,Boutique,Nice)</h2>
                           <form method="post" id="form_stats" action="/data/ventes">
                           @csrf
                           <select id="ders" class="form-select" name="id_cate" id="id_categ" aria-label="Default select example" style="height:40px;width:250px;">
                                 <option value="none" selected>Choisir la catégorie</option>
                                   @foreach($data as $resultat)
                                    <option value="{{ $resultat['rowid'] }}">{{ $resultat['label'] }}</option>
                                     @endforeach
                                     </select>
                                     
                                     <select id="ders" class="form-select" name="poste" id="poste" aria-label="Default select example" style="height:40px;width:250px;">
                                    <option value="none" selected>Choisir</option>
                                    <option value="1">Internet</option>
                                    <option value="2">Marseille</option>
                                    <option value="3">Nice</option>
                                    </select>
                                     

								<span class="der"><select id="date_from" name="search_dates" class="form-select" aria-label="Default select example" style="width:200px;float:left;" required>
                                 <option selected>Date start(mois)</option>
                                  <option value="1">Janvier</option>
                                  <option value="2">Février</option>
                                  <option value="3">Mars</option>
                                  <option value="4">Avril</option>
                                  <option value="5">Mai</option>
                                  <option value="6">Juin</option>
                                  <option value="7">Juillet</option>
                                  <option value="8">Aout</option>
                                   <option value="9">Septembre</option>
                                  <option value="10">Octobre</option>
                                  <option value="11">Novembre</option>
                                  <option value="12">Décembre</option>
                                   </select>

                                     <select id="date_year" name="date_year" class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:2%" required>
                                     <option selected>Année</option>
                                     <option value="2022">2022</option>
                                     <option value="2023">2023</option>
                                     </select>
						
							        <select id="date_from" name="search_date" class="form-select" aria-label="Default select example" style="width:200px;float:left;" required>
                                    <option selected>Date end(mois)</option>
                                    <option value="1">Janvier</option>
                                    <option value="2">Février</option>
                                    <option value="3">Mars</option>
                                    <option value="4">Avril</option>
                                    <option value="5">Mai</option>
                                    <option value="6">Juin</option>
                                    <option value="7">Juillet</option>
                                    <option value="8">Aout</option>
                                   <option value="9">Septembre</option>
                                    <option value="10">Octobre</option>
                                    <option value="11">Novembre</option>
                                    <option value="12">Décembre</option>
                                     </select>

                                     <select id="date_years" name="date_years" class="form-select" aria-label="Default select example" style="width:200px;float:left;margin-left:2%" required>
                                     <option selected>Année</option>
                                     <option value="2022">2022</option>
                                     <option value="2023">2023</option>
                                     <option value="2024">2024</option>
                                     <option value="2025">2025</option>
                                     <option value="2026">2026</option>
                       
                                   </select>
						
                                <button  type="submit" class="p-1 px-1 btn btn-primary" id="derr" style="margin-left:-6%" >Générer un csv</button>
                                </span>
                                     
                            </form>
                          </div>

				        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>


        <!-- MODAL VALIDATION --->
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post" id="task_form" action="">
                            @csrf
                        <h2 class="text-center">Exécuter la commande ?</h2>
                            <div id="error_code"></div>
                        </div>
                        <div class="p-2 d-flex justify-content-center">
                           
                            <button type="button"  data-bs-dismiss="modal" class="button_form annuler" style="width:100px;background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;">Annuler</button>
                            <button type="button" class="button_form validate" style="width:100px;margin-left:10px;border-radius:15px;font-weight:bold">Oui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL VALIDATION -->

  
    @section("script")

    <script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>

    <script>
        // $( document ).ready(function() {

        //     $('#example').DataTable();
        // })

        



        var d = new Date();
        var date = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
        var hours = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
        var fullDate = date;


        $('#id_categoris').on('change', function (){
           
        
            var chaine = $('#id_categoris').val();
            var result = chaine.split(',');
            $('#cat_id').val(result[0])
            $('#fich_name').val(result[1]+'_'+fullDate+'.csv');
        
        });

        const actualBtn = document.getElementById('file');

        const fileChosen = document.getElementById('file-chosen');

        actualBtn.addEventListener('change', function(){
            fileChosen.textContent = this.files[0].name
        })
        
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            hour12: false,
            timeZone: 'Europe/Paris'
        };

        $(".validate").on('click', function(){
            var token = $('input[name="_token"]').val();
            var url = $("#task_form").attr("action")+"?from_cron=false"
            var id_categoris = false
            var fich_name = false

            $(".spinner-border").removeClass("d-none")
            $(".button_form").addClass("d-none")

            if($(this).attr('id') == "export_csv_1"){

                var id_categoris = $("#cat_id").val()
                var fich_name = $("#fich_name").val()
                var export_csv = "export_csv_1"
            } else if($(this).attr('id') == "export_csv_2"){
                var id_categoris = $("#id_categoriss").val()
                var export_csv = "export_csv_2"
            }

            if(id_categoris == "none"){
                alert('Veuillez chosir une catégorie')
                $(".spinner-border").addClass("d-none")
                $(".button_form").removeClass("d-none")
                $("#exampleModal").modal('hide')
                return
            }

            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {id_categoris: id_categoris, fich_name:fich_name},
                success: function(response) {
                    $("#exampleModal").modal('hide')
                    $(".spinner-border").addClass("d-none")
                    $(".button_form").removeClass("d-none")

                    if(id_categoris){

                        const date_new = new Date();
                        const dateEnFrancais = date_new.toLocaleString('fr-FR', options);
                        var name = export_csv
                        
                        // Remove existing content
                        $("#"+name+" .last_execution").text("")
                        $("#"+name+"  .status").children().remove()
                        $("#"+name+" .origin").text("")

                        try{
                            var blob = new Blob([response]);
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);

                            if(name == "export_csv_1"){
                                link.download = fich_name
                            } else {
                                link.download = "stocks.csv"
                            }
                            link.click();

                            // Add content
                            $("#"+name+" .last_execution").append(dateEnFrancais)
                            $("#"+name+" .status").append('<span class="badge bg-success">Success</span>')
                            $("#"+name+" .origin").append("<span class='manually'>Manuellement</span>")

                        } catch (error) {
                            // Add content
                            $("#"+name+" .last_execution").append(dateEnFrancais)
                            $("#"+name+" .status").append('<span class="badge bg-danger">'+error+'</span>')
                            $("#"+name+" .origin").append("<span class='manually'>Manuellement</span>")
                        }

                    } else {
                        var response = JSON.parse(response)
                        var name = response.cron.name
                        var updated_at = response.cron.updated_at
                        var error = response.cron.error
                        var message = response.cron.message
                        var origin = response.cron.origin

                        const date_new = new Date(updated_at);
                        const dateEnFrancais = date_new.toLocaleString('fr-FR', options);

                        if(response.message == "Created successfully"){
                        
                            // Remove existing content
                            $("#"+name+" .last_execution").text("")
                            $("#"+name+"  .status").children().remove()
                            $("#"+name+" .origin").text("")
                            
                            // Add content
                            $("#"+name+" .last_execution").append(dateEnFrancais)
                            $("#"+name+" .status").append(error == 0 ? '<span class="badge bg-success">Success</span>' : '<span class="badge bg-danger">'+message+'</span>')
                            $("#"+name+" .origin").append("<span class='manually'>Manuellement</span>")
                            
        
                        }
                    } 
                },
                error: function(xhr, status, error) {
                    $(".spinner-border").addClass("d-none")
                    $(".button_form").removeClass("d-none")
                    $("#exampleModal").modal('hide')
                    alert(error);
                }


            });
        })

        $(".task_execution").on('click', function(){
            if(typeof $(this).attr('id') != "undefined"){
                $(".button_form ").attr('id', $(this).attr('id'))
            } else {
                $(".button_form ").attr('id', 'validate_form')
            }
            
            $("#task_form").attr('action', $(this).attr('data-url'))
            $("#exampleModal").modal('show')
        })
        
    </script>
    @endsection

@endsection






	