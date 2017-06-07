<?php

/**
 * Created by PhpStorm.
 * User: Jim
 * Date: 31/5/2015
 * Time: 8:39 μμ
 */
class User
{
    function User($name, $username, $surname, $email, $role, $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
    }
}

?>