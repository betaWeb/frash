<?php
namespace LFW\Framework\Globals\Server;

/**
 * Class Server
 * @package LFW\Framework\Globals\Server
 */
class Server{
    /**
     * @return string
     */
    public function getUser(): string{
        return $_SERVER['USER'];
    }

    /**
     * @return string
     */
    public static function getPhpSelf(): string{
        return $_SERVER['PHP_SELF'];
    }

    /**
     * @return string
     */
    public static function getGatewayInterface(): string{
        return $_SERVER['GATEWAY_INTERFACE'];
    }

    /**
     * @return string
     */
    public static function getServerAddr(): string{
        return $_SERVER['SERVER_ADDR'];
    }

    /**
     * @return string
     */
    public static function getServerName(): string{
        return $_SERVER['SERVER_NAME'];
    }

    /**
     * @return string
     */
    public static function getServerSoftware(): string{
        return $_SERVER['SERVER_SOFTWARE'];
    }

    /**
     * @return string
     */
    public static function getServerProtocol(): string{
        return $_SERVER['SERVER_PROTOCOL'];
    }

    /**
     * @return string
     */
    public static function getRequestMethod(): string{
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return int
     */
    public static function getRequestTime(): int{
        return $_SERVER['REQUEST_TIME'];
    }

    /**
     * @return string
     */
    public static function getQueryString(): string{
        return $_SERVER['QUERY_STRING'];
    }

    /**
     * @return string
     */
    public static function getDocumentRoot(): string{
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * @return string
     */
    public static function getHttpAccept(): string{
        return $_SERVER['HTTP_ACCEPT'];
    }

    /**
     * @return string
     */
    public static function getHttpAcceptCharset(): string{
        return $_SERVER['HTTP_ACCEPT_CHARSET'];
    }

    /**
     * @return string
     */
    public static function getHttpAcceptEncoding(): string{
        return $_SERVER['HTTP_ACCEPT_ENCODING'];
    }

    /**
     * @return string
     */
    public static function getHttpAcceptLanguage(): string{
        return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }

    /**
     * @return string
     */
    public static function getHttpHost(): string{
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * @return string
     */
    public static function getHttpReferer(): string{
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * @return string
     */
    public static function getHttpUserAgent(): string{
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return string
     */
    public static function getHttps(): string{
        return $_SERVER['HTTPS'];
    }

    /**
     * @return string
     */
    public static function getRemoteAddr(): string{
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @return string
     */
    public static function getRemoteHost(): string{
        return $_SERVER['REMOTE_HOST'];
    }

    /**
     * @return int
     */
    public static function getRemotePort(): int{
        return $_SERVER['REMOTE_PORT'];
    }

    /**
     * @return string
     */
    public static function getScriptFilename(): string{
        return $_SERVER['SCRIPT_FILENAME'];
    }

    /**
     * @return string
     */
    public static function getServerAdmin(): string{
        return $_SERVER['SERVER_ADMIN'];
    }

    /**
     * @return int
     */
    public static function getServerPort(): int{
        return $_SERVER['SERVER_PORT'];
    }

    /**
     * @return string
     */
    public static function getServerSignature(): string{
        return $_SERVER['SERVER_SIGNATURE'];
    }

    /**
     * @return string
     */
    public static function getPathTranslated(): string{
        return $_SERVER['PATH_TRANSLATED'];
    }

    /**
     * @return string
     */
    public static function getScriptName(): string{
        return $_SERVER['SCRIPT_NAME'];
    }

    /**
     * @return string
     */
    public static function getRequestUri(): string{
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @return string
     */
    public static function getPhpAuthDigest(): string{
        return $_SERVER['PHP_AUTH_DIGEST'];
    }

    /**
     * @return string
     */
    public static function getPhpAuthUser(): string{
        return $_SERVER['PHP_AUTH_USER'];
    }

    /**
     * @return string
     */
    public static function getPhpAuthPw(): string{
        return $_SERVER['PHP_AUTH_PW'];
    }

    /**
     * @return string
     */
    public static function getAuthType(): string{
        return $_SERVER['AUTH_TYPE'];
    }

    /**
     * @return string
     */
    public static function getPathInfo(): string{
        return $_SERVER['PATH_INFO'];
    }

    /**
     * @return string
     */
    public static function getOrigPathInfo(): string{
        return $_SERVER['ORIG_PATH_INFO'];
    }

    /**
     * @return array
     */
    public static function getAllRequest(): array{
        return $_SERVER;
    }
}