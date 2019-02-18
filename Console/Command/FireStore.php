<?php

namespace Hieu\Firebase\Console\Command;

use Google\Cloud\Core\Exception\GoogleException;
use Hieu\Firebase\Model\JobInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Input\InputOption;
use Magento\Framework\App\State;

class FireStore extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var JobInterface
     */
    private $job;
    /**
     * @var State
     */
    private $state;

    /**
     * Test constructor.
     * @param JobInterface $job
     */
    public function __construct(JobInterface $job, State $state)
    {
        $this->job = $job;
        $this->state = $state;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('firestore:sync')
            ->setDescription('Sync data from magento to firestore');

        parent::configure();
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        try {
            $this->state->setAreaCode('adminhtml');
        } catch (LocalizedException $e) {
            $output->writeln($e->getMessage());
        }

        try {
            $this->job->batchProcess();
        } catch (GoogleException $e) {
            $output->writeln('GoogleException: ' . $e->getMessage());
        } catch (\Exception $e) {
            $output->writeln('Exception: ' . $e->getMessage());
        }
    }
}