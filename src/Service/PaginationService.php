<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class PaginationService 
{
  private $entityClass;
  private $limit = 10;
  private $currentPage = 1;
  private $manager;

  public function __construct(ObjectManager $manager)
  {
    $this->manager = $manager;
  }

  public function getPages()
  {
    // Total pages of an entity for pagination
    $repository = $this->manager->getRepository($this->entityClass);
    $total = count($repository->findAll());
    $pages = ceil($total / $this->limit);
    
    return $pages;

  }

  public function getData()
  { 
    // offset
    $offset = $this->currentPage * $this->limit - $this->limit;
    // get elements with the repository
    $repository = $this->manager->getRepository($this->entityClass);
    $data = $repository->findBy([], [], $this->limit, $offset);

    return $data;
  }

  public function setCurrentPage($currentPage)
  {
    $this->currentPage = $currentPage;
    return $this->currentPage;
  }

  public function getCurrentPage()
  {
    return $this->currentPage;
  }

  public function setLimit($limit)
  {
    $this->limit = $limit;
    return $this;
  }

  public function getLimit()
  {
    return $this->limit;
  }

  public function setEntityClass($entityClass) 
  {
    $this->entityClass = $entityClass;
    return $this;
  }

  public function getEntityClass()
  {
    return $this->entityClass;
  }
}