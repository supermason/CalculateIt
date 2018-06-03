<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 16:13
 */

namespace EquationGen\Rules;


use EquationGen\Calculation;
use EquationGen\Operator;

interface IRule
{
    /**
     * Applies the current rule to the calculation, by fixing the values on either
     * left or right hand side of the calculation. The operator will also has the chance
     * to be changed when applying the rule.
     *
     * @param Calculation $left The left hand side of the calculation.
     * @param Calculation $right The right hand side of the calculation.
     * @param array(string, string) $parameters The calculation generation parameters that are extracted from the equation formation.
     * @param Operator $operator The operator to join the two calculations.
     * @return void
     */
    public function Apply(Calculation $left, Calculation $right, array $parameters, Operator &$operator);

    /**
     * get type of an instance
     *
     * @return string
     */
    public function getType();
}