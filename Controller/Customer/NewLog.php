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
 * The NewLog controller is responsible for the form to create a new log.
 */
class NewLog extends Customer
{
    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->getResultPage()->getConfig()->getTitle()->set(__('New Fitness Log'));

        return parent::execute();
    }
}
