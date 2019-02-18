<?php

namespace Hieu\Firebase\Model;

use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Core\Exception\GoogleException;

class Adapter implements AdapterInterface
{
    protected $_db;

    /**
     * @return FirestoreClient
     * @throws GoogleException
     */
    public function getDatabase()
    {
        if (!isset($this->_db)) {
            $this->_db = new FirestoreClient();
        }
        return $this->_db;
    }

    /**
     * @param $collectionName
     * @param $id
     * @param $body
     * @throws GoogleException
     */
    public function saveDocument($collectionName, $id, $body)
    {
        $docRef = $this->getDatabase()->collection($collectionName)->document($id);
        $docRef->set($body);
    }

    /**
     * @param $collectionName
     * @param $id
     * @return \Google\Cloud\Firestore\DocumentReference
     * @throws GoogleException
     */
    public function getDocumentRef($collectionName, $id)
    {
        return $this->getDatabase()->collection($collectionName)->document($id);
    }

    /**
     * @return \Google\Cloud\Firestore\WriteBatch
     * @throws GoogleException
     */
    public function getBatch()
    {
        return $this->getDatabase()->batch();
    }

    /**
     * @throws GoogleException
     */
    public function startBatch()
    {
        $this->getBatch();
    }

    /**
     * @param $collectionName
     * @param $id
     * @param $body
     * @throws GoogleException
     */
    public function saveDocumentInBatch($collectionName, $id, $body)
    {
        $docRef = $this->getDatabase()->collection($collectionName)->document($id);
        $this->getBatch()->set($docRef, $body);
    }

    /**
     * @throws GoogleException
     */
    public function commit()
    {
        $this->getBatch()->commit();
    }
}