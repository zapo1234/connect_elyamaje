@extends("layouts.apps_ambassadrice")



	@section("style")


	@endsection	

		@section("wrapper")

		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

					<div class="breadcrumb-title pe-3"></div>
					<div class="ms-auto">

					</div>
				</div>


        <div class="text-center">
                        <h5 class="mb-4 text-uppercase">Questions fréquentes (FAQ<small class="text-lowercase">s</small>)</h5>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion" id="accordionExample">


                                @foreach($dataQuestions as $key => $val)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne{{$key}}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$key}}" aria-expanded="false" aria-controls="collapseOne{{$key}}">
                                            {{$val['question']}} ?
                                        </button>
                                    </h2>
                                    <div id="collapseOne{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne{{$key}}" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body">
                                            <p>
												<textarea id="myTextarea_{{$key}}" style="background-color: transparent; border:0 !important; height:auto;" class="form-control text_area" rows="10" disabled>{{$val['reponse']}}</textarea>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach()
                            </div>
                        </div>
                    </div>


			</div>
		</div>

	

		

		<!--end page wrapper -->

		@endsection

			

		@section("script")
<script>
		$(document).ready(function() {
			multip = 1;
			if (/Mobi|Android/i.test(navigator.userAgent)) {
				multip = 2.8;
			} else {
					multip = 1;
			}

			$('.text_area').each(function(index, element) {
			var rows = element.value.split('\n').length*multip;

			$(element).attr('rows', rows);
			console.log(rows);
			});
		});
</script>




	@endsection

	