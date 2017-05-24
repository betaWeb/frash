<?php
namespace Frash\Console\Framework;
use Configuration\Routing as RoutConf;
use Frash\Framework\DIC\Dic;
use Frash\Framework\FileSystem\{ Directory, File };

/**
 * Class Routing
 * @package Frash\Console\Framework
 */
class Routing
{
	public static function work()
	{
        $errors = [];

        $dic = new Dic('console');
        $dic->preloading();

        $call_routarr = new RoutConf($dic);
        $get = $call_routarr->list('get');
        $post = $call_routarr->list('post');

        foreach($get as $route => $precision){
            if(!is_callable($precision['path'])){
                list($bundle, $controller, $action) = explode(':', $precision['path']);

                if(!Directory::exist('Bundles/')){
                    $errors['general'][] = 'The Bundles directory does not exist.';
                }

                if(!Directory::exist('Bundles/'.$bundle.'/')) {
                    $errors['general'][] = 'The bundle '.$bundle.' does not exist.';
                }

                if(!Directory::exist('Bundles/'.$bundle.'/Controllers')) {
                    $errors['general'][] = 'The Controllers directory in '.$bundle.' does not exist.';
                }

                if(!file_exists('Bundles/'.$bundle.'/Controllers/'.$controller.'.php')) {
                    $errors['get'][] = 'Route '.$route.' ('.$precision['path'].') is invalid.';
                }
            }
        }

        foreach($post as $route => $precision){
            if(!is_callable($precision['path'])){
                list($bundle, $controller, $action) = explode(':', $precision['path']);

                if(!Directory::exist('Bundles/')){
                    $errors['general'][] = 'The Bundles directory does not exist.';
                }

                if(!Directory::exist('Bundles/'.$bundle.'/')) {
                    $errors['general'][] = 'The bundle '.$bundle.' does not exist.';
                }

                if(!Directory::exist('Bundles/'.$bundle.'/Controllers')) {
                    $errors['general'][] = 'The Controllers directory in '.$bundle.' does not exist.';
                }

                if(!file_exists('Bundles/'.$bundle.'/Controllers/'.$controller.'.php')) {
                    $errors['post'][] = 'Route '.$route.' ('.$precision['path'].') is invalid.';
                }
            }
        }

        if(!empty($errors['general'])){
            echo 'General :'.PHP_EOL;

            foreach($errors['general'] as $msg){
                echo $msg.PHP_EOL;
            }
        }

        if(!empty($errors['get'])){
            echo PHP_EOL.'GET :'.PHP_EOL;

            foreach($errors['get'] as $msg){
                echo $msg.PHP_EOL;
            }
        }

        if(!empty($errors['post'])){
            echo PHP_EOL.'POST :'.PHP_EOL;

            foreach($errors['post'] as $msg){
                echo $msg.PHP_EOL;
            }
        }
	}
}