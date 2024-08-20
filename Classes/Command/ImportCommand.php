<?php

declare(strict_types=1);

namespace GeorgRinger\PressrelationsNewsImport\Command;

use GeorgRinger\PressrelationsNewsImport\Job\ImportJob;
use GeorgRinger\PressrelationsNewsImport\PressRelations\Api;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ImportCommand extends Command
{

    protected function configure()
    {
        $this
            ->addOption(
                'url',
                'u',
                InputOption::VALUE_NONE,
                'URL to fetch from',
            )
            ->addOption(
                'project',
                'p',
                InputOption::VALUE_REQUIRED,
                'Project ID'
            )
            ->addOption(
                'pid',
                'pid',
                InputOption::VALUE_REQUIRED,
                'Target Page'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Import news from Press Relations');

        $project = (int)$input->getOption('project');
        $pid = (int)$input->getOption('pid');
        if ($pid === 0) {
            $io->error('No pid given');
            return 1;
        }
        if ($project === 0) {
            $io->error('No project ID given');
            return 1;
        }

        $api = GeneralUtility::makeInstance(Api::class);
        $data = $api->fetchByProjectId($project);
        $news = $data['data'] ?? [];
        if (empty($news)) {
            $io->error('No news found');
            return 1;
        }

        $importJob = GeneralUtility::makeInstance(ImportJob::class);
        $count = $importJob->run($news, $pid);
        $io->success('Imported ' . $count . ' news');

        return 0;
    }
}
