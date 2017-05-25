<?php
namespace Frash\Template\Parsing;
use Frash\Framework\DIC\Dic;
use Frash\Template\{ DependTemplEngine, RegexParse };
use Frash\Template\Parsing\{ ParseParent, ParseTplParent };

/**
 * Class Parser
 * @package Frash\Template\Parsing
 */
class Parser extends RegexParse{
    /**
     * @var array
     */
    private $attributes = [
        'bundle' => '',
        'class_cache' => '',
        'tpl' => '',
        'params' => [],
        'parts_in_escape' => [],
        'display' => '',
        'level' => [ 'condition' => 0, 'esc_tpl' => 0, 'for' => 0, 'foreach' => 0, 'index' => 0, 'itvl' => 0, 'part' => 0 ],
        'count' => [ 'general' => 0, 'condition' => 0, 'esc_tpl' => 0, 'for' => 0, 'foreach' => 0, 'index' => 0, 'itvl' => 0, 'part' => 0 ],
        'condition' => [],
        'foreach' => [],
        'function' => [],
        'parts' => []
    ];

    /**
     * @var DependTemplEngine
     */
    private $dic_t;

    /**
     * @var array
     */
    private $extend = [];

    /**
     * @var ParseParent
     */
    private $pp;

    /**
     * @var object
     */
    private $trad;

    /**
     * ParseWithExtend constructor.
     * @param string $tpl
     * @param array $extend
     * @param Dic $dic
     * @param DependTemplEngine $dic_t
     */
    public function __construct(string $tpl, array $extend, Dic $dic, DependTemplEngine $dic_t){
        $this->dic = $dic;
        $this->dic_t = $dic_t;
        $this->extend = $extend;

        $class_trad = 'Traductions\\Trad'.ucfirst($dic->lang);
        $this->trad = new $class_trad;

        $this->attributes['bundle'] = $dic->bundle;
        $this->attributes['params'] = $dic_t->get('params');
        $this->attributes['tpl'] = $tpl;

        if($extend[0] != 'no'){
            $this->pp = new ParseParent($this->trad, $this->attributes['bundle'], $this->dic_t);

            $this->attributes['display'] = '    public function display(){'."\n";
            $this->attributes['display'] .= '       $content = \''.file_get_contents($this->determinatePathExtend(rtrim($extend[1]))).'\';'."\n\n";
            $this->attributes['display'] .= '       return $content;'."\n";
            $this->attributes['display'] .= '   }'."\n";
        }
    }

    /**
     * @param object $return
     */
    private function returnExtension($return){
        $infos = $return->getInfos();
        $this->attributes['class_cache'] = $infos['class_cache'];
        $this->attributes['condition'] = $infos['condition'];
        $this->attributes['display'] = $infos['display'];
        $this->attributes['foreach'] = $infos['foreach'];
        $this->attributes['function'] = $infos['function'];
        $this->attributes['level'] = $infos['level'];
        $this->attributes['count'] = $infos['count'];
        $this->attributes['params'] = $infos['params'];
        $this->attributes['parts'] = $infos['parts'];
        $this->attributes['parts_in_escape'] = $infos['parts_in_escape'];
        $this->attributes['tpl'] = $infos['tpl'];
    }

    /**
     * @return string
     */
    public function parse(): string{
        preg_match_all('/\{\{ (([a-zA-Z_]*)?\s?([a-zA-Z0-9\/@\$\_!=:;+",<>\[\]\(\)\-\.\s]*)) \}\}/', $this->attributes['tpl'], $match_all, PREG_SET_ORDER);
        foreach($match_all as $key => $tag){
            switch(true){
                case (preg_match($this->extension['escape']['tpl']['open'], $tag[0])):
                    $ext = $this->dic_t->callExtension()->parse('EscapeTpl', 'open', $this->attributes, [ 'match_all' => $match_all[ $key ] ]);
                    $this->returnExtension($ext);
                    break;
                case (preg_match($this->extension['escape']['tpl']['close'], $tag[0])):
                    $ext = $this->dic_t->callExtension()->parse('EscapeTpl', 'close', $this->attributes, [ 'match_all' => $match_all[ $key ] ]);
                    $this->returnExtension($ext);
                    break;
                case $this->attributes['level']['esc_tpl'] == 0:
                    switch(true){
                        case preg_match($this->extension['bundle'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('BundleParse', 'parse', $this->attributes, [ 'match' => $match_all[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['call'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('CallParse', 'parse', $this->attributes, [ 'match' => $match_all[ $key ], 'dic' => $this->dic ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['condition']['else'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ConditionParse', 'typeElse', $this->attributes, [ 'condition' => $match_all[ $key ][1] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['condition']['elseif'], $tag[0]):
                            $condition[ $level['condition'] ][] = [ 'type' => 'elseif', 'condition' => $match_all[ $key ][2] ];
                            break;
                        case preg_match($this->extension['condition']['end'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ConditionParse', 'typeEnd', $this->attributes, [ 'condition' => $match_all[ $key ][2] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['escape']['html']['close'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('EscapeHtmlParse', 'close', $this->attributes);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['loop']['for']['close'], $tag[0]):
                            break;
                        case preg_match($this->extension['loop']['foreach']['close'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ForeachParse', 'close', $this->attributes, [ 'match' => $match_all[ $key ], 'parsing' => $this->extension ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['loop']['index']['close'], $tag[0]):
                            break;
                        case preg_match($this->extension['loop']['itvl']['close'], $tag[0]):
                            break;
                        case preg_match($this->extension['parts']['close'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('Part', 'close', $this->attributes, [ 'match' => $match_all[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['escape']['html']['open'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('EscapeHtmlParse', 'open', $this->attributes);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['loop']['for']['open'], $tag[0]):
                            break;
                        case preg_match($this->extension['loop']['foreach']['open'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ForeachParse', 'open', $this->attributes, [ 'match' => $match_all[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['condition']['if'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ConditionParse', 'typeIf', $this->attributes, [ 'condition' => $match_all[ $key ][1] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['include'], $tag[0]):
                            break;
                        case preg_match($this->extension['loop']['index']['open'], $tag[0]):
                            break;
                        case preg_match($this->extension['internal'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('BundleParse', 'internal', $this->attributes, [ 'match' => $match_all[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['loop']['itvl']['open'], $tag[0]):
                            break;
                        case preg_match($this->extension['parts']['parent'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('Part', 'parent', $this->attributes, [ 'match' => $match_all[ $key ], 'pp' => $this->pp ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['parts']['open'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('Part', 'open', $this->attributes, [ 'match' => $match_all[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['public'], $tag[0]):
                            $this->tpl = str_replace($match_all[ $key ][0], $this->dic_t->extension('Public')->parse($match_all[ $key ][4]), $this->tpl);
                            break;
                        case preg_match($this->extension['route'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('Route', 'parse', $this->attributes, [ 'match' => $match_all[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['set_var'], $tag[0]):
                            preg_match('/\[define (\w+)\](.*)\[\/var\]/', $this->tpl, $set_var);
                            $this->attributes['params'][$set_var[1]] = $set_var[2];

                            break;
                        case preg_match($this->extension['show_var'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ShowVarParse', 'parse', $this->attributes, [ 'variable' => ltrim($match_all[ $key ][3], '$'), 'match' => $match_all[ $key ][0] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['traduction'], $tag[0]):
                            $key_trad = $match_all[ $key ][3];
                            $this->attributes['tpl'] = str_replace($match_all[ $key ][0], str_replace('\'', "\'", $this->trad->$key_trad), $this->attributes['tpl']);
                            break;
                    }

                    break;
            }
        }

        if($this->extend[0] != 'no'){
            $ptp = new ParseTplParent($this->trad, $this->attributes, $this->dic_t);
            $this->attributes['display'] = $ptp->parse();
            $this->attributes['class_cache'] .= $this->attributes['display'];
            $this->removeUnuseParts();
        } else {
            $this->attributes['class_cache'] .= '       public function display(){'."\n";
            $this->attributes['class_cache'] .= '           $content = \''.$this->attributes['tpl'].'\';'."\n";
            $this->attributes['class_cache'] .= '           return $content;'."\n";
            $this->attributes['class_cache'] .= '       }'."\n";
        }

        return $this->attributes['class_cache'];
    }

    /**
     * @param string $extend
     * @return string
     */
    private function determinatePathExtend(string $extend): string{
        if(strstr($extend, '::')){
            list($bundle, $file) = explode('::', $extend);
        } else {
            $file = $extend;
            $bundle = $this->attributes['bundle'];
        }

        return 'Bundles/'.$bundle.'/Views/'.$file;
    }

    private function removeUnuseParts(){
        preg_match_all('/\{\{ part (\w+) \}\}(.*)\{\{ end_part (\w+) \}\}/Us', $this->attributes['class_cache'], $unuse, PREG_SET_ORDER);
        foreach($unuse as $u){
            if(!in_array($u[1], $this->attributes['parts_in_escape'])){
                $this->attributes['class_cache'] = str_replace($u[0], '', $this->attributes['class_cache']);
            }
        }
    }
}