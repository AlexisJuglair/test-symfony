<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product_index")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findBy(
                ["visible" => 1],
                ['updated_at' => 'DESC']
            ) 
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_show", priority=-1)
     */
    public function show($id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if(!$product) 
        {
            throw $this->createNotFoundException("Le produit demandé n'existe pas.");
        }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/admin/product/add", name="product_add", methods={"GET","POST"})
     */
    public function add(Request $request)
    {
        $product = new Product;

        $formProduct = $this->createForm(ProductType::class, $product);

        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid()) 
        {
            $product->setCreatedAt(new \DateTime())
                ->setUpdatedAt($product->getCreatedAt());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', "Le produit a été ajouté !");

            return $this->redirectToRoute('product_index');
        }
        
        return $this->renderForm('product/add_edit.html.twig', [
            "action" => "Ajouter",
            'formProduct' => $formProduct
        ]);
    }

    /**
     * @Route("/admin/product/edit/{id}", name="product_edit", methods={"GET","POST"})
     */
    public function edit($id, ProductRepository $productRepository, Request $request)
    {
        $product = $productRepository->find($id);

        if(!$product) 
        {
            throw $this->createNotFoundException("Le produit à modifier n'existe pas.");
        }

        $formProduct = $this->createForm(ProductType::class, $product);

        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid()) 
        {
            $product->setUpdatedAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', "Le produit a été modifié !");

            return $this->redirectToRoute('product_index');
        }
        
        return $this->renderForm('product/add_edit.html.twig', [
            "action" => "Modifier",
            'formProduct' => $formProduct
        ]);
    }

    /**
     * @Route("admin/product/delete/{id}", name="product_delete", methods={"POST"})
     */
    public function delete($id, ProductRepository $productRepository, Request $request)
    {
        $product = $productRepository->find($id);

        if ($this->isCsrfTokenValid($product->getId(), $request->request->get('_token'))) 
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();

            $this->addFlash('success', "Le produit a été supprimé !");
        }

        return $this->redirectToRoute('product_index');
    }

}
