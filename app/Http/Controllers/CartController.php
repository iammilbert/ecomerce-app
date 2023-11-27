<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Models\Order;
use Carbon\Carbon;
use Stripe\Stripe;
use App\Models\PaymentIntent;
use Stripe\PaymentIntent as StripePaymentIntent;

class CartController extends Controller
{

    public function addToCart(Request $request, $userId)
    {
        $cart = new ShoppingCart([
            'user_id' => $userId,
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity', 1),
        ]);

        $cart->save();
        return $this->sendSuccess($cart, 'Item added to the cart', 200);
    }



    public function updateCart(Request $request, $shoppingCartId)
    {
        $cart = ShoppingCart::find($shoppingCartId);

        if (!$cart) {
             return $this->sendError('Item not found in the cart', 404);
        }

        $cart->quantity = $request->input('quantity', 1);
        $cart->save();

         return $this->sendSuccess($cart, 'Cart updated', 200);
    }



    public function removeFromCart($shoppingCartId)
    {
        $cart = ShoppingCart::find($shoppingCartId);

        if (!$cart) {
             return $this->sendError('Item not found in the cart', 404);
        }

        $cart->delete();
        return $this->sendSuccess($cart, 'Item removed from the cart', 200);
    }



        public function clearCart($userId)
    {
        // Find all items in the cart for the authenticated user
        $cartItems = ShoppingCart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is already empty']);
        }

        // Delete all items from the cart
        Cart::where('user_id', $userId)->delete();

         return $this->sendSuccess($cart, 'Item removed from the cart', 200);
    }



    public function checkout($userId)
    {
        // Validate if the user has items in the cart
        $cartItems = ShoppingCart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty. Add items before checking out.'], 400);
        }

         // Create a payment intent with Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        $stripeIntent = StripePaymentIntent::create([
            'amount' => $this->calculateTotal($cartItems), // Calculate the total amount of the order
            'currency' => 'NGN', // Change to your preferred currency
            'payment_date'=> Carbon::now(),
        ]);
        

    // Creating an order for the user based on cart items
        $order = new Order([
            'user_id' => $user_id,
            'payment_intent_id'=>$stripeIntent->id,
            'order_date'=> Carbon::now(),
            'product_id'=> $cartItems->product_id,
            'quantity'=> $cartItems->quantity,
            'unit_price'=> $cartItems->product->price,
        ]);
        $order->save();


        // Create a PaymentIntent record
        $paymentIntent = new PaymentIntent([
            'payment_intent_id' => $stripeIntent->id,
            'order_id' => $order->id,
            'amount'=>$stripeIntent->amount,
            'currency'=>$stripeIntent->currency,
            'payment_date'=>$stripeIntent->payment_date,
        ]);
        $paymentIntent->save();

 
        // Remove cart items after successful checkout
        ShoppingCart::where('user_id', $userId)->delete();

        return response()->json([
            'data'=>$order,
            'message' => 'Checkout successful', 
            'order_id' => $order->id], 200);
    }


    private function calculateTotal($cartItems)
    {
        // Logic to calculate the total amount of the order based on cart items
        return $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });
    }

}

