<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 14:57
 */

namespace EquationGen;


abstract class Calculation implements IVisitorAcceptor
{
    #region Public Properties
    /**
     * Gets the value of the current calculation.
     *
     * @return int
     */
    public abstract function Value();
    #endregion

    #region Public Methods
    /**
     * Accepts the specified visitor.
     *
     * @param IVisitor $visitor The visitor instance to be accepted.
     * @return void
     */
    public abstract function Accept(IVisitor $visitor);

    /**
     * Returns a more human-readable string that represents the current calculation instance.
     *
     * @param string $option The spacing option.
     * @return string A string with better readability.
     */
    public abstract function ToFormattedString($option = SpacingOption::None);

    /**
     * Merges the specified calculations with a given
     *
     * @param Calculation $left The left side of the calculation.
     * @param Calculation $right The right side of the calculation.
     * @param Operator $operator The operator to merge the two operations.
     * @return Calculation The merged operation.
     */
    public static function Merge(Calculation $left = null, Calculation $right = null, $operator)
    {
        if (is_null($left) && is_null($right)) {
            throw new \InvalidArgumentException('Both left and right calculations are empty.');
        }

        if (is_null($left)) {
            return $right;
        }

        if (is_null($right)) {
            return $left;
        }

        return new CompositeCalculation($left, $right, $operator);
    }
    #endregion
}