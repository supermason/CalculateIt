<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 15:50
 */

namespace EquationGen;

/**
 * Represents the visitor that can visit each node of a calculation.
 *
 * Class CalculationVisitor
 * @package EquationGen
 */
abstract class CalculationVisitor implements IVisitor
{
    #region Public Methods
    /**
     * Visits the given object as an acceptor.
     *
     * @param IVisitorAcceptor $acceptor
     * @return void
     */
    public function Visit(IVisitorAcceptor $acceptor)
    {
        if ($acceptor instanceof ConstantCalculation) {
            $this->VisitConstantCalculation($acceptor);
        }

        if ($acceptor instanceof CompositeCalculation) {
            $this->VisitCompositeCalculation($acceptor);
        }

    }
    #endregion

    #region Protected Methods
    /**
     * Visits the constant calculation.
     *
     * @param ConstantCalculation $constantCalculation
     * @return void
     */
    protected abstract function VisitConstantCalculation(ConstantCalculation $constantCalculation);

    /**
     * Visits the composite calculation.
     *
     * @param CompositeCalculation $compositeCalculation
     * @return void
     */
    protected abstract function VisitCompositeCalculation(CompositeCalculation $compositeCalculation);
    #endregion

}