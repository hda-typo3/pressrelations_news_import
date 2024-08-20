<?php
declare(strict_types=1);

namespace GeorgRinger\PressrelationsNewsImport\Job;

use GeorgRinger\News\Domain\Service\NewsImportService;
use GeorgRinger\NewsImporticsxml\Domain\Model\Dto\TaskConfiguration;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ImportJob
{

    protected Logger $logger;
    protected NewsImportService $newsImportService;

    public function __construct(
        NewsImportService $newsImportService
    )
    {
        $this->newsImportService = $newsImportService;
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
    }

    public function run(array $news, int $pid): int
    {
        $dataToImport = [];
        foreach ($news as $rawNews) {
            $item = [
                'generate_path_segment' => true,
                'import_source' => 'pressrelations',
                'import_id' => $rawNews['id'],
                'type' => 2,
                'pid' => $pid,
                'title' => $rawNews['headline'],
                'teaser' => $rawNews['highlighted'],
                'content' => $rawNews['content'],
                'externalurl' => $rawNews['url'],
                '_dynamicData' => [
                    'full' => $rawNews,
                ],
            ];
            $date = new \DateTime($rawNews['clip_date']);
            $item['datetime'] = $date ? $date->getTimestamp() : 0;
//print_r($rawNews);die;
            $dataToImport[] = $item;
        }
        $this->newsImportService->import($dataToImport);
        return count($dataToImport);
    }
}
