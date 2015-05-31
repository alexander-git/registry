<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// Если YII_DEBUG === true, то в случае возникновения NOTICE, WARRING или 
// исключения отличного от CHttpException код ошибки будет установлен в  
// 500(Internal Server Error) и  будет отображён файл
// protectes/views/system/exception.php(если файл с таким же именем не  
// определен в текущей теме в themes, конечно). В exception.php выводится 
// подробная информация об ошибке или исключении.
// Если выброшено CHttpException, то будет отображён файл из 
// protectes/views/system/errorXXX.php(где XXX код состояния) или
// protectes/views/system/error.php если файла errorXXX для не найдено.
//
// Если YII_DEBUG === false, то в случае возникновения NOTICE, WARRING или 
// исключения отличного от CHttpException код ошибки будет установлен в  
// 500(Internal Server Error) и  будет отображён файл
// protectes/views/system/error500.php. Если выброшено CHttpException, то будет 
// отображён файл из protectes/views/system/errorXXX.php(где XXX код состояния) 
// или protectes/views/system/error.php если файла errorXXX для не найдено. 
// Так как YII_DEBUG === false, то некоторые переменные, используемые в файлах 
// errorХХХ.php и т.д., errorHandler из Yii определит как пустые строки и
// и пользователю будет отображен только минимум информации. Например, версии  
// apache, php, Yii отображается не будут.
// 
// Если  для компонета 'errorHandler' установлено свойство 'errorAction', то 
// вместо отображения файлов errorXXX.php вызываться действие контроллера
// определённое в этом свойстве. Т.е в случае YII_DEBUG === true это произойдет
// только в случае возникновения ChttpException. Если YII_DEBUG === false, то
// соответствующее действие контроллера будет вызываться для всех ошибок и
// исключений.  
//
// По умолчанию внутри фреймворка YII_DEBUG определено как false.
// Т.е. чтобы значение YII_DEBUG осталось false, нужно удалить или
// закомментировать следующую строку кода.
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);


// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
