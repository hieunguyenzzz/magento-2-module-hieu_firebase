<?php
/**
 * Created by PhpStorm.
 * User: hieunguyen
 * Date: 2/17/19
 * Time: 11:11 AM
 */

namespace Hieu\Firebase\Model;

use Hieu\Firebase\Model\Exception\FirebaseAuthenticationFailException;
use Magento\Framework\Exception\LocalizedException;

class Job implements JobInterface
{
    /**
     * @var \Hieu\Firebase\Model\Entity\EntityInterface[]
     */
    private $entities;
    /**
     * @var AdapterInterface
     */
    public $adapter;

    /**
     * Job constructor.
     * @param array $entities
     * @param AdapterInterface $adapter
     */
    public function __construct($entities = [], AdapterInterface $adapter)
    {
        $this->entities = $entities;
        $this->adapter = $adapter;
    }

    /**
     * @return array
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @throws \Google\Cloud\Core\Exception\GoogleException
     */
    public function process()
    {

    }

    /**
     * @throws \Google\Cloud\Core\Exception\GoogleException
     */
    public function batchProcess()
    {
        $i = 1;
        $batch = $this->adapter->getBatch();
        $database = $this->adapter->getDataBase();

        foreach ($this->entities as $entityName => $entity) {
            foreach ($entity->getItems() as $id => $data) {
                echo "$id" . "\n";
                $ref = $database->collection($entityName)->document($id);
                $batch->set($ref, $data);

                if ($i++ >= 100) {
                    $i = 1;
                    echo "commit \n";
                    $batch->commit();
                }
            }
        }

        if ($i > 1) {
            $batch->commit();
        }
    }
}