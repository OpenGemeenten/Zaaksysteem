<?php
namespace SimplyAdmire\Zaaksysteem\V1;

use SimplyAdmire\Zaaksysteem\AbstractPagedResult;
use SimplyAdmire\Zaaksysteem\Exception\RequestException;
use SimplyAdmire\Zaaksysteem\Exception\ResponseException;

class PagedResult extends AbstractPagedResult
{

    /**
     * @param array $data
     * @return void
     */
    protected function addPage(array $data)
    {
        $this->totalRows = $data['pager']['total_rows'];
        $pageIndex = $data['pager']['page'] - 1;
        $this->pages[$pageIndex] = [];

        foreach ($data['rows'] as $value) {
            $this->pages[$pageIndex][] = new $this->itemClassName($value['instance']);
        }
    }

    /**
     * @return object
     * @throws RequestException
     * @throws ResponseException
     */
    public function current()
    {
        $page = 0;
        $index = 0;

        if ($this->index > 0) {
            $page = floor($this->index / $this->pageSize);
            $index = $this->index % $this->pageSize;
        }

        if (!isset($this->pages[$page])) {
            $url = $this->path . '?page=' . ($page + 1);
            $this->addPage($this->client->request('GET', $url));
        }

        return $this->pages[$page][$index];
    }

}
