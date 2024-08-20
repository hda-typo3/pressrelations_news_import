# TYPO3 Extension `pressrelations_news_import`

This extensions provides an import of articles provided by https://pressrelations.de/ into the TYPO3 Extension `news`.

## Requirements

- TYPO3: 11 LTS, 12 LTS
- EXT:news: 10, 11

## Installation

Either install via composer with `composer req georgringer/pressrelations-news-import` or install via the TYPO3 Extension Manager.

## Usage

Define the required configuration in the extension settings:

- `apiKey`: The key is provided by PressRelations
- `apiUrl`: This looks typically like `https://public-api.pressrelations.de/rest/v1/`

Afterwards, you can import articles via the scheduler command or directly calling the import with the CLI command

```bash
./vendor/bin/typo3  news:pressrelations-import --pid=6 --project=123456
```