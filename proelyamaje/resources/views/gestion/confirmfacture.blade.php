<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>elyamaje confirm </title>
     <!-- Custom fonts for this template-->
    <link href="https://prodev.elyamaje.com/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link rel="icon" type="image/png" href="https://prodev.elyamaje.com/admin/img/Logo_elyamaje.png" />
    
        
     <!-- Custom styles for this template-->
    <link href="https://prodev.elyamaje.com/admin/css/sb-admin-2.min.css" rel="stylesheet">
     <!-- Outer Row -->
     <style type="text/css">
        .response{width:30%;margin:auto;}
         h3{color:black;font-weight:bold;font-size:24px;margin-top:100px;}
         .loading{margin-top:20px;margin-left:10%;}
         
         
         .loader {
         border: 16px solid #f3f3f3; /* Light grey */
       border-top: 16px solid green; /* Blue */
        border-radius: 50%;
         width: 160px;
        height: 160px;
        animation: spin 2s linear infinite;
    }

      @keyframes spin {
       0% { transform: rotate(0deg); }
       100% { transform: rotate(360deg); }
   }
         
         
         
         
         @media (max-width: 760.98px) {
         
        .response{width:30%;margin-top:300px;margin:auto;font-family:45px;}
         h3{color:black;font-weight:bold;font-size:4%;margin-top:100px;width:350px;}
         .loading{margin-top:20px;margin-left:10%;font-size:70px;}
          #imc{margin-top:150px;}
         }
     </style>
     
    
  </head>
  <body>
    <div class="response"> 
      <!-- Sidebar - Brand -->
    <div id="imc"><img src="https://prodev.elyamaje.com/admin/img/Logo_elyamaje.png" width="150px" height="auto" style="margin-top:100px;"></div>

     <h3 style="font-size:25px">La facture à eté bien mise à jour! </h3>
    
    <div class="loader"></div>
     
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
        window.location.replace("https://erp.elyamaje.com/index.php/ambassadrice/factures");
      }      
      setTimeout("redirection()", 4000);
    </script>
  </body>
</html>