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
            throw new ValidationException(['email' => ['Email is already taken']]);
        }
    }

    // Add this new method
    public function isSocialMediaURLTaken(string $url)
    {
        $urlCount = $this->db->query(
            "SELECT COUNT(*) FROM users WHERE social_media_url = :social_media_url",
            ['social_media_url' => $url]
        )->count();

        if ($urlCount > 0) {
            throw new ValidationException(['socialMediaURL' => ['Social media URL is already taken']]);  // ← array
        }
    }


    public function create(array $formData){

        $this->isEmailTaken($formData['email']);
        $this->isSocialMediaURLTaken($formData['socialMediaURL']);

        $password = password_hash($formData['password'],PASSWORD_BCRYPT,['cost' => 12])
        ;

        $this->db->query(
            "INSERT INTO users (email, age, country, social_media_url, password) 
                   VALUES (:email, :age, :country, :social_media_url, :password)",
            [
                'email' => $formData['email'],
                'age' => $formData['age'],
                'country' => $formData['country'],
                'social_media_url' => $formData['socialMediaURL'],
                'password' => $password
            ]
        );
    }

    public function login(array $formData) {
            $user = $this->db->query(
                "SELECT * FROM users WHERE email = :email",
                ['email' => $formData['email']]
            )->find();

            $passwordMatch = password_verify(
                $formData['password'],
                $user['password'] ?? ''
            );

            if (!$user || !$passwordMatch) {
                throw new ValidationException(['password' => ['Invalid credentials']]);
            }

            session_regenerate_id();

            $_SESSION['user'] = $user['user_id'];
    }

    public function logout()
    {
        unset($_SESSION['user']);

        session_regenerate_id();
    }
}