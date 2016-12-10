<?php
	namespace LFW\DocGen;
    use LFW\DocGen\Treatment\DirExist;
    use LFW\DocGen\Treatment\DirsClass;
    use LFW\DocGen\Treatment\Comments\CommentClass;
    use LFW\DocGen\Treatment\Create\Css;
    use LFW\DocGen\Treatment\Create\Summary;
    use LFW\Framework\FileSystem\Directory;
    use LFW\Framework\FileSystem\File;

	class GenerationDoc{
		public static function work($output, $class){
            $json = json_decode(file_get_contents('Configuration/config.json'), true);
            $prefix = ($json['prefix'] == '/') ? '' : $json['prefix'];

            DirExist::verif($output);
            Directory::create($output.'/src', 0775);
            DirsClass::work($class);

            Css::work();

            foreach($class as $k => $c){
                $cl = new \ReflectionClass($c);
                $name = str_replace('\\', '/', $c);

                $const = $cl->getConstants();
                $prop = $cl->getProperties();
                $method = $cl->getMethods();

                $code = '<html>'."\n";
                $code .= '  <head>'."\n";
                $code .= '      <meta charset="UTF-8">'."\n";
                $code .= '      <title>'.$name.'</title>'."\n";
                $code .= '      <link rel="stylesheet" media="screen" type="text/css" href="'.$prefix.'/'.$output.'/design.css">'."\n";
                $code .= '  </head>'."\n";
                $code .= '  <body>'."\n";
                $code .= '      <div id="corps">'."\n";
                $code .= '          <div id="summary">'."\n";
                $code .= Summary::work($output.'/src', $class, $prefix);
                $code .= '          </div>'."\n";
                $code .= '          <div id="contenu">'."\n";
                $code .= '              <h2 id="title_class">'.$c.'</h2>'."\n";
                $code .= '              '.nl2br(CommentClass::work($cl->getDocComment()))."\n";
                $code .= '          </div>'."\n";
                $code .= '      </div>'."\n";
                $code .= '  </body>'."\n";
                $code .= '</html>';

                File::create($output.'/src/'.$name.'.html', $code);
            }
		}
	}