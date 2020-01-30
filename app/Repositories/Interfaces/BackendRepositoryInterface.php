<?php

namespace App\Repositories\Interfaces;

//use App\User;

interface BackendRepositoryInterface
{
    /////////////////////////////////////////////////////////////////////////////////ADMIN USERS 
    public function getAdminUsers();
    public function getAdminUsersById($id);
     /////////////////////////////////////////////////////////////////////////////////ADMIN ROLES
    public function getAdminRoles();       
    public function getAdminRolesById($id); 
      

}
