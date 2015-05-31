<?php

class DateTimeHelper {
    
    // Объекты DateTime можно просто сравниваить операторами сравнения,
    // но эта возможность поддерживается начиная с определённой версии php.
    // На случай если возникнет необходимость  
    // 
    // Возвращает 1 если $firstDateTime > $secondDateTime, 
    // -1 если $firstDateTime < $secondDateTime
    // 0 - если $firstDateTime === $secondDateTime.
    public static function compare($firstDateTime, $secondDateTime) {
        if ($firstDateTime > $secondDateTime) {
            return 1;
        } else if ($firstDateTime < $secondDateTime) {
            return -1;
        } else {
            return 0;
        }    
    }
     
    private function __construct() {
         
    }
    
}