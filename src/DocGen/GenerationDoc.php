<?php
namespace Frash\DocGen;
use Frash\DocGen\Treatment\{ DirExist, DirsClass };
use Frash\DocGen\Treatment\Create\{ Css, Display };
use Frash\Framework\FileSystem\Directory;

/**
 * Class GenerationDoc
 * @package Frash\DocGen
 */
class GenerationDoc
{
    /**
     * @param array $class
     */
	public static function work(array $class)
    {
        DirExist::verif('Storage');
        DirExist::verif('Storage/output');

        Directory::create('Storage/output/src', 0770);
        DirsClass::work($class);

        Css::work();

        foreach($class as $k => $c){
            $rc = new \ReflectionClass($c);

            $const = $rc->getConstants();
            $method = $rc->getMethods();

            $pub_ob = $rc->getProperties(\ReflectionProperty::IS_PUBLIC);
            $prot_ob = $rc->getProperties(\ReflectionProperty::IS_PROTECTED);
            $priv_ob = $rc->getProperties(\ReflectionProperty::IS_PRIVATE);

            Display::work(str_replace('\\', '/', $c), $class, $c, $rc, $pub_ob, $prot_ob, $priv_ob);
        }
	}
}