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

use MageBootcamp\CustomerFitness\Api\Data\LogInterface;
use MageBootcamp\CustomerFitness\Api\Data\LogSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * The respository is responsible for all data related information of the customer fitness log.
 */
interface LogRepositoryInterface
{
    /**
     * @param int $entityId
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogInterface
     */
    public function get(int $entityId): LogInterface;

    /**
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterface $customerFitnessLog
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogInterface
     */
    public function save(LogInterface $customerFitnessLog): LogInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): LogSearchResultsInterface;

    /**
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterface $customerFitnessLog
     *
     * @return bool
     */
    public function delete(LogInterface $customerFitnessLog): bool;

    /**
     * Load the latest log that has customer sizes
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCustomerSizes(): LogInterface;
}
