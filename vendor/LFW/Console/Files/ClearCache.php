<?php
	namespace LFW\Console\Files;
	use LFW\Framework\FileSystem\File;

    /**
     * Class ClearCache
     * @package LFW\Console\Files
     */
	class ClearCache{
        /**
         * @param string $path
         */
		public function work(string $path){
			$dir_content = scandir($path);

            if($dir_content !== FALSE){
                foreach($dir_content as $entry){
                    if(!in_array($entry, [ '.', '..' ])){
                        $entry = $path.'/'.$entry;

                        if(!is_dir($entry)){
                            File::delete($entry);
                        }
                        else{
                            $this->work($entry);
                        }
                    }
                }
            }
		}
	}