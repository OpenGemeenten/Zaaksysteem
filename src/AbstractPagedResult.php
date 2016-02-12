<?php
namespace SimplyAdmire\Zaaksysteem;

use Iterator;
use SimplyAdmire\Zaaksysteem\Exception\RequestException;
use SimplyAdmire\Zaaksysteem\Exception\ResponseException;

abstract class AbstractPagedResult implements Iterator
{

    /**
     * @var AbstractClient
     */
    protected $client;

    /**
     * @var integer
     */
    protected $index = 0;

    /**
     * @var array
     */
    protected $pages = [];

    /**
     * @var integer
     */
    protected $totalRows = 0;

    /**
     * @var integer
     */
    protected $pageSize = 10;

    /**
     * @var string
     */
    protected $itemClassName;

    /**
     * @param AbstractClient $client
     * @param string $itemClassName
     * @param string $path
     * @throws RequestException
     * @throws ResponseException
     */
    public function __construct(AbstractClient $client, $itemClassName, $path)
    {
        $this->client = $client;
        $this->itemClassName = $itemClassName;
        $this->path = $path;

        $this->addPage($this->client->request('GET', $this->path), 0);
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
     * @param integer $pageIndex
     * @return void
     */
    abstract protected function addPage(array $data, $pageIndex);

    /**
     * @return object
     * @throws RequestException
     * @throws ResponseException
     */
    abstract public function current();

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
