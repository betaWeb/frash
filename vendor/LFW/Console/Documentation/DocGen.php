<?php
namespace LFW\Console\Documentation;
use LFW\Console\CommandInterface;
use LFW\DocGen\{ GenerationDoc, ListDirFiles, TreatmentClass, TreatmentList };

/**
 * Class DocGen
 * @package LFW\Console\Documentation
 */
class DocGen implements CommandInterface{
    /**
     * DocGen constructor.
     * @param array $argv
     */
	public function __construct(array $argv){}

	public function work(){
        fwrite(STDOUT, 'Exceptions (Séparez par ;) : ');
        $except = trim(fgets(STDIN));

        $list = ListDirFiles::generation(getcwd());
        TreatmentList::setExcept($except);
        $new_list = TreatmentList::removeExcept($list);

        TreatmentClass::generationClass($new_list);
        GenerationDoc::work(TreatmentClass::getClass());
	}
}