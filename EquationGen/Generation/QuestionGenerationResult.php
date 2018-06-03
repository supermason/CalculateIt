<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/2
 * Time: 10:29
 */

namespace EquationGen\Generation;

/**
 * Represents the result of a question generation.
 *
 * Class QuestionGenerationResult
 * @package EquationGen\Generation
 */
class QuestionGenerationResult
{
    #region Private Fields
    /**
     * @var string
     */
    private $formula;

    /**
     * @var mixed
     */
    private $answer;
    #endregion

    #region Constructor
    /**
     * Initializes a new instance of the "QuestionGenerationResult{TAnswer}" class.
     *
     * QuestionGenerationResult constructor.
     * @param string $formula The "String" presentation of the formula that the question generator has generated.
     * @param mixed $answer The answer to the generated question.
     */
    function __construct($formula, $answer)
    {
        $this->formula = $formula;
        $this->answer = $answer;
    }
    #endregion

    #region Public Properties
    /**
     * Gets the "String" presentation of the formula that the question generator has generated.
     *
     * @return string
     */
    public function getFormula()
    {
        return $this->formula;
    }

    /**
     * Gets the answer to the generated question.
     *
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }
    #endregion
}