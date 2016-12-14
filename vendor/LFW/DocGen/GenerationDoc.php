<?php
	namespace LFW\DocGen;
    use LFW\DocGen\Treatment\{ DirExist, DirsClass };
    use LFW\DocGen\Treatment\Create\{ Css, Display };
    use LFW\Framework\FileSystem\{ Directory, Json };

    /**
     * Class GenerationDoc
     * @package LFW\DocGen
     */
	class GenerationDoc{
        /**
         * @param string $output
         * @param string $class
         */
		public static function work($output, $class){
            $json = Json::importConfigArray();
            $prefix = ($json['prefix'] == '/') ? '' : $json['prefix'];

            DirExist::verif($output);
            Directory::create($output.'/src', 0775);
            DirsClass::work($class);

            Css::work($output);

            foreach($class as $k => $c){
                $rc = new \ReflectionClass($c);
                $name = str_replace('\\', '/', $c);

                $const = $rc->getConstants();
                $method = $rc->getMethods();

                $pub_ob = $rc->getProperties(\ReflectionProperty::IS_PUBLIC);
                $prot_ob = $rc->getProperties(\ReflectionProperty::IS_PROTECTED);
                $priv_ob = $rc->getProperties(\ReflectionProperty::IS_PRIVATE);

                Display::work($output, $name, $class, $c, $prefix, $rc, $pub_ob, $prot_ob, $priv_ob);
            }
		}
	}