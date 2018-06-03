<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 14:10
 */

namespace EquationGen;

/**
 * Represents the arithmetic calculation operators.
 *
 * Class Operator
 * @package EquationGen
 */
class Operator
{
    /**
     * Indicates that the operator has not been defined.
     */
    const None = 0;

    /**
     * Indicates the Add (+) operator.
     */
    const Add = 1;

    /**
     * Indicates the Subtraction (-) operator.
     */
    const Sub = 2;

    /**
     * Indicates the Multiplicity (*) operator.
     */
    const Mul = 4;

    /**
     * Indicates the Division (/) operator.
     */
    const Div = 8;
}