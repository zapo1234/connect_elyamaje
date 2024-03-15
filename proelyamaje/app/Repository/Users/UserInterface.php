<?php

namespace App\Repository\Users;

use App\Model\User;

interface UserInterface
{
   public function getUsers(); // recupére tous les uers

   public function getUserId(int $id); // recupérer un user

   public function create(array $attribute); // créer un array

   public function update($id, array $attribute); // Modifier un user

   public function getEmail(string $email); // get 
   
   public function insertTokenresetPassword(string $email, string $token); // insert data dans password rest
   
   public function getToken($email,$token); // recupérer token

   public function newPassword(string $email, string $password);
   
   public function deletepassword_reset(string $email); // delete data in password_rest
   
   public function updateactive($id); // update activer
   
   public function destroy($id);
   
   public function accescompte($email,$date);
   
   public function getambassadrice($id);// recupérer tous les ambassadrice
   
   public function getdatausercodelive();
   


}




