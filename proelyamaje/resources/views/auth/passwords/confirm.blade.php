<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>elyamaje confirm </title>
     <!-- Custom fonts for this template-->
    <link href="https://prodev.elyamaje.com/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link rel="icon" type="image/png" href="https://prodev.elyamaje.com/admin/img/Logo_elyamaje.png" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        
     <!-- Custom styles for this template-->
     <!-- Outer Row -->
     <style type = "text/css">
        .response{width:30%;margin-top:300px;margin:auto;}
         .h2{color:black;font-weight:bold;font-size:50px;margin-top:50px;}
         .loading{margin-top:20px;margin-left:10%;font-size:30px;}
         @media (max-width: 760.98px) {
         
        .response{width:30%;margin:auto;font-size:35px;}
         h2{color:black;font-weight:bold;font-size:40px;margin-top:100px;}
         .loading{margin-top:120px;margin-left:20%;width:80px}
         
         #imc{margin-top:200px;}
         }
     </style>
     
    
  </head>
  <body>
    <div class="response"> 
      <!-- Sidebar - Brand -->
    <div class="imc" style="margin-top:100px"><img id="imj" src="https://connect.elyamaje.com/admin/img/Logo_elyamaje.png" width="105px";
					height="auto";></div>

     <div class="h2">Vous avez bien reinitialiser un nouveau mot de passe ! </div>
     <div class="loading">
     <div class="spinner-border text-dark" role="status">
     <span class="sr-only">Chargement...</span>
     </div>
     </div>
     
     </div>
    
    
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
        window.location.replace("https://connect.elyamaje.com/login");
      }      
      setTimeout("redirection()", 3000);
    </script>
  </body>
</html>