<?php
namespace LFW\Framework\Request\Server;

/**
 * Class Server
 * @package LFW\Framework\Request\Server
 */
class Server{
    /**
     * @return bool
     */
    public static function refresh(): bool{
        if(isset($_SERVER['HTTP_CACHE_CONTROL']) && ($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' || $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache')){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public static function gatewayInterface(): string{
        return $_SERVER['GATEWAY_INTERFACE'];
    }

    /**
     * @return string
     */
    public static function user(): string{
        return $_SERVER['USER'];
    }

    /**
     * @return string
     */
    public static function phpSelf(): string{
        return $_SERVER['PHP_SELF'];
    }

    /**
     * @return string
     */
    public static function serverAddr(): string{
        return $_SERVER['SERVER_ADDR'];
    }

    /**
     * @return string
     */
    public static function serverName(): string{
        return $_SERVER['SERVER_NAME'];
    }

    /**
     * @return string
     */
    public static function serverSoftware(): string{
        return $_SERVER['SERVER_SOFTWARE'];
    }

    /**
     * @return string
     */
    public static function serverProtocol(): string{
        return $_SERVER['SERVER_PROTOCOL'];
    }

    /**
     * @return string
     */
    public static function requestMethod(): string{
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return int
     */
    public static function requestTime(): int{
        return $_SERVER['REQUEST_TIME'];
    }

    /**
     * @return string
     */
    public static function queryString(): string{
        return $_SERVER['QUERY_STRING'];
    }

    /**
     * @return string
     */
    public static function documentRoot(): string{
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * @return string
     */
    public static function httpAccept(): string{
        return $_SERVER['HTTP_ACCEPT'];
    }

    /**
     * @return string
     */
    public static function httpAcceptCharset(): string{
        return $_SERVER['HTTP_ACCEPT_CHARSET'];
    }

    /**
     * @return string
     */
    public static function httpAcceptEncoding(): string{
        return $_SERVER['HTTP_ACCEPT_ENCODING'];
    }

    /**
     * @return string
     */
    public static function httpAcceptLanguage(): string{
        return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }

    /**
     * @return string
     */
    public static function httpHost(): string{
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * @return string
     */
    public static function httpReferer(): string{
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * @return string
     */
    public static function httpUserAgent(): string{
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return string
     */
    public static function https(): string{
        return $_SERVER['HTTPS'];
    }

    /**
     * @return string
     */
    public static function remoteAddr(): string{
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @return string
     */
    public static function remoteHost(): string{
        return $_SERVER['REMOTE_HOST'];
    }

    /**
     * @return int
     */
    public static function remotePort(): int{
        return $_SERVER['REMOTE_PORT'];
    }

    /**
     * @return string
     */
    public static function scriptFilename(): string{
        return $_SERVER['SCRIPT_FILENAME'];
    }

    /**
     * @return string
     */
    public static function serverAdmin(): string{
        return $_SERVER['SERVER_ADMIN'];
    }

    /**
     * @return int
     */
    public static function serverPort(): int{
        return $_SERVER['SERVER_PORT'];
    }

    /**
     * @return string
     */
    public static function serverSignature(): string{
        return $_SERVER['SERVER_SIGNATURE'];
    }

    /**
     * @return string
     */
    public static function pathTranslated(): string{
        return $_SERVER['PATH_TRANSLATED'];
    }

    /**
     * @return string
     */
    public static function scriptName(): string{
        return $_SERVER['SCRIPT_NAME'];
    }

    /**
     * @return string
     */
    public static function requestUri(): string{
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @return string
     */
    public static function phpAuthDigest(): string{
        return $_SERVER['PHP_AUTH_DIGEST'];
    }

    /**
     * @return string
     */
    public static function phpAuthUser(): string{
        return $_SERVER['PHP_AUTH_USER'];
    }

    /**
     * @return string
     */
    public static function phpAuthPw(): string{
        return $_SERVER['PHP_AUTH_PW'];
    }

    /**
     * @return string
     */
    public static function authType(): string{
        return $_SERVER['AUTH_TYPE'];
    }

    /**
     * @return string
     */
    public static function pathInfo(): string{
        return $_SERVER['PATH_INFO'];
    }

    /**
     * @return string
     */
    public static function origPathInfo(): string{
        return $_SERVER['ORIG_PATH_INFO'];
    }

    /**
     * @return array
     */
    public static function getAllRequest(): array{
        return $_SERVER;
    }
}