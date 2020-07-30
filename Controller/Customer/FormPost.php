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
namespace MageBootcamp\CustomerFitness\Controller\Customer;

use Exception;
use InvalidArgumentException;
use MageBootcamp\CustomerFitness\Api\Data\LogInterface;
use MageBootcamp\CustomerFitness\Api\Data\LogInterfaceFactory;
use MageBootcamp\CustomerFitness\Api\LogRepositoryInterface;
use MageBootcamp\CustomerFitness\Controller\Customer;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Magento\Framework\UrlInterface;

/**
 * The FormPost controller is responsible for handling a save action in the customer account
 */
class FormPost extends Customer
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * @var \MageBootcamp\CustomerFitness\Api\LogRepositoryInterface
     */
    protected $logRepository;

    /**
     * @var \MageBootcamp\CustomerFitness\Api\Data\LogInterfaceFactory
     */
    protected $logFactory;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @param \Magento\Framework\UrlInterface                            $url
     * @param \MageBootcamp\CustomerFitness\Api\Data\LogInterfaceFactory $logFactory
     * @param \MageBootcamp\CustomerFitness\Api\LogRepositoryInterface   $logRepository
     * @param \Magento\Framework\Data\Form\FormKey\Validator             $formKeyValidator
     * @param \Magento\Framework\App\Action\Context                      $context
     * @param \Magento\Customer\Model\Session                            $customerSession
     */
    public function __construct(
        UrlInterface $url,
        LogInterfaceFactory $logFactory,
        LogRepositoryInterface $logRepository,
        FormKeyValidator $formKeyValidator,
        Context $context,
        Session $customerSession
    ) {
        parent::__construct(
            $context,
            $customerSession
        );

        $this->formKeyValidator = $formKeyValidator;
        $this->logRepository = $logRepository;
        $this->logFactory = $logFactory;
        $this->url = $url;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $redirectUrl = null;
        /** Handle form key validation */
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        /** Handle invalid request type */
        if (!$this->getRequest()->isPost()) {
            return $this->resultRedirectFactory->create()->setUrl(
                $this->_redirect->error($this->_url->getUrl('*/*/edit'))
            );
        }

        try {
            /** Handle saving a fitness log based on the post data */
            $fitnessLog = $this->extractFitnessLog();
            $this->logRepository->save($fitnessLog);
            $this->messageManager->addSuccessMessage(__('You saved the fitness log.'));
            $url = $this->_url->getUrl('*/*/index', ['_secure' => true]);

            return $this->resultRedirectFactory->create()->setUrl($this->_redirect->success($url));
        } catch (InvalidArgumentException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (Exception $e) {
            $redirectUrl = $this->url->getUrl('*/*/index');
            $this->messageManager->addExceptionMessage($e, __('We can\'t save the fitness log.'));
        }

        return $this->resultRedirectFactory->create()->setUrl(
            $this->_redirect->error(
                $redirectUrl ?? $this->getEditUrl()
            )
        );
    }

    /**
     * Extract the request data posted to this controller
     *
     * @return \MageBootcamp\CustomerFitness\Api\Data\LogInterface
     */
    protected function extractFitnessLog(): LogInterface
    {
        $log = $this->logFactory->create()
            ->setWeight((float) $this->getRequest()->getParam('weight'))
            ->setHeight((float) $this->getRequest()->getParam('height'))
            ->setBodyFat((float) $this->getRequest()->getParam('body_fat'))
            ->setChestSize((float) $this->getRequest()->getParam('chest_size'))
            ->setWaistSize((float) $this->getRequest()->getParam('waist_size'))
            ->setHipSize((float) $this->getRequest()->getParam('hip_size'))
            ->setCustomerId($this->customerSession->getCustomerId());

        if ($this->getRequest()->getParam('id')) {
            $log->setEntityId((int) $this->getRequest()->getParam('id'));
        }

        return $log;
    }

    /**
     * @return string
     */
    protected function getEditUrl(): string
    {
        return $this->url->getUrl('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
    }
}
