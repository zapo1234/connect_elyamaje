    <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Elyamaje confirm </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <!-- Custom fonts for this template-->
    <link href="https://prodev.elyamaje.com/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link rel="icon" type="image/png" href="https://prodev.elyamaje.com/admin/img/Logo_elyamaje.png" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        
     <!-- Custom styles for this template-->
    <link href="https://prodev.elyamaje.com/admin/css/sb-admin-2.min.css" rel="stylesheet">
     <!-- Outer Row -->
     <link href="https://prodev.elyamaje.com/admin/css/Api/orders_mobile.css" rel="stylesheet">
    
    
  </head>
  <body>
    <div class="response"> 
      <!-- Sidebar - Brand -->
    <div><img id="im" src="https://prodev.elyamaje.com/admin/img/Logo_elyamaje.png" width="75px";
					height="auto"; style="";></div>

     <h1><i class='fas fa-exclamation-circle' style='font-size:20px;color:red'></i> Aucune commande récupérée<br/>dans cette période ! </h1>
     <a href ="{{ route('api.orders') }}"><button type="button" class="lister">Commandes</button></a>
         <a href="{{ route('api.dataorders') }}"> <button type="button"  class="continue">Continuer</button></a>
     
     </div>
      
      <div id="pak"></div>
    
    
    <script src="https://prodev.elyamaje.com/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://prodev.elyamaje.com/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="https://prodev.elyamaje.com/admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="https://prodev.elyamaje.com/admin/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="https://prodev.elyamaje.com/admin/js/demo/chart-area-demo.js"></script>
    <script src="https://prodev.elyamaje.com/admin/js/demo/chart-pie-demo.js"></script>
    <script src="https://prodev.elyamaje.com/admin/js/account.js"></script>
    
    <script type="text/javascript">
      function redirection() {
        window.location.replace("https://prodev.elyamaje.com/data/society/dataorders");
      }      
      setTimeout("redirection()", 5000);
    </script>
  </body>
</html>   
          
      