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

use Magento\Framework\Api\ExtensibleDataInterface;
use MageBootcamp\CustomerFitness\Api\Data\LogExtensionInterface;

/**
 * This is the interface for the entity log, this entity is linked to a customer and store.
 * The fields created at and updated at are initialized and updated on save.
 * All other fields are data fields regarding the customer fitness.
 */
interface LogInterface extends ExtensibleDataInterface
{
    const ENTITY_ID = 'entity_id';
    const CUSTOMER_ID = 'customer_id';
    const STORE_ID = 'store_id';
    const WEIGHT = 'weight';
    const HEIGHT = 'height';
    const BODY_FAT = 'body_fat';
    const BMI = 'BMI';
    const CHEST_SIZE = 'chest_size';
    const WAIST_SIZE = 'waist_size';
    const HIP_SIZE = 'hip_size';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * @param int $entityId
     *
     * @return $this
     */
    public function setEntityId(int $entityId): LogInterface;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * @param int $customerId
     *
     * @return $this
     */
    public function setCustomerId(int $customerId): LogInterface;

    /**
     * @return int|null
     */
    public function getStoreId(): ?int;

    /**
     * @param int $storeId
     *
     * @return $this
     */
    public function setStoreId(int $storeId): LogInterface;

    /**
     * @return float|null
     */
    public function getWeight(): ?float;

    /**
     * @param float $weight
     *
     * @return $this
     */
    public function setWeight(float $weight): LogInterface;

    /**
     * @return float|null
     */
    public function getHeight(): ?float;

    /**
     * @param float $height
     *
     * @return $this
     */
    public function setHeight(float $height): LogInterface;

    /**
     * @return float|null
     */
    public function getBodyFat(): ?float;

    /**
     * @param float $bodyFat
     *
     * @return $this
     */
    public function setBodyFat(float $bodyFat): LogInterface;

    /**
     * @return float|null
     */
    public function getBMI(): ?float;

    /**
     * @param float $BMI
     *
     * @return $this
     */
    public function setBMI(float $BMI): LogInterface;

    /**
     * @return float|null
     */
    public function getChestSize(): ?float;

    /**
     * @param float $chestSize
     *
     * @return $this
     */
    public function setChestSize(float $chestSize): LogInterface;

    /**
     * @return float|null
     */
    public function getWaistSize(): ?float;

    /**
     * @param float $waistSize
     *
     * @return $this
     */
    public function setWaistSize(float $waistSize): LogInterface;

    /**
     * @return float|null
     */
    public function getHipSize(): ?float;

    /**
     * @param float $hipSize
     *
     * @return $this
     */
    public function setHipSize(float $hipSize): LogInterface;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(string $createdAt): LogInterface;

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * @param string $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): LogInterface;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogExtensionInterface|null
     */
    public function getExtensionAttributes(): ?LogExtensionInterface;

    /**
     * Set an extension attributes object.
     *
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogExtensionInterface $extensionAttributes
     *
     * @return $this
     */
    public function setExtensionAttributes(
        LogExtensionInterface $extensionAttributes
    ): LogInterface;
}
