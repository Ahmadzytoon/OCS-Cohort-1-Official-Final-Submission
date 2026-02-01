<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Author;
use App\Models\Book;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Literature Parent Category
        $literature = Category::updateOrCreate(
            ['name' => 'Literature'],
            ['description' => 'Great works of written art, including fiction, poetry, and classical drama.']
        );

        // 2. Create Children Categories
        $fiction = Category::updateOrCreate(
            ['name' => 'Fiction'],
            [
                'description' => 'Stories from the imagination, exploring narrative and theme.',
                'parent_id' => $literature->id
            ]
        );

        $poetry = Category::updateOrCreate(
            ['name' => 'Poetry'],
            [
                'description' => 'Rhythmic and symbolic language used to evoke emotion and meaning.',
                'parent_id' => $literature->id
            ]
        );

        // 3. Move existing Drama under Literature if it exists
        $drama = Category::where('name', 'Drama')->first();
        if ($drama) {
            $drama->update(['parent_id' => $literature->id]);
        } else {
            $drama = Category::create([
                'name' => 'Drama',
                'description' => 'Emotional and character-driven stories exploring human relationships.',
                'parent_id' => $literature->id
            ]);
        }

        // 4. Create an Author for testing
        $author = Author::updateOrCreate(
            ['name' => 'F. Scott Fitzgerald'],
            [
                'biography' => 'Francis Scott Key Fitzgerald was an American novelist, essayist, and short story writer.',
                'image' => null
            ]
        );

        // 5. Add Books to Subcategories
        Book::updateOrCreate(
            ['isbn' => '9780743273565'],
            [
                'title' => 'The Great Gatsby',
                'author_id' => $author->id,
                'category_id' => $fiction->id,
                'price' => 15.00,
                'stock_quantity' => 50,
                'status' => 'Active',
                'description' => 'A classic novel of the Jazz Age.',
                'long_description' => 'The Great Gatsby is a 1925 novel by American writer F. Scott Fitzgerald. Set in the Jazz Age on Long Island, near New York City, the novel depicts first-person narrator Nick Carraway\'s interactions with mysterious millionaire Jay Gatsby and Gatsby\'s obsession to reunite with his former lover, Daisy Buchanan.',
                'publish_year' => 1925,
                'country' => 'United States',
                'language' => 'English'
            ]
        );

        Book::updateOrCreate(
            ['isbn' => '9780142437339'],
            [
                'title' => 'The Waste Land',
                'author_id' => $author->id, // just for testing, I know T.S. Eliot wrote this
                'category_id' => $poetry->id,
                'price' => 12.00,
                'stock_quantity' => 20,
                'status' => 'Active',
                'description' => 'A foundational work of modernist poetry.',
                'long_description' => 'The Waste Land is a poem by T. S. Eliot, widely regarded as one of the most important poems of the 20th century and a central work of modernist poetry.',
                'publish_year' => 1922,
                'country' => 'United Kingdom',
                'language' => 'English'
            ]
        );
    }
}
