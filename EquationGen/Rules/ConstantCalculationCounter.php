<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 16:26
 */

namespace EquationGen\Rules;


use EquationGen\CalculationVisitor;
use EquationGen\CompositeCalculation;
use EquationGen\ConstantCalculation;

class ConstantCalculationCounter extends CalculationVisitor
{
    #region Private Fields
    private $numOfConstantCalculations;
    #endregion

    #region Public Properties
    /**
     * Gets the number of constant calculations.
     *
     * @return int
     */
    public function NumOfConstantCalculations()
    {
        return $this->numOfConstantCalculations;
    }
    #endregion

    #region Protected Methods
    /**
     * Visits the constant calculation.
     *
     * @param ConstantCalculation $constantCalculation The constant calculation.
     */
    protected function VisitConstantCalculation(ConstantCalculation $constantCalculation)
    {
//        parent::VisitConstantCalculation($constantCalculation);
        $this->numOfConstantCalculations++;
    }

    /**
     * bla...bla...
     *
     * @param CompositeCalculation $compositeCalculation
     */
    protected function VisitCompositeCalculation(CompositeCalculation $compositeCalculation)
    {
        // do nothing here
        // just make sure this class can be instantiated.
    }
    #endregion
}