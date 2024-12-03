<?php
namespace App\Controller;

use App\Entity\Product;
use App\Entity\UserFavoriteProduct;
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
        $favoriteProductIds = [];
        if ($user) {
            $favorites = $userFavoriteProductRepository->findBy(['user' => $user]);
            $favoriteProductIds = array_map(function ($favorite) {
                return $favorite->getProduct()->getId();
            }, $favorites);
        }

        return $this->render('product/list.html.twig', [
            'products' => $products,
            'favoriteProductIds' => $favoriteProductIds,
        ]);
    }

    #[Route('/product/{id}', name: 'product_detail')]
    public function detail(
        int $id,
        EntityManagerInterface $entityManager,
        UserFavoriteProductRepository $userFavoriteProductRepository
    ): Response {
        $user = $this->getUser();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('El producto no existe');
        }

        // Obtener IDs de productos favoritos del usuario actual
        $favoriteProductIds = [];
        if ($user) {
            $favorites = $userFavoriteProductRepository->findBy(['user' => $user]);
            $favoriteProductIds = array_map(function ($favorite) {
                return $favorite->getProduct()->getId();
            }, $favorites);
        }

        return $this->render('product/detail.html.twig', [
            'product' => $product,
            'favoriteProductIds' => $favoriteProductIds,
        ]);
    }

    #[Route('/product/category/{category}', name: 'product_category')]
    public function category(
        string $category,
        EntityManagerInterface $entityManager,
        UserFavoriteProductRepository $userFavoriteProductRepository
    ): Response {
        $user = $this->getUser();
        $products = $entityManager->getRepository(Product::class)->findBy(['category' => $category]);

        // Obtener IDs de productos favoritos del usuario actual
        $favoriteProductIds = [];
        if ($user) {
            $favorites = $userFavoriteProductRepository->findBy(['user' => $user]);
            $favoriteProductIds = array_map(function ($favorite) {
                return $favorite->getProduct()->getId();
            }, $favorites);
        }

        return $this->render('product/list.html.twig', [
            'products' => $products,
            'favoriteProductIds' => $favoriteProductIds,
            'category' => $category
        ]);
    }

    #[Route('/product/{id}/favorite', name: 'add_favorite', methods: ['POST'])]
    public function addToFavorites(
        int $id,
        EntityManagerInterface $entityManager,
        UserFavoriteProductRepository $userFavoriteProductRepository
    ): Response {
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $product = $entityManager->getRepository(Product::class)->find($id);
        
        if (!$product) {
            throw $this->createNotFoundException('El producto no existe');
        }

        // Verificar si ya está en favoritos
        $existingFavorite = $userFavoriteProductRepository->findOneBy([
            'user' => $user,
            'product' => $product
        ]);

        if (!$existingFavorite) {
            $favorite = new UserFavoriteProduct();
            $favorite->setUser($user);
            $favorite->setProduct($product);
            
            $entityManager->persist($favorite);
            $entityManager->flush();

            $this->addFlash('success', 'Producto agregado a favoritos');
        }

        // Redirigir de vuelta a la página de detalle
        return $this->redirectToRoute('product_detail', ['id' => $id]);
    }

    #[Route('/product/{id}/favorite/remove', name: 'remove_favorite', methods: ['POST'])]
    public function removeFromFavorites(
        int $id,
        EntityManagerInterface $entityManager,
        UserFavoriteProductRepository $userFavoriteProductRepository
    ): Response {
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $product = $entityManager->getRepository(Product::class)->find($id);
        
        if (!$product) {
            throw $this->createNotFoundException('El producto no existe');
        }

        $favorite = $userFavoriteProductRepository->findOneBy([
            'user' => $user,
            'product' => $product
        ]);

        if ($favorite) {
            $entityManager->remove($favorite);
            $entityManager->flush();

            $this->addFlash('success', 'Producto eliminado de favoritos');
        }

        return $this->redirectToRoute('product_detail', ['id' => $id]);
    }
}