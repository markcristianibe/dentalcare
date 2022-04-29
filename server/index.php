<!DOCTYPE html>
<html>


<?php
arithmeticOperation(5, 5, "modulus");

function arithmeticOperation($number1, $number2, $operation)
{
	if($operation == "addition")
	{
		$answer = $number1 + $number2;
		echo $answer;
	}
	else if($operation == "subtraction")
	{
		$answer = $number1 - $number2;
		echo $answer;
	}
	else if($operation == "multiplication")
	{
		$answer = $number1 * $number2;
		echo $answer;
	}
	else if($operation == "division")
	{
		$answer = $number1 / $number2;
		echo $answer;
	}
	else if($operation == "modulus")
	{
		$answer = $number1 % $number2;
		echo $answer;
	}
	else
	{
		echo "Invalid Arithmetic Operator";
	}
}
?>