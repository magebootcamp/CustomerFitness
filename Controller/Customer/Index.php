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

use MageBootcamp\CustomerFitness\Controller\Customer as CustomerController;

/**
 * The index controller is responsible for the overview of logs.
 */
class Index extends CustomerController
{
    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->getResultPage()->getConfig()->getTitle()->set(__('My Fitness Progress'));

        return parent::execute();
    }
}
