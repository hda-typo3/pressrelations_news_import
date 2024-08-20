<?php
declare(strict_types=1);

namespace GeorgRinger\PressrelationsNewsImport\PressRelations;

use GeorgRinger\PressrelationsNewsImport\Configuration;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Api
{

    public function __construct(
        protected readonly Configuration $configuration
    )
    {

    }

    /**
     * @throws \JsonException
     */
    public function fetchByProjectId(int $projectId): array
    {
        return $this->request('projects/' . $projectId . '/news');
    }

    protected function request(string $apiPart): array
    {
        $url = $this->configuration->getApiUrl() . $apiPart;
        $options['headers'] = [
            'Authorization' => 'Bearer ' . $this->configuration->getApiKey(),
        ];
        $requestFactory = GeneralUtility::makeInstance(RequestFactory::class);
        $response = $requestFactory->request($url, 'GET', $options);

        if ($response->getStatusCode() !== 200) {
            throw new \UnexpectedValueException(sprintf('Error fetching %s', $url), 1599727379);
        }
        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

}
