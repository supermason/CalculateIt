<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 16:51
 */

namespace EquationGen\Rules;
use EquationGen\Calculation;
use EquationGen\ConstantCalculation;
use EquationGen\Operator;

/**
 * Represents that the generated arithmetic equation should ensure that when the calculation operator is
 * <see cref="Operator.Div"/>, the left side of the calculation should be divisible by the right side of the calculation.
 *
 * Class DivisibilityEnsuranceRule
 * @package EquationGen\Rules
 */
class DivisibilityEnsuranceRule implements IRule
{
    #region Public Methods
    /**
     * Applies the current rule to the calculation, by fixing the values on either
     * left or right hand side of the calculation. The operator will also has the chance
     * to be changed when applying the rule.
     *
     * @param Calculation $left The left hand side of the calculation.
     * @param Calculation $right The right hand side of the calculation.
     * @param array $parameters The calculation generation parameters that are extracted from the equation formation.
     * @param Operator $operator The operator to join the two calculations.
     */
    public function Apply(Calculation $left = null, Calculation $right = null, array $parameters, &$operator)
    {
        if (is_null($right) || is_null($left)) {
            return;
        }

        $leftValue = $left->Value();
        $rightValue = $right->Value();

        if ($operator == Operator::Div && ($leftValue % $rightValue) != 0) {
            $max = intval($parameters['max']);

            $leftIsCC = $left instanceof ConstantCalculation;
            $rightIsCC = $right instanceof ConstantCalculation;

            if (!$leftIsCC && !$rightIsCC) {
                return;
            }

            if ($leftIsCC) {
                $i = 0;
                do {
                    $i++;
                } while ($i * $rightValue <= $max);

                $proposedLeftConstantValue = mt_rand(0, $i - 1) * $rightValue;
                $left->SetValue($proposedLeftConstantValue);
            } else if ($rightIsCC) {
                $possibleValues = [];
                for ($i = 1; $i <= min($leftValue, $max); $i++) {
                    if ($leftValue % $i == 0) {
                        array_push($possibleValues, $i);
                    }
                }

                $proposedRightConstantValue = $possibleValues[mt_rand(0, count($possibleValues))];
                $right->SetValue($proposedRightConstantValue);
            }
        }
    }

    public function getType()
    {
        return 'DivisibilityEnsuranceRule';
    }

    #endregion
}