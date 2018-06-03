<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 16:31
 */

namespace EquationGen\Rules;


use EquationGen\CalculationVisitor;
use EquationGen\CompositeCalculation;
use EquationGen\ConstantCalculation;

class RandomizedCalculationValueAdjustment extends CalculationVisitor
{
    #region Private Fields
    private $min;
    private $max;
    private $totalNumberOfConstantCalculations;
    private $exclusionExpectation; // Func<int, bool>
    private $currentIdx = 0;
    private $hitIndex;
    #endregion

    #region Constructor
    /**
     * Initializes a new instance of the <see cref="RandomizedCalculationValueAdjustment"/> class.
     *
     * RandomizedCalculationValueAdjustment constructor.
     * @param int $min The minimum of the value that can be generated and being used by the adjustment.
     * @param int $max The maximum of the value that can be generated and being used by the adjustment.
     * @param int $totalNumberOfConstantCalculations The total number of constant calculations.
     * @param callback $exclusionExpectation The exclusion expectation.
     */
    public function __construct($min, $max, $totalNumberOfConstantCalculations, $exclusionExpectation)
    {
        $this->min = $min;
        $this->max = $max;
        $this->totalNumberOfConstantCalculations = $totalNumberOfConstantCalculations;
        $this->exclusionExpectation = $exclusionExpectation;
    }
    #endregion

    #region Internal Methods
    /**
     * Resets the counters of the calculation adjustment.
     */
    function Reset()
    {
        $this->currentIdx = 0;
        $this->hitIndex = mt_rand(0, $this->totalNumberOfConstantCalculations);
    }
    #endregion

    #region Protected Methods
    /**
     * Visits the constant calculation.
     *
     * @param ConstantCalculation $constantCalculation
     */
    protected function VisitConstantCalculation(ConstantCalculation $constantCalculation)
    {
        if ($this->currentIdx == $this->hitIndex) {
            $constantCalculation->SetValue($this->GetValue());
        }

        $this->currentIdx++;
    }

    protected function VisitCompositeCalculation(CompositeCalculation $compositeCalculation)
    {
        // do nothing here
        // just make sure this class can be instantiated.
    }
    #endregion

    #region Private Methods
    private function GetValue()
    {
        $value = 0;

        if (!is_null($this->exclusionExpectation) && !isset($this->exclusionExpectation)) {
            do {
                if ($this->max == 0) {
                    $value = mt_rand(0, $this->min + 1);
                } else {
                    $value = mt_rand($this->min, $this->max + 1);
                }
            } while ($this->exclusionExpectation($value));
        } else {
            if ($this->max == 0) {
                $value = mt_rand(0, $this->min + 1);
            } else {
                $value = mt_rand($this->min, $this->max + 1);
            }
        }

        return $value;
    }
    #endregion
}