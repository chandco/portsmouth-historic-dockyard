<?php

/* Creates a Grid system.  

	Basic version:

	[columns]

		cONTENT

	{half}

		cONTENT	

	[/columns]

	But with more dividers.  Final column is 'leftover space' so it's up tot he user to understand maths!

*/

function arr_closest_key($array, $number) {

    asort($array);
    $b = key($array);
    
    foreach ($array as $key => $a) {
    	

        if (round($a,2) >= round($number,2)) return $key;
        $b = $key;
    }
    end($array);
    return key($array); // or return NULL;
}

function cf_column_system($atts, $content) {


	 $atts = shortcode_atts( array(
        'class' => '',
        'id' => '',
    ), $atts );

	$output = "<div class='cf_columns " . $atts["class"] . "'";

	$output .= ($atts["id"]) ? " id='" . $atts["id"] . "'>" : ">";

	$pattern = '/({[a-z]+})(.*)/i';


	preg_match_all($pattern, $content, $matches);

	$cols = array();

	$colvalues = array(
		"half" => 0.5,
		"third" => 1/3,
		"twothirds" => 2/3,
		"quarter" => 0.25,
		"threequarters" => 0.75
		);

	$coltotal = 1;

	foreach ($matches[1] as $key => $chunk) {

		$columnid = str_replace("{", "", $chunk);
		$columnid = str_replace("}", "", $columnid);

		$coltotal = $coltotal - $colvalues[$columnid];
		
		$output .= "<div class='col-" . $columnid . "'>";
		//$output .= "<span class='debug'>" .  $colvalues[$columnid] . " / " . $columnid . "</span>";
		$inner = wpautop( strstr($content, $chunk, true) );
		$output .= $inner . "</div>";


		// remaining content:
		$content = substr( strstr($content, $chunk), strlen($chunk) );
	}

	
	$lastcol = arr_closest_key($colvalues, $coltotal);
	$output .= "<div class='col-" . $lastcol . "'>";
	//$output .= "<span class='debug'>" .  $coltotal . " / " . $lastcol . "</span>";
	$output .= wpautop( $content );	
	$output .= "</div>";
	
	

	$output .= "</div>";
	return $output;

}

add_shortcode("columns", "cf_column_system");


