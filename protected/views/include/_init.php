<?php
if (!isset($assetUrl) || !isset($clientScript) ) {
    // _init.php необходимо подключать в остальные файлы из этой папки 
    // с помощью require, а не require_once. Это необходимо т.к. сами эти "остальные" файлы
    // подключаются в вид с помощью функции renderPartial. 
    // Например, если необходимо подключить два файла, то функция 
    // renderPartial будет вызвана два раза. Если вместо require использовать require_once, то
    // во втором вызове файл _init.php подключен не будет, а т.к. область видимости у 
    // переменных для каждого вызова renderPartial своя, то переменнные задаваемые 
    // в этом файле определены не будут. Но они используются в "остальных" файлах - произойдёт ошибка.
    // С другой стороны этот файл может быть подключён несколько раз и при одном вызове renderPartial.
    // В этом случае при повторном подключении за счёт проверки будет видно, что 
    // переменные уже определены и повторно это делать нет необходимости.
    $assetsUrl = $this->assetsUrl;
    $clientScript = Yii::app()->clientScript;
}
