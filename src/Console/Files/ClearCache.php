<?php
namespace Frash\Console\Files;
use Frash\Console\CommandInterface;
use Frash\Framework\FileSystem\File;

/**
 * Class ClearCache
 * @package Frash\Console\Files
 */
class ClearCache implements CommandInterface{
    const PATH = 'Storage/Cache/Templating';

    /**
     * ClearCache constructor.
     * @param array $argv
     */
    public function __construct(array $argv){}

	public function work(){
		$dir_content = (array) scandir(self::PATH);

        if($dir_content !== false){
            foreach($dir_content as $entry){
                if(!in_array($entry, [ '.', '..' ])){
                    File::delete(self::PATH.'/'.$entry);
                }
            }
        }
	}
}