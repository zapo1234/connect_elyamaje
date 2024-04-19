<?php
namespace App\Http\Service\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Http\Request;

class ServiceMailer
{
   public function SendMail(string $email, string $from, string $subject, string $message)
   {
        //Load Composer's autoloader
        require base_path("vendor/autoload.php");
        //instant de mailer 
        $mail = new PHPMailer(true);
    
     try {
          //Server settings
           $mail->isSMTP();                    //Enable verbose debug output
           $mail->isSMTP();                                            //Send using SMTP
           $mail->Host       = 'mail.elyamaje.com';                     //Set the SMTP server to send through
           $mail->SMTPAuth   =    true;                                   //Enable SMTP authentication
           $mail->Username   = 'connect@elyamaje.com';                     //SMTP username
           $mail->Password   = '7vfsLE3D*7eO';                     //SMTP password
           //SMTP password
	       $mail->SMTPSecure = 'ssl';
           $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
           $mail->Port       = 465;   
           //encode Utf 8
           $mail->CharSet = 'UTF-8';                               
           //Recipients
           $mail->setFrom($from);
           $mail->addAddress($email);   
           //Content
           $mail->isHTML(true);                                  
           $mail->Subject = $subject;
           $mail->Body    = $message;
        
           // send Mail
           $mail->send();
           
       }    catch (Exception $e) {
          
    }
     
   }
   
   
   
   public function SendMails(array $data, string $from, string $subject,$message)
   {
        
      foreach($data as $value){
          
        if($value['email']!="") {
          //Load Composer's autoloader
        require base_path("vendor/autoload.php");
        //instant de mailer 
          $mail = new PHPMailer(true);
    
          //Server settings
           $mail->isSMTP();         //Enable verbose debug output
                                    //Send using SMTP
           $mail->Host       = 'mail.elyamaje.com';                     //Set the SMTP server to send through
           $mail->SMTPAuth   =    true;                                   //Enable SMTP authentication
           $mail->Username   = 'serviceerp@elyamaje.com';                     //SMTP username
           $mail->Password   = 'Uu4R(gymH6E;';                     //SMTP password
           //SMTP password
	       $mail->SMTPSecure = 'ssl';
           $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
           $mail->Port       = 465;   
           //encode Utf 8
           $mail->CharSet = 'UTF-8';                               
           //Recipients
           $mail->setFrom($from);
           $mail->AddAddress($value['email']);
           // envoi de mail mutiple
           
           //Content
           $mail->isHTML(true);                                  
           $mail->Subject = $subject;
          
          // construire l'email
            
             $mail->Body.='<div class="contenu" style="color:black !important;"><h1> Message  de  '.$value['libelle'].'  Elyamaje </h1></div>';
             $mail->Body.='<div style="color:black !important;"> Cher élève </div>';
             $mail->Body.='<div style="color:black !important;"><span style="text-transform:capitalize;">'.$value['nom_ambassadrice'].'</span> vous a attribué un code promotionnel. Grâce à ce code, vous avez accès à 10% de reduction sur tous les produits du site <a href="elyamaje.com">elyamaje.com</a>.<br/><br/>
             Voici votre code élève <strong>'.$value['code_promo'].'</strong> pour effectuer vos achats. <br><br>
             Ce code est valable une seule fois lors de votre première commande.<br><br></div>';
             $mail->Body.='<div>Pour l&apos;utiliser, rendez-vous notre boutique <a href="https://www.elyamaje.com">Aller sur le site d&apos;Elyamaje</a>. <br><br>À bientôt ! </div>';
             
              $mail->send();
       }   
           // send Mail
          
      }    
         
    }

    public function SendMailnotification(array $data, string $from, string $subject,$message){
        
      foreach($data as $value){
          
         if($value['email']!="") {
           //Load Composer's autoloader
         require base_path("vendor/autoload.php");
         //instant de mailer 
           $mail = new PHPMailer(true);
     
           //Server settings
            $mail->isSMTP();         //Enable verbose debug output
                                     //Send using SMTP
            $mail->Host       = 'mail.elyamaje.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   =    true;                                   //Enable SMTP authentication
            $mail->Username   = 'serviceerp@elyamaje.com';                     //SMTP username
            $mail->Password   = 'Uu4R(gymH6E;';                     //SMTP password
            //SMTP password
             $mail->SMTPSecure = 'ssl';
             $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
             $mail->Port       = 465;   
             //encode Utf 8
             $mail->CharSet = 'UTF-8';                               
             //Recipients
             $mail->setFrom($from);
             $mail->AddAddress($value['email']);
            // envoi de mail mutiple
             //Content
              $mail->isHTML(true);                                  
              $mail->Subject = $subject;
              // construire l'email
               $mail->Body.='<div class="contenu" style="margin-top:15px;"><h1 style="font-size:16px">  Bonjour Chère  <strong>'.$value['status'].'</strong></h1></div>';
               $mail->Body.='<div style="margin-bottom:3px;">  - Merci de bien recevoir les informations sur votre activité pour la période de  <strong>'.$value['Periode'].'</strong> </div>';
               $mail->Body.='<div style="margin-bottom:3px;">  -  Nombre de code promo crée :   <strong>'.$value['nom_code_use'].' </strong></div>';
               $mail->Body.='<div style="margin-bottom:3px;">  -  Nombre de code prormo utilisé :  '.$value['nombre_code_great'].'</div>';
               $mail->Body.='<div style="margin-bottom:3px">   -  La meilleur commande pour vos codes elèves  à été réalisée par votre élève :  <strong>'.$value['nombre_code_create'].' </strong></div>';
               $mail->Body.='<div style="margin-bottom:3px">   -  La meilleur commande pendant vos lives à été réalisée par la cliente   <strong>'.$value['nom_great_eleve'].' </strong></div>';
               $mail->Body.='<div style="margin-top:10px;text-transform:uppercase;font-size:18px;">  L\'equipe Elyamaje vous remercie  </div>';
              
               $mail->send();
        } 
      }  

    }
    
    
    public function SendMailedit(string $email, string $from, string $subject, string $message,string $nom_ambassadrice, string $code_promo,string $libelle)
    {
        //Load Composer's autoloader
        require base_path("vendor/autoload.php");
        //instant de mailer 
        $mail = new PHPMailer(true);
    
     try {
          //Server settings
           $mail->isSMTP();                    //Enable verbose debug output
           $mail->isSMTP();                                            //Send using SMTP
           $mail->Host       = 'mail.elyamaje.com';                     //Set the SMTP server to send through
           $mail->SMTPAuth   =    true;                                   //Enable SMTP authentication
           $mail->Username   = 'serviceerp@elyamaje.com';                     //SMTP username
           $mail->Password   = 'Uu4R(gymH6E;';                     //SMTP password
           //SMTP password
	       $mail->SMTPSecure = 'ssl';
           $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
           $mail->Port       = 465;   
           //encode Utf 8
           $mail->CharSet = 'UTF-8';                               
           //Recipients
           $mail->setFrom($from);
           $mail->addAddress($email);   
           //Content
           $mail->isHTML(true);                                  
           $mail->Subject = $subject;
           
             $mail->Body.='<div class="contenu" style="color:black !important;"><h1> Message  de  '.$libelle.'  Elyamaje </h1></div>';
             $mail->Body.='<div style="color:black !important;"> Cher élève </div>';
             $mail->Body.='<div style="color:black !important;"><span style="text-transform:capitalize;">'.$nom_ambassadrice.'</span> vous a attribué un code promotionnel. Grâce à ce code, vous avez accès à 10% de reduction sur tous les produits du site <a href="elyamaje.com">elyamaje.com</a>.<br/><br/>
             Voici votre code élève <strong>'.$code_promo.'</strong>  pour effectuer vos achats. <br><br>
             Ce code est valable une seule fois lors de votre première commande.<br><br></div>';
              $mail->Body.='<div>Pour l&apos;utiliser, rendez-vous notre boutique <a href="https://www.elyamaje.com">Aller sur le site d&apos;Elyamaje</a>. <br><br>À bientôt ! </div>';
             
              $mail->send();
           // send Mail
        
           
       }    catch (Exception $e) {
          
    }
    
   }
   
   
    public function SendMailadd(string $email, string $from, string $subject, string $message,string $nom, string $code_promof,string $libelle)
    {
        //Load Composer's autoloader
        require base_path("vendor/autoload.php");
        //instant de mailer 
        $mail = new PHPMailer(true);
    
     try {
          //Server settings
           $mail->isSMTP();                    //Enable verbose debug output
           $mail->isSMTP();                                            //Send using SMTP
           $mail->Host       = 'mail.elyamaje.com';                     //Set the SMTP server to send through
           $mail->SMTPAuth   =    true;                                   //Enable SMTP authentication
           $mail->Username   = 'serviceerp@elyamaje.com';                     //SMTP username
           $mail->Password   = 'Uu4R(gymH6E;';                     //SMTP password
           //SMTP password
	       $mail->SMTPSecure = 'ssl';
           $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
           $mail->Port       = 465;   
           //encode Utf 8
           $mail->CharSet = 'UTF-8';                               
           //Recipients
           $mail->setFrom($from);
           $mail->addAddress($email);   
           //Content
           $mail->isHTML(true);                                  
           $mail->Subject = $subject;
           
             $mail->Body.='<div class="contenu" style="color:black !important;"><h1> Message  de  '.$libelle.'  Elyamaje </h1></div>';
             $mail->Body.='<div style="color:black !important;"> Cher élève <br></div>';
             $mail->Body.='<div style="color:black !important;"><span style="text-transform:capitalize;">'.$nom.'</span> vous a attribué un code promotionnel. Grâce à ce code, vous avez accès à 10% de reduction sur tous les produits du site <a href="elyamaje.com">elyamaje.com</a>.<br/><br/>
             Voici votre code élève <strong>'.$code_promof.'</strong>  pour effectuer vos achats. <br><br>
             Ce code est valable une seule fois lors de votre première commande.<br><br></div>';
             $mail->Body.='<div>Pour l&apos;utiliser, rendez-vous notre boutique <a href="https://www.elyamaje.com">Aller sur le site d&apos;Elyamaje</a>. <br><br>À bientôt ! </div>';
             
              $mail->send();
           // send Mail
        
           
       }    catch (Exception $e) {
          
     }
    
   }

}



