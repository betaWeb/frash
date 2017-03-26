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
            'ajax' => '/\{\{ ajax \}\}/',
            'bundle' => '/\{\{ bundle (.*) \}\}/',
            'call' => '/\{\{ call (\w+) (.*) \}\}/',
            'else' => '/\{\{ else \}\}/',
            'elseif' => '/\{\{ elseif (.*) \}\}/',
            'escape_html' => '/\{\{ esc_html \}\}/',
            'escape_tpl' => '/\{\{ esc_tpl \}\}/',
            'end_condition' => '/\{\{ end_if \}\}/',
            'end_escape_html' => '/\{\{ end_esc_html \}\}/',
            'end_escape_tpl' => '/\{\{ end_esc_tpl \}\}/',
            'end_for' => '/\{\{ end_for \}\}/',
            'end_foreach' => '/\{\{ end_foreach \}\}/',
            'end_func' => '/\{\{ end_func \}\}/',
            'end_index' => '/\{\{ end_index \}\}/',
            'end_itvl' => '/\{\{ end_itvl \}\}/',
            'end_parts' => '/\{\{ end_part (\w+) \}\}/',
            'for' => '/\{\{ for (.*) \}\}/',
            'foreach' => '/\{\{ foreach (.*) :: (.*), (.*) \}\}/',
            'if' => '/\{\{ if (.*) \}\}/',
            'include' => '/\{\{ include (\w+) (.*) \}\}/',
            'index' => '/\{\{ index (.*) \}\}/',
            'internal' => '/\{\{ internal (.*) \}\}/',
            'itvl' => '/\{\{ itvl (.*) \}\}/',
            'parent' => '/\{\{ parent (\w+) \}\}/',
            'parts' => '/\{\{ part (\w+) \}\}/',
            'public' => '/\{\{ public (.*) \}\}/',
            'route' => '/\{\{ route (.*) \}\}/',
            'set_func' => '/\{\{ func (\w+)\((.*)\) \}\}/',
            'set_var' => '/\{\{ define (\w+) \}\}/',
            'show_func' => '/\{\{ _(\w+)\((.*)\) \}\}/',
            'show_var' => '/\{\{ @(.*) \}\}/',
            'show_var_for' => '/\{\{ !(.*) \}\}/',
            'traduction' => '/\{\{ traduction (.*) \}\}/'
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