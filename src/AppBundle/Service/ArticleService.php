<?php
namespace AppBundle\Service;

use AppBundle\Exception\InvalidApiFormException;
use AppBundle\Form\ArticleType;
use AppBundle\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Created by PhpStorm.
 * User: florian
 * Date: 25/02/16
 * Time: 14:13
 */
class ArticleService
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var EntityRepository
     */
    protected $repository;
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('AppBundle\Entity\Article');
        $this->formFactory = $formFactory;
    }

    /**
     * Create a new Article.
     *
     * @param array $parameters
     *
     * @return Article
     */
    public function create(array $parameters)
    {
        $article = new Article();

        // Process form does all the magic, validate and hydrate the Page Object.
        return $this->processForm($article, $parameters, 'POST');
    }

    /**
     * Processes the form.
     *
     * @param Article $article
     * @param array         $parameters
     * @param String        $method
     *
     * @return Article
     *
     * @throws InvalidApiFormException
     */
    private function processForm(Article $article, array $parameters, $method = "PUT")
    {
        unset($parameters['_format']); //fix nelmio todo: trouver mieu
        $form = $this->formFactory->create(ArticleType::class, $article, array('method' => $method, 'csrf_protection'   => false));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {

            $article = $form->getData();
            $this->entityManager->persist($article);
            $this->entityManager->flush($article);

            return $article;
        }

        throw new InvalidApiFormException();
    }
}