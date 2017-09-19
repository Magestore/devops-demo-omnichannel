<?php
/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\InventorySuccess\Ui\DataProvider\TransferStock\Request\Form;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;


class DeliveryProductSelection extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var \Magestore\InventorySuccess\Model\Warehouse\WarehouseManagement
     */
    protected $warehouseManagement;



    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * Product collection
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected $collection;

    /**
     * @var  \Magestore\InventorySuccess\Model\Locator\LocatorFactory $locatorFactory
     */
    protected $locatorFactory;

    /**
     * @var \Magento\Ui\DataProvider\AddFieldToCollectionInterface[]
     */
    protected $addFieldStrategies;

    /**
     * @var \Magento\Ui\DataProvider\AddFilterToCollectionInterface[]
     */
    protected $addFilterStrategies;

    /** @var  \Magestore\InventorySuccess\Model\TransferStockFactory */
    protected $_transferStockFactory;

    /** @var  \Magestore\InventorySuccess\Model\TransferStock\TransferStockProductFactory */
    protected $_transferStockProductFactory;

    /** @var  \Magestore\InventorySuccess\Model\ResourceModel\TransferStock\TransferStockProduct\CollectionFactory */
    protected $_collectionFactory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param \Magestore\InventorySuccess\Model\Warehouse\WarehouseManagement $warehouseManagement
     * @param \Magento\Framework\App\RequestInterface request
     * @param \Magestore\InventorySuccess\Model\ResourceModel\AdjustStock $adjustStockResource
     * @param \Magestore\InventorySuccess\Model\AdjustStockFactory $adjustStockFactory
     * @param \Magento\Ui\DataProvider\AddFieldToCollectionInterface[] $addFieldStrategies
     * @param \Magento\Ui\DataProvider\AddFilterToCollectionInterface[] $addFilterStrategies
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magestore\InventorySuccess\Model\ResourceModel\TransferStock\TransferStockProduct\CollectionFactory $collectionFactory,
        \Magestore\InventorySuccess\Model\Warehouse\WarehouseManagement $warehouseManagement,
        \Magento\Framework\App\RequestInterface $request,
        \Magestore\InventorySuccess\Model\Locator\LocatorFactory $locatorFactory,
        \Magestore\InventorySuccess\Model\TransferStockFactory $transferStockFactory,
        \Magestore\InventorySuccess\Model\TransferStock\TransferStockProductFactory $transferStockProductFactory,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->request = $request;
        $this->warehouseManagement = $warehouseManagement;

        $this->locatorFactory = $locatorFactory;
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
        $this->_transferStockFactory = $transferStockFactory;
        $this->_transferStockProductFactory = $transferStockProductFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->collection = $this->getProductCollection();

    }



    /**
     * {@inheritdoc}
     */
    public function getProductCollection()
    {
        /** @var \Magestore\InventorySuccess\Model\Locator\Locator $locator */
        $locator = $this->locatorFactory->create();
        $transferstockId = $locator->getCurrentTransferstockId();
        $warehouseId = $this->getWarehouseId();
        $collection = $this->_collectionFactory->create()->getTransferStockProduct($transferstockId, $warehouseId);
        return $collection;
    }

    public function getTransferProductList(){
        /** @var \Magestore\InventorySuccess\Model\Locator\Locator $locator */
        $locator = $this->locatorFactory->create();
        $transferstockId = $locator->getCurrentTransferstockId();
        $products = $this->_transferStockProductFactory->create()->getProducts($transferstockId);
        $productIds = [];
        foreach ($products as $product){
            $productIds[] = $product->getProductId();
        }
        $productIds = implode(",", $productIds);
        return $productIds;
    }

    /**
     * Get current Adjustment
     *
     * @return Adjustment
     * @throws NoSuchEntityException
     */
    public function getWarehouseId()
    {
        /** @var \Magestore\InventorySuccess\Model\Locator\Locator $locator */
        $locator = $this->locatorFactory->create();
        $transferstockId = $locator->getCurrentTransferstockId();
        $transferStock = $this->_transferStockFactory->create()->load($transferstockId);
        $warehouseId = $transferStock->getSourceWarehouseId();
        return $warehouseId;
    }



}