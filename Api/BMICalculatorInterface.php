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
namespace MageBootcamp\CustomerFitness\Api;

/**
 * A dedicated calculator to calculate the BMI of a customer.
 * The BMI calculation is dependent of the unit system, make sure you are using the right system for your store.
 */
interface BMICalculatorInterface
{
    /**
     * Two types of supported unit systems
     */
    const METRIC_SYSTEM = 'metric';
    const IMPERIAL_SYSTEM = 'imperial';

    /**
     * Used in the calculator formula.
     */
    const IMPERIAL_CONVERT_NUMBER = 703;

    /**
     * Calculate the BMI based on the weight, height and unit system (e.g. Metric or Imperial)
     *
     * @param float  $weight
     * @param float  $height
     * @param string $system
     *
     * @return float
     * @throws \Magento\Framework\Exception\InputException
     */
    public function calculateBMI(float $weight, float $height, string $system): float;
}
