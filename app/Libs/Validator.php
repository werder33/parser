<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 06.04.2016
 * Time: 13:20
 */

namespace app\Libs;


class Validator
{
    public function lengthValid($string)
    {
        if (strlen($string) >= 50) {
            return false;
        } else {
            $result = $this->valid($string);
            if ($result == false) {
                return false;
            } else {
                return $result;
            }

        }
    }

    public function stringValid($options)
    {
        $pattern = '/[0-9<> @ # $ % . ^ & \/* ; \\"  + = ()]+/';
        $res = preg_match($pattern, $options);
        if ($res == 0) {
            return trim(htmlspecialchars($options));
        } else {
            return false;
        }
    }

    public function dateValid($date)
    {
        $pattern = '/^[1-2]\d{3}-\d{2}-\d{2}$/';
        $res = preg_match($pattern, $date);
        if ($res == 1) {
            $tooday = date('Y-m-d');
            if ($date >= $tooday) {
                return 1;
            } else {
                return $date;
            }
        } else {
            return 2;
        }
    }

    public function valid($text)
    {
        $res = trim(htmlspecialchars($text));
        return $res;
    }

    public function phoneValid($phone)
    {
        $pattern = '/^\+[1].\(\d{3}\).\d{3}-\d{4}$/';
        $res = preg_match($pattern, $phone);
        if ($res == 1) {
            return $phone;
        } else {
            return false;
        }

    }

    public function emailValid($email)
    {
        $pattern = '/.*@.*\..+/';
        $res = preg_match($pattern, $email);
        if ($res == 1) {
            return $email;
        } else {
            return false;
        }
    }


}