@extends('auth.layouts.app')

@section('content')
<div class="container" id="content1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <img id="imj" src="{{ asset('admin/img/Logo_elyamaje.png')}}" width="95px";
					height="auto">
                <div class="titre" style="text-align:center">Confirmer la création de votre compte !</div>

                <div class="card-body">
                    
                    <form method="POST" id ="forms_create_password" action="/createpassword">
                        @csrf
                        
                        <input type="hidden" id='token' name="token" value="{{ $token }}">
                        
                        <input type="hidden" id="email" name="email" value="{{ $email }}">
                        
                        <div class="form-group">
                                    <label>Entrez un mot de passe</label>
                                </div>
                         
                         <div class="form-group">
                                    <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Confirmez le mot de passe </label>
                                </div>
                                
                                <div class="form-group">
                                        <input id="password-confirm" type="password" class="form-control form-control-user" name="password-confirm" required autocomplete="new-password">
                                </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" id="create_pass" class="btn btn-primary" style="width:230px;background-color:black;border:2px solid black;">
                                    Créer votre mot de passe  !
                                </button>
                            </div>
                            <br/><br/>
                            <div id="error_password"></div><!--result--password-->
                           
                            
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection