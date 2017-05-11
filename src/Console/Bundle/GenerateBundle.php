<?php
namespace Frash\Console\Bundle;
use Frash\Console\CommandInterface;
use Frash\Console\Bundle\CreateBundle;

/**
 * Class GenerateBundle
 * @package Frash\Console\Bundle
 */
class GenerateBundle implements CommandInterface
{
    /**
     * @var string
     */
    private $name = '';

    /**
     * GenerateBundle constructor.
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        $this->name = $argv[2];
    }

    public function work()
    {
        CreateBundle::verifDirExist();
        CreateBundle::createDir($this->name);
    }
}