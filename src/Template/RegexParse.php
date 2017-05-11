<?php
namespace Frash\Template;

/**
 * Class RegexParse
 * @package Frash\Template
 */
class RegexParse
{
    /**
     * @var array
     */
	protected $extension = [
        'ajax' => '/\{\{ ajax \}\}/',
        'bundle' => '/\{\{ bundle (.*) \}\}/',
        'call' => '/\{\{ call (.*) \}\}/',
        'condition' => [
            'else' => '/\{\{ else \}\}/',
            'elseif' => '/\{\{ elseif (.*) \}\}/',
            'end' => '/\{\{ end_if \}\}/',
            'if' => '/\{\{ if (.*) \}\}/'
        ],
        'escape' => [
            'html' => [ 'open' => '/\{\{ esc_html \}\}/', 'close' => '/\{\{ end_esc_html \}\}/' ],
            'tpl' => [ 'open' => '/\{\{ esc_tpl \}\}/', 'close' => '/\{\{ end_esc_tpl \}\}/' ]
        ],
        'loop' => [
            'for' => [ 'open' => '/\{\{ for (.*) \}\}/', 'close' => '/\{\{ end_for \}\}/' ],
            'foreach' => [ 'open' => '/\{\{ foreach (.*) :: (.*), (.*) \}\}/', 'close' => '/\{\{ end_foreach \}\}/' ],
            'index' => [ 'open' => '/\{\{ index (.*) \}\}/', 'close' => '/\{\{ end_index \}\}/' ],
            'itvl' => [ 'open' => '/\{\{ itvl (.*) \}\}/', 'close' => '/\{\{ end_itvl \}\}/' ],
        ],
        'parts' => [ 'open' => '/\{\{ part (\w+) \}\}/', 'close' => '/\{\{ end_part (\w+) \}\}/', 'parent' => '/\{\{ parent (\w+) \}\}/' ],
        'include' => '/\{\{ include (\w+) (.*) \}\}/',
        'internal' => '/\{\{ internal (.*) \}\}/',
        'public' => '/\{\{ public (.*) \}\}/',
        'route' => '/\{\{ route (.*) \}\}/',
        'set_var' => '/\{\{ define (\w+) \}\}/',
        'show_var' => '/\{\{ \$(.*) \}\}/',
        'show_var_for' => '/\{\{ !(.*) \}\}/',
        'traduction' => '/\{\{ traduction (.*) \}\}/'
	];
}