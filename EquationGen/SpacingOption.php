<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 14:16
 */

namespace EquationGen;

/**
 * Represents the spacing option when generating formatted string for the calculations.
 *
 * Class SpacingOption
 * @package EquationGen
 */
class SpacingOption
{
    /**
     * Indicates that no space should be added before and after the operator signs.
     */
    const None = 'None';

    /**
     *  Indicates that one space should be added before and after the operator signs.
     */
    const Thin = 'Thin';

    /**
     * Indicates that three spaces should be added before and after the operator signs.
     */
    const Thick = 'Thick';
}