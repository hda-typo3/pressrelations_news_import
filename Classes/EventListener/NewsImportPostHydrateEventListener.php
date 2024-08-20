<?php
declare(strict_types=1);

namespace GeorgRinger\PressrelationsNewsImport\EventListener;

use GeorgRinger\News\Event\NewsImportPostHydrateEvent;

class NewsImportPostHydrateEventListener
{

    public function __invoke(NewsImportPostHydrateEvent $event): void
    {
    }
}