<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 15:57
 */

namespace EquationGen;

/**
 * Represents a constant calculation that has a given object as its value.
 *
 * Class ConstantCalculation
 * @package EquationGen
 */
class ConstantCalculation extends Calculation
{
    #region Private Fields
    private $value;
    #endregion

    #region Public Properties
    /**
     * Gets the value of the current calculation.
     *
     * @return int
     */
    public function Value()
    {
        return $this->value;
    }
    #endregion

    #region Constructor
    /**
     * Initializes a new instance of the ConstantCalculation class.
     *
     * ConstantCalculation constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
    #endregion

    #region Public Properties
    /**
     * Accepts the specified visitor.
     *
     * @param IVisitor $visitor
     */
    public function Accept(IVisitor $visitor)
    {
        $visitor->Visit($this);
    }

    /**
     * Returns a string that represents the current object.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value . '';
    }

    /**
     * Returns a more human-readable string that represents the current calculation instance.
     *
     * @param string $option
     * @return string
     */
    public function ToFormattedString($option = SpacingOption::None)
    {
        return $this->__toString();
    }

    /**
     * Operator override for implicitly converts the given long value into a constant calculation.
     *
     * @param $x
     * @return ConstantCalculation
     */
    public static function ConstantCalculation($x)
    {
        return new ConstantCalculation($x);
    }


    /**
     * Operator override for implicitly converts the given "ConstantCalculation" into a "Long" value.
     *
     * @param ConstantCalculation $c
     * @return int
     */
    public static function long(ConstantCalculation $c)
    {
        return $c->Value();
    }

    /**
     * Explicitly sets the value of current <c>ConstantCalculation</c> instance.
     *
     * @param $value integer The value to be set to this instance.
     */
    function SetValue($value)
    {
        $this->value = $value;
    }
    #endregion
}