<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Form\ArticleType;
use AppBundle\Entity\Article;
use FOS\RestBundle\View\View;

class DefaultController  extends FOSRestController
{
    /**
       * Note: here the name is important
       * get => the action is restricted to GET HTTP method
       * Article => (without s) generate /articles/SOMETHING
       * Action => standard things for symfony for a controller method which
       *           generate an output.
       *
       * it generates so the route GET .../articles/{id}
       */
      /**
       * ....
       *
       * @return Article
       */
      public function getArticleAction($id)
      {
          $article = new Article("title $id", "body $id");

          $manager = $this->getDoctrine()->getManager();
          // persist ONLY add the object to the list of object to
          // save
          $manager->persist($article);
          // only flush will actually save in database, this in order
          // to make it possible to save a lot of object in only one flush
          // (which is a LOT faster than flushing one by one
          $manager->flush();

          return $article;
      }
    /**
     *
     */
    public function postArticlesAction(Request $request)
    {
        //TODO: there's a simpler method using FOSRestBundle body converter
        // that's the reason why we need to be able to create
        // an article without body or title, to use it as
        // a placeholder for the form
        $article = new Article();
        $errors = $this->treatAndValidateRequest($article, $request);
        if (count($errors) > 0) {
            return new View(
                $errors,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $this->persistAndFlush($article);
        // created => 201, we need View here because we're not
        // returning the default 200
        return new View($article, Response::HTTP_CREATED);
    }
    /**
     * fill $article with the json send in request and validates it.
     *
     * returns an array of errors (empty if everything is ok)
     *
     * @return array
     */
    private function treatAndValidateRequest(Article $article, Request $request)
    {
        // createForm is provided by the parent class
        $form = $this->createForm(
            new ArticleType(),
            $article,
            array(
                'method' => $request->getMethod(),
            )
        );
        // this method is the one that will use the value in the POST
        // to update $article
        $form->handleRequest($request);
        // we use it like that instead of the standard $form->isValid()
        // because the json generated
        // is much readable than the one by serializing $form->getErrors()
        $errors = $this->get('validator')->validate($article);

        return $errors;
    }
    private function persistAndFlush(Article $article)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($article);
        $manager->flush();
    }
}
