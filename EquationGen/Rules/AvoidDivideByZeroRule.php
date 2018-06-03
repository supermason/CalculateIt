<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 16:19
 */

namespace EquationGen\Rules;


use EquationGen\Calculation;
use EquationGen\Operator;

/**
 * Represents that when the operator is <see cref="Operator.Div"/>, the equation should ensure that
 * the value of the right side calculation should not be zero, so that the division by zero would never occur.
 *
 * Class AvoidDivideByZeroRule
 * @package EquationGen\Rules
 */
class AvoidDivideByZeroRule implements IRule
{
    public function Apply(Calculation $left = null, Calculation $right = null, array $parameters, &$operator)
    {
        if (is_null($right)) {
            return;
        }

        if ($operator == Operator::Div && $right->Value() == 0) {
            $max = intval($parameters['max']);

            $counter = new ConstantCalculationCounter();
            $right->Accept($counter);

            $adjustment = new RandomizedCalculationValueAdjustment(1, $max, $counter->NumOfConstantCalculations(), function ($x) { return $x == 0; });
            while ($right->Value() == 0) {
                $adjustment->Reset();
                $right->Accept($adjustment);
            }
        }
    }

    public function getType()
    {
        return 'AvoidDivideByZeroRule';
    }
}