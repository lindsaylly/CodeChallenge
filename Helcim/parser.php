<!--Author:Lindsay Li
	Date: Sep. 1th, 2018
	Purpose: Helcim interview test
-->
<?php

/*The function is to get a parsed string in the same formart that it was passed through, 
  but with a series of sensitive data masked;  
*/
function parser_SensitiveData($string){
	//patterns match various possible input data
	//the pattern is focused on the credit card number (a valid card number length can be from 14 to 19)
	$patternCardNum = '/^(.*)(card)([a-z_]{0,4})(number)([=>:"\s\]]+)([0-9]{14,19})(.*)$/is'; 
	//the pattern is focused on credit card expiry date which is a 4 digit number
	$patternExpiryDate = '/^(.*)(exp|expiry)([=>:"\s\]]+)([0-9]{4})(.*)$/is';
	//the pattern is focused on credit card CVV value which is a 3 or 4 digits code
	$patternCVV = '/^(.*)(cvv)([a-z_]{0,15})([=>:"\s\]]+)([0-9]{3,4})(.*)$/is';
	//call the maskData function to mask these sensitive data
	$string = maskData($patternCardNum,$string,6,7);
	if ($string !== false) 
	{
		$string = maskData($patternExpiryDate,$string,4,5);
		if ($string !== false)
		{
			$string = maskData($patternCVV,$string,5,6);
			return $string;
		}
		else return false;
	}
	else return false;    
}

/*The function is to replace a specifed input data with an Asterisk(*) character.
  There are four parameters which need to be passed:
  $pattern is a pattern string which can match the given string with a specified data;
  $string is a subject which is needed to be parsed;
  $position is the number of the subpatterns which relate the specified data;
  $subpatternNum is the counter of the total subpatterns;
  Return value: returns the replaced string with the specified data masked if there is no error, otherwise returns false.
*/
function maskData($pattern, $string, $position, $subpatternNum)
{
	if (preg_match($pattern, $string, $matches) == 1) //if the pattern matches given string
	{		
		//$matches[$position] will have the text that match the relative captured parenthesized subpattern
		$matches[$position] = str_repeat('*', strlen($matches[$position])); 
		$maskedStr = null;//initilize the string
		//concatenat all the elements of the $matches array except $matches[0]
		for ($i=1; $i<=$subpatternNum; $i++)
		{
			$maskedStr .= $matches[$i]; 
		}
		return $maskedStr; //return the masked string
	}	
	else return false;
}

?>

