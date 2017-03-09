<?php
namespace Frash\Template\Parsing;

/**
 * Class ParseArray
 * @package Frash\Template\Parsing
 */
class ParseArray{
    /**
     * @var array
     */
	protected $extension = [
	    'default' => [
            'bundle' => '/\[bundle (.*)\]/',
            'call' => '/\[call (\w+) (.*)\]/',
            'else' => '/\[else\]/',
            'elseif' => '/\[elseif (.*)\]/',
            'escape_tpl' => '/\[escape_tpl\]/',
            'end_condition' => '/\[\/condition\]/',
            'end_escape_tpl' => '/\[\/escape_tpl\]/',
            'end_for' => '/\[\/for\]/',
            'end_foreach' => '/\[\/foreach\]/',
            'end_func' => '/\[\/func\]/',
            'end_index' => '/\[\/index\]/',
            'end_itvl' => '/\[\/itvl\]/',
            'end_parts' => '/\[\/part (\w+)\]/',
            'for' => '/\[for (.*)\]/',
            'foreach' => '/\[foreach (.*) :: (.*), (.*)\]/',
            'if' => '/\[if (.*)\]/',
            'include' => '/\[include (\w+) (.*)\]/',
            'index' => '/\[index (.*)\]/',
            'itvl' => '/\[itvl (.*)\]/',
            'parent' => '/\[parent (\w+)\]/',
            'parts' => '/\[part (\w+)\]/',
            'public' => '/\[public (.*)\]/',
            'route' => '/\[route (.*)\]/',
            'set_func' => '/\[func (\w+)\((.*)\)\]/',
            'set_var' => '/\[define (\w+)\]/',
            'show_func' => '/\[_(\w+)\((.*)\)\]/',
            'show_var' => '/\[@(.*)\]/',
            'show_var_for' => '/\[!(.*)\]/',
            'traduction' => '/\[traduction (.*)\]/'
        ],
        'custom' => []
	];

    /**
     * @param string $name
     * @param string $regex
     */
    public function setCustomExtension(string $name, string $regex){
        $this->extension['custom'][ $name ] = $regex;
    }
}