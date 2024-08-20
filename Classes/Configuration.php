<?php
declare(strict_types=1);

namespace GeorgRinger\PressrelationsNewsImport;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use UnexpectedValueException;

class Configuration
{

    protected string $apiKey;
    protected string $apiUrl;

    public function __construct()
    {
        try {
            $configuration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('pressrelations_news_import');
            $this->apiKey = $configuration['apiKey'] ?? '';
            $this->apiUrl = $configuration['apiUrl'] ?? '';
        } catch (\Exception $e) {
            // do nothing
        }
        $this->validate();
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getApiUrl(): string
    {
        return trim($this->apiUrl, '/') . '/';
    }

    protected function validate(): void
    {
        if (empty($this->apiKey)) {
            throw new UnexpectedValueException('No API key found', 1599727379);
        }
        if (empty($this->apiUrl)) {
            throw new UnexpectedValueException('No API url found', 1599727380);
        }
    }
}
