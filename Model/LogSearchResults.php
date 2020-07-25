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

use MageBootcamp\CustomerFitness\Api\Data\LogSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * This is the implementation of the interface that is used to handle a list response in the repository.
 * You can get and set the items but also get the count (due to the interface extend).
 */
class LogSearchResults extends SearchResults implements LogSearchResultsInterface
{
}
