<?php

require_once('php-sql-parser/src/PHPSQLParser.php');

$sql = "select Name, PersNr, Rang, Raum, VorlNr, Titel, SWS from uni_Vorlesungen, uni_Professoren where PersNr = gelesenVon order by Name";

$answer = "select Name, PersNr, Rang, Raum, VorlNr, Titel, SWS from uni_Vorlesungen, uni_Professoren where PersNr = gelesenVon order by Name";

$parser = new PHPSQLParser();
$parsed = $parser->parse($sql);
//print_r($parsed);

$answerParser = new PHPSQLParser();
$solution = $answerParser->parse($answer);
//print_r($solution);
$counter = count($solution);

$diff = array_diff_assoc_recursive($parsed, $solution);
//print_r($diff);

if ($diff != 0) {
    $correct = 1;
    $correct = $correct - (count($diff) / $counter);
    echo $correct;
} else {
    echo 1;
}



    function array_diff_assoc_recursive($array1, $array2)
{
	foreach($array1 as $key => $value)
	{
		if(is_array($value))
		{
			if(!isset($array2[$key]))
			{
				$difference[$key] = $value;
			}
			elseif(!is_array($array2[$key]))
			{
				$difference[$key] = $value;
			}
			else
			{
				$new_diff = array_diff_assoc_recursive($value, $array2[$key]);
				if($new_diff != FALSE)
				{
					$difference[$key] = $new_diff;
				}
			}
		}
		elseif(!isset($array2[$key]) || $array2[$key] != $value)
		{
			$difference[$key] = $value;
		}
	}
	return !isset($difference) ? 0 : $difference;
}

?>