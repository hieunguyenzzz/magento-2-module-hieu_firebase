<?php

namespace Hieu\Firebase\Model;

use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Firestore\FirestoreClient;

interface AdapterInterface
{
    /**
     * @param $collectionName
     * @param $id
     * @param $body
     * @throws GoogleException
     */
    public function saveDocument($collectionName, $id, $body);

    /**
     * @param $collectionName
     * @param $id
     * @param $body
     * @throws GoogleException
     */
    public function saveDocumentInBatch($collectionName, $id, $body);

    /**
     * @param $collectionName string
     * @param $id string
     * @return \Google\Cloud\Firestore\DocumentReference
     * @throws GoogleException
     */
    public function getDocumentRef($collectionName, $id);

    /**
     * @throws GoogleException
     */
    public function commit();

    /**
     * @return \Google\Cloud\Firestore\WriteBatch
     */
    public function getBatch();

    /**
     * @return FirestoreClient
     */
    public function getDataBase();
}