<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Flex\Response;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bridge\Doctrine;
use FOS\RestBundle\FOSRestBundle;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//use Symfony\Component\Form\Extension\Core\Type\HiddenType;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;

class ArticleController extends AbstractController
{


    /**
     * @Route("/", name="article")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ArticleController.php',
        ]);
    }
    /**
     * Create Article.
     * @Route("/article_new", methods={"POST"}, name="article")
     *
     * @return array
     */
    public function postArticleAction(Request $request, SerializerInterface $serializer)
    {
        $article = new Article();
        $article->setName($request->get('name'));
        $article->setDescription($request->get('description'));
        $em = $this->getDoctrine()->getManager();

        $em->persist($article);
        $em->flush();
        $error = 1;
        if (!isset($error)) {


            throw new NotFoundHttpException('E-File not found');
        }

        return $this->json($article);
    }
    /**
     * Lists all Articles.
     * @Route("/articles", methods={"GET"}, name="efile_change_case", options={"expose"=true})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function getArticleAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->findall();
        if ($article) {
            return $this->json($article);
            } else{
            throw new NotFoundHttpException(400, 'Bad Request');
        }
//        $article = $serializer->deserialize($request->getContent(), Article::class, 'json');

//        $article = serialize($article);
//        $article = $repository->findBy($id);
//        $article->getName();


//        return View::create($article, Response::HTTP_OK , []);
    }

}

