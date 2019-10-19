<?php

namespace Framework\Model\Traits;

use LeanCloud\User;

trait UserAction
{
    public function sendVerifyEmail()
    {
        User::requestEmailVerify($this->email);
    }

    public function sendVerifyPhone()
    {
        User::requestMobilePhoneVerify($this->phoneNumber);
    }

    public function verifyPhone($sms_code)
    {
        User::verifyMobilePhone($sms_code);
    }
}
