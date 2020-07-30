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
namespace MageBootcamp\CustomerFitness\Block\Customer;

use IntlDateFormatter;
use MageBootcamp\CustomerFitness\Api\Data\LogInterface;
use MageBootcamp\CustomerFitness\Api\Data\LogSearchResultsInterface;
use MageBootcamp\CustomerFitness\Api\LogRepositoryInterface;
use MageBootcamp\SizeChart\Helper\UnitHelper;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Block\Account\Dashboard;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template\Context;
use Magento\Newsletter\Model\SubscriberFactory;

class ListFitnessLog extends Dashboard
{
    /**
     * @var \MageBootcamp\CustomerFitness\Api\LogRepositoryInterface
     */
    protected $logRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var \MageBootcamp\SizeChart\Helper\UnitHelper
     */
    protected $unitHelper;

    /**
     * @param \MageBootcamp\SizeChart\Helper\UnitHelper                $unitHelper
     * @param \MageBootcamp\CustomerFitness\Api\LogRepositoryInterface $logRepository
     * @param \Magento\Framework\View\Element\Template\Context         $context
     * @param \Magento\Customer\Model\Session                          $customerSession
     * @param \Magento\Newsletter\Model\SubscriberFactory              $subscriberFactory
     * @param \Magento\Customer\Api\CustomerRepositoryInterface        $customerRepository
     * @param \Magento\Customer\Api\AccountManagementInterface         $customerAccountManagement
     * @param \Magento\Framework\Api\SortOrderBuilder                  $sortOrderBuilder
     * @param \Magento\Framework\Api\SearchCriteriaBuilder             $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder                     $filterBuilder
     * @param array                                                    $data
     */
    public function __construct(
        UnitHelper $unitHelper,
        LogRepositoryInterface $logRepository,
        Context $context,
        Session $customerSession,
        SubscriberFactory $subscriberFactory,
        CustomerRepositoryInterface $customerRepository,
        AccountManagementInterface $customerAccountManagement,
        SortOrderBuilder $sortOrderBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $customerSession,
            $subscriberFactory,
            $customerRepository,
            $customerAccountManagement,
            $data
        );

        $this->logRepository = $logRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->unitHelper = $unitHelper;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * Get a list of logs based on the customer id
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogSearchResultsInterface
     */
    public function getLogs(): LogSearchResultsInterface
    {
        $sortOrder = $this->sortOrderBuilder
            ->setField(LogInterface::CREATED_AT)
            ->setDirection(SortOrder::SORT_DESC)
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(
                LogInterface::CUSTOMER_ID,
                $this->customerSession->getCustomerId()
            )
            ->addSortOrder($sortOrder)
            ->create();

        return $this->logRepository->getList($searchCriteria);
    }

    /**
     * Get the edit link for a log
     *
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterface $log
     *
     * @return string
     */
    public function getLogLink(LogInterface $log): string
    {
        return $this->getUrl('fitness/customer/edit', ['id' => $log->getEntityId()]);
    }

    /**
     * Format date in short format
     *
     * @param string $date
     *
     * @return string
     */
    public function dateFormat(string $date): string
    {
        return $this->formatDate($date, IntlDateFormatter::MEDIUM);
    }

    /**
     * @return string
     */
    public function getWeightUnit(): string
    {
        return $this->unitHelper->getWeightUnit();
    }

    /**
     * @return string
     */
    public function getDistanceUnit(): string
    {
        return $this->unitHelper->getDistanceUnit();
    }
}
