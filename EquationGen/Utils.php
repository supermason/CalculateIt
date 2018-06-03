<?php
/**
 * Created by PhpStorm.
 * User: SuperMason
 * Date: 2018/6/1
 * Time: 14:19
 */

namespace EquationGen;

/**
 * Represents the utility class.
 *
 * Class Utils
 * @package EquationGen
 */
class Utils
{
    private static $OperatorSignsKV = [
        Operator::Add => "+",
        Operator::Sub => '-',
        Operator::Mul => '*',
        Operator::Div => '/',
    ];

    private static $OperatorSignsArr = [
        [Operator::Add => "+"],
        [Operator::Sub => '-'],
        [Operator::Mul => '*'],
        [Operator::Div => '/'],
    ];

    /**
     * Generates the calculation operator randomly.
     *
     * @param String $acceptableOperators The acceptable operators that can be considered into the operator generating.
     * @param Operator $bypass The operator that should be excluded from the generating operators.
     * @return Operator A randomly generated operator.
     */
    public static function GenerateRandomOperator($acceptableOperators, Operator $bypass = null)
    {
        if (is_null($bypass)) {
            $bypass = Operator::None;
        }

        // If the proposed bypassing operator is the only one that is allowed to be
        // returned, then return it.
        if ($bypass != Operator::None &&
            mb_strlen($acceptableOperators) == 1 &&
            strpos($acceptableOperators, static::$OperatorSignsKV[$bypass]) !== false) {
            return $bypass;
        }

        while (true) {
            $idx = mt_rand(0, 3);
            $sign = static::$OperatorSignsArr[$idx];
            foreach ($sign as $key => $value) {
                if (strpos($acceptableOperators, $value) !== false && $key != $bypass) {
                    return $key;
                }
            }
        }
    }

    /**
     *
     *
     * @param $source
     * @return array
     */
    public static function copyArray($source)
    {
        $copy = [];

        foreach ($source as $item) {
            array_push($copy, $item);
        }

        return $copy;
    }
}