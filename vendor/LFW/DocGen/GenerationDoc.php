<?php
namespace LFW\DocGen;
use LFW\DocGen\Treatment\{ DirExist, DirsClass };
use LFW\DocGen\Treatment\Create\{ Css, Display };
use LFW\Framework\FileSystem\Directory;

/**
 * Class GenerationDoc
 * @package LFW\DocGen
 */
class GenerationDoc{
    /**
     * @param string $output
     * @param array $class
     */
	public static function work(string $output, array $class, string $pwd){
        DirExist::verif($output);
        Directory::create($output.'/src', 0770);
        DirsClass::work($class);

        Css::work($output);

        foreach($class as $k => $c){
            $rc = new \ReflectionClass($c);
            $name = (string) str_replace('\\', '/', $c);

            $const = $rc->getConstants();
            $method = $rc->getMethods();

            $pub_ob = $rc->getProperties(\ReflectionProperty::IS_PUBLIC);
            $prot_ob = $rc->getProperties(\ReflectionProperty::IS_PROTECTED);
            $priv_ob = $rc->getProperties(\ReflectionProperty::IS_PRIVATE);

            Display::work($output, $name, $class, $c, $pwd, $rc, $pub_ob, $prot_ob, $priv_ob);
        }
	}
}