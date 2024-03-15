@extends("layouts.apps_ambassadrice")



<html lang="en">

<head>
    <link href="{{ asset('admin/assets/assets/plugins/fancy-file-uploader/fancy_fileupload.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
</head>

<body>

    @section("wrapper")

    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <div class="upload_rib flex-wrap align-items-center d-flex mb-0 ">
                        <h6 class="text-uppercase mb-0 ">Joindre mon RIB {{$user_rib ? "ou" : ""}}</h6>
                        @if ($user_rib)
                            <a class="preview_rib d-flex" target="_blank" href="{{ asset('admin/uploads/rib/').'/'.$user_rib}}">
                                <span class="existing_rib">Voir mon RIB</span>
                            </a>
                            <div class="rib_file">{{explode('.', $user_rib)[1]}}</div>
                        @endif
                    </div>
                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <form id="form_id"> 
                                @csrf
                                <input id="fancy-file-upload" type="file" name="files" accept=".jpg, .png, image/jpeg, image/png, .pdf" class="ff_fileupload_hidden">
                                <div class="ff_fileupload_wrap">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
</body>
</html>



@section("script")

	<script src="{{ asset('admin/assets/assets/plugins/fancy-file-uploader/jquery.ui.widget.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/fancy-file-uploader/jquery.fileupload.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/fancy-file-uploader/jquery.iframe-transport.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/fancy-file-uploader/jquery.fancy-fileupload.js') }}"></script>
	<script src="{{ asset('admin/assets/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js') }}"></script>

    <script>
		$('#fancy-file-upload').FancyFileUpload({
            url: "{{ route('ambassadrice.postrib') }}",
			params: {
                _token: $('#form_id').find('input[name="_token"').first().val(),
			},
			maxfilesize: 9000000,
            edit: true,
            uploadcompleted : function(e, data) {
                var url = "{{ asset('admin/uploads/rib') }}"
                if($(".preview_rib").length == 0){

                    $(".upload_rib").append(`
                        <a class="preview_rib d-flex" target="_blank" href="`+url+`/`+data.result.file+`">
                            <span class="existing_rib">Voir mon RIB</span>
                        </a>
                        <div class="rib_file">`+data.result.extension+`</div>
                    `)
                    $(".upload_rib").children('h6').text("Joindre mon RIB ou")

                } else {
                    $(".rib_file").text(data.result.extension)
                    $(".preview_rib").attr('href', url+'/'+data.result.file)
                }
                
            }
		});
	</script>
	<script>
		$(document).ready(function () {
			$('#image-uploadify').imageuploadify();
		})
	</script>
    
@endsection
	


