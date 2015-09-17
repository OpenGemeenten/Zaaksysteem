<?php
namespace SimplyAdmire\Zaaksysteem\Object;

use Iterator;
use SimplyAdmire\Zaaksysteem\Exception\RequestException;
use SimplyAdmire\Zaaksysteem\Exception\ResponseException;

class PagedResult implements Iterator
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var integer
     */
    private $index = 0;

    /**
     * @var array
     */
    private $pages = [];

    /**
     * @var integer
     */
    private $totalRows = 0;

    /**
     * @var integer
     */
    private $pageSize = 10;

    /**
     * @var string
     */
    private $itemClassName;

    /**
     * @param Client $client
     * @param string $itemClassName
     * @param string $path
     * @throws RequestException
     * @throws ResponseException
     */
    public function __construct(Client $client, $itemClassName, $path)
    {
        $this->client = $client;
        $this->itemClassName = $itemClassName;
        $this->path = $path;

        $this->addPage($this->client->request('GET', $this->path));
    }

    /**
     * @return integer
     */
    public function count()
    {
        return $this->totalRows;
    }

    /**
     * @param array $data
     * @return void
     */
    private function addPage(array $data)
    {
        $this->totalRows = $data['num_rows'];
        preg_match('/zapi_page=([0-9]+)/', $data['next'], $pageIndex);

        // Subtract 2 to get 0 based array index
        $pageIndex = (integer)$pageIndex[1] - 2;
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

    /**
     * @return void
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * @return integer
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        return $this->index < $this->totalRows;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->index = 0;
    }

}
