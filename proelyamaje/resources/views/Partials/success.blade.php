@if(session()->has('success'))
<div id="success-message" class="alert custom-page-style" style="text-align: center;color:#e9186594;margin-top: 100px;">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function() {
            $('#success-message').remove();
        }, 2000);
    </script>
@endif