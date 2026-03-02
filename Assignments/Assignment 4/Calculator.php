<?php

class Calculator {

    public function calc() {
        $args = func_get_args();

        // Validate: must have exactly 3 arguments
        if (count($args) !== 3) {
            return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
        }

        $operator = $args[0];
        $num1     = $args[1];
        $num2     = $args[2];

        // Validate operator is a string and one of the allowed operators
        if (!is_string($operator) || !in_array($operator, ['+', '-', '*', '/'])) {
            return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
        }

        // Validate both numbers are integers or floats (not strings, booleans, etc.)
        if (!is_int($num1) && !is_float($num1)) {
            return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
        }

        if (!is_int($num2) && !is_float($num2)) {
            return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
        }

        // Perform calculation
        switch ($operator) {
            case '+':
                $answer = $num1 + $num2;
                break;
            case '-':
                $answer = $num1 - $num2;
                break;
            case '*':
                $answer = $num1 * $num2;
                break;
            case '/':
                if ($num2 == 0) {
                    return "<p>The calculation is {$num1} / {$num2}. The answer is cannot divide a number by zero.</p>";
                }
                $answer = $num1 / $num2;
                break;
        }

        return "<p>The calculation is {$num1} {$operator} {$num2}. The answer is {$answer}.</p>";
    }
}

//Explain the purpose of require_once "Calculator.php"; in th index.php page. What would be the difference if include or require were used instead of require_once?
//How does the divide method specifically prevent and report an error for division by zero? Why is this a critical consideration in calculator applications?
//Explain the difference between the Calculator class and the $Calculator object. Why do we create an instance of the class?
//Why is it important to check that the last two parameters are numbers in our Calculator class?
//Index.php handles the display of the results using HTML, while Calculator.php contains the core calculation logic. Discuss the importance of separating user interface (presentation) concerns from business logic.