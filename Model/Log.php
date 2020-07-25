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

use MageBootcamp\CustomerFitness\Api\BMICalculatorInterface;
use MageBootcamp\CustomerFitness\Api\Data\LogInterface;
use MageBootcamp\CustomerFitness\Api\Data\LogInterfaceFactory;
use MageBootcamp\SizeChart\Helper\UnitHelper;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;

/**
 * The model represents the data from a log record.
 */
class Log extends AbstractModel
{
    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var \MageBootcamp\CustomerFitness\Api\Data\LogInterfaceFactory
     */
    protected $logInterfaceFactory;

    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \MageBootcamp\CustomerFitness\Api\BMICalculatorInterface
     */
    protected $BMICalculator;

    /**
     * @var \MageBootcamp\SizeChart\Helper\UnitHelper
     */
    protected $unitHelper;

    /**
     * @param \MageBootcamp\SizeChart\Helper\UnitHelper                  $unitHelper
     * @param \MageBootcamp\CustomerFitness\Api\BMICalculatorInterface   $BMICalculator
     * @param \Magento\Framework\Reflection\DataObjectProcessor          $dataObjectProcessor
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterfaceFactory $logInterfaceFactory
     * @param \Magento\Framework\Api\DataObjectHelper                    $dataObjectHelper
     * @param \Magento\Framework\Model\Context                           $context
     * @param \Magento\Framework\Registry                                $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource    $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb              $resourceCollection
     * @param array                                                      $data
     */
    public function __construct(
        UnitHelper $unitHelper,
        BMICalculatorInterface $BMICalculator,
        DataObjectProcessor $dataObjectProcessor,
        LogInterfaceFactory $logInterfaceFactory,
        DataObjectHelper $dataObjectHelper,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );

        $this->dataObjectHelper = $dataObjectHelper;
        $this->logInterfaceFactory = $logInterfaceFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->BMICalculator = $BMICalculator;
        $this->unitHelper = $unitHelper;
    }

    /**
     * Reference to the resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(ResourceModel\Log::class);
    }

    /**
     * Get log data model based on this object data.
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogInterface
     */
    public function getDataModel(): LogInterface
    {
        /** @var \MageBootcamp\CustomerFitness\Api\Data\LogInterface $logDataModel */
        $logDataModel = $this->logInterfaceFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $logDataModel,
            $this->getData(),
            LogInterface::class
        );

        return $logDataModel;
    }

    /**
     * Update log data object by copying the data from the interface data object.
     *
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterface $log
     *
     * @return $this
     */
    public function updateData(LogInterface $log): Log
    {
        $dataAttributes = $this->dataObjectProcessor->buildOutputDataArray($log, LogInterface::class);
        foreach ($dataAttributes as $attributeCode => $attributeData) {
            $this->setDataUsingMethod($attributeCode, $attributeData);
        }

        $customAttributes = $log->getExtensionAttributes();
        if ($customAttributes !== null) {
            foreach ($customAttributes as $attribute) {
                $this->setData($attribute->getAttributeCode(), $attribute->getValue());
            }
        }

        if (!$this->getData(LogInterface::BMI)) {
            $this->setData(LogInterface::BMI, $this->calculateBMI());
        }

        $entityId = $log->getEntityId();
        if ($entityId) {
            $this->setId($entityId);
        }

        return $this;
    }

    /**
     * Calculate the BMI using the BMICalculatorInterface
     *
     * @return float
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function calculateBMI(): float
    {
        return $this->BMICalculator->calculateBMI(
            $this->getWeight(),
            $this->getHeight(),
            $this->unitHelper->useMetricSystem()
                ? BMICalculatorInterface::METRIC_SYSTEM
                : BMICalculatorInterface::IMPERIAL_SYSTEM
        );
    }
}
