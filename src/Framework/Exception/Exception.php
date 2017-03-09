<?php
namespace Frash\Framework\Exception;
use Frash\Framework\Log\CreateLog;

/**
 * Class Exception
 * @package Frash\Framework\Exception
 */
class Exception{
    /**
     * Exception constructor.
     * @param string $message
     * @param array $conf
     */
    public function __construct(string $message, array $conf){
        CreateLog::error($message, $conf);

        ob_start();
        debug_print_backtrace();
        $data = ob_get_clean();

        echo '<pre>'; print_r($data); echo '</pre>';

        header('HTTP/1.0 404 Not Found', true, 404);
        die();
    }
}