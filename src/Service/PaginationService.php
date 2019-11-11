<?php

namespace App\Service;

use Twig\Environment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationService 
{
  private $entityClass;
  private $limit = 10;
  private $currentPage = 1;
  private $manager;
  private $twig;
  private $route;
  private $templatePath;

  public function __construct(ObjectManager $manager, Environment $twig, RequestStack $request, $templatePath)
  {
    $this->manager = $manager;
    $this->twig = $twig;
    $this->route = $request->getCurrentRequest()->attributes->get('_route');
    $this->templatePath = $templatePath;
  }


  public function display()
  {
    $this->twig->display($this->templatePath, [
      'page' => $this->currentPage,
      'pages' => $this->getPages(),
      'route' => $this->route
    ]);
  }

  public function getPages()
  { 
    if(empty($this->entityClass)) {
      throw new \Exception("Vous n'avez pas spécifié l'entitée sur laquelle vous voulez paginer, utilisez la methode setEntityClass du PaginationService !");
    }
    // Total pages of an entity for pagination
    $repository = $this->manager->getRepository($this->entityClass);
    $total = count($repository->findAll());
    $pages = ceil($total / $this->limit);
    
    return $pages;

  }

  public function getData()
  { 
    if(empty($this->entityClass)) {
      throw new \Exception("Vous n'avez pas spécifié l'entitée sur laquelle vous voulez paginer, utilisez la methode setEntityClass du PaginationService !");
    }
    // offset
    $offset = $this->currentPage * $this->limit - $this->limit;
    // get elements with the repository
    $repository = $this->manager->getRepository($this->entityClass);
    $data = $repository->findBy([], [], $this->limit, $offset);

    return $data;
  }

  public function setTemplatePath($templatePath)
  {
    $this->templatePath = $templatePath;
    return $this;
  }

  public function getTemplatePath()
  {
    return $this->templatePath;
  }

  public function setRoute($route)
  {
    $this->route = $route;
    return $this;
  }

  public function getRoute()
  {
    return $this->route;
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