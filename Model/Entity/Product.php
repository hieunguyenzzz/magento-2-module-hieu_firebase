<?php

namespace Hieu\Firebase\Model\Entity;

use Hieu\Firebase\Model\AdapterInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;


class Product implements EntityInterface
{

    private $items = [];
    private $itemsFromFirestore = [];

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;
    /**
     * @var AdapterInterface
     */
    private $adapter;


    /**
     * Product constructor.
     * @param $collection
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        AdapterInterface $adapter
    )
    {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->adapter = $adapter;
        $this->loadItemFromFirestore();
    }

    /**
     * @return array
     * @todo find a way to be able to add filter dynamic
     */
    public function getItems()
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('visibility', 4)
            ->addFilter('status', 1)
            ->create();

        $searchResult = $this->productRepository->getList($searchCriteria);

        foreach ($searchResult->getItems() as $item) {
            if ($item->getTypeId() == 'simple') {
                $productData = [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'images' => $item->getImage(),
                    'price' => $item->getPrice(),
                    'sku' => $item->getSku(),
                    'description' => $item->getDescription(),
                    'short_description' => $item->getShortDescription()
                ];

                if (!empty($this->itemsFromFirestore[$item->getSku()]) && array_diff($productData, $this->itemsFromFirestore[$item->getSku()])) {
                    $this->items[$item->getSku()] = $productData;
                }
            }
        }
        return $this->items;
    }


    protected function loadItemFromFirestore()
    {
        $database = $this->adapter->getDataBase();

        $entityRef = $database->collection('product');
        $documents = $entityRef->documents();

        foreach ($documents as $document) {
            $this->itemsFromFirestore[$document->id()] = $document->data();
        }
    }

}