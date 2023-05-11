<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Http\Controllers\BookController;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the maxdiscount method of the BookController.
     *
     * @return void
     */
    public function testMaxDiscount()
    {
        // Set the cart session data
        session(['cart' => [
            ['name' => 'Book 1', 'quantity' => 2],
            ['name' => 'Book 2', 'quantity' => 2],
            ['name' => 'Book 3', 'quantity' => 2],
            ['name' => 'Book 4', 'quantity' => 1],
            ['name' => 'Book 5', 'quantity' => 1],
        ]]);

        // Create a new BookController instance
        $controller = new BookController();

        // Call the maxdiscount method
        $discount = $controller->maxdiscount();

        // Assert that the discount is correct
        $this->assertEquals(51.20, $discount);
    }
}
