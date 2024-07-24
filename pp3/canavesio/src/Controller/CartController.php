<?php
namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartProductOrder;
use App\Entity\Product;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CartController extends AbstractController
{
    #[Route('/cart/add/{productId}', name: 'cart_add_product', methods: ['POST'])]
    public function addProduct(
        int $productId,
        Request $request,
        ProductRepository $productRepository,
        CartRepository $cartRepository,
        EntityManagerInterface $entityManager,
        Security $security
    ): Response {
        $user = $security->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $product = $productRepository->find($productId);
        if (!$product) {
            return $this->redirectToRoute('product_list');
        }

        // Find or create a cart for the user
        $cart = $cartRepository->findOneBy(['user' => $user]);
        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $entityManager->persist($cart);
            $entityManager->flush();
        }

        // Check if product is already in the cart
        $cartProductOrder = $cart->getCartProductOrders()->filter(function ($cartProductOrder) use ($product) {
            return $cartProductOrder->getProduct() === $product;
        })->first();

        if ($cartProductOrder) {
            // Increment quantity if product is already in the cart
            $cartProductOrder->setQuantity($cartProductOrder->getQuantity() + 1);
        } else {
            // Add new product to the cart
            $cartProductOrder = new CartProductOrder();
            $cartProductOrder->setProduct($product);
            $cartProductOrder->setCart($cart);
            $cartProductOrder->setQuantity(1);
            $cartProductOrder->setDate(new \DateTime());
            $cartProductOrder->setTime(new \DateTime());

            $entityManager->persist($cartProductOrder);
        }

        $entityManager->flush();

        return $this->redirectToRoute('cart_view');
    }

    #[Route('/cart', name: 'cart_view')]
    public function viewCart(CartRepository $cartRepository, Security $security): Response {
        $user = $security->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $cart = $cartRepository->findOneBy(['user' => $user]);

        return $this->render('cart/view.html.twig', [
            'cart' => $cart,
        ]);
    }
}
