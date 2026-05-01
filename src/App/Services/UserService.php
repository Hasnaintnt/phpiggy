<?php

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(private Database $db)
    {

    }
    public function isEmailTaken(string $email){
        $emailCount = $this->db->query("SELECT COUNT(*) FROM users WHERE email = :email",
        [
            'email' => $email
        ]
        )->count();

        if ($emailCount > 0) {
            throw new ValidationException(['email' => 'Email is already taken']);
        }
    }

    public function create(array $formData){
        $this->db->query(
            "INSERT INTO users (email, age, country, social_media_url, password) 
                   VALUES (:email, :age, :country, :social_media_url, :password)",
            [
                'email' => $formData['email'],
                'age' => $formData['age'],
                'country' => $formData['country'],
                'social_media_url' => $formData['socialMediaURL'],
                'password' => $formData['password']
            ]
        );
    }
}