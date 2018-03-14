<?php

namespace App\Auth;

use Cake\Auth\AbstractPasswordHasher;

class GreenPasswordHasher extends AbstractPasswordHasher
{

    public function hash($password)
    {                
        return strrev(hash('sha512', $password));
    }

    public function check($password, $hashedPassword)
    {
        return strrev(hash('sha512', $password)) === $hashedPassword;
    }
}