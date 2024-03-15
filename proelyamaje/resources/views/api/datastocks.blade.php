@extends("layouts.apps")

	@section("style")

	<!-- <link href="{{asset('admin/css/account.css')}}" rel="stylesheet"> -->
     <!-- <link href="{{asset('admin/css/apiorders.css')}}" rel="stylesheet"> -->
	
	@endsection

	@section('wrapper')

    <div class="page-wrapper">
        <div class="page-content">
            <!-- <div class="container-fluid"> -->



            <!-- Page Heading -->

            <div class="d-sm-flex align-items-center justify-content-between mb-4">

                <h1 class="h3">Mise à jours des stocks dans dolibar  ! </h1>

                

                @if (session('success'))

                <div class="alert alert-success" role="alert" id="alert_emails" style="width:300px;height:55px;text-align:center;margin-top:-30px;padding:0.5%">

                {{ session('success') }}

                </div>

                @elseif(session('failed'))

                                

                @endif

                

                <form method="post" action="">

                @csrf

                <button type="button" id="buttoncodepromo" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="background-color:green;color:white;border:2px solid green;"><i

                        class="fas fa-download fa-sm text-white-50"></i>Export</button>

                

                    </form>

                

                

            </div>



            <!-- Content Row --Mobile -->

            <div class="row" id="cards">

                

            



                

        </div>



            <!-- Content Row -->



            <div class="row">



                <!-- Area Chart -->

                <div class="col-xl-12 col-lg-12">

                    <div class="card shadow mb-4 p-3" >

                        <!-- Card Header - Dropdown -->

                        <div

                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                            <h6 class="m"> <span class="recher"> </span></h6>

                            <div class="dropdown no-arrow">

                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"

                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>

                                </a>

                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"

                                    aria-labelledby="dropdownMenuLink">

                                    <div class="dropdown-header">Dropdown Header:</div>

                                    <a class="dropdown-item" href="#">Action</a>

                                    <a class="dropdown-item" href="#">Another action</a>

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="#">Something else here</a>

                                </div>

                                

                            

                            </div>

                        </div>

                        <!-- Card Body -->

                        <div id="cards_content">

                        

                    <form method="post" id="export_stocks" action="" style="" style="width:700px;"> 

                            @csrf

                    <h2 style="border:1px solid #eee;padding:1.5%;">Choisir la catégorie de mise à jours de stocks</h2><br/>     

                    <select class="form-select" name="id_categoris" id="id_categoris" aria-label="Default select example" style="height:40px;">

                <option selected>Choisir la categorie</option>

                @foreach($data as $resultat)

                

                <option value="{{ $resultat['rowid'] }}">{{ $resultat['label'] }}</option>

                

                @endforeach

                

            </select><button type="submit" id="export_stock" style="background-color:black;color:white;width:150px;padding:1%;border-radius:15px;margin-top:10px;">Générer le csv</button>

            

            </form><br/><br/>

                

                

                

                <form method="post" id="export_stocks_entrepot" action="/data/dolibar/entreport/stocks/csv" style="" style="width:700px;"> 

                            @csrf

                    

                    <h1>Stocks de produit par Entrepot</h1>

                    <h2 style="border:1px solid #eee;padding:1.5%;">Choisir la catégorie </h2><br/>  

                    

                    <select class="form-select" name="id_categoriss" id="id_categoriss" aria-label="Default select example" style="height:40px;">

                <option selected>Choisir la categorie</option>

                @foreach($data as $resultat)

                

                <option value="{{ $resultat['rowid'] }}">{{ $resultat['label'] }}</option>

                

                @endforeach

                

            </select><button type="submit" id="export_stock_entrepot" style="background-color:black;color:white;width:150px;padding:1%;border-radius:15px;margin-top:10px;">Générer un  csv</button>

            

            </form><br/><br/>

                

                

                

                

                

                

                <form method="post" id="imports_stocks" action="/data/dolibar/miseajours" enctype="multipart/form-data" style="">

                    @csrf

                    <h2 style="border:1px solid #eee;padding:1.5%;">Importer votre fichier de mise à jour de stocks vers dolibar</h2> 

                    <h3>Upload du fichiers </h3>

                <input type="file" id="file" name="file" required><br><br>

                <button type="button"  id="transfers_stocks" class="envois" style ="background-color:black;color:white;width:150px;padding:1%;border-radius:15px;"><i class="fas fa-download fa-sm text-white-50"></i>Importer</button>

                </form><br/><span class="mm" style="color:red;font-weight:bold;padding-left:7%;">{{ $message }} </span> 

                    <span class="mm" style="color:green;font-weight:bold;padding-left:7%;">{{ $messages }} </span><br/>

                

                



                

                <div class="footer_form" style="border:1px solid #eee;padding:1.5%;">

                    

                    <h3 style="color:black;font-size:18px;">Merci de bien vérifier votre fichier d' import CSV  <br/></h3>

                    

                </div>



                </div>

                

                



            </div>

                    <div id="resultats"></div><!--resutat requete ajax-->

            <div id="pak" style="display:none"></div>

            <div class="form_api_codepromo" style="display:none">

            <form method="post" id="transfers_coupon_api" action="/datas/coupons">

                    @csrf

                <h2>Transférez vos articles dolibar </h2>

                <div id="error_code"></div>

                

                <button type="button" class="annuler">Annuler</button>

                <button type="submit"  id="transfers_codepromo" class="envoi"><i class="fas fa-download fa-sm text-white-50"></i> Transférer</button>

                </form>

                

            </div><!--.form_api-->

            

            

            <div class="forms_csv" style="display:none">

            

            <!-- </div> -->
        </div>

    </div>


</div>

@endsection
