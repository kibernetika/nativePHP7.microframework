<?php
/**
 * Created by PhpStorm.
 * User: Test
 * Date: 06.10.2017
 * Time: 14:05
 */

namespace jobtest\core;

error_reporting(0);

// пользовательская функция для обработки ошибок
function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
    // временная метка возникновения ошибки
    $dt = date("Y-m-d H:i:s (T)");

    // определим ассоциативный массив соответствия всех
    // констант уровней ошибок с их названиями, хотя
    // в действительности мы будем рассматривать только
    // следующие типы: E_WARNING, E_NOTICE, E_USER_ERROR,
    // E_USER_WARNING и E_USER_NOTICE
    $errortype = array(
        E_ERROR => 'Ошибка',
        E_WARNING => 'Предупреждение',
        E_PARSE => 'Ошибка разбора исходного кода',
        E_NOTICE => 'Уведомление',
        E_CORE_ERROR => 'Ошибка ядра',
        E_CORE_WARNING => 'Предупреждение ядра',
        E_COMPILE_ERROR => 'Ошибка на этапе компиляции',
        E_COMPILE_WARNING => 'Предупреждение на этапе компиляции',
        E_USER_ERROR => 'Пользовательская ошибка',
        E_USER_WARNING => 'Пользовательское предупреждение',
        E_USER_NOTICE => 'Пользовательское уведомление',
        E_STRICT => 'Уведомление времени выполнения',
        E_RECOVERABLE_ERROR => 'Отлавливаемая фатальная ошибка'
    );
    // определим набор типов ошибок, для которых будет сохранен стек переменных
    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

    $err = "<errorentry>\n";
    $err .= "\t<datetime>" . $dt . "</datetime>\n";
    $err .= "\t<errornum>" . $errno . "</errornum>\n";
    $err .= "\t<errortype>" . $errortype[$errno] . "</errortype>\n";
    $err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
    $err .= "\t<scriptname>" . $filename . "</scriptname>\n";
    $err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";

    if (in_array($errno, $user_errors)) {
        $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Переменные") . "</vartrace>\n";
    }
    $err .= "</errorentry>\n\n";

    // для тестирования echo $err;

    // сохраняем в протокол ошибок, а если произошла пользовательская критическая ошибка, то отправляем письмо
    error_log($err, 3, "error.log");
    if ($errno == E_USER_ERROR) {
        mail("deni.ecybernetrics@gmail.com", "Пользовательская критическая ошибка", $err);
    }
}

$old_error_handler = set_error_handler("userErrorHandler");
