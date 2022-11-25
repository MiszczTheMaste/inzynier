<?php

declare(strict_types=1);

namespace App\Front\Application\UseCase\ViewPage;

final class ViewPageRequest
{
    private string $page;

    /**
     * @param string $page
     */
    public function __construct(string $page)
    {
        $this->page = $page;
    }

    /**
     * @return string
     */
    public function getPage(): string
    {
        return $this->page;
    }
}
