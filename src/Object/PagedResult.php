<?php
namespace SimplyAdmire\Zaaksysteem\Object;

use SimplyAdmire\Zaaksysteem\AbstractPagedResult;
use SimplyAdmire\Zaaksysteem\Exception\RequestException;
use SimplyAdmire\Zaaksysteem\Exception\ResponseException;

class PagedResult extends AbstractPagedResult
{

    /**
     * @param array $data
     * @param integer $pageIndex
     * @return void
     */
    protected function addPage(array $data, $pageIndex)
    {
        $this->totalRows = (integer)$data['num_rows'];
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
            $this->addPage($this->client->request('GET', $url), $page);
        }

        return $this->pages[$page][$index];
    }

}
