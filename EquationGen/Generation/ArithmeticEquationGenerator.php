<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/2
 * Time: 10:41
 */

namespace EquationGen\Generation;
use EquationGen\Calculation;
use EquationGen\ConstantCalculation;
use EquationGen\Operator;
use EquationGen\Utils;

/**
 * Represents the arithmetic equation generator.
 *
 * Class ArithmeticEquationGenerator
 * @package EquationGen\Generation
 */
class ArithmeticEquationGenerator extends EquationGenerator
{
    #region Private Fields
    /**
     * @var int
     */
    private $max;
    /**
     * @var string
     */
    private $acceptableOperators;
    /**
     * @var int
     */
    private $numOfFactors_min;
    /**
     * @var int
     */
    private $numOfFactors_max;
    #endregion

    #region Constructor
    /**
     * Initializes a new instance of the "ArithmeticEquationGenerator" class.
     *
     * ArithmeticEquationGenerator constructor.
     * @param $formation
     * @param array $rules
     */
    public function __construct($formation, array $rules = [])
    {
        parent::__construct($formation, $rules);
    }
    #endregion

    #region Public Methods
    /**
     * Generates the calculation based on the given formation.
     *
     * @return \EquationGen\Calculation The "Calculation" being generated.
     * @throws
     */
    public function Generate()
    {
        if (!$this->IsValid()) {
            throw new \ErrorException('Cannot generate the equation: the given equation generation formation is not valid, please see ErrorMessages property for details.');
        }

        $result = null;
        $numOfFactors = $this->numOfFactors_min;
        if ($this->numOfFactors_max != 0) {
            $numOfFactors = mt_rand($this->numOfFactors_min, $this->numOfFactors_max);
        }

        for ($idx = 0; $idx < $numOfFactors; $idx++) {
            $factor = mt_rand(0, $this->max);
            $operator = Utils::GenerateRandomOperator($this->acceptableOperators);
            $left = $result;
            $right = new ConstantCalculation($factor);

            if ($operator == Operator::Add || $operator == Operator::Mul) {
                $seed = mt_rand();
                if ($seed % 2 == 0) {
                    $left = new ConstantCalculation($factor);
                    $right = $result;
                }
            }

            if (!is_null($this->rules)) {
                foreach ($this->rules as $rule) {
                    $rule->Apply($left, $right, $this->getParameters(), $operator);
                }
            }

            $result = Calculation::Merge($left, $right, $operator);
        }

        return $result;
    }
    #endregion

    #region Protected Properties
    /**
     * Gets a "String" value which represents the regular expression pattern of the formation.
     *
     * @return string
     */
    protected function getFormationPatter()
    {
        return '/^{(?\'max\'\d+)}(?\'operator\'(\+)?(\-)?(\*)?(\/)?){1}(\|(?\'factors_min\'\d+)(-(?\'factors_max\'\d+))?)?$/';
    }
    #endregion

    #region Protected Methods
    protected function ValidateParameters(array $parameters)
    {
        $this->max = intval($parameters['max']);

        if ($this->max <= 0) {
            array_push($this->errorMessages, 'Proposed maximum value should be larger than zero.');
        }

        $this->acceptableOperators = $parameters['operator'];

        if (!isset($parameters['factors_min'])) {
            $this->numOfFactors_min = 2;
        } else {
            $this->numOfFactors_min = intval($parameters['factors_min']);
        }

        if (!isset($parameters['factors_max'])) {
            $this->numOfFactors_max = 0;
        } else {
            $this->numOfFactors_max = intval($parameters['factors_max']);
        }

        if ($this->numOfFactors_max != 0 && $this->numOfFactors_min > $this->numOfFactors_max) {
            array_push($this->errorMessages, 'Maximum number of factors should be larger than or equal to the minimum value.');
        }

        if (is_null($this->acceptableOperators) || $this->acceptableOperators == '') {
            array_push($this->errorMessages, 'No acceptable operator has been specified.');
        }

        return count($this->errorMessages) == 0;
    }
    #endregion
}