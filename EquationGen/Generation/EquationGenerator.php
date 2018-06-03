<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 17:18
 */

namespace EquationGen\Generation;

use EquationGen\Calculation;
use EquationGen\Rules\AvoidDivideByZeroRule;

/**
 * Represents the base class for the equation generators.
 *
 * Class EquationGenerator
 * @package EquationGen\Generation
 */
abstract class EquationGenerator
{
    #region Fields
    /**
     * @var array (<string>, <string>)
     */
    private $parameters = [];

    /**
     * The local list for storing the error message texts.
     *
     * @var array (<string>)
     */
    protected $errorMessages = [];

    /**
     * The local list which contains all the registered rules.
     *
     * @var array (<IRule>)
     */
    protected $rules = [];

    /**
     * The formation of the equations being generated.
     *
     * @var string
     */
    private $formation;

    /**
     *  <c>true</c> if the current <c>EquationGenerator</c> is in a valid state; otherwise, <c>false</c>.
     *
     * @var boolean
     */
    private $isValid;
    #endregion

    #region Constructor
    /**
     * Initializes a new instance of <c>EquationGenerator</c> class.
     *
     * EquationGenerator constructor.
     * @param string $formation >The formation of the equation that is going to be generated.
     * @param array<IRule> $rules A list of <see "Rules.IRule"/> instances that is registered with current equation generator.
     */
    public function __construct($formation, array $rules=[])
    {
        // Adds the AvoidDivideByZeroRule, as it is a mandatory for a arithmetic calculation.
        array_push($this->rules, new AvoidDivideByZeroRule());

        // Load additional rules and register to the current generator instance.
        if (!is_null($rules) && count($rules) > 0) {
            foreach ($rules as $rule) {
                $alreadyExisted = false;

                foreach ($this->rules as $existedRule) {
                    if ($rule->getType() == $existedRule->getType()) {
                        $alreadyExisted = true;
                        break;
                    }
                }

                if (!$alreadyExisted) {
                    array_push($this->rules, $rule);
                }
            }
        }

        $this->formation = $formation;
        $this->errorMessages = [];

        // Firstly use the regular expression to validate the given formation.
        $pattern = $this->getFormationPatter();
        $matches = [];
        $this->isValid = preg_match($pattern, $this->formation, $matches);
        if ($this->isValid) {
            // If the given formation can pass the regular expression matching, the matching groups
            // will be extracted from the formation, and be stored into the local dictionary as parameters.
            foreach ($matches as $key => $match) {
                if (!is_numeric($key)) {
                    $this->parameters[$key] = $match;
                }
            }

            // Passing the parameters to the ValidateParamters method for additional validation. For example,
            // check if the parameters are valid.
            $this->isValid = $this->ValidateParameters($this->parameters);
        } else {
            // If the given formation cannot pass the regular expression matching, an error
            // message will be added to the local list.
            array_push($this->errorMessages, 'The formation passed in cannot match the required pattern criteria');
        }

    }
    #endregion

    #region Public Properties
    /**
     * Gets a "Boolean" value which indicates whether the current <c>EquationGenerator</c> is in a valid state.
     *
     * @return bool
     */
    public function IsValid()
    {
        return $this->isValid;
    }

    /**
     *  Gets the formation of the equations being generated.
     *
     * @return string
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * Gets the error messages being generated when doing the generator validation.
     *
     * @return array <string>
     */
    public function getErrorMessage()
    {
        return $this->errorMessages;
    }
    #endregion

    #region Protected Properties
    /**
     * Gets a "String" value which represents the regular expression pattern of the formation.
     *
     * @return string
     */
    protected abstract function getFormationPatter();

    /**
     * Gets the parameters that are extracted from the given formation.
     *
     * @return array<string, string>
     */
    protected function getParameters()
    {
        return $this->parameters;
    }
    #endregion

    #region Public Methods
    /**
     * Generates the calculation based on the given formation.
     *
     * @return Calculation
     */
    public abstract function Generate();
    #endregion

    #region Protected Methods
    /**
     * Validates the parameters that are extracted from the given formation.
     *
     * @param array<string => string> $parameters
     * @return bool
     */
    protected function ValidateParameters(array $parameters)
    {
        return true;
    }
    #endregion
}