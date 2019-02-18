<?php

namespace Hieu\Firebase\Model;

interface JobInterface
{
    /**
     * @throws \Google\Cloud\Core\Exception\GoogleException
     */
    public function process();

    /**
     * @throws \Google\Cloud\Core\Exception\GoogleException
     */
    public function batchProcess();
}