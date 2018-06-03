<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/2
 * Time: 22:13
 */

namespace EquationGen\Generation;
use EquationGen\Calculation;
use EquationGen\SpacingOption;

/**
 * Represents the question generator that generates the comparison questions.
 *
 * A comparison question is the one that, it will give the student a calculation, as the left
 * part of the equation, and then propose a value which might be less than, greater than or
 * equal to the value of the calculation. The student should use &lt; &gt and = signs to make
 * the equation reasonable.
 *
 * For example:
 *
 * 2 + 3 ○ 6
 *
 * The students should fill &lt; sign in the circle.
 *
 * Class ComparisonQuestionGenerator
 * @package EquationGen\Generation
 */
class ComparisonQuestionGenerator extends QuestionGenerator
{
    #region Private Fields
    /**
     * @var int
     */
    private $threshold;
    #endregion

    #region Constructor
    /**
     * Initializes a new instance of the "ComparisonQuestionGenerator" class.
     *
     * ComparisonQuestionGenerator constructor.
     * @param int $threshold The threshold.
     * @param string $placeholder The place holder.
     * @param SpacingOption $spacingOption The spacing option.
     */
    public function __construct($threshold, $placeholder = '\u25CB', SpacingOption $spacingOption = null)
    {
        if (is_null($spacingOption)) {
            $spacingOption = SpacingOption::Thin;
        }

        parent::__construct($placeholder, $spacingOption);

        $this->threshold = $threshold;
    }
    #endregion

    #region Public Methods
    /**
     * Generates the arithmetic question based on the given calculation.
     *
     * @param Calculation $calculation The calculation equation from which the question is generated.
     * @return QuestionGenerationResult A QuestionGenerationResult instance which contains the question formular and the answer.
     */
    public function Generate(Calculation $calculation)
    {
        $value = $calculation->Value();
        $min = $value > $this->threshold ? $value - $this->threshold : 0;
        $max = $value + $this->threshold + 1;

        $v = mt_rand(intval($min), intval($max));

        return new QuestionGenerationResult($calculation->ToFormattedString($this->getSpacingOption()) . ' ' . $this->getPlaceHolder() . ' ' . $v,
            $value == $v ? '=' : ($value > $v ? '>' : '<')
        );
    }
    #endregion
}