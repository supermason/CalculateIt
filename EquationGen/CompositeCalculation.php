<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 15:09
 */

namespace EquationGen;


class CompositeCalculation extends Calculation
{
    private $left;
    private $right;
    private $operator;

    #region Construct

    /**
     * CompositeCalculation constructor.
     * @param Calculation $left The left hand side of the calculation.
     * @param Calculation $right The right hand side of the calculation.
     * @param Operator $operator The arithmetic operator to be used.
     */
    public function __construct(Calculation $left, Calculation $right, $operator)
    {
        $this->left = $left;
        $this->right = $right;
        $this->operator = $operator;
    }
    #endregion

    #region Public Properties
    /**
     * Gets the left hand side of the calculation.
     *
     * @return Calculation
     */
    public function Left()
    {
        return $this->left;
    }

    /**
     * Gets the right hand side of the calculation.
     *
     * @return Calculation
     */
    public function Right()
    {
        return $this->right;
    }

    /**
     * Gets the arithmetic operator.
     *
     * @return Operator
     */
    public function Operator()
    {
        return $this->operator;
    }

    /**
     * Gets the value of the current calculation.
     *
     * @return int
     */
    public function Value()
    {
        switch($this->operator) {
            case Operator::Add:
                return $this->left->Value() + $this->right->Value();
            case Operator::Sub:
                return $this->left->Value() - $this->right->Value();
            case Operator::Mul:
                return $this->left->Value() * $this->right->Value();
            case Operator::Div:
                return $this->left->Value() / $this->right->Value();
            default:
                return -2147483648; // (c# long.MinValue)
        }
    }

    #endregion

    #region Public Methods
    /**
     * Accepts the specified visitor.
     *
     * @param IVisitor $visitor The visitor instance to be accepted.
     */
    public function Accept(IVisitor $visitor)
    {
        $this->left->Accept($visitor);
        $this->operator->Accept($visitor);
        $this->right->Accept($visitor);
    }

    /**
     * Returns a string that represents this instance.
     *
     * @return string
     */
    public function __toString()
    {
       $operatorSign = null;

       switch ($this->operator) {
           case Operator::Add:
               $operatorSign = "+";
               break;
           case Operator::Sub:
               $operatorSign = "-";
               break;
           case Operator::Mul:
               $operatorSign = "*";
               break;
           case Operator::Div:
               $operatorSign = "/";
               break;
       }

       if ($this->left instanceof CompositeCalculation
            && !($this->right instanceof CompositeCalculation)
            && static::OperatorPrecedence($this->left->Operator()) < static::OperatorPrecedence($this->operator)) {
           return '(' . $this->left . ')' . $operatorSign . $this->right;
       }

        if (!($this->left instanceof CompositeCalculation)
            && $this->right instanceof CompositeCalculation
            && static::OperatorPrecedence($this->right->Operator()) < static::OperatorPrecedence($this->operator)) {
            return $this->left . $operatorSign . '(' . $this->right . ')';
        }

        if ($this->left instanceof CompositeCalculation && $this->right instanceof CompositeCalculation) {
           return '(' . $this->left . ')' . $operatorSign . '(' . $this->right . ')';
        }

        return $this->left . $operatorSign . $this->right;
    }

    /**
     * Returns a more human-readable string that represents the current calculation instance.
     *
     * @param string  $option
     * @return string
     */
    public function toFormattedString($option = SpacingOption::None)
    {
        $operatorSing = null;
        $spacing = '';

        switch ($option) {
            case SpacingOption::Thin:
                $spacing = " ";
                break;
            case SpacingOption::Thick:
                $spacing = "   ";
                break;
        }

        switch ($this->operator) {
            case Operator::Add:
                $operatorSign = $spacing . "+" . $spacing;
                break;
            case Operator::Sub:
                $operatorSign = $spacing . "-" . $spacing;
                break;
            case Operator::Mul:
                $operatorSign = $spacing . "*" . $spacing;
                break;
            case Operator::Div:
                $operatorSign = $spacing . "/" . $spacing;
                break;
        }

        if ($this->left instanceof CompositeCalculation
            && !($this->right instanceof CompositeCalculation)
            && static::OperatorPrecedence($this->left->Operator()) < static::OperatorPrecedence($this->operator)) {
            return '(' . $this->left->ToFormattedString($option) . ')' . $operatorSign . $this->right->ToFormattedString($option);
        }

        if (!($this->left instanceof CompositeCalculation)
            && $this->right instanceof CompositeCalculation
            && static::OperatorPrecedence($this->right->Operator()) < static::OperatorPrecedence($this->operator)) {
            return $this->left->ToFormattedString($option) . $operatorSign . '(' . $this->right->ToFormattedString($option) . ')';
        }

        if ($this->left instanceof CompositeCalculation && $this->right instanceof CompositeCalculation) {
            return '(' . $this->left->ToFormattedString($option) . ')' . $operatorSign . '(' . $this->right->ToFormattedString($option) . ')';
        }

        return $this->left->ToFormattedString($option) . $operatorSign . $this->right->ToFormattedString($option);
    }
    #endregion

    #region Private Methods
    /**
     *
     * @param Operator $op
     * @return int
     */
    private static function OperatorPrecedence($op)
    {
    return $op == Operator::Add || $op == Operator::Sub ? 1 : 2;
    }
    #endregion
}
