<?php

namespace App\Controller;

use App\Entity\Book;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController {

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    /**
     * 
     * @Route("/book", name="book_show")
     * 
     * @return void
     */
    public function index(Request $request) {
        $response = new JsonResponse();

        $title = $request->get('title', 'default');

        $this->logger->info('BookController::index() called');

        
        $response->setData([
            'success' => true,
            'data' => [
                [
                    'id' => 1,
                    'title' => 'Book 1',
                ],
                [
                    'id' => 2,
                    'title' => 'Book 2',
                ],
                [
                    'id' => 3,
                    'title' => $title,
                ],
            ]
        ]);

        return $response;
    }

    /**
     * 
     * @Route("/book/{id}", name="book_show_id", requirements={"id"="\d+"})
     * 
     * @param int $id
     * @return void
     */
    public function show($id) {
        $response = new JsonResponse();
        
        $response->setData([
            'success' => true,
            'data' => [
                'id' => $id,
                'title' => 'Book ' . $id,
            ]
        ]);

        return $response;

    }
    /**
     * 
     * @Route("/book/create", name="book_create")
     * 
     * @param Request $request
     * @return void
     */
    public function createBook(Request $request) {

        $book = new Book();
        $book->setTitle($request->get('title', 'Default Book Title'));
        $book->setImage('image.jpg');

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($book);
        $manager->flush();

        return new JsonResponse([
            'success' => true,
            'data' => [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'image' => $book->getImage(),
            ]
        ]);

    }
}

?>