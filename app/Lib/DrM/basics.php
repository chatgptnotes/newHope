<?php
/**
 * Basic file
 *
 * PHP 5
 * 
 *
 * @copyright     Copyright 2015 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Basic
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

function ddebug($var = false, $showHtml = null, $showFrom = true) {
	    $file = '';
		$line = '';
		if ($showFrom) {
			$calledFrom = debug_backtrace();
			$file = substr(str_replace(ROOT, '', $calledFrom[0]['file']), 1);
			$line = $calledFrom[0]['line'];
		}
		$html = <<<HTML
<div class="cake-debug-output">
<span><strong>%s</strong> (line <strong>%s</strong>)</span>
<pre class="cake-debug">
%s
</pre>
</div>
HTML;
			$text = <<<TEXT

%s (line %s)
########## DEBUG ##########
%s
###########################

TEXT;
		$template = $html;
		if (php_sapi_name() == 'cli') {
			$template = $text;
		}
		if ($showHtml === null && $template !== $text) {
			$showHtml = true;
		}
		$var = print_r($var, true);
		if ($showHtml) {
			$var = h($var);
		}
		printf($template, $file, $line, $var);
}

/**
 * Print_r convenience function, which prints out <PRE> tags around
 * the output of given array. Similar to debug().
 *
 * @see	debug()
 * @param array $var Variable to print out
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#pr
 */
function dpr($var) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
}
