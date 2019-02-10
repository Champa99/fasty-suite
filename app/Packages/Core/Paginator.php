<?php

/**
 * Auto created by artisan on 02.02.2019 at 15:41
 * @author Champa
 */

namespace App\Packages\Core;

class Paginator
{

	/**
	 * @var int
	 */
	private $page = 0;

	/**
	 * @var int
	 */
	private $pageSize = 10;

	/**
	 * Gets the database offset based on the page
	 */
	public function getOffset() : int {

		return ($this->page * $this->pageSize);
	}

    /**
     * Get the value of page
     *
     * @return  int
     */
    public function getPage() : int {

        return $this->page;
    }

    /**
     * Set the value of page
     *
     * @param   int  $page  
     *
     * @return  self
     */
    public function setPage(int $page) {

        $this->page = $page;

        return $this;
    }

    /**
     * Get the value of pageSize
     *
     * @return  int
     */
    public function getPageSize() : int {

        return $this->pageSize;
    }

    /**
     * Set the value of pageSize
     *
     * @param   int  $pageSize  
     *
     * @return  self
     */
    public function setPageSize(int $pageSize) {

        $this->pageSize = $pageSize;

        return $this;
    }
}