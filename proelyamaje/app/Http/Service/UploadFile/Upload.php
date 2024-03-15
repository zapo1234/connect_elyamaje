<?php

namespace App\Http\Service\UplaodFile;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class  Uploadfile
{
   /**
   * upload file.
   *
   * @return $this
   */
   public function uploadfile(string $file, Request $request)
   {
       if($request->hasfile('file')) 
       {
           // l'extension du fichier 
           $extension = $file->getClientOriginalExtension();
          // renommer le fichier
          $array = array('png','jpg','jpeg');
          $filename = time().'.'.$extension;
          // enregsitrer le fichier dans le dossier upload.
          $file->move(public_path('upload'), $filename);
          // message is succesfull
          return redirect('upload.file')->with('status', 'le fichier est uploadé');
    
       }

   }
   
   
   public function store(){
         
         
         $file = $request->file('file'); // l'extension du fichier 
         
         $name = $file->getClientOriginalName();
         if($name)
         {
           $extension = $file->getClientOriginalExtension();
          // renommer le fichier
          $array = array('png','jpg','jpeg');
         
          
          if(in_array($extension,$array))
          {
              $name = $file->getClientOriginalName();
              $path = $file->store('public/files');
    
            $error ="succes";
            return $error;
        }
        
        
        if(!in_array($extension, $array))
         {
             
             $error ="denied";
            return $error;
             
         }
        
        
    }
    
    else{
        
        $error ="";
        return $error;
    }
   
   
}


}








