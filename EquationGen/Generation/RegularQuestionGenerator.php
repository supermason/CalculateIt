<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/2
 * Time: 10:33
 */

namespace EquationGen\Generation;
use EquationGen\Calculation;
use EquationGen\SpacingOption;

/**
 * Represents the regular question generator.
 *
 * This question generator simply generates a regular arithmetic equation question. For example:
 *
 * 2 + 3 = ____
 *
 * The students should fll in 5 in the place holder.
 *
 * Class RegularQuestionGenerator
 * @package EquationGen\Generation
 */
class RegularQuestionGenerator extends QuestionGenerator
{
    #region Constructor
    /**
     * Initializes a new instance of the "RegularQuestionGenerator" class.
     *
     * RegularQuestionGenerator constructor.
     * @param string $placeholder The place holder of the question where the students should put the answer in.
     * @param SpacingOption|null $spacingOption The 'SpacingOption' value which indicates the spacing options of the generated question.
     */
    public function __construct($placeholder = '____', SpacingOption $spacingOption = null)
    {
        if (is_null($spacingOption)) {
            $spacingOption = SpacingOption::Thin;
        }

        parent::__construct($placeholder, $spacingOption);
    }
    #endregion

    #region Public Methods
    public function Generate(Calculation $calculation)
    {
       return new QuestionGenerationResult($calculation->ToFormattedString($this->getSpacingOption()) . '=' . $this->getPlaceHolder(), $calculation->Value());
    }
    #endregion
}