<?php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\UserFavoriteProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/new', name: 'new_product')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Manejar la subida de la imagen
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                // Convertir el contenido del archivo a base64
                $imageData = base64_encode(file_get_contents($imageFile->getPathname()));
                $product->setImage($imageData);
            }

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product', name: 'product_list')]
    public function list(
        EntityManagerInterface $entityManager,
        UserFavoriteProductRepository $userFavoriteProductRepository
    ): Response {
        $user = $this->getUser();
        $products = $entityManager->getRepository(Product::class)->findAll();

        // Obtener IDs de productos favoritos del usuario actual
        $favoriteProductIds = $userFavoriteProductRepository->findBy(['user' => $user]);
        $favoriteProductIds = array_map(function ($favorite) {
            return $favorite->getProduct()->getId();
        }, $favoriteProductIds);

        return $this->render('product/list.html.twig', [
            'products' => $products,
            'favoriteProductIds' => $favoriteProductIds,
        ]);
    }
}
