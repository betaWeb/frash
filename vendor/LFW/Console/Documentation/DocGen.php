<?php
	namespace LFW\Console\Documentation;
    use LFW\Console\CommandInterface;
    use LFW\DocGen\{ GenerationDoc, ListDirFiles, TreatmentClass, TreatmentList };

	class DocGen implements CommandInterface{
		public function __construct(array $argv){}

		public function work(){
			fwrite(STDOUT, 'Dossier de sortie : ');
            $output = trim(fgets(STDIN));

            fwrite(STDOUT, 'Exceptions (Séparez par ;) : ');
            $except = trim(fgets(STDIN));

            $list = ListDirFiles::generation(getcwd());
            TreatmentList::setExcept($except);
            $new_list = TreatmentList::removeExcept($list);

            TreatmentClass::generationClass($new_list);
            GenerationDoc::work($output, TreatmentClass::getClass());
		}
	}