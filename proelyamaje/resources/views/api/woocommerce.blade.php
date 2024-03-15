
@extends("layouts.apps")




	@section("style")

    <link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />


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
                                <li class="breadcrumb-item active" aria-current="page">Woocommerce</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            
				<!--end breadcrumb-->

				<div class="card card_table_mobile_responsive no_dataTable_bordered">
					<div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table_mobile_responsive table table-striped table-bordered">

                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
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
                                    <tr id="update_product_woocommerce">
                                        <td data-label="Nom">Mise à jour des produits</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['update_product_woocommerce']) ? $cron['update_product_woocommerce']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['update_product_woocommerce']))
                                                    @if($cron['update_product_woocommerce']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['update_product_woocommerce']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                        <td class="origin" data-label="Origine">
                                            @if($cron)
                                                @if(isset($cron['update_product_woocommerce']))
                                                    @if($cron['update_product_woocommerce']['from_cron'] == "0")
                                                        <span class="manually">Manuellement</span>
                                                    @else 
                                                        <span class="cron">Tâche Cron</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                        <td class="col-md-1" data-label="">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('data.product_all') }}">Exécuter</button>
                                        </td>
                                    </tr>
                                    <tr id="update_categories_woocommerce">
                                        <td data-label="Nom">Mise à jour des catégories</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['update_categories_woocommerce']) ? $cron['update_categories_woocommerce']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['update_categories_woocommerce']))
                                                    @if($cron['update_categories_woocommerce']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['update_categories_woocommerce']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['update_categories_woocommerce']))
                                                        @if($cron['update_categories_woocommerce']['from_cron'] == "0")
                                                            <span class="manually">Manuellement</span>
                                                        @else 
                                                           <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        <td class="col-md-1" data-label="">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('data.categories_all') }}">Exécuter</button>
                                        </td>
                                    </tr>
                                    <tr class="bg_black">
                                         <th colspan="5">Ambassadrices</th>

                                    </tr>
                                    <tr id="import_order_ambassadrice_woocommerce">
                                        <td data-label="Nom">Import des commandes ambassadrices</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['import_order_ambassadrice_woocommerce']) ? $cron['import_order_ambassadrice_woocommerce']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['import_order_ambassadrice_woocommerce']))
                                                    @if($cron['import_order_ambassadrice_woocommerce']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['import_order_ambassadrice_woocommerce']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['import_order_ambassadrice_woocommerce']))
                                                        @if($cron['import_order_ambassadrice_woocommerce']['from_cron'] == "0")
                                                            <span class="manually">Manuellement</span>
                                                        @else 
                                                           <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        <td class="col-md-1" data-label="">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('api.code_promos') }}">Exécuter</button>
                                        </td>
                                    </tr>
                                    <tr id="import_code_promo_woocommerce">
                                        <td data-label="Nom">Import des codes promos</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['import_code_promo_woocommerce']) ? $cron['import_code_promo_woocommerce']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['import_code_promo_woocommerce']))
                                                    @if($cron['import_code_promo_woocommerce']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['import_code_promo_woocommerce']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['import_code_promo_woocommerce']))
                                                        @if($cron['import_code_promo_woocommerce']['from_cron'] == "0")
                                                            <span class="manually">Manuellement</span>
                                                        @else 
                                                           <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        <td data-label="">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('datas.coupon') }}">Exécuter</button>
                                        </td>
                                    </tr>
                                    <tr id="import_cards_woocommerce">
                                        <td data-label="Nom">Mise à jour des cartes cadeaux</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['import_cards_woocommerce']) ? $cron['import_cards_woocommerce']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['import_cards_woocommerce']))
                                                    @if($cron['import_cards_woocommerce']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['import_cards_woocommerce']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['import_cards_woocommerce']))
                                                        @if($cron['import_cards_woocommerce']['from_cron'] == "0")
                                                            <span class="manually">Manuellement</span>
                                                        @else 
                                                           <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        <td data-label="">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('data.gift_card') }}">Exécuter</button>
                                        </td>
                                    </tr>
                                    <tr id="import_promo_proucts_woocommerce">
                                        <td data-label="Nom">Import de produits en promotions</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['import_promo_proucts_woocommerce']) ? $cron['import_promo_proucts_woocommerce']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['import_promo_proucts_woocommerce']))
                                                    @if($cron['import_promo_proucts_woocommerce']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['import_promo_proucts_woocommerce']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['import_promo_proucts_woocommerce']))
                                                        @if($cron['import_promo_proucts_woocommerce']['from_cron'] == "0")
                                                            <span class="manually">Manuellement</span>
                                                        @else 
                                                           <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        <td data-label="">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('data.product_jour') }}">Exécuter</button>
                                        </td>
                                    </tr>
                                    <tr class="bg_black">
                                         <th colspan="5">Distributeurs</th>

                                    </tr>
                                    <tr id="import_order_distributeur_woocommerce">
                                        <td data-label="Nom">Import des commandes distributeurs</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['import_order_distributeur_woocommerce']) ? $cron['import_order_distributeur_woocommerce']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['import_order_distributeur_woocommerce']))
                                                    @if($cron['import_order_distributeur_woocommerce']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['import_order_distributeur_woocommerce']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['import_order_distributeur_woocommerce']))
                                                        @if($cron['import_order_distributeur_woocommerce']['from_cron'] == "0")
                                                            <span class="manually">Manuellement</span>
                                                        @else 
                                                           <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        <td data-label="">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('datas.distributed') }}">Exécuter</button>
                                        </td>
                                    </tr>
                                    <tr class="bg_black">
                                         <th colspan="5">Divers</th>

                                    </tr>
                                    <tr id="notification_paiement_woocommerce">
                                        <td data-label="Nom">Notifier des paiements</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['notification_paiement_woocommerce']) ? $cron['notification_paiement_woocommerce']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['notification_paiement_woocommerce']))
                                                    @if($cron['notification_paiement_woocommerce']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['notification_paiement_woocommerce']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['notification_paiement_woocommerce']))
                                                        @if($cron['notification_paiement_woocommerce']['from_cron'] == "0")
                                                            <span class="manually">Manuellement</span>
                                                        @else 
                                                           <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        <td data-label="">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('post_ambassadrice.paimentnotif') }}">Exécuter</button>
                                        </td>
                                    </tr>
                                    <tr id="import_order_boutique_woocommerce">
                                        <td data-label="Nom">Changement statut commandes boutique</td>
                                        <td class="last_execution" data-label="Dernière exécution">{{ isset($cron['import_order_boutique_woocommerce']) ? $cron['import_order_boutique_woocommerce']['updated_at'] : ''}}</td>
                                        <td class="status" data-label="Status">  
                                            @if($cron)
                                                @if(isset($cron['import_order_boutique_woocommerce']))
                                                    @if($cron['import_order_boutique_woocommerce']['error'] == "0")
                                                        <span class="badge bg-success">Success</span>
                                                    @else 
                                                        <span class="badge bg-danger">{{ $cron['import_order_boutique_woocommerce']['message'] }}</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                            <td class="origin" data-label="Origine">
                                                @if($cron)
                                                    @if(isset($cron['import_order_boutique_woocommerce']))
                                                        @if($cron['import_order_boutique_woocommerce']['from_cron'] == "0")
                                                            <span class="manually">Manuellement</span>
                                                        @else 
                                                           <span class="cron">Tâche Cron</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        <td class="col-md-1" data-label="">
                                            <button type="button" class="p-1 px-1 task_execution btn btn-primary" data-url="{{ route('order_boutique.prepared') }}">Exécuter</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
				        </div>
                    </div>
                </div>
            </div>
      </div>
      
        <!-- MODAL VALIDATION -->
        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post" id="task_form" action="">
                            @csrf
                        <h2 class="text-center">Exécuter la commande ?</h2>
                            <div id="error_code"></div>
                        </div>
                        <div class="p-2 d-flex justify-content-center">
                            <div class="spinner-border d-none text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
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

                $(".spinner-border").removeClass("d-none")
                $(".button_form").addClass("d-none")

                

                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(response) {
                        $("#exampleModal").modal('hide')
                        $(".spinner-border").addClass("d-none")
                        $(".button_form").removeClass("d-none")
                        
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
                $("#task_form").attr('action', $(this).attr('data-url'))
                $("#exampleModal").modal('show')
            })
        </script>
    @endsection

@endsection






	