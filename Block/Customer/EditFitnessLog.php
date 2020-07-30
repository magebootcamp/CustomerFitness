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

use MageBootcamp\CustomerFitness\Api\Data\LogInterface;
use MageBootcamp\CustomerFitness\Api\Data\LogInterfaceFactory;
use MageBootcamp\CustomerFitness\Api\LogRepositoryInterface;
use MageBootcamp\SizeChart\Helper\UnitHelper;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Block\Account\Dashboard;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template\Context;
use Magento\Newsletter\Model\SubscriberFactory;

class EditFitnessLog extends Dashboard
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
     * @var \MageBootcamp\CustomerFitness\Api\Data\LogInterface
     */
    protected $log;

    /**
     * @var \MageBootcamp\CustomerFitness\Api\Data\LogInterfaceFactory
     */
    protected $logInterfaceFactory;

    /**
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterfaceFactory $logInterfaceFactory
     * @param \MageBootcamp\CustomerFitness\Api\LogRepositoryInterface   $logRepository
     * @param \Magento\Framework\View\Element\Template\Context           $context
     * @param \Magento\Customer\Model\Session                            $customerSession
     * @param \Magento\Newsletter\Model\SubscriberFactory                $subscriberFactory
     * @param \Magento\Customer\Api\CustomerRepositoryInterface          $customerRepository
     * @param \Magento\Customer\Api\AccountManagementInterface           $customerAccountManagement
     * @param \Magento\Framework\Api\SearchCriteriaBuilder               $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder                       $filterBuilder
     * @param \MageBootcamp\SizeChart\Helper\UnitHelper                  $displayHelper
     * @param array                                                      $data
     */
    public function __construct(
        LogInterfaceFactory $logInterfaceFactory,
        LogRepositoryInterface $logRepository,
        Context $context,
        Session $customerSession,
        SubscriberFactory $subscriberFactory,
        CustomerRepositoryInterface $customerRepository,
        AccountManagementInterface $customerAccountManagement,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        UnitHelper $displayHelper,
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
        $this->logInterfaceFactory = $logInterfaceFactory;
    }

    /**
     * @return array
     */
    public function getFormFields(): array
    {
        return [
            LogInterface::WEIGHT => __('Weight'),
            LogInterface::HEIGHT => __('Height'),
            LogInterface::BODY_FAT => __('Body Fat (%)'),
            LogInterface::CHEST_SIZE => __('Chest Size'),
            LogInterface::WAIST_SIZE => __('Waist Size'),
            LogInterface::HIP_SIZE => __('Hip Size'),
        ];
    }

    /**
     * @return string
     */
    public function getSaveUrl(): string
    {
        return $this->getUrl(
            'fitness/customer/formPost',
            $this->getLogId()
                ? ['id' => $this->getLogId()]
                : []
        );
    }

    /**
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogInterface
     */
    public function getLog(): LogInterface
    {
        if (!$this->log) {
            if (!$this->getLogId()) {
                $this->log = $this->logInterfaceFactory->create();
            } else {
                try {
                    $this->log = $this->logRepository->get($this->getLogId());
                } catch (\Exception $e) {
                    $this->log = $this->logInterfaceFactory->create();
                }
            }
        }

        return $this->log;

    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getLogData(string $key)
    {
        $logData = $this->getLog()->__toArray();

        return $logData[$key] ?? null;
    }

    /**
     * @return int|null
     */
    protected function getLogId(): ?int
    {
        return $this->_request->getParam('id');
    }
}
