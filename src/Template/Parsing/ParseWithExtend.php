<?php
namespace Frash\Template\Parsing;
use Frash\Framework\DIC\Dic;
use Frash\Template\DependTemplEngine;
use Frash\Template\Parsing\{ ParseArray, ParseParent, ParseTplParent };

/**
 * Class ParseWithExtend
 * @package Frash\Template\Parsing
 */
class ParseWithExtend extends ParseArray{
    /**
     * @var array
     */
    private $attributes = [
        'bundle' => '',
        'class_cache' => '',
        'tpl' => '',
        'parts_in_escape' => [],
        'display' => '',
        'level' => [ 'condition' => 0, 'escape_tpl' => 0, 'for' => 0, 'foreach' => 0, 'index' => 0, 'itvl' => 0, 'part' => 0 ],
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
    private $params = [];

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
     * @param array $params
     * @param DependTemplEngine $dic_t
     */
    public function __construct(string $tpl, array $extend, Dic $dic, array $params, DependTemplEngine $dic_t){
        $this->attributes['bundle'] = $dic->get('bundle');
        $this->dic_t = $dic_t;

        $class_trad = 'Traductions\\Trad'.ucfirst($dic->get('lang'));
        $this->trad = new $class_trad;

        $this->params = $params;
        $this->pp = new ParseParent($this->trad, $this->attributes['bundle'], $this->dic_t);
        $this->attributes['tpl'] = $tpl;

        $this->attributes['display'] = '	public function display(){'."\n";
        $this->attributes['display'] .= '		return \''.file_get_contents($this->determinatePathExtend(rtrim($extend[1]))).'\';'."\n";
        $this->attributes['display'] .= '	}'."\n\n";
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
                case (preg_match($this->extension['default']['escape_tpl'], $tag[0])):
                    $ext = $this->dic_t->callExtension()->parse('EscapeTpl', 'open', $this->attributes, [ 'match_all' => $match_all[ $key ] ]);
                    $this->returnExtension($ext);
                    break;
                case (preg_match($this->extension['default']['end_escape_tpl'], $tag[0])):
                    $ext = $this->dic_t->callExtension()->parse('EscapeTpl', 'close', $this->attributes, [ 'match_all' => $match_all[ $key ] ]);
                    $this->returnExtension($ext);
                    break;
                case $this->attributes['level']['escape_tpl'] == 0:
                    switch(true){
                        case preg_match($this->extension['default']['bundle'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('BundleParse', 'parse', $this->attributes, [ 'match' => $match_all[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['default']['call'], $tag[0]):
                            break;
                        case preg_match($this->extension['default']['else'], $tag[0]):
                            $condition[ $level['condition'] ][] = [ 'type' => 'else', 'condition' => 'else' ];
                            break;
                        case preg_match($this->extension['default']['elseif'], $tag[0]):
                            $condition[ $level['condition'] ][] = [ 'type' => 'elseif', 'condition' => $match_all[ $key ][2] ];
                            break;
                        case preg_match($this->extension['default']['end_condition'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ConditionParse', 'typeEnd', $this->attributes, [ 'condition' => $match_all[ $key ][2] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['default']['end_for'], $tag[0]):
                            break;
                        case preg_match($this->extension['default']['end_foreach'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ForeachParse', 'close', $this->attributes, [ 'match' => $match_all[ $key ], 'parsing' => $this->extension ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['default']['end_func'], $tag[0]):
                            preg_match('/\[func '.$function[1].'\('.$function[2].'\)\](.*)\[\/func\]/Us', $this->tpl, $match);
                            $this->class_cache .= $this->dic_t->extension('Func')->parse($function[1], $function[2], $match[1]);
                            $this->tpl = str_replace($match[0], '', $this->tpl);
                            break;
                        case preg_match($this->extension['default']['end_index'], $tag[0]):
                            break;
                        case preg_match($this->extension['default']['end_itvl'], $tag[0]):
                            break;
                        case preg_match($this->extension['default']['end_parts'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('Part', 'close', $this->attributes, [ 'match' => $match_all[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['default']['for'], $tag[0]):
                            break;
                        case preg_match($this->extension['default']['foreach'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ForeachParse', 'open', $this->attributes, [ 'match' => $match_all[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['default']['if'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ConditionParse', 'typeIf', $this->attributes, [ 'condition' => $match_all[ $key ][1] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['default']['include'], $tag[0]):
                            break;
                        case preg_match($this->extension['default']['index'], $tag[0]):
                            break;
                        case preg_match($this->extension['default']['itvl'], $tag[0]):
                            break;
                        case preg_match($this->extension['default']['parent'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('Part', 'parent', $this->attributes, [ 'match' => $match_all[ $key ], 'pp' => $this->pp ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['default']['parts'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('Part', 'open', $this->attributes, [ 'match' => $match_all[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['default']['public'], $tag[0]):
                            $this->tpl = str_replace($match_all[ $key ][0], $this->dic_t->extension('Public')->parse($match_all[ $key ][4]), $this->tpl);
                            break;
                        case preg_match($this->extension['default']['route'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('Route', 'parse', $this->attributes, [ 'match' => $match_all[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['default']['set_func'], $tag[0]):
                            if($level['part'] == 0){
                                preg_match('/\[func (\w+)\((.*)\)\]/', $tag[0], $match);
                                $function = $match;
                            }

                            break;
                        case preg_match($this->extension['default']['set_var'], $tag[0]):
                            preg_match('/\[define (\w+)\](.*)\[\/var\]/', $this->tpl, $set_var);
                            $this->params[$set_var[1]] = $set_var[2];

                            break;
                        case preg_match($this->extension['default']['show_var'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ShowVarParse', 'parse', $this->attributes, [ 'variable' => ltrim($match_all[ $key ][3], '@'), 'match' => $match_all[ $key ][0] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['default']['show_func'], $tag[0]):
                            preg_match('/\[_(\w+)\((.*)\)\]/', $tag[0], $match);
                            $this->tpl = str_replace($tag[0], '\'.$this->'.$match[1].'('.$match[2].').\'', $this->tpl);

                            break;
                        case preg_match($this->extension['default']['traduction'], $tag[0]):
                            $key_trad = $match_all[ $key ][3];
                            $this->attributes['tpl'] = str_replace($match_all[ $key ][0], str_replace('\'', "\'", $this->trad->$key_trad), $this->attributes['tpl']);
                            break;
                    }

                    break;
            }
        }

        $ptp = new ParseTplParent($this->trad, $this->attributes['bundle'], $this->attributes['display'], $this->dic_t);
        $this->attributes['display'] = $ptp->parse();
        $this->attributes['class_cache'] .= $this->attributes['display'];
        $this->removeUnuseParts();

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