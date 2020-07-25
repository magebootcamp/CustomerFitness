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
namespace MageBootcamp\CustomerFitness\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * This interface is used to handle a list response in the repository.
 * You can get and set the items but also get the count (due to the interface extend).
 */
interface LogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get list of customer fitness log entries.
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogInterface[]
     */
    public function getItems();

    /**
     * Set customer fitness log list.
     *
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
