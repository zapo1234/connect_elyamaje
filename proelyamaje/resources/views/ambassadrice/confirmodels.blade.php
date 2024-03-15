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
    <link href="https://prodev.elyamaje.com/admin/css/sb-admin-2.min.css" rel="stylesheet">
     <!-- Outer Row -->
     <style type="text/css">
        .response{width:30%;margin:auto;}
         .h2{color:black;font-weight:bold;font-size:24px;margin-top:100px;}
         .loading{margin-top:20px;margin-left:10%;}
         @media (max-width: 760.98px) {
         
        .response{width:30%;margin-top:300px;margin:auto;font-family:45px;}
         .h2{color:black;font-weight:bold;font-size:75px;margin-top:50px;}
         .loading{margin-top:20px;margin-left:10%;font-size:70px;}
          #imc{margin-top:150px;}
         }
     </style>
     
    
  </head>
  <body>
    <div class="response"> 
      <!-- Sidebar - Brand -->
    <div id="imc"><img src="https://prodev.elyamaje.com/admin/img/Logo_elyamaje.png" width="100px" height="auto" style="margin-top:100px;"></div>

     <div class="h2">Votre message est bien arrivé chez votre élève! </div>
     <div class="loading">
     <div class="spinner-border text-dark" role="status">
     <span class="sr-only">Loading...</span>
     </div>
     </div>
     
     </div>
     </div>
    
    
    <script src="https://connect.elyamaje.com/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://connect.elyamaje.com/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="https://connect.elyamaje.com/admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="https://connect.elyamaje.com/admin/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="https://prodev.elyamaje.com/admin/js/demo/chart-area-demo.js"></script>
    <script src="https://prodev.elyamaje.com/admin/js/demo/chart-pie-demo.js"></script>
    <script src="https://prodev.elyamaje.com/admin/js/account.js"></script>
    
    <script type="text/javascript">
      function redirection() {
        window.location.replace("https://www.staging.connect.elyamaje.com/ambassadrice/customer/list");
      }      
      setTimeout("redirection()", 2000);
    </script>
  </body>
</html>