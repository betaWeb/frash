<?php
namespace Frash\Template\Parsing;
use Frash\Framework\DIC\Dic;
use Frash\Template\DependTemplEngine;
use Frash\Template\Parsing\ParseArray;

/**
 * Class ParseWithoutExtend
 * @package Frash\Template\Parsing
 */
class ParseWithoutExtend extends ParseArray{
    /**
     * @var string
     */
    private $bundle = '';

    /**
     * @var string
     */
    private $class_cache = '';

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var string
     */
    private $tpl = '';

    /**
     * @var object
     */
    private $trad;

    /**
     * @var DependTemplEngine
     */
    private $dic_t;

    /**
     * ParseWithoutExtend constructor.
     * @param string $tpl
     * @param Dic $dic
     * @param array $params
     * @param DependTemplEngine $dic_t
     */
    public function __construct(string $tpl, Dic $dic, array $params, DependTemplEngine $dic_t){
        $this->bundle = $dic->get('bundle');
        $this->dic_t = $dic_t;

        $class_trad = 'Traductions\\Trad'.ucfirst($dic->get('lang'));
        $this->trad = new $class_trad;

        $this->params = $params;
        $this->tpl = $tpl;
    }

    /**
     * @return string
     */
    public function parse(): string{
        $level_condition = 0;
        $level_escape = 0;
        $level_for = 0;
        $level_for_itvl = 0;
        $level_index = 0;
        $level_foreach = 0;

        $condition = [];
        $foreach = [];

        preg_match_all('/\[(\/?)(([a-zA-Z]*)?\s?([a-zA-Z0-9\/@_!=:",\.\s]*))\]/', $this->tpl, $match_all, PREG_SET_ORDER);
        foreach($match_all as $key => $tag){
            switch(true){
                case (preg_match($this->parsing['escape'], $tag[0])):
                    $level_escape++;
                    break;
                case (preg_match($this->parsing['end_escape'], $tag[0])):
                    preg_match('/\[escape\](.*)\[\/escape\]/Us', $this->tpl, $match);
                    $this->class_cache .= $this->dic_t->load('Escape')->parse($match);
                    $this->tpl = str_replace($match[0], '\'.$this->escape'.md5($match[1]).'().\'', $this->tpl);
                    $level_escape--;
                    break;
                case $level_escape == 0:
                    switch(true){
                        case preg_match($this->parsing['bundle'], $tag[0]):
                            if($level_foreach == 0 && $level_for == 0 && $level_index == 0 && $level_for_itvl == 0){
                                $this->tpl = str_replace($match_all[ $key ][0], $this->dic_t->load('Bundle')->parse($match_all[ $key ][4], $this->bundle), $this->tpl);
                            }

                            break;
                        case preg_match($this->parsing['call'], $tag[0]):
                            break;
                        case preg_match($this->parsing['else'], $tag[0]):
                            $condition[ $level_condition ][] = [ 'type' => 'else', 'condition' => 'else' ];
                            break;
                        case preg_match($this->parsing['elseif'], $tag[0]):
                            $condition[ $level_condition ][] = [ 'type' => 'elseif', 'condition' => $match_all[ $key ][2] ];
                            break;
                        case preg_match($this->parsing['end_condition'], $tag[0]):
                            $condition[ $level_condition ][] = [ 'type' => 'end', 'condition' => '/condition' ];

                            $cp = $this->dic_t->load('Condition')->parse($condition[ $level_condition ], $this->tpl);
                            $this->class_cache .= $cp['code'];
                            $this->tpl = str_replace($cp['replace'], '\'.$this->'.$cp['name'].'().\'', $this->tpl);

                            unset($condition[ $level_condition ]);
                            $level_condition--;
                            break;
                        case preg_match($this->parsing['end_for'], $tag[0]):
                            break;
                        case preg_match($this->parsing['end_foreach'], $tag[0]):
                            preg_match('/\[foreach '.$foreach[ $level_foreach ]['param'].'\](.*)\[\/foreach\]/Us', $this->tpl, $match);
                            $this->class_cache .= $this->dic_t->load('Foreach')->parse($foreach[ $level_foreach ]['param'], $match[1]);
                            $this->tpl = str_replace($match[0], '\'.$this->foreach'.md5($foreach[ $level_foreach ]['param']).'().\'', $this->tpl);
                            $level_foreach--;
                            break;
                        case preg_match($this->parsing['end_func'], $tag[0]):
                            break;
                        case preg_match($this->parsing['end_index'], $tag[0]):
                            break;
                        case preg_match($this->parsing['end_itvl'], $tag[0]):
                            break;
                        case preg_match($this->parsing['for'], $tag[0]):
                            break;
                        case preg_match($this->parsing['foreach'], $tag[0]):
                            $level_foreach++;
                            $foreach[ $level_foreach ] = [ 'foreach' => $match_all[ $key ][0], 'param' => $match_all[ $key ][4] ];
                            break;
                        case preg_match($this->parsing['if'], $tag[0]):
                            $level_condition++;
                            $condition[ $level_condition ][] = [ 'type' => 'if', 'condition' => $match_all[ $key ][2] ];
                            break;
                        case preg_match($this->parsing['include'], $tag[0]):
                            break;
                        case preg_match($this->parsing['index'], $tag[0]):
                            break;
                        case preg_match($this->parsing['internal'], $tag[0]):
                            $this->tpl = str_replace($match_all[ $key ][0], $this->dic_t->load('Bundle')->internal($match_all[ $key ][4]), $this->tpl);
                            break;
                        case preg_match($this->parsing['itvl'], $tag[0]):
                            break;
                        case preg_match($this->parsing['route'], $tag[0]):
                            if($level_foreach == 0 && $level_for == 0 && $level_index == 0 && $level_for_itvl == 0){
                                $this->tpl = str_replace($match_all[ $key ][0], $this->dic_t->load('Route')->parse($match_all[ $key ][4]), $this->tpl);
                            }

                            break;
                        case preg_match($this->parsing['set_func'], $tag[0]):
                            break;
                        case preg_match($this->parsing['set_var'], $tag[0]):
                            if($level_foreach == 0 && $level_for == 0 && $level_index == 0 && $level_for_itvl == 0){
                                preg_match('/\[\@(\w+)\](.*)\[\/var]/', $this->tpl, $set_var);
                                $this->params[$set_var[1]] = $set_var[2];
                            }

                            break;
                        case preg_match($this->parsing['show_var'], $tag[0]):
                            if($level_foreach == 0 && $level_for == 0 && $level_index == 0 && $level_for_itvl == 0){
                                $variable = $this->dic_t->load('ShowVar')->parse(ltrim($match_all[ $key ][4], '@'));
                                $this->tpl = str_replace($match_all[ $key ][0], $variable, $this->tpl);
                            }

                            break;
                        case preg_match($this->parsing['traduction'], $tag[0]):
                            $this->tpl = str_replace($match_all[ $key ][0], str_replace('\'', "\'", $this->trad->show($match_all[ $key ][4])), $this->tpl);
                            break;
                    }

                    break;
            }
        }

        $this->class_cache .= '		public function display(){'."\n";
        $this->class_cache .= '			return \''.$this->tpl.'\';'."\n";
        $this->class_cache .= '		}'."\n\n";

        return $this->class_cache;
    }
}