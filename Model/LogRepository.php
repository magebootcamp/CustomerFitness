<?php
/**
 * Copyright (c) MageBootcamp 2020.
 * Created by MageBootcamp: The Ultimate Online Magento Course.
 * We are here to help you become a Magento PRO.
 * Watch and learn at https://magebootcamp.com.
 * @author Daniel Donselaar
 */
namespace MageBootcamp\CustomerFitness\Model\ResourceModel;

use Exception;
use MageBootcamp\CustomerFitness\Api\Data\LogSearchResultsInterface;
use MageBootcamp\CustomerFitness\Api\Data\LogSearchResultsInterfaceFactory;
use MageBootcamp\CustomerFitness\Api\Data\LogInterfaceFactory;
use MageBootcamp\CustomerFitness\Api\LogRepositoryInterface;
use MageBootcamp\CustomerFitness\Api\Data\LogInterface;
use MageBootcamp\CustomerFitness\Model\ResourceModel\Log\CollectionFactory;
use MageBootcamp\CustomerFitness\Model\LogFactory;
use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * The respository is responsible for all data related information of the customer fitness log.
 */
class LogRepository implements LogRepositoryInterface
{
    /**
     * @var \MageBootcamp\CustomerFitness\Model\LogFactory
     */
    protected $logFactory;

    /**
     * @var \MageBootcamp\CustomerFitness\Model\ResourceModel\LogInterfaceFactory
     */
    protected $logInterfaceFactory;

    /**
     * @var \MageBootcamp\CustomerFitness\Model\ResourceModel\Log\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \MageBootcamp\CustomerFitness\Model\ResourceModel\Log
     */
    protected $logResourceModel;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var \MageBootcamp\CustomerFitness\Api\Data\LogSearchResultsInterfaceFactory
     */
    protected $logSearchResultsFactory;

    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $joinProcessor;

    /**
     * @var \Magento\Authorization\Model\UserContextInterface
     */
    protected $userContext;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param \MageBootcamp\CustomerFitness\Model\LogFactory                          $logFactory
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterfaceFactory              $logInterfaceFactory
     * @param \MageBootcamp\CustomerFitness\Model\ResourceModel\Log\CollectionFactory $collectionFactory
     * @param \MageBootcamp\CustomerFitness\Model\ResourceModel\Log                   $logResourceModel
     * @param \Psr\Log\LoggerInterface                                                $logger
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface      $collectionProcessor
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogSearchResultsInterfaceFactory $logSearchResultsFactory
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface        $joinProcessor
     * @param \Magento\Authorization\Model\UserContextInterface                       $userContext
     * @param \Magento\Framework\Api\SortOrderBuilder                                 $sortOrderBuilder
     * @param \Magento\Framework\Api\SearchCriteriaBuilder                            $searchCriteriaBuilder
     */
    public function __construct(
        LogFactory $logFactory,
        LogInterfaceFactory $logInterfaceFactory,
        CollectionFactory $collectionFactory,
        Log $logResourceModel,
        LoggerInterface $logger,
        CollectionProcessorInterface $collectionProcessor,
        LogSearchResultsInterfaceFactory $logSearchResultsFactory,
        JoinProcessorInterface $joinProcessor,
        UserContextInterface $userContext,
        SortOrderBuilder $sortOrderBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->logFactory = $logFactory;
        $this->logInterfaceFactory = $logInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->logResourceModel = $logResourceModel;
        $this->logger = $logger;
        $this->collectionProcessor = $collectionProcessor;
        $this->logSearchResultsFactory = $logSearchResultsFactory;
        $this->joinProcessor = $joinProcessor;
        $this->userContext = $userContext;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param int $entityId
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogInterface
     */
    public function get(int $entityId): LogInterface
    {
        /** @var \MageBootcamp\CustomerFitness\Model\Log $logModel */
        $logModel = $this->logFactory->create();
        $this->logResourceModel->load($logModel, $entityId);

        return $logModel->getDataModel();
    }

    /**
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterface $customerFitnessLog
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(LogInterface $customerFitnessLog): LogInterface
    {
        $this->validateLog($customerFitnessLog);

        /** @var \MageBootcamp\CustomerFitness\Model\Log $logModel */
        $logModel = $this->logFactory->create();

        try {
            $this->logResourceModel->save($logModel->updateData($customerFitnessLog));
        } catch (Exception $e) {
            $this->logger->critical(
                sprintf(
                    "Couldn't save customer fitness log for customer id '%s' and entity id '%s' \n Exception: %s",
                    $customerFitnessLog->getCustomerId(),
                    $customerFitnessLog->getEntityId(),
                    $e->getMessage()
                )
            );

            throw new CouldNotSaveException(
                __("The customer fitness log couldn't be saved. Please verify your data."),
                $e
            );
        }

        return $logModel->getDataModel();
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): LogSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->joinProcessor->process($collection, LogInterface::class);
        $this->collectionProcessor->process($searchCriteria, $collection);

        $items = [];
        foreach ($collection->getData() as $logData) {
            $log = $this->logInterfaceFactory->create(['data' => $logData]);

            if (!$log->getBMI()) {
                try {
                    $log = $this->save($log);
                } catch (CouldNotSaveException $e) {
                    $this->logger->critical('Unable to save log when updating BMI in list action' . $e->getMessage());
                    continue;
                }
            }

            $items[] = $log;
        }

        return $this->logSearchResultsFactory->create()
            ->setSearchCriteria($searchCriteria)
            ->setItems($items)
            ->setTotalCount($collection->getSize());
    }

    /**
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterface $customerFitnessLog
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(LogInterface $customerFitnessLog): bool
    {
        /** @var \MageBootcamp\CustomerFitness\Model\Log $logModel */
        $logModel = $this->logFactory->create();
        try {
            $this->logResourceModel->delete($logModel->updateData($customerFitnessLog));
        } catch (Exception $e) {
            $this->logger->critical(
                sprintf(
                    "Couldn't delete customer fitness log for customer id '%s' and entity id '%s' \n Exception: %s",
                    $customerFitnessLog->getCustomerId(),
                    $customerFitnessLog->getEntityId(),
                    $e->getMessage()
                )
            );

            throw new CouldNotDeleteException(
                __("Enable to delete customer fitness log. Please contact support for more information."),
                $e
            );
        }

        return true;
    }

    /**
     * Load the latest log that has customer sizes
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCustomerSizes(): LogInterface
    {
        $sortOrder = $this->sortOrderBuilder
            ->setField(LogInterface::CREATED_AT)
            ->setDirection(SortOrder::SORT_DESC)
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(
                LogInterface::CUSTOMER_ID,
                $this->userContext->getUserId()
            )->addFilter(
                LogInterface::CHEST_SIZE,
                true,
                'notnull'
            )->addFilter(
                LogInterface::WAIST_SIZE,
                true,
                'notnull'
            )->addFilter(
                LogInterface::HIP_SIZE,
                true,
                'notnull'
            )->addSortOrder($sortOrder)->create();

        $customerLogs = $this->getList($searchCriteria);
        if ($customerLogs->getTotalCount() === 0) {
            throw new NoSuchEntityException(__('No log found'));
        }

        return current($customerLogs->getItems());
    }

    /**
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterface $log
     */
    protected function validateLog(LogInterface $log)
    {
        if ($log->getWeight() <= 0) {
            throw new \InvalidArgumentException('Weight needs to be more than zero');
        }

        if ($log->getHeight() <= 0) {
            throw new \InvalidArgumentException('Height needs to be more than zero');
        }

        if ($log->getBodyFat() <= 0) {
            throw new \InvalidArgumentException('Body Fat needs to be more than zero');
        }

        return true;
    }
}
