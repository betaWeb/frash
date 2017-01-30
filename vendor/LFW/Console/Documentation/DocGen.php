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
	public function __construct(array $argv){
        $this->pwd = $pwd;
    }

	public function work(){
		fwrite(STDOUT, 'Dossier de sortie : ');
        $output = (string) trim(fgets(STDIN));

        fwrite(STDOUT, 'Exceptions (Séparez par ;) : ');
        $except = trim(fgets(STDIN));

        fwrite(STDOUT, 'Prefix : ');
        $prefix = trim(fgets(STDIN));

        $list = ListDirFiles::generation(getcwd());
        TreatmentList::setExcept($except);
        $new_list = TreatmentList::removeExcept($list);

        TreatmentClass::generationClass($new_list);
        GenerationDoc::work($output, TreatmentClass::getClass(), $prefix);
	}
}