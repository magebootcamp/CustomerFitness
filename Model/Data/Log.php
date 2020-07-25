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
namespace MageBootcamp\CustomerFitness\Model\Data;

use MageBootcamp\CustomerFitness\Api\Data\LogInterface;
use MageBootcamp\CustomerFitness\Api\Data\LogExtensionInterface;
use Magento\Framework\Api\AbstractExtensibleObject;

/**
 * This is the implementation of the interface for the entity log, this entity is linked to a customer and store.
 * The fields created at and updated at are initialized and updated on save.
 * All other fields are data fields regarding the customer fitness.
 */
class Log extends AbstractExtensibleObject implements LogInterface
{
    /**
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->_get(self::ENTITY_ID);
    }

    /**
     * @param int $entityId
     *
     * @return $this
     */
    public function setEntityId($entityId): LogInterface
    {
        $this->setData(self::ENTITY_ID, $entityId);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * @param int $customerId
     *
     * @return $this
     */
    public function setCustomerId($customerId): LogInterface
    {
        $this->setData(self::CUSTOMER_ID, $customerId);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStoreId(): ?int
    {
        return $this->_get(self::STORE_ID);
    }

    /**
     * @param int $storeId
     *
     * @return $this
     */
    public function setStoreId($storeId): LogInterface
    {
        $this->setData(self::STORE_ID, $storeId);

        return $this;
    }

    /**
     * @return float|null
     */
    public function getWeight(): ?float
    {
        return $this->_get(self::WEIGHT);
    }

    /**
     * @param float $weight
     *
     * @return $this
     */
    public function setWeight(float $weight): LogInterface
    {
        $this->setData(self::WEIGHT, $weight);

        return $this;
    }

    /**
     * @return float|null
     */
    public function getHeight(): ?float
    {
        return $this->_get(self::HEIGHT);
    }

    /**
     * @param float $height
     *
     * @return $this
     */
    public function setHeight(float $height): LogInterface
    {
        $this->setData(self::HEIGHT, $height);

        return $this;
    }

    /**
     * @return float|null
     */
    public function getBodyFat(): ?float
    {
        return $this->_get(self::BODY_FAT);
    }

    /**
     * @param float $bodyFat
     *
     * @return $this
     */
    public function setBodyFat(float $bodyFat): LogInterface
    {
        $this->setData(self::BODY_FAT, $bodyFat);

        return $this;
    }

    /**
     * @return float|null
     */
    public function getBMI(): ?float
    {
        return $this->_get(self::BMI);
    }

    /**
     * @param float $BMI
     *
     * @return $this
     */
    public function setBMI(float $BMI): LogInterface
    {
        $this->setData(self::BMI, $BMI);

        return $this;
    }

    /**
     * @return float|null
     */
    public function getChestSize(): ?float
    {
        return $this->_get(self::CHEST_SIZE);
    }

    /**
     * @param float $chestSize
     *
     * @return $this
     */
    public function setChestSize(float $chestSize): LogInterface
    {
        $this->setData(self::CHEST_SIZE, $chestSize);

        return $this;
    }

    /**
     * @return float|null
     */
    public function getWaistSize(): ?float
    {
        return $this->_get(self::WAIST_SIZE);
    }

    /**
     * @param float $waistSize
     *
     * @return $this
     */
    public function setWaistSize(float $waistSize): LogInterface
    {
        $this->setData(self::WAIST_SIZE, $waistSize);

        return $this;
    }

    /**
     * @return float|null
     */
    public function getHipSize(): ?float
    {
        return $this->_get(self::HIP_SIZE);
    }

    /**
     * @param float $hipSize
     *
     * @return $this
     */
    public function setHipSize(float $hipSize): LogInterface
    {
        $this->setData(self::HIP_SIZE, $hipSize);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt): LogInterface
    {
        $this->setData(self::CREATED_AT, $createdAt);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->_get(self::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt): LogInterface
    {
        $this->setData(self::UPDATED_AT, $updatedAt);

        return $this;
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogExtensionInterface|null
     */
    public function getExtensionAttributes(): ?LogExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     *
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogExtensionInterface $extensionAttributes
     *
     * @return $this
     */
    public function setExtensionAttributes(LogExtensionInterface $extensionAttributes): LogInterface
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
