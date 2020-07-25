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
namespace MageBootcamp\CustomerFitness\Block\Sidebar;

use MageBootcamp\SizeChart\Setup\Patch\Data\AddProductAttributes;
use Magento\Framework\View\Element\Template;

class CustomerSize extends Template
{
    /**
     * The api path defined in webapi.xml
     */
    const REST_API_URI = 'rest/V1/customer/sizes';

    /**
     * Retrieve serialized JS layout configuration ready to use in template
     *
     * @return string
     */
    public function getJsLayout()
    {
        $this->jsLayout['components']['customerSize']['config']['customerSizesUri'] = $this->getCustomerSizesUri();
        $this->jsLayout['components']['customerSize']['config']['fields'] = [
            AddProductAttributes::ATTRIBUTE_CHEST_SIZE,
            AddProductAttributes::ATTRIBUTE_WAIST_SIZE,
            AddProductAttributes::ATTRIBUTE_HIP_SIZE
        ];

        return parent::getJsLayout();
    }

    /**
     * Get the customer size REST API URI
     *
     * @return string
     */
    protected function getCustomerSizesUri(): string
    {
        return $this->getBaseUrl() . self::REST_API_URI;
    }

    /**
     * Get the fitness progress overview page
     *
     * @return string
     */
    public function getAccountSizeUrl(): string
    {
        return $this->getUrl('fitness/customer');
    }
}
