<?php
namespace Frash\DocGen\Treatment\Create;
use Frash\DocGen\Treatment\Comments\CommentClass;
use Frash\DocGen\Treatment\Create\Summary;
use Frash\Framework\FileSystem\File;
use Frash\Framework\Request\Server\Console;

/**
 * Class Display
 * @package Frash\DocGen\Treatment\Create
 */
class Display{
    /**
     * @param string $name
     * @param array $class
     * @param string $c
     * @param string $rc
     * @param \ReflectionClass $pub_ob
     * @param \ReflectionClass $prot_ob
     * @param \ReflectionClass $priv_ob
     */
	public static function work(string $name, array $class, string $c, $rc, $pub_ob, $prot_ob, $priv_ob){
		$code = '<html>'."\n";
        $code .= '  <head>'."\n";
        $code .= '      <meta charset="UTF-8">'."\n";
        $code .= '      <title>'.$name.'</title>'."\n";
        $code .= '      <link rel="stylesheet" media="screen" type="text/css" href="/Storage/output/design.css">'."\n";
        $code .= '  </head>'."\n";
        $code .= '  <body>'."\n";
        $code .= '      <div id="corps">'."\n";
        $code .= '          <div id="summary">'."\n";
        $code .= Summary::work($class, Console::pwd());
        $code .= '          </div>'."\n";
        $code .= '          <div id="contenu">'."\n";
        $code .= '              <h2 id="title_class">'.$c.'</h2>'."\n";
        $code .= '              '.nl2br(CommentClass::work($rc->getDocComment()));
        $code .= '              <h2>Objects</h2>'."\n";
        $code .= '              <div class="div_object">'."\n";
        $code .= '                  <h3>public</h3>'."\n";
                                    foreach($pub_ob as $po){
                                        $code .= '                  '.$po->getName().'<br>'."\n";
                                    }
        $code .= '              </div>'."\n";
        $code .= '              <div class="div_object">'."\n";
        $code .= '                  <h3>protected</h3>'."\n";
                                    foreach($prot_ob as $po){
                                        $code .= '                  '.$po->getName().'<br>'."\n";
                                    }
        $code .= '              </div>'."\n";
        $code .= '              <div class="div_object">'."\n";
        $code .= '                  <h3>private</h3>'."\n";
                                    foreach($priv_ob as $po){
                                        $code .= '                  '.$po->getName().'<br>'."\n";
                                    }
        $code .= '              </div>'."\n";
        $code .= '          </div>'."\n";
        $code .= '      </div>'."\n";
        $code .= '  </body>'."\n";
        $code .= '</html>';

        File::create('Storage/output/src/'.$name.'.html', $code);
	}
}