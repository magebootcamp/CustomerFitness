<?php
/**
 * Copyright (c) MageBootcamp 2020.
 *
 * Created by MageBootcamp: The Ultimate Online Magento Course.
 * We are here to help you become a Magento PRO.
 * Watch and learn at https://magebootcamp.com.
 *
 * @author Daniel Donselaar
 */
namespace MageBootcamp\CustomerFitness\Model;

use MageBootcamp\CustomerFitness\Api\BMICalculatorInterface;
use Magento\Framework\Exception\InputException;

/**
 * A dedicated calculator to calculate the BMI of a customer.
 * The BMI calculation is dependent of the unit system, make sure you are using the right system for your store.
 */
class BMICalculator implements BMICalculatorInterface
{
    /**
     * @param float  $weight
     * @param float  $height
     * @param string $system
     *
     * @return float
     * @throws \Magento\Framework\Exception\InputException
     */
    public function calculateBMI(float $weight, float $height, string $system): float
    {
        if (!($system === self::IMPERIAL_SYSTEM || $system === self::METRIC_SYSTEM)) {
            throw new InputException(__('System can only be imperial or metric.'));
        }

        $bmi = $weight / (($height / 100) * 2);

        return round(
            $system === self::IMPERIAL_SYSTEM ? $bmi * self::IMPERIAL_CONVERT_NUMBER : $bmi,
            2
        );
    }
}
