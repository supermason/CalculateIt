<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/2
 * Time: 22:26
 */

spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();

use EquationGen\Generation\ArithmeticEquationGenerator;
use EquationGen\Rules\AvoidNegativeResultRule;
use EquationGen\Rules\DivisibilityEnsuranceRule;

$formation = "{10}+-*/|3";
$equation = new ArithmeticEquationGenerator($formation, [new AvoidNegativeResultRule(), new DivisibilityEnsuranceRule()]);

for ($i = 0; $i < 10; $i++) {
    try {
        $calculation = $equation->Generate();
        echo $calculation->ToFormattedString() . ' = ' . $calculation->Value() . '<br><br>';
    } catch (Exception $e) {
        echo $e . '<br><br>';
    }
}