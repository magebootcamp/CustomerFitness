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
namespace MageBootcamp\CustomerFitness\Controller\Customer;

use MageBootcamp\CustomerFitness\Controller\Customer;

/**
 * This controller is responsible for editing a log in the customer account.
 */
class Edit extends Customer
{
    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->getResultPage()->getConfig()->getTitle()->set(__('Edit Fitness Log'));

        return parent::execute();
    }
}
