<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 16:42
 */

namespace EquationGen\Rules;
use EquationGen\Calculation;
use EquationGen\ConstantCalculation;
use EquationGen\Operator;

/**
 * Represents that when the operator is <see cref="Operator.Sub"/>, the equation should ensure that
 * the value of the left calculation is larger than or equal to the value of the right calculation,
 * so that the generated equation will never has a negative value.
 *
 * Class AvoidNegativeResultRule
 * @package EquationGen\Rules
 */
class AvoidNegativeResultRule implements IRule
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

        if ($operator == Operator::Sub && $leftValue < $rightValue) {
            $max = intval($parameters['max']);

            $leftIsCC = $left instanceof ConstantCalculation;
            $rightIsCC = $right instanceof ConstantCalculation;

            if (!$leftIsCC && !$rightIsCC) {
                return;
            }

            if ($rightIsCC) {
                $right->SetValue(mt_rand(0, intval($leftValue)));
            } else if ($leftIsCC) {
                $left->SetValue(mt_rand(intval($rightValue), $max));
            }
        }
    }

    public function getType()
    {
        return 'AvoidNegativeResultRule';
    }
    #endregion

}