<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display the products .
     */
    public function index()
    {
        $books = Book::all();
        return view('products', compact('books'));
    }

    /**
     * Display the book cart and calculation of biggest discount
     */
    public function bookCart()
    {
        $discount =  $this->maxdiscount() ?? 0;
        return view('cart', compact('discount'));
    }

    /**
     * Create the book cart
     */
    public function addBooktoCart($id)
    {
        $book = Book::findOrFail($id);
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $book->name,
                "quantity" => 1,
                "price" => $book->price,
                "image" => $book->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Book has been added to cart!');
    }

    /**
     * Update the books cart.
     */
    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Book added to cart.');
        }
        return redirect()->back()->with('success', 'Book added to cart!');
    }

    /**
     * Delete the product.
     */
    public function deleteProduct(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Book successfully deleted.');
        }
        return redirect()->back()->with('success', 'Book successfully deleted.');
    }


    public function maxdiscount()
    {
        // New array to store the book names
        $books = [];

        foreach (session('cart') as $book) {
            $books = array_merge($books, array_fill(0, $book['quantity'], $book['name']));
        }

        $books = [1, 1, 2, 2, 3, 3, 4, 5];
        $discounts = [0, 0.05, 0.10, 0.20, 0.25];
        $book_price = 8;
        
        // Count the occurrences of each book
        $counts = array_count_values($books);
        
        // Find the count of the most occurred book
        $most_occurred_count = max($counts);
        
        // Sort the books based on their counts
        uksort($counts, function ($a, $b) use ($books, $counts) {
            if ($counts[$a] == $counts[$b]) {
                return array_search($a, $books) - array_search($b, $books);
            }
            return $counts[$b] - $counts[$a];
        });
        
        // Build the empty arrays
        $arrays = array_fill(0, $most_occurred_count, []);
        
        // Peel each repeated element in the sorted array to each different new array
        $i = 0;
        foreach ($counts as $book => $count) {
            for ($j = 0; $j < $count; $j++) {
                $arrays[$i][] = $book;
                $i = ($i + 1) % $most_occurred_count;
            }
        }
        
        // Print the sorted arrays and the count of the most occurred book
        // foreach ($arrays as $i => $array) {
        //     echo "Array " . ($i + 1) . ": " . implode(", ", $array) . "\n";
        // }
        
        // Apply the discounts to each array and calculate the total cost
        $total_cost = 0;
        foreach ($arrays as $array) {
            $num_books = count($array);
            $discount = $discounts[$num_books - 1] * $book_price * $num_books;
            $subtotal = $book_price * $num_books;
            $total_cost += $subtotal - $discount;
        }
        

        return  $total_cost;
    }
}
