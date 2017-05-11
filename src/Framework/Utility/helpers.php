<?php
/**
 * @param mixed $value
 */
function dump($value){
	print_r($value);
}

/**
 * @param mixed $value
 */
function predump($value){
	echo '<pre>'; print_r($value); echo '</pre>';
}