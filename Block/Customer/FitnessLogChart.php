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
use MageBootcamp\CustomerFitness\Model\ResourceModel\LogRepository;
use MageBootcamp\SizeChart\Helper\UnitHelper;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template\Context;
use Magento\Newsletter\Model\SubscriberFactory;

class FitnessLogChart extends ListFitnessLog
{
    /**
     * The default border with of the chart
     */
    const DEFAULT_WIDTH = 2;

    /**
     * The color that is used when we can't determine the color
     */
    const FALLBACK_COLOR = '#000';

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected $json;

    /**
     * @param \Magento\Framework\Serialize\Serializer\Json                    $json
     * @param \MageBootcamp\SizeChart\Helper\UnitHelper                       $unitHelper
     * @param \MageBootcamp\CustomerFitness\Model\ResourceModel\LogRepository $logRepository
     * @param \Magento\Framework\View\Element\Template\Context                $context
     * @param \Magento\Customer\Model\Session                                 $customerSession
     * @param \Magento\Newsletter\Model\SubscriberFactory                     $subscriberFactory
     * @param \Magento\Customer\Api\CustomerRepositoryInterface               $customerRepository
     * @param \Magento\Customer\Api\AccountManagementInterface                $customerAccountManagement
     * @param \Magento\Framework\Api\SortOrderBuilder                         $sortOrderBuilder
     * @param \Magento\Framework\Api\SearchCriteriaBuilder                    $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder                            $filterBuilder
     * @param array                                                           $data
     */
    public function __construct(
        Json $json,
        UnitHelper $unitHelper,
        LogRepository $logRepository,
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
            $unitHelper,
            $logRepository,
            $context,
            $customerSession,
            $subscriberFactory,
            $customerRepository,
            $customerAccountManagement,
            $sortOrderBuilder,
            $searchCriteriaBuilder,
            $filterBuilder,
            $data
        );

        $this->json = $json;
    }

    /**
     * @return string
     */
    public function getChartData()
    {
        return $this->json->serialize($this->generateChartData());
    }

    /**
     * @return array
     */
    protected function generateChartData(): array
    {
        $dataSet = $this->indexDataset();

        return [
            'labels' => $this->getLabels($dataSet),
            'datasets' => $this->formatDataset($dataSet)
        ];
    }

    /**
     * @param array $dataSet
     *
     * @return array
     */
    protected function getLabels(array $dataSet): array
    {
        return $dataSet[LogInterface::CREATED_AT] ?? [];
    }

    /**
     * Get the type of format for a dataset ()
     *
     * @param array $dataSet
     *
     * @return array
     */
    protected function formatDataset(array $dataSet): array
    {
        return [
            $this->getChartLine(LogInterface::BMI, __('BMI'), $dataSet),
            $this->getChartBar(LogInterface::WEIGHT, __('Weight'), $dataSet),
            $this->getChartBar(LogInterface::BODY_FAT, __('Body Fat'), $dataSet)
        ];
    }

    /**
     * Assign log data to the dataset for the chart.
     *
     * @return array
     */
    protected function indexDataset(): array
    {
        foreach ($this->getLogs()->getItems() as $log) {
            $dataset[LogInterface::WEIGHT][] = $log->getWeight();
            $dataset[LogInterface::BODY_FAT][] = $log->getBodyFat();
            $dataset[LogInterface::CREATED_AT][] = $this->dateFormat($log->getCreatedAt());
            $dataset[LogInterface::BMI][] = $log->getBMI();
        }

        return $dataset ?? [];
    }

    /**
     * Get the bar chart information
     *
     * @param string $field
     * @param string $label
     * @param array  $dataSet
     *
     * @return array
     */
    protected function getChartBar(string $field, string $label, array $dataSet): array
    {
        return [
            'type' => 'bar',
            'label' => $label,
            'backgroundColor' => $this->getColor($field),
            'data' => $dataSet[$field] ?? [],
            'borderColor' => 'white',
            'borderWidth' => self::DEFAULT_WIDTH
        ];
    }

    /**
     * Get the chart line information
     *
     * @param string $field
     * @param string $label
     * @param array  $dataSet
     *
     * @return array
     */
    protected function getChartLine(string $field, string $label, array $dataSet): array
    {
        return [
            'type' => 'line',
            'label' => $label,
            'fill' => false,
            'data' => $dataSet[$field] ?? [],
            'borderColor' => $this->getColor($field),
            'borderWidth' => self::DEFAULT_WIDTH
        ];
    }

    /**
     * Get a color based on the field
     *
     * @param string $field
     *
     * @return string
     */
    protected function getColor(string $field): string
    {
        $fieldColorMapping = $this->getFieldColorMapping();

        return $fieldColorMapping[$field] ?? self::FALLBACK_COLOR;
    }

    /**
     * Get field color mapping.
     * You can set the value in the layout.xml
     *
     * @return array
     */
    protected function getFieldColorMapping(): array
    {
        return $this->getData('field_color_mapping') ?? [];
    }
}
