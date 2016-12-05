<?php
	namespace LFW\Framework\Template\Parsing;

    /**
     * Class ParseArray
     * @package LFW\Framework\Template\Parsing
     */
	class ParseArray{
        /**
         * @var array
         */
		protected $parsing = [
			'bundle' => '/\[bundle (.*?)\]/',
			'call' => '/\[call (\w+)\]/', // Call route to execute action in view
			'else' => '/\[else\]/',
			'elseif' => '/\[elseif (.*)\]/',
			'escape' => '/\[escape\]/',
			'end_condition' => '/\[\/condition\]/',
			'end_escape' => '/\[\/escape\]/',
			'end_for_index' => '/\[\/for_index\]/',
			'end_for_itvl' => '/\[\/for_itvl\]/',
			'end_for_simple' => '/\[\/for_simple\]/',
			'end_foreach' => '/\[\/foreach\]/',
			'end_func' => '/\[\/func\]/',
			'end_parts' => '/\[\/part (\w+)\]/',
			'for_index' => '/\[for_index (.*)\]/', // [for_index i -> 0...10]
			'for_itvl' => '/\[for_itvl (.*)\]/', // [for_itvl 1.5]
			'for_simple' => '/\[for_simple (\w+)\]/', // [for_simple i = 0; i <= 10; i++]
			'foreach' => '/\[foreach (.*) :: (.*), (.*)\]/',
			'if' => '/\[if (.*)\]/',
			'include' => '/\[include (\w+)\]/', // include('bundle', 'file.html')
			'parent' => '/\[parent (\w+)\]/',
			'parts' => '/\[part (\w+)\]/',
			'route' => '/\[route (.*)]/',
			'set_func' => '/\[func (\w+)\]/',
			'set_var' => '/\[define (\w+)\]/',
			'show_var' => '/\[show (.*)\]/',
			'show_var_for' => '/\[show !(.*)\]/',
			'traduction' => '/\[traduction (.*?)\]/'
		];
	}