<?php

class Validation {

    public function validateName($name) {
        $pattern = '/^[a-zA-Z]+$/';
        return preg_match($pattern, $name);
    }

    public function validateEmail($email) {
        $pattern = '/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/';
        return preg_match($pattern, $email);
    }

    public function validatePassword($password) {
        $pattern = '/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/';
        return preg_match($pattern, $password);
    }
}
