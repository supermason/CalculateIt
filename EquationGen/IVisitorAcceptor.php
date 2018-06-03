<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 13:44
 */

namespace EquationGen;

/**
 * Represents that the implemented classes are visitor acceptors.
 *
 * Interface IVisitorAcceptor
 * @package EquationGen
 */
interface IVisitorAcceptor
{
    /**
     * Accepts the specified visitor.
     *
     * @param IVisitor $visitor The visitor instance to be accepted.
     * @return void
     */
    function Accept(IVisitor $visitor);
}