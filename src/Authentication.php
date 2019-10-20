<?php

namespace Framework;

use LeanCloud\SMS;
use LeanCloud\User;

class Authentication
{
    static public $email_regex = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
    static public $phone_regex = '/^([1][3,4,5,6,7,8,9])\d{9}$/';
    protected static $className = '_User';

    static public function register($username, $password, $data = [])
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        foreach ($data as $k => $datum) {
            $user->set($k, $datum);
        }

        $user->signUp();
    }

    static public function login($username, $password)
    {
        if (preg_match(self::$email_regex, $username)) {
            return User::logInWithEmail($username, $password);
        } elseif (preg_match(self::$phone_regex, $username)) {
            return User::logInWithMobilePhoneNumber($username, $password);
        } else {
            return User::logIn($username, $password);
        }
    }

    static public function sendSmsCode($phone)
    {
        SMS::requestSmsCode($phone);
        return true;
    }

    static public function authByPhone($phone, $sms_code)
    {
        return User::signUpOrLoginByMobilePhone($phone, $sms_code);
    }

    static public function sendResetEmail($email)
    {
        User::requestPasswordReset($email);
        return true;
    }
}
