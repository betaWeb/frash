<?php
namespace LFW\Template\Parsing;

/**
 * Class ParseArray
 * @package LFW\Template\Parsing
 */
class ParseArray{
    /**
     * @var array
     */
	protected $parsing = [
		'bundle' => '/\[bundle (.*)\]/',
		'call' => '/\[call (\w+) (.*)\]/',
		'else' => '/\[else\]/',
		'elseif' => '/\[elseif (.*)\]/',
		'escape' => '/\[escape\]/',
		'end_condition' => '/\[\/condition\]/',
		'end_escape' => '/\[\/escape\]/',
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
		'internal' => '/\[internal (.*)\]/',
		'itvl' => '/\[itvl (.*)\]/',
		'parent' => '/\[parent (\w+)\]/',
		'parts' => '/\[part (\w+)\]/',
		'route' => '/\[route (.*)]/',
		'set_func' => '/\[func (\w+)\((.*)\)\]/',
		'set_var' => '/\[define (\w+)\]/',
		'show_func' => '/\[_(\w+)\((.*)\)\]/',
		'show_var' => '/\[@(.*)\]/',
		'show_var_for' => '/\[!(.*)\]/',
		'traduction' => '/\[traduction (.*)\]/'
	];
}