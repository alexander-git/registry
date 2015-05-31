<?php

// Дополнительно генерирует цифры. Т.к. как стандартная Captcha выдаёт только буквы
class AdvancedCaptchaAction  extends CCaptchaAction {

    protected function generateVerifyCode()
    {
            if($this->minLength > $this->maxLength)
                    $this->maxLength = $this->minLength;
            if($this->minLength < 3)
                    $this->minLength = 3;
            if($this->maxLength > 20)
                    $this->maxLength = 20;
            $length = mt_rand($this->minLength,$this->maxLength);

            // Исключим o и 0 т.к. отличить их визуально может быть трудно.
            $lettersAndNumbers = 'bcdfghjklmnpqrstvwxyz123456789';                                              
            $vowels = 'aeiu';
            $code = '';
            for($i = 0; $i < $length; ++$i)
            {
                    if($i % 2 && mt_rand(0,10) > 2 || !($i % 2) && mt_rand(0,10) > 9)
                            $code.= $vowels[mt_rand(0, 3)];
                    else
                            $code.= $lettersAndNumbers[mt_rand(0,29)];
            }

            return $code;
    }

}