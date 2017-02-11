<?php
namespace LFW\Console\Bundle;
use LFW\Console\CommandInterface;
use LFW\Console\Bundle\CreateBundle;

/**
 * Class GenerateBundle
 * @package LFW\Console\Bundle
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