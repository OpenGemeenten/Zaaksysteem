<?php
namespace SimplyAdmire\Zaaksysteem\Object;

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
        $this->totalRows = (integer)$data['num_rows'];
        if ($data['next'] === null) {
            $pageIndex = (integer)floor($this->totalRows / 10);
        } else {
            preg_match('/zapi_page=([0-9]+)/', $data['next'], $pageIndex);

            // Subtract 2 to get 0 based array index
            $pageIndex = (integer)$pageIndex[1] - 2;
        }

        $this->pages[$pageIndex] = [];

        foreach ($data['result'] as $value) {
            $this->pages[$pageIndex][] = new $this->itemClassName($value);
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
            $url = $this->path . '?zapi_page=' . ($page + 1);
            $this->addPage($this->client->request('GET', $url));
        }

        return $this->pages[$page][$index];
    }

}
