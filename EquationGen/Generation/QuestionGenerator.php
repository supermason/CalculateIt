<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/2
 * Time: 10:22
 */

namespace EquationGen\Generation;

use EquationGen\Calculation;
use EquationGen\SpacingOption;

/**
 * Represents the base class of question generators.
 *
 * Class QuestionGenerator
 * @package EquationGen\Generation
 */
abstract class QuestionGenerator
{
    #region Private Fields
    /**
     * @var string
     */
    private $placeHolder;

    /**
     * @var SpacingOption
     */
    private $spacingOption;
    #endregion

    #region Constructor
    /**
     * Initializes a new instance of the "QuestionGenerator" class.
     *
     * QuestionGenerator constructor.
     * @param string $placeholder The place holder of the question where the students should put the answer in.
     * @param SpacingOption $spacingOption The "SpacingOption" value which indicates the spacing options of the generated question.
     */
    protected function __construct($placeholder, SpacingOption $spacingOption)
    {
        $this->spacingOption = $spacingOption;
        $this->placeHolder = $placeholder;
    }
    #endregion

    #region Public Methods
    /**
     * Generates the arithmetic question based on the given calculation.
     *
     * @param Calculation $calculation The calculation equation from which the question is generated.
     * @return QuestionGenerationResult mixed A "QuestionGenerationResult" instance which contains the question formular and the answer.
     */
    public abstract function Generate(Calculation $calculation);
    #endregion

    #region Protected Properties
    /**
     * Gets the place holder of the question where the students should put the answer in.
     *
     * @return string
     */
    protected function getPlaceHolder()
    {
        return $this->placeHolder;
    }

    /**
     * Gets the "SpacingOption" value which indicates the spacing options of the generated question.
     *
     * @return SpacingOption
     */
    protected function getSpacingOption()
    {
        return $this->spacingOption;
    }
    #endregion
}