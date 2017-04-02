<?php
namespace Frash\Framework\Exception;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Log\CreateLog;

/**
 * Class Exception
 * @package Frash\Framework\Exception
 */
class Exception{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * Exception constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic)
    {
        $this->dic = $dic;
    }

    /**
     * @param string $message
     */
    public function publish(string $message)
    {
        CreateLog::error($message, $this->dic->conf['config']['log']);

        ob_start();
        debug_print_backtrace();
        $data = ob_get_clean();

        $histo = explode("\n", $data);
        $count = count($histo) - 1;

        $histo_stacktrace = [];

        for($i = 0; $i < $count; $i++){
            if(preg_match('/\A#(\d*) /', $histo[ $i ], $match)){
                $histo_stacktrace[] = str_replace($match[0].' ', '', $histo[ $i ]);
            }
        }

        foreach($histo_stacktrace as $content){
            preg_match_all('/\[(.*)\]/Us', $content, $matches, PREG_SET_ORDER);
            $matches_pop = array_pop($matches);

            if(preg_match('/(.*):(\d+)/', $matches_pop[1], $match)){
                $cf = $this->contentFile($match[1], $match[2]);

                $stacktrace[] = [
                    'file' => $match[1],
                    'trace' => (strlen($content) > 200) ? $matches_pop[1] : $content,
                    'line' => $match[2],
                    'code_before' => $cf->content_before,
                    'code_line' => $cf->content_line,
                    'code_after' => $cf->content_after
                ];
            }
        }

        $this->dic->load('tpl')->internal('Exception', 'vendor/alixsperoza/frash/ressources/views/exception.tpl', [ 'true_route' => $this->dic->uri, 'stacktrace' => $stacktrace ]);
        die();
    }

    /**
     * @param string $file
     * @param string $line
     * @return object
     */
    private function contentFile(string $file, string $line)
    {
        $content_file = new \SplFileObject($file);

        $content_before = [];
        $content_after = [];

        $content_file->seek($line - 1);
        $content_line = [ $line => $content_file->current() ];

        $min = ($line < 11) ? $min = 1 : $line - 10;

        for($i = $min; $i < $line; $i++){
            $true_line = $i - 1;
            $content_file->seek($true_line);
            $content_before[ $true_line + 1 ] = $content_file->current();
        }

        $content_file->seek(PHP_INT_MAX);
        $nb_line = $content_file->key();
        $max = ($nb_line - $line < 11) ? $nb_line : $line + 10;

        for($i = $line + 1; $i <= $max; $i++){
            $true_line = $i - 1;
            $content_file->seek($true_line);
            $content_after[ $true_line + 1 ] = $content_file->current();
        }

        return (object) [ 'content_before' => $content_before, 'content_line' => $content_line, 'content_after' => $content_after ];
    }
}