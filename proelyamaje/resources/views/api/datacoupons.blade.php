		@extends("layouts.apps")
		@section("wrapper")
            <div class="page-wrapper">
                <div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3">Importer des données depuis API WOOCOMMERCE</div>
                        <div class="ps-3">
                            
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
                    <div class="row">
                        <div class="col col-lg-9 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="mb-0">Coupons(code promo) && Cards(gift)</h5>
                                    </div>
                                    <hr/>
                                    <div class="row row-cols-auto g-3">
                                        <div class="col">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Import de coupons </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Importer des données dans le ERP </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            
                                                           <form method="post" id="transfers_coupon_api" action="/datas/coupons">
                                                              @csrf
                                                            <h2>Transférez vos code promo </h2>
                                                                 <div id="error_code"></div>
        
                                                           </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annnuler</button>
                                                            <button type="submit" id="transfers_codepromo" class="btn btn-primary">Transférez</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">Import de cards gift</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Importer des données dans le ERP</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">Importez des données depuis Api woocomerce, les cartes cadeaux.</div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="button" class="btn btn-primary">Transférez </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                           @if (session('success'))
                                     <div class="alert alert-success" role="alert" id="alert_emails" style="width:300px;height:55px;text-align:center;margin-top:50px;padding:0.5%">
	                                 {{ session('success') }}
                                           </div>
                                      @elseif(session('failed'))
                           
                                       @endif
                                       
                                    <!--end row-->
                                </div>
                            </div>
                            
            </div>
		@endsection
