<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return new Response("Hello World !");
    }

    /**
     * @Route("/test/{age<\d+>?0}", name="test")
     */
    public function age($age)
    {
        return new Response($age);
    }

    /**
     * @Route("/test/show", name="test-show")
     */
    public function show()
    {
        $names = ["alexis", "thierry", "anthony"];

        return $this->render('test/show.html.twig', 
        [
            'age' => 33,
            "names" => $names
        ]);
    }

    /**
     * @Route("/test/see", name="test-see")
     */
    public function see()
    {
        // $trainees = ['name' => 'alexis', 'thierry' => 23, 'anthony' => 34, 'amanda' => 33, "tomg" => 22, "calvin" => 25];

        $trainees = 
        [
            [
                "name" => "alexis",
                "age" => 31,
            ],
            [
                "name" => "thierry",
                "age" => 18,
            ],
            [
                "name" => "anthony",
                "age" => 34,
            ],
            [
                "name" => "amanda",
                "age" => 33,
            ],
            [
                "name" => "tomg",
                "age" => 22,
            ],
            [
                "name" => "toma",
                "age" => 23,
            ],
            [
                "name" => "loic",
                "age" => 52,
            ],
            [
                "name" => "mickael",
                "age" => 31,
            ],
            [
                "name" => "marc",
                "age" => 38,
            ],
            [
                "name" => "calvin",
                "age" => 25,
            ],
        ];

        return $this->render('test/see.html.twig', 
        [
            "ageLess" => 25,
            "ageMore" => rand(35, 45),
            "trainees" => $trainees
        ]);
    }
}