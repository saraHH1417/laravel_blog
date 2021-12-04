<?php

class User {

    public static $phone;
    public static $email;
    public static $name;


    public static function phone($phone_value){
        self::$phone = $phone_value;
        return new self;
    }

    public static function email($email_value){
        self::$email = $email_value;
        return new self;
    }

    public static function name($name_value){
        self::$name = $name_value;
        echo self::$phone . "   " . self::$email . "  " . self::$name;
    }

}

User::phone(1234)->email('aa@test.com')->name('aa');


class UserTwo
{

    public static $phone;
    public $email;
    public $name;


    public static function phone($phone_value)
    {
        self::$phone = $phone_value;
        return new self;
    }

    public function email($email_value)
    {
        $this->email = $email_value;
        return $this;
    }

    public function name($name_value)
    {
        $this->name = $name_value;
        echo $this->phone . " " . $this->email . " " . $this->name;
    }

}

UserTwo::phone(1234)->email('aa@test.com')->name('aa');
