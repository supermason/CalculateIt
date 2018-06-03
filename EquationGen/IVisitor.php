<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 13:46
 */

namespace EquationGen;

/**
 * Represents that the implemented classes are object hierarchy visitors.
 *
 * Interface IVisitor
 * @package EquationGen
 */
interface IVisitor
{
    /**
     * Visits the given object as an acceptor.
     *
     * @param IVisitorAcceptor $acceptor The object being visited.
     * @return mixed
     */
    function Visit(IVisitorAcceptor $acceptor);
}