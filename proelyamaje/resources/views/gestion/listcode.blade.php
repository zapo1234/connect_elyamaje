@extends('layouts.apps')

@section('style')
    <link href="{{asset('admin/css/account.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/assets/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
@endsection



@section("wrapper")
<div class="page-wrapper">
    <div class="page-content">

        <div class="page-breadcrumb d-sm-flex align-items-center mb-2">
            <div class="breadcrumb-title pe-3">Codes promos</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 pe-3">
                        <li class="breadcrumb-item active" aria-current="page">Liste des codes ambassadrices & partenaires</li>
                    </ol>
                </nav>
            </div>
        </div>
       

            <!-- Content Row -->

            <div class="card card_table_mobile_responsive">
					<div class="table-responsive p-3">
                    
                    <div class="d-flex flex-wrap">
                        <div class="d-none filter_research_invoice d-flex fact{{ Auth()->user()->is_admin }}" style="color:black">
                                <select class="users_dropdown input_form_type">
                                    <option value="">Utilisateurs</option>
                                        @foreach($list as $k => $val)
                                            @foreach($val as $m =>$vals)
                                            <option value="{{ $vals }}">{{ $vals }}</option>
                                            @endforeach
                                        @endforeach
                                    <option value=""><strong>Partenaires</strong></option>
                                        @foreach($lists as $ks => $vals)
                                            @foreach($vals as $ms =>$valss)
                                            <option value="{{ $valss }}">{{ $valss }}</option>
                                            @endforeach
                                        @endforeach
                                </select>

                                <select class="type_dropdown input_form_type" name="type_user">
                                    <option value="">Type utilisateur</option>
                                    <option value="Ambassadrice">Ambassadrice</option>
                                    <option value="Partenaire">Partenaire</option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="d-flex justify-content-center w-100 loading"> 
							<div class="spinner-border text-dark" role="status"> <span class="visually-hidden">Loading...</span></div>
						</div>

                        <table id="example" class="d-none table_mobile_responsive table table-striped table-bordered" style="width:100%;text-align:center;">
                        <thead>
                        
                        
                        <th scope="col" style="color:black;font-size:16px;font-weight:300"><i class="fa fa-calendar" aria-hidden="true"></i> Date de création </th>
                        <th scope="col">Nom</th>
                        <th>Type/utilisateur</th>
                        <th>Code élève</th>
                        <th class="cx">Status</th>
                        <th class="cx">Commission</th>
                        <th scope="col">Action</th>
                        <th scope="col">ID</th>

                        
                      
                    </thead>
                    <tbody>
                    
                    @foreach($users as $resultat)
                        <tr>
                            <th scope="row" style="font-size:18px;color:#000;font-weight:bold">{{ \Carbon\Carbon::parse($resultat['datet'])->format('d/m/Y')}}</th>
                            <!-- <td></td> -->
                            <td data-label="Nom">{{ $resultat['name'] }}</td></td>
                            <td data-label="Type/utilisateur">{{ $resultat['type_account'] }}</td>
                            <td data-label="Code élève">{{ $resultat['code_promo']  }} </td>
                            <td style="position:relative" data-label="Status"><div style="position:absolute;right:35px" class="{{ $resultat['css'] }}"></div></td>
                            <td data-label="Commission"> {{ $resultat['montant'] }}</td>
                            
                            <td data-label="Action" class="button">
                                @if($resultat['css'] = "com")
                                    <button type="button" style="background-color:black;border-radius:5px;color:white;border:2px solid black" class="add_delete_code" data-id2="{{ $resultat['code_promo'] }}">Suprimer</button>
                                @endif
                            </td> 
                            <td data-label="ID"> {{ $resultat['id'] }}</td>
                           
                                        
                            
                        </tr>

                    @endforeach
                
                </tbody>
        
        </table>
        
        <div class="affiche" style="margin-left:50%">  </div>  
        
            
            <!-- <div class="form_validate" style="display:none;background-color:white;border:2px solid white;border-radius:10px;position:fixed;z-index:5;width:25%;height:140px;padding:2%;top:180px;left:33%;
            font-size:16px;color:black;">
                <form method="post" action="/collaborateur/delete/code">
                    @csrf
                <h3 style="font-size:17px;text-align:center">Souhaitez vous suprimer ce code élève ? </h3>
                <button type="button" class="annuler" style="background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;margin-left:3%">Annuler</button>  
                <button type="submit" class="validate" style="background-color:#00FF00;color:black;border:2px solid #00FF00;margin-left:20%;border-radius:15px;font-weight:bold">valider</button> <br/> 
                <input type="hidden" id="id_codeeleve" name="id_codeleve">
                </form>
            </div>   -->



            <!-- Modal -->
            <div class="modal fade form_validate" id="form_validate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-body">
                    <form method="post" action="/collaborateur/delete/codes">
                        @csrf
                        <h3 style="font-size:17px;text-align:center">Souhaitez vous suprimer ce code élève ? </h3>
                        <div class="w-100 d-flex justify-content-center">
                            <button data-bs-dismiss="modal" type="button" class="annuler" style="background-color:#eee;color:black;border:2px solid #eee;border-radius:15px;">Annuler</button>  
                            <button type="submit" class="validate" style="background-color:#00FF00;color:black;border:2px solid #00FF00;margin-left:15px;border-radius:15px;font-weight:bold">valider</button> <br/> 
                        </div>
                            <input type="hidden" id="id_codeeleve" name="id_codeleve">
                    </form>
                </div>
                </div>
            </div>
            </div>
            

                

                </div>

           

        </div>

     

       

    </div>
</div>
@endsection

@section("script")
    <script src="{{asset('admin/assets/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/assets/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('admin/assets/assets/plugins/select2/js/select2.min.js')}}"></script>


    <script>

    $('.add_delete_code').on('click', function(){
        $("#form_validate").modal('show')
    })

        $(document).ready(function() {

            $('#example').DataTable({
                "ordering": false,
                "order": [[7, 'desc']],
                "initComplete": function(settings, json) {
                    $(".filter_research_invoice").removeClass('d-none')
                    $(".loading").remove()
                    $("#example").removeClass('d-none')
                    // $('.form-select form-select-sm')
                    $("#example_length select").css('margin-left', '10px')
                    $("#example_length select").addClass('filter_length')
                    $("#example_length select").appendTo('.filter_research_invoice')
                    $(".dataTables_length").hide()

                    $("select").select2({
                     width: '150px'
                    });

                    $(".filter_length").select2({
                        width: '80px'
                    });
                }

            });

            $('#example').DataTable().column(7).visible(false)

            $("#example_filter").remove()
            $('.users_dropdown').on('change', function(e){
                var user = $(this).val();
                var type_user = $('.type_dropdown').val();
                $('.users_dropdown').val(user);
                $('#example').DataTable()
                .column(1).search(user, true, false)
                .column(2).search(type_user, true, false)
                .draw();
            })

            $('.type_dropdown').on('change', function(e){
                var type_user = $(this).val();
                var user = $('.users_dropdown').val();
                $('.type_dropdown').val(type_user)
                $('#example').DataTable()
                .column(1).search(user, true, false)
                .column(2).search(type_user, true, false)
                .draw();
            })

        });


    </script>
@endsection


        


