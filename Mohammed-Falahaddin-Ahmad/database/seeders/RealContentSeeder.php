<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Str;

class RealContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories
        $categories = [
            'Drama' => 'Emotional and character-driven stories exploring human relationships and conflicts.',
            'Action' => 'Fast-paced adventures with suspense, physical challenges, and heroism.',
            'Mystery/Thriller' => 'Suspenseful narratives focused on solving crimes or uncovering hidden truths.',
            'Children’s Literature' => 'Imaginative and engaging stories written specifically for young readers.',
            'Horror' => 'Tales designed to evoke fear, suspense, and psychological unease.'
        ];

        $categoryModels = [];
        foreach ($categories as $name => $desc) {
            $categoryModels[$name] = Category::updateOrCreate(['name' => $name], ['description' => $desc]);
        }

        // 2. Authors and Books data
        $data = [
            'Drama' => [
                'author' => [
                    'name' => 'Colleen Hoover',
                    'biography' => 'Colleen Hoover is the #1 New York Times bestselling author of twenty-two novels and novellas.',
                    'image' => 'authors/colleen_hoover.png'
                ],
                'books' => [
                    ['title' => 'It Ends with Us', 'isbn' => '9781501110368', 'price' => 14.99, 'cover' => 'it_ends_with_us.png', 'year' => 2016],
                    ['title' => 'Verity', 'isbn' => '9781538724736', 'price' => 12.50, 'cover' => null, 'year' => 2018],
                    ['title' => 'It Starts with Us', 'isbn' => '9781668001226', 'price' => 15.99, 'cover' => null, 'year' => 2022],
                    ['title' => 'Ugly Love', 'isbn' => '9781476753188', 'price' => 13.99, 'cover' => null, 'year' => 2014],
                    ['title' => 'Reminders of Him', 'isbn' => '9781542025607', 'price' => 11.99, 'cover' => null, 'year' => 2022],
                ]
            ],
            'Action' => [
                'author' => [
                    'name' => 'James Patterson',
                    'biography' => 'James Patterson is the world\'s bestselling author, most famous for his Alex Cross series.',
                    'image' => 'authors/james_patterson.png'
                ],
                'books' => [
                    ['title' => 'Along Came a Spider', 'isbn' => '9780446364195', 'price' => 16.99, 'cover' => null, 'year' => 1993],
                    ['title' => 'Kiss the Girls', 'isbn' => '9780446601245', 'price' => 15.50, 'cover' => null, 'year' => 1995],
                    ['title' => 'Cross', 'isbn' => '9780316014496', 'price' => 14.99, 'cover' => null, 'year' => 2006],
                    ['title' => '1st to Die', 'isbn' => '9780446610032', 'price' => 12.99, 'cover' => null, 'year' => 2001],
                    ['title' => 'The President Is Missing', 'isbn' => '9780316412698', 'price' => 19.99, 'cover' => null, 'year' => 2018],
                ]
            ],
            'Mystery/Thriller' => [
                'author' => [
                    'name' => 'Agatha Christie',
                    'biography' => 'Agatha Christie is the best-selling novelist of all time, known as the Queen of Mystery.',
                    'image' => 'authors/agatha_christie.png'
                ],
                'books' => [
                    ['title' => 'Murder on the Orient Express', 'isbn' => '9780007119318', 'price' => 10.99, 'cover' => null, 'year' => 1934],
                    ['title' => 'Death on the Nile', 'isbn' => '9780007119325', 'price' => 11.50, 'cover' => null, 'year' => 1937],
                    ['title' => 'And Then There Were None', 'isbn' => '9780007119356', 'price' => 12.99, 'cover' => null, 'year' => 1939],
                    ['title' => 'The Murder of Roger Ackroyd', 'isbn' => '9780007119288', 'price' => 9.99, 'cover' => null, 'year' => 1926],
                    ['title' => 'A Murder is Announced', 'isbn' => '9780007119349', 'price' => 11.99, 'cover' => null, 'year' => 1950],
                ]
            ],
            'Children’s Literature' => [
                'author' => [
                    'name' => 'Roald Dahl',
                    'biography' => 'Roald Dahl was a British novelist, short-story writer, poet, and screenwriter, famous for children\'s books.',
                    'image' => 'authors/roald_dahl.png'
                ],
                'books' => [
                    ['title' => 'Matilda', 'isbn' => '9780141301068', 'price' => 8.99, 'cover' => null, 'year' => 1988],
                    ['title' => 'Charlie and the Chocolate Factory', 'isbn' => '9780141301037', 'price' => 9.50, 'cover' => null, 'year' => 1964],
                    ['title' => 'The BFG', 'isbn' => '9780141301051', 'price' => 8.99, 'cover' => null, 'year' => 1982],
                    ['title' => 'James and the Giant Peach', 'isbn' => '9780141301075', 'price' => 7.99, 'cover' => null, 'year' => 1961],
                    ['title' => 'Fantastic Mr Fox', 'isbn' => '9780141301136', 'price' => 6.99, 'cover' => null, 'year' => 1970],
                ]
            ],
            'Horror' => [
                'author' => [
                    'name' => 'Stephen King',
                    'biography' => 'Stephen King is an American author of horror, supernatural fiction, suspense, and fantasy novels.',
                    'image' => 'authors/stephen_king.png'
                ],
                'books' => [
                    ['title' => 'The Shining', 'isbn' => '9780385121675', 'price' => 17.99, 'cover' => null, 'year' => 1977],
                    ['title' => 'It', 'isbn' => '9780670813025', 'price' => 19.50, 'cover' => null, 'year' => 1986],
                    ['title' => 'Carrie', 'isbn' => '9780385086950', 'price' => 14.99, 'cover' => null, 'year' => 1974],
                    ['title' => 'Misery', 'isbn' => '9780670813643', 'price' => 15.99, 'cover' => null, 'year' => 1987],
                    ['title' => 'Pet Sematary', 'isbn' => '9780385182089', 'price' => 16.99, 'cover' => null, 'year' => 1983],
                ]
            ]
        ];

        // 3. Create Authors and Books
        foreach ($data as $catName => $content) {
            $cat = $categoryModels[$catName];
            
            // Create Author
            $author = Author::updateOrCreate(
                ['name' => $content['author']['name']],
                [
                    'biography' => $content['author']['biography'],
                    'image' => $content['author']['image']
                ]
            );

            // Create Books
            foreach ($content['books'] as $bookData) {
                Book::updateOrCreate(
                    ['isbn' => $bookData['isbn']],
                    [
                        'title' => $bookData['title'],
                        'author_id' => $author->id,
                        'category_id' => $cat->id,
                        'price' => $bookData['price'],
                        'stock_quantity' => rand(20, 100),
                        'status' => 'Active',
                        'cover_image' => $bookData['cover'],
                        'description' => "Real-world masterpiece \"{$bookData['title']}\" by {$author->name}.",
                        'long_description' => "Full description for \"{$bookData['title']}\", a renowned work in the {$catName} genre by {$author->name}. Published in {$bookData['year']}.",
                        'publish_year' => $bookData['year'],
                        'country' => 'United States',
                        'language' => 'English'
                    ]
                );
            }
        }
    }
}
