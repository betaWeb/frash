<?php
namespace Frash\Framework\Request\Server;

/**
 * Class Console
 * @package Frash\Framework\Request\Server
 */
class Console{
    /**
     * @return string
     */
    public static function home(): string
    {
        return $_SERVER['HOME'];
    }

    /**
     * @return string
     */
    public static function hushLogin(): string
    {
        return $_SERVER['HUSHLOGIN'];
    }

    /**
     * @return string
     */
    public static function lang(): string
    {
        return $_SERVER['LANG'];
    }

    /**
     * @return string
     */
    public static function mail(): string
    {
        return $_SERVER['MAIL'];
    }

    /**
     * @return string
     */
    public static function path(): string
    {
        return $_SERVER['PATH'];
    }

    /**
     * @return string
     */
    public static function pwd(): string
    {
        return $_SERVER['PWD'];
    }

    /**
     * @return string
     */
    public static function shell(): string
    {
        return $_SERVER['SHELL'];
    }

    /**
     * @return string
     */
    public static function shlvl(): string
    {
        return $_SERVER['SHLVL'];
    }

    /**
     * @return string
     */
    public static function getHushLogin(): string
    {
        return $_SERVER['HUSHLOGIN'];
    }

    /**
     * @return string
     */
    public static function term(): string
    {
        return $_SERVER['TERM'];
    }

    /**
     * @return string
     */
    public static function user(): string
    {
        return $_SERVER['USER'];
    }

    /**
     * @return string
     */
    public static function phpSelf(): string
    {
        return $_SERVER['PHP_SELF'];
    }

    /**
     * @return string
     */
    public static function scriptName(): string
    {
        return $_SERVER['SCRIPT_NAME'];
    }

    /**
     * @return string
     */
    public static function scriptFilename(): string
    {
        return $_SERVER['SCRIPT_FILENAME'];
    }

    /**
     * @return string
     */
    public static function pathTranslated(): string
    {
        return $_SERVER['PATH_TRANSLATED'];
    }

    /**
     * @return array
     */
    public static function argv(): array
    {
        return $_SERVER['argv'];
    }

    /**
     * @return array
     */
    public static function argc(): array
    {
        return $_SERVER['argc'];
    }

    /**
     * @return array
     */
    public static function all(): array
    {
        return $_SERVER;
    }
}