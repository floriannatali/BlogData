<?php

namespace AppBundle\Controller\Api;

use AppBundle\Exception\InvalidApiFormException;
use AppBundle\Exception\InvalidFormException;
use AppBundle\Entity\Article;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ArticleController
 * @package AppBundle\Controller\Api
 *
 * @Route("/article", name="api_article")
 */
class ArticleController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  section = "article",
     *  resource = true,
     *  description="Returns the articles list filtered",
     *  output = "array<AppBundle\Entity\Article>",
     *
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized"
     *     }
     *
     * )
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @Rest\Get("/list",name="api_article_list")
     * @Rest\View(serializerGroups={ "Article" })
     * @Rest\QueryParam(name="offset", requirements="\d+", default="0", nullable=false, description="Offset from which to start listing articles")
     * @Rest\QueryParam(name="limit", requirements="\d+", nullable=true, description="limit of articles number to return")
     * @return string
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle\Entity\Article')->findBy(
            [],
            ['dateCreation' => 'DESC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }

    /**
     * @ApiDoc(
     *  section = "article",
     *  resource = true,
     *  description="Create an article",
     *  statusCodes={
     *         201="Returned when successfully created",
     *         400="Returned if submitted data are wrong",
     *         403="Returned when the user is not authorized"
     *     },
     *     parameters={
     *      {"name"="title", "dataType"="string", "required"=true, "description"="article title"},
     *      {"name"="author", "dataType"="string", "required"=true, "description"="article author"},
     *      {"name"="content", "dataType"="string", "required"=true, "description"="article content"},
     *      {"name"="date_creation", "dataType"="datetime", "required"=true, "format"="Y-m-d H:i:s", "description"="article date creation"}
     *     },
     *     output="AppBundle\Entity\Article"
     * )
     *
     *
     * @Rest\Post("/create",name="api_article_create")
     * @Rest\View(serializerGroups={ "Article" })
     *
     *
     * @return \AppBundle\Entity\Article
     * @throws \Exception
     */
    public function createAction(Request $request)
    {
        try {
            $newArticle = $this->get('app_article.article_service')->create(
                $request->request->all()
            );

            return $newArticle;
        }
        catch (InvalidApiFormException $exception) {
            throw $exception;
        }
        catch (\Exception $exception) {
            $this->get('logger')->addError($exception->getTraceAsString());
            throw new \Exception('An exception occurred');
        }
    }

    /**
     * @ApiDoc(
     *  section = "article",
     *  resource = true,
     *  description="Get an article by id",
     *  output = "AppBundle\Entity\Article",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="article id"
     *      }
     * },
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when the article not found"
     *     }
     * )
     *
     * @Rest\Get("/{id}",name="api_article_get",requirements={
            "id": "\d+"
     * })
     * @Rest\View(serializerGroups={ "Article" })
     * @return Article
     */
    public function getAction(Article $article)
    {
        return $article;
    }

}
