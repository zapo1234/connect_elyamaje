@extends(
	Auth()->user()->is_admin == 1 ? "layouts.apps" : (Auth()->user()->is_admin == 2 ? 
	"layouts.apps_ambassadrice" : (Auth()->user()->is_admin == 3 ? "layouts.apps_utilisateurs" : "layouts.apps_ambassadrice"))
)

	
	@section("style")

	<link href="{{asset('admin/assets/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />

	@endsection	

		@section("wrapper")

		<!--start page wrapper -->

			<div class="page-wrapper">
				<div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-sm-flex align-items-center mb-3 justify-content-between">
                        <div class="breadcrumb-title pe-3">Profil</div>

						@if (\Session::has('success'))
							
						@endif
						@if (\Session::has('error'))
							<!-- <div class="col-md-6 alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
								<div class="d-flex align-items-center">
									<div class="font-35 text-danger"><i class="bx bxs-check-circle"></i>
									</div>
									<div class="ms-3">
										<h6 class="mb-0 text-danger">Erreur</h6>
										<div>{!! \Session::get('error') !!}</div>
									</div>
								</div>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
							<div class="col-md-1"></div> -->
						@endif
                    </div>
                    <!--end breadcrumb-->

                    <div class="container">
                        <div class="main-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card h-100">
                                        <div class="card-body d-flex flex-column align-items-center justify-content-center h-100">
                                            <div class="d-flex flex-column align-items-center text-center">
												@if(file_exists('admin/uploads/'.$user->img_select))
													<div class="profil_image" style="width:110px; height:110px;background-image: url('{{ asset('admin/uploads/'.$user->img_select.'' )}}')"></div>
													<!-- <img src="{{ asset('admin/uploads/'.$user->img_select.'' )}}" alt="Admin" class="rounded-circle p-1 bg-black" width="110"> -->
												@else 
													<div class="profil_image" style="width:110px; height:110px;background-image: url('{{ asset('admin/uploads/default_avatar.png' )}}')"></div>
													<!-- <img src="{{ asset('admin/uploads/default_avatar.png' )}}" alt="Admin" class="rounded-circle p-1 bg-black" width="110"> -->
												@endif
                                                <div class="mt-3">
                                                    <h4 class="text-capitalize">{{$user->username ?? ''}} {{$user->name ?? ''}}</h4>
                                                    <p class="text-secondary mb-1">{{ $user->type_account ?? '' }}</p>
                                                    <p class="text-muted font-size-sm">{{ $user->ville ?? '' }}</p>
                                                    <!-- <button class="btn btn-primary">Follow</button>
                                                    <button class="btn btn-outline-primary">Message</button> -->
                                                </div>
                                            </div>
                                            <hr class="my-4 w-100">
											@if($user->is_admin == 2)
												<ul class="list-group list-group-flush w-100">
													<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
														<h6 class="d-flex align-items-center mb-0"><i style="color:#fd3550" class="bx bx-video-recording font-24"></i><span style="margin-left:5px">Lives</span></h6>
														<span style="font-size:18px" class="text-secondary">{{ $live['nbres_live'] ?? ''}}</span>
													</li>
													<!-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
														<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter me-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Twitter</h6>
														<span class="text-secondary">@codervent</span>
													</li>
													<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
														<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram me-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
														<span class="text-secondary">codervent</span>
													</li>
													<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
														<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook me-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
														<span class="text-secondary">codervent</span>
													</li> -->
												</ul>
											 @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="detail_account col-lg-8">
                                    <div class="card h-100">
                                        <div class="card-body">
											<form enctype="multipart/form-data" class="row g-3" method="post" action="{{ route('ambassadrice.profil') }}"> 
												@csrf

												<div class="col-md-6">
													<label for="inputFirstName" class="form-label">Nom *</label>
													<input required type="text" id="nom" name="nom" class="form-control" value="{{ $user->name ?? '' }}">
													@error('nom')
														<div class="alert alert_update_profil border-0 border-start border-5 border-danger alert-dismissible fade show">
															<div>{{ $message }}</div>
															<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
														</div>
													@enderror
												</div>
												<div class="col-md-6">
													<label for="inputLastName" class="form-label">Prénom *</label>
													<input required type="text" name="prénom" class="form-control" value="{{ $user->username ?? '' }}">
													@error('prénom')
														<div class="alert alert_update_profil border-0 border-start border-5 border-danger alert-dismissible fade show">
															<div>{{ $message }}</div>
															<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
														</div>
													@enderror
												</div>
												<div class="col-md-6">
													<label for="inputEmail" class="form-label">Email *</label>
													<input required type="email" id="email" name="email" class="form-control" value="{{ $user->email ?? '' }}">
													@error('email')
														<div class="alert alert_update_profil border-0 border-start border-5 border-danger alert-dismissible fade show">
															<div>{{ $message }}</div>
															<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
														</div>
													@enderror
												</div>
												<div class="col-md-6">
													<label for="inputAddress" class="form-label">Téléphone</label>
													<input type="text" name="telephone" class="form-control" value="{{ $user->telephone ?? '' }}">
												</div>
												<div class="col-12">
													<label for="inputAddress" class="form-label">Adresse</label>
													<input type="text" name="addresse" class="form-control" value="{{ $user->addresse ?? '' }}">
												</div>
												<div class="col-md-6">
													<label for="inputLastName" class="form-label">Ville</label>
													<input type="text" name="ville" class="form-control" value="{{ $user->ville ?? '' }}">
												</div>
												<div class="col-md-6">
													<label for="inputFirstName" class="form-label">Code Postal *</label>
													<input required type="text" name="code_postal" class="form-control" value="{{ $user->code_postal ?? '' }}">
													@error('code_postal')
														<div class="alert alert_update_profil border-0 border-start border-5 border-danger alert-dismissible fade show">
															<div>{{ $message }}</div>
															<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
														</div>
													@enderror
												</div>
												<div class="col-md-6">
													<label for="inputSiret" class="form-label">Siret</label>
													<input type="text" name="siret" class="form-control" value="{{ $user->siret ?? '' }}">
													@error('siret')
														<div class="alert alert_update_profil border-0 border-start border-5 border-danger alert-dismissible fade show">
															<div>{{ $message }}</div>
															<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
														</div>
													@enderror
												</div>
												<div class="col-md-6">
													<label for="inputFirstName" class="form-label">Status Juridique</label>
													<select name="status_juridique" id="status_juridique">
														<option value="SASU">SASU</option>
														<option value="EI">EI</option>
														<option value="SARL">SARL</option>
														<option value="SAS">SAS</option>
													</select>
												</div>


												<!-- RIB FOR PARTENAIRE AND AMBASSADRICE -->
												@if($user->is_admin == 2 || $user->is_admin == 4)
													<div style="position:relative" class="col-12">
														<label for="inputRib" class="d-flex w-100 justify-content-between form-label">RIB (PDF)
															@if(isset($user->rib))
																<a class="preview_rib d-flex" target="_blank" href="{{ asset('admin/uploads/rib/').'/'.$user->rib ?? ''}}">
																	<span class="existing_rib">Voir mon RIB</span>
																	<div class="rib_file">{{explode('.', $user->rib)[1]}}</div>
																</a>
															@endif
														</label>
														<input type="file" id="rib" name="rib"  accept=".pdf" class="form-control">
													</div>

													<div class="col-md-8">
														<label for="iban" class="form-label">IBAN</label>
														<input maxlength="34" type="text" name="iban" class="form-control" value="{{ $user->iban ?? '' }}">
													</div>
													<div class="col-md-4">
														<label for="swift" class="form-label">BIC / Swift</label>
														<input type="text" name="swift" class="form-control" value="{{ $user->swift ?? '' }}">
													</div>
												@endif

												<div class="col-12" style="position:relative">
													
													<div class="col-sm-9 text-secondary">
														<input disabled id="edit" type="submit" class="btn btn-primary px-4" value="Modifier">
													</div>
													
													@if (\Session::has('success'))
														<div class="d-flex justify-content-center w-100" style="position:absolute; z-index:1; top:0px">
															<div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2 w-100"
															style="background-color:white">
																<div class="d-flex align-items-center">
																	<div class="font-35 text-success"><i class="bx bxs-check-circle"></i>
																	</div>
																	<div class="ms-3">
																		<h6 class="mb-0 text-success">Success</h6>
																		<div>{!! \Session::get('success') !!}</div>
																	</div>
																</div>
																<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
															</div>
														</div>
													@elseif(\Session::has('error'))
														<div class="d-flex justify-content-center w-100" style="position:absolute; z-index:1; top:0px">
															<div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2 w-100"
															style="background-color:white">
																<div class="d-flex align-items-center">
																	<div class="font-35 text-danger"><i class="bx bxs-message-square-x"></i>
																	</div>
																	<div class="ms-3">
																		<h6 class="mb-0 text-danger">Erreur</h6>
																		<div>{!! \Session::get('error') !!}</div>
																	</div>
																</div>
																<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
															</div>
														</div>
													@endif
												</div> 
											</form>	
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>


	@section("script")

	<script>
		$("#status_juridique").val('{{$user->account_societe}}')

		$("input").on('change', function(){
			$("#edit").attr('disabled', false)
		})

		$("input").on('keypress', function(){
			$("#edit").attr('disabled', false)
		})

		$("select").on('change', function(){
			$("#edit").attr('disabled', false)
		})
	</script>

	@endsection
		
	