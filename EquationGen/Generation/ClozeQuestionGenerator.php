<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/2
 * Time: 11:58
 */

namespace EquationGen\Generation;
use EquationGen\Calculation;
use EquationGen\SpacingOption;
use EquationGen\Utils;

/**
 * Represents the question generator that generates the cloze questions.
 *
 * Cloze questions are the questions that leaves a place holder in an arithmetic equation, requiring
 * the student to fill in a number so that the equation can balance. For example, given a calculation:
 *
 * 2 + ( ) = 5
 *
 * The student should fill 3 into the parenthesis.
 *
 * The <c>CloseQuestionGenerator</c> will generate the string '2 + ( ) = 5' as the formula, and number 3 is also provided in the generated result.
 *
 * Class ClozeQuestionGenerator
 * @package EquationGen\Generation
 */
class ClozeQuestionGenerator extends QuestionGenerator
{
    #region Private Fields
    const DigitalPattern = "/\d+/";
    #endregion

    #region Constructor
    /**
     * Initializes a new instance of the "ClozeQuestionGenerator" class.
     *
     * ClozeQuestionGenerator constructor.
     * @param string $placeholder The place holder of the question where the students should put the answer in.
     * @param SpacingOption $spacingOption value which indicates the spacing options of the generated question.
     */
    public function __construct($placeholder = "（ ）", SpacingOption $spacingOption)
    {
        parent::__construct($placeholder, $spacingOption);
    }
    #endregion

    #region Public Methods
    /**
     * Generates the arithmetic question based on the given calculation.
     *
     * @param Calculation $calculation The calculation equation from which the question is generated.
     * @return QuestionGenerationResult A "QuestionGenerationResult{TAnswer}" instance which contains the question formular and the answer.
     */
    public function Generate(Calculation $calculation)
    {
        $calculationString = $calculation->ToFormattedString($this->getSpacingOption());
        $digitalMatches = [];
        preg_match_all(static::DigitalPattern, $calculationString, $digitalMatches, PREG_OFFSET_CAPTURE);
        $matchesArray = Utils::copyArray($digitalMatches);
        $idx = mt_rand(0, count($matchesArray));
        $selectedIndex = $matchesArray[$idx][1];
        $selectedValue = $matchesArray[$idx][0];
        $formula = preg_replace_callback($calculationString, function ($match) use ($selectedIndex) {
            if ($match[1] == $selectedIndex) {
                return $this->getPlaceHolder();
            }

            return $match[0];
        }, static::DigitalPattern) . '=' . $calculation->Value();

        return new QuestionGenerationResult($formula, $selectedValue);



        return new QuestionGenerationResult($formula, $selectedValue);
    }
    #endregion

    #region Private Methods

    #endregion
}