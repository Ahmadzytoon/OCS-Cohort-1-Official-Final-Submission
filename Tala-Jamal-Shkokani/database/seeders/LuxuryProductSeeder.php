<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LuxuryProductSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        DB::table('images')->truncate();
        DB::table('product_variants')->truncate();
        Schema::enableForeignKeyConstraints();

        $categories = Category::all()->pluck('id', 'slug')->toArray();

        // 60 High-Quality Curated Products (15 per aesthetic)
        $luxuryData = [
            // --- SOFT FEMME 🌸 (15 Items) ---
            [
                'name' => 'Petal-Soft Charmeuse Maxi',
                'aesthetic' => 'soft',
                'price' => 285.00,
                'description' => 'A breathtaking maxi dress crafted from heavy-weight silk charmeuse. Features a delicate bias cut that skims the body.',
                'category_slug' => 'dresses',
                'colors' => ['#FADADD', '#FFFFFF', '#E6E6FA'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?q=80&w=800', 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=800']
            ],
            [
                'name' => 'Victorian Lace Blouse',
                'aesthetic' => 'soft',
                'price' => 175.00,
                'description' => 'Vintage-inspired with hand-finished lace overlays and mother-of-pearl buttons.',
                'category_slug' => 'tops',
                'colors' => ['#FFFFFF', '#F5F5DC'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1551163943-3f6a855d1153?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1485968579580-b6d095142e6e?q=80&w=800']
            ],
            [
                'name' => 'Tulle Symphony Skirt',
                'aesthetic' => 'soft',
                'price' => 140.00,
                'description' => 'Mulitple layers of Italian soft tulle create a voluminous, romantic movement.',
                'category_slug' => 'dresses',
                'colors' => ['#FADADD', '#E6E6FA', '#FFFFFF'],
                'sizes' => ['XS', 'S', 'M'],
                'image' => 'https://images.unsplash.com/photo-1582142407894-ec1d7bd254c4?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=800']
            ],
            [
                'name' => 'Blush Cashmere Cardigan',
                'aesthetic' => 'soft',
                'price' => 210.00,
                'description' => 'Feather-light cashmere in a gentle rose hue. Perfect for cool spring evenings.',
                'category_slug' => 'tops',
                'colors' => ['#FFC0CB', '#FFFFFF'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?q=80&w=800']
            ],
            [
                'name' => 'Garden Party Floral Mini',
                'aesthetic' => 'soft',
                'price' => 155.00,
                'description' => 'Delicate hand-painted floral print on organic cotton poplin.',
                'category_slug' => 'dresses',
                'colors' => ['#FFFDD0', '#E0FFFF'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=800']
            ],
            [
                'name' => 'Pearl Embellished Headband',
                'aesthetic' => 'soft',
                'price' => 45.00,
                'description' => 'A crown of freshwater pearls on a velvet band. The ultimate soft accessory.',
                'category_slug' => 'accessories',
                'colors' => ['#FFFFFF'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1532453288672-3a27e9be9efd?q=80&w=1200', // Jewellery/Accessory
                'gallery' => ['https://images.unsplash.com/photo-1599643478518-17488fbbcd75?q=80&w=800']
            ],
            [
                'name' => 'Silk Ribbon Ballet Flats',
                'aesthetic' => 'soft',
                'price' => 120.00,
                'description' => 'Classic satin ballet flats with interchangeable silk ribbon ties.',
                'category_slug' => 'footwear',
                'colors' => ['#FFC0CB', '#000000', '#FFFFFF'],
                'sizes' => ['36', '37', '38', '39', '40'],
                'image' => 'https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=1200', // Shoes
                'gallery' => ['https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=800']
            ],
            [
                'name' => 'Rose Quartz Pendant',
                'aesthetic' => 'soft',
                'price' => 190.00,
                'description' => 'A large, raw cut rose quartz stone set in 18k gold vermeil.',
                'category_slug' => 'accessories',
                'colors' => ['#FFC0CB'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=1200', // Necklace
                'gallery' => ['https://images.unsplash.com/photo-1611085583191-a3b181a88401?q=80&w=800']
            ],
            [
                'name' => 'White Eyelet Midi Dress',
                'aesthetic' => 'soft',
                'price' => 230.00,
                'description' => 'Summer innocence defined. Full skirt with intricate eyelet embroidery.',
                'category_slug' => 'dresses',
                'colors' => ['#FFFFFF'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=800']
            ],
            [
                'name' => 'Lavender Puff Sleeve Top',
                'aesthetic' => 'soft',
                'price' => 95.00,
                'description' => 'Dramatic puff sleeves meet a fitted bodice in a soothing lavender shade.',
                'category_slug' => 'tops',
                'colors' => ['#E6E6FA'],
                'sizes' => ['XS', 'S', 'M'],
                'image' => 'https://images.unsplash.com/photo-1583244673646-e4141d7d6365?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1562157873-818bc0726f68?q=80&w=800']
            ],
            [
                'name' => 'Cream Wool Wrap Coat',
                'aesthetic' => 'soft',
                'price' => 450.00,
                'description' => 'Envelop yourself in softness. Unlined double-face wool for a fluid drape.',
                'category_slug' => 'outerwear',
                'colors' => ['#FFFFF0', '#D3D3D3'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1539533018447-63fcce6671b4?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1559563458-527698bf5295?q=80&w=800']
            ],
            [
                'name' => 'Velvet Bow Hairclip',
                'aesthetic' => 'soft',
                'price' => 25.00,
                'description' => 'A vintage touch to finish any look. Made from plush silk velvet.',
                'category_slug' => 'accessories',
                'colors' => ['#800020', '#000000', '#FFC0CB'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1570295939919-56ceb5ccca61?q=80&w=1200', // Close up
                'gallery' => ['https://images.unsplash.com/photo-1596473536124-7472d9595059?q=80&w=800']
            ],
            [
                'name' => 'Pastel Tweed Jacket',
                'aesthetic' => 'soft',
                'price' => 310.00,
                'description' => 'Chanel-inspired cropped jacket in a custom pastel weave.',
                'category_slug' => 'outerwear',
                'colors' => ['#FADADD', '#B0E0E6'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1548624149-f3dd743b1872?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=800']
            ],
            [
                'name' => 'Angora Knit Beret',
                'aesthetic' => 'soft',
                'price' => 55.00,
                'description' => 'Fuzzy, warm, and undeniably cute. The perfect winter accessory.',
                'category_slug' => 'accessories',
                'colors' => ['#FFFFFF', '#FFC0CB'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1556306535-0f09a537f0a3?q=80&w=1200', // Hat
                'gallery' => ['https://images.unsplash.com/photo-1576871337622-98d48d1cf531?q=80&w=800']
            ],
            [
                'name' => 'Chiffon Pleated Midi',
                'aesthetic' => 'soft',
                'price' => 180.00,
                'description' => 'Sun-ray pleats that catch the light with every step.',
                'category_slug' => 'dresses',
                'colors' => ['#E0FFFF', '#FFB6C1'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1562157873-818bc0726f68?q=80&w=800']
            ],

            // --- ALT GIRLY 🖤 (15 Items) ---
            [
                'name' => 'Noir Vegan Leather Corset',
                'aesthetic' => 'alt',
                'price' => 195.00,
                'description' => 'Structured elegance meets rebellious spirit. Premium vegan leather.',
                'category_slug' => 'tops',
                'colors' => ['#000000', '#8B0000'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1583209814683-c023dd293cc6?q=80&w=800']
            ],
            [
                'name' => 'Buckled Platform Boots',
                'aesthetic' => 'alt',
                'price' => 320.00,
                'description' => 'The ultimate foundation for the alt aesthetic. Massive soles.',
                'category_slug' => 'footwear',
                'colors' => ['#000000'],
                'sizes' => ['37', '38', '39', '40'],
                'image' => 'https://images.unsplash.com/photo-1608256246200-53e635b5b65f?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?q=80&w=800']
            ],
            [
                'name' => 'Studded Archive Mini',
                'aesthetic' => 'alt',
                'price' => 115.00,
                'description' => 'A sharp A-line silhouette featuring hand-placed pyramid studs.',
                'category_slug' => 'dresses',
                'colors' => ['#000000', '#4B0082'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=800']
            ],
            [
                'name' => 'Distressed Knit Sweater',
                'aesthetic' => 'alt',
                'price' => 145.00,
                'description' => 'Perfectly undone. Oversized fit with strategic laddering.',
                'category_slug' => 'tops',
                'colors' => ['#000000', '#808080'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1550614000-4b9519e0074d?q=80&w=800']
            ],
            [
                'name' => 'Vinyl High-Shine Pants',
                'aesthetic' => 'alt',
                'price' => 160.00,
                'description' => 'Wet-look vinyl that demands attention. Fleece-lined for comfort.',
                'category_slug' => 'tops', // Actually pants but mapping to tops or outerwear typically if no pants cat. Mapping to Outerwear for now or fallback. User used 'outerwear' for pants before.
                'category_slug' => 'outerwear',
                'colors' => ['#000000', '#FF0000'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1548863255-827a5d9a9ba5?q=80&w=800']
            ],
            [
                'name' => 'Gothic Lace Choker',
                'aesthetic' => 'alt',
                'price' => 35.00,
                'description' => 'Victorian goth revival. Wide lace band with a central onyx drop.',
                'category_slug' => 'accessories',
                'colors' => ['#000000'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1611591437253-46e149c71999?q=80&w=800']
            ],
            [
                'name' => 'Mesh Overlay Bodysuit',
                'aesthetic' => 'alt',
                'price' => 85.00,
                'description' => 'Sheer mesh with flock printed moons and stars.',
                'category_slug' => 'tops',
                'colors' => ['#000000'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1618354691438-25bc04584c23?q=80&w=1200', // Bodysuit vibe
                'gallery' => ['https://images.unsplash.com/photo-1583209814683-c023dd293cc6?q=80&w=800']
            ],
            [
                'name' => 'Silver Chain Harness',
                'aesthetic' => 'alt',
                'price' => 125.00,
                'description' => 'Wear over tees or dresses. industrial gauge silver links.',
                'category_slug' => 'accessories',
                'colors' => ['#C0C0C0'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1579600161224-c152a9693996?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1541280879942-78d120d58832?q=80&w=800']
            ],
            [
                'name' => 'Asymmetric Hem Midi',
                'aesthetic' => 'alt',
                'price' => 135.00,
                'description' => 'Raw hem finish and dramatic asymmetry. Made from structured jersey.',
                'category_slug' => 'dresses',
                'colors' => ['#000000', '#556B2F'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=800']
            ],
            [
                'name' => 'Skull Knuckle Clutch',
                'aesthetic' => 'alt',
                'price' => 210.00,
                'description' => 'Hard case clutch with signature skull knuckle duster handle.',
                'category_slug' => 'accessories',
                'colors' => ['#000000', '#FF0000'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1566150905458-1bf1fd15dbc4?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=800']
            ],
            [
                'name' => 'Oversized Safety Pin Earrings',
                'aesthetic' => 'alt',
                'price' => 40.00,
                'description' => 'Punk heritage. Sterling silver heavy duty safety pins.',
                'category_slug' => 'accessories',
                'colors' => ['#C0C0C0'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1630019852942-f89202989a51?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1606760227091-3dd870d97f1d?q=80&w=800']
            ],
            [
                'name' => 'Combat Trench Coat',
                'aesthetic' => 'alt',
                'price' => 380.00,
                'description' => 'All-black trench with tactical pockets and D-ring hardware.',
                'category_slug' => 'outerwear',
                'colors' => ['#000000'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1532715088550-62f09305f765?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=800']
            ],
            [
                'name' => 'Velvet Burnout Kimono',
                'aesthetic' => 'alt',
                'price' => 165.00,
                'description' => 'Dark romanticism. Sheer base with deep red velvet rose pattern.',
                'category_slug' => 'outerwear',
                'colors' => ['#8B0000'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1582142327373-56d887a2e327?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=800']
            ],
            [
                'name' => 'Platform Mary Janes',
                'aesthetic' => 'alt',
                'price' => 190.00,
                'description' => 'School-girl style with a deadly edge. 3-inch chunky heel.',
                'category_slug' => 'footwear',
                'colors' => ['#000000', '#FFFFFF'],
                'sizes' => ['36', '37', '38', '39', '40'],
                'image' => 'https://images.unsplash.com/photo-1511556820780-d912e42b4980?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=800']
            ],
            [
                'name' => 'Spiderweb Lace Tights',
                'aesthetic' => 'alt',
                'price' => 30.00,
                'description' => 'Intricate web patterns. Highly durable nylon blend.',
                'category_slug' => 'accessories',
                'colors' => ['#000000'],
                'sizes' => ['S-M', 'M-L'],
                'image' => 'https://images.unsplash.com/photo-1580913428023-02c695b3db5c?q=80&w=1200', // Legs focus
                'gallery' => ['https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=800']
            ],

            // --- LUXURY CLEAN ✨ (15 Items) ---
            [
                'name' => 'Architectural Neutral Trench',
                'aesthetic' => 'luxury',
                'price' => 640.00,
                'description' => 'A cornerstone of a curated wardrobe. Razor-sharp architectural cut.',
                'category_slug' => 'outerwear',
                'colors' => ['#F5F5DC', '#A52A2A', '#000000'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=800']
            ],
            [
                'name' => 'Silk Column Gown',
                'aesthetic' => 'luxury',
                'price' => 890.00,
                'description' => 'Quiet luxury at its finest. Double-faced silk that drapes perfectly.',
                'category_slug' => 'dresses',
                'colors' => ['#E5E4E2', '#000000', '#FFD700'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1539008835657-9e8e9680c956?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1566174053879-31528523f8ae?q=80&w=800']
            ],
            [
                'name' => 'Cashmere Neutral Polo',
                'aesthetic' => 'luxury',
                'price' => 310.00,
                'description' => '100% Mongolian cashmere. Relaxed yet refined.',
                'category_slug' => 'tops',
                'colors' => ['#F5F5DC', '#FFFFFF', '#000000'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1434389677669-e08b4cac3105?q=80&w=800']
            ],
            [
                'name' => 'Structrued Leather Tote',
                'aesthetic' => 'luxury',
                'price' => 550.00,
                'description' => 'Italian calfskin. Minimalist hardware. Holds a 13-inch laptop.',
                'category_slug' => 'accessories',
                'colors' => ['#000000', '#8B4513'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1591561954557-26941169b49e?q=80&w=800']
            ],
            [
                'name' => 'Wide-Leg Wool Trousers',
                'aesthetic' => 'luxury',
                'price' => 280.00,
                'description' => 'Impeccable tailoring. High-waisted with a fluid wide leg.',
                'category_slug' => 'tops', // Pants -> Tops/Outerwear fallback
                'category_slug' => 'outerwear',
                'colors' => ['#808080', '#F5F5DC'],
                'sizes' => ['36', '38', '40', '42'],
                'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?q=80&w=800']
            ],
            [
                'name' => 'Minimal Gold Hoop Earrings',
                'aesthetic' => 'luxury',
                'price' => 120.00,
                'description' => 'Hollow 14k gold. Lightweight for everyday elegance.',
                'category_slug' => 'accessories',
                'colors' => ['#FFD700'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1630019852942-f89202989a51?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=800']
            ],
            [
                'name' => 'Pointed Toe Stilettos',
                'aesthetic' => 'luxury',
                'price' => 450.00,
                'description' => 'Razor sharp profile in patent leather. The power shoe.',
                'category_slug' => 'footwear',
                'colors' => ['#000000', '#F5F5DC'],
                'sizes' => ['36', '37', '38', '39', '40'],
                'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=800']
            ],
            [
                'name' => 'Herringbone oversized blazer',
                'aesthetic' => 'luxury',
                'price' => 375.00,
                'description' => 'Borrowed from the boys. Structured shoulders and a relaxed fit.',
                'category_slug' => 'outerwear',
                'colors' => ['#808080'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=800']
            ],
            [
                'name' => 'White Poplin Shirt',
                'aesthetic' => 'luxury',
                'price' => 145.00,
                'description' => 'Crisp, bright, and essential. High collar for a dramatic effect.',
                'category_slug' => 'tops',
                'colors' => ['#FFFFFF'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1598532163257-522600490f56?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=800']
            ],
            [
                'name' => 'Leather Weekender Bag',
                'aesthetic' => 'luxury',
                'price' => 780.00,
                'description' => 'For the jet-setter. Grained leather that improves with age.',
                'category_slug' => 'accessories',
                'colors' => ['#8B4513', '#000000'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=800']
            ],
            [
                'name' => 'Satin Lapel Tuxedo Dress',
                'aesthetic' => 'luxury',
                'price' => 320.00,
                'description' => 'Menswear tailored for the female form. Powerful and chic.',
                'category_slug' => 'dresses',
                'colors' => ['#000000', '#FFFFFF'],
                'sizes' => ['36', '38', '40'],
                'image' => 'https://images.unsplash.com/photo-1539008835657-9e8e9680c956?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1566174053879-31528523f8ae?q=80&w=800']
            ],
            [
                'name' => 'Ribbed Knit Midi Dress',
                'aesthetic' => 'luxury',
                'price' => 210.00,
                'description' => 'Body-contouring knit that offers comfort without sacrificing polish.',
                'category_slug' => 'dresses',
                'colors' => ['#F5F5DC', '#808080'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1562157873-818bc0726f68?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1582142407894-ec1d7bd254c4?q=80&w=800']
            ],
            [
                'name' => 'Cashmere Scarf',
                'aesthetic' => 'luxury',
                'price' => 150.00,
                'description' => 'Generously sized to double as a travel wrap.',
                'category_slug' => 'accessories',
                'colors' => ['#A52A2A', '#F5F5DC'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1520904382578-a30a605ce516?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?q=80&w=800']
            ],
            [
                'name' => 'Tortoiseshell Sunglasses',
                'aesthetic' => 'luxury',
                'price' => 180.00,
                'description' => 'Oversized frames handcrafted in Italy.',
                'category_slug' => 'accessories',
                'colors' => ['#A52A2A'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1572635196237-14b3f281503f?q=80&w=800']
            ],
            [
                'name' => 'Suede Ankle Boots',
                'aesthetic' => 'luxury',
                'price' => 295.00,
                'description' => 'Buttery soft suede with a walkable block heel.',
                'category_slug' => 'footwear',
                'colors' => ['#A52A2A', '#000000'],
                'sizes' => ['36', '37', '38', '39'],
                'image' => 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=800']
            ],

            // --- MODERN MIX 🎭 (15 Items) ---
            [
                'name' => 'Mixed-Media Blazer',
                'aesthetic' => 'mix',
                'price' => 420.00,
                'description' => 'Traditional tailoring meets modern abstract panels.',
                'category_slug' => 'tops',
                'colors' => ['#4B0082', '#008080'],
                'sizes' => ['M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1548142723-aae7678afd54?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=800']
            ],
            [
                'name' => 'Cosmopolitan Flare Pants',
                'aesthetic' => 'mix',
                'price' => 185.00,
                'description' => 'High-waisted with a dramatic flare. High-recovery stretch.',
                'category_slug' => 'outerwear', // Pants
                'colors' => ['#000000', '#FF00FF'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=800']
            ],
            [
                'name' => 'Abstract Resin Clutch',
                'aesthetic' => 'mix',
                'price' => 245.00,
                'description' => 'Hand-poured resin creates a unique marbled effect.',
                'category_slug' => 'accessories',
                'colors' => ['#FFD700', '#C0C0C0'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1566150905458-1bf1fd15dbc4?q=80&w=800']
            ],
            [
                'name' => 'Grafitti Print Tee',
                'aesthetic' => 'mix',
                'price' => 75.00,
                'description' => 'Street art inspired graphic on heavy cotton.',
                'category_slug' => 'tops',
                'colors' => ['#FFFFFF', '#000000'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1503342394128-c104d54dba01?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?q=80&w=800']
            ],
            [
                'name' => 'Neon Hiking Sandals',
                'aesthetic' => 'mix',
                'price' => 130.00,
                'description' => 'Gorpcore meets high fashion. Ultra comfortable.',
                'category_slug' => 'footwear',
                'colors' => ['#FFFF00', '#FF00FF'],
                'sizes' => ['36', '37', '38', '39', '40'],
                'image' => 'https://images.unsplash.com/photo-1603808033192-082d6919d3e1?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=800']
            ],
            [
                'name' => 'Deconstructed Denim Jacket',
                'aesthetic' => 'mix',
                'price' => 220.00,
                'description' => 'Two jackets spliced into one. Asymmetric hem.',
                'category_slug' => 'outerwear',
                'colors' => ['#0000FF'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1523205565295-f8e91625443b?q=80&w=1200', // Denim
                'gallery' => ['https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?q=80&w=800']
            ],
            [
                'name' => 'Metallic Pleated Skirt',
                'aesthetic' => 'mix',
                'price' => 175.00,
                'description' => 'Liquid metal effect. Moves like mercury.',
                'category_slug' => 'dresses',
                'colors' => ['#C0C0C0', '#FFD700'],
                'sizes' => ['XS', 'S', 'M'],
                'image' => 'https://images.unsplash.com/photo-1582142407894-ec1d7bd254c4?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1566174053879-31528523f8ae?q=80&w=800']
            ],
            [
                'name' => 'Bold Acetate Sunglasses',
                'aesthetic' => 'mix',
                'price' => 140.00,
                'description' => 'Thick, geometric frames in unexpected colors.',
                'category_slug' => 'accessories',
                'colors' => ['#FF0000', '#0000FF'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1572635196237-14b3f281503f?q=80&w=800']
            ],
            [
                'name' => 'Colourblock Sneakers',
                'aesthetic' => 'mix',
                'price' => 195.00,
                'description' => 'Retro silhouettes with futuristic colorways.',
                'category_slug' => 'footwear',
                'colors' => ['#FFFFFF', '#000000'],
                'sizes' => ['36', '37', '38', '39', '40'],
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1603808033192-082d6919d3e1?q=80&w=800']
            ],
            [
                'name' => 'Sequin Slip Dress',
                'aesthetic' => 'mix',
                'price' => 260.00,
                'description' => 'Day to night. Matte sequins for a sophisticated shimmer.',
                'category_slug' => 'dresses',
                'colors' => ['#C0C0C0', '#000000'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1566174053879-31528523f8ae?q=80&w=800']
            ],
            [
                'name' => 'Oversized Graphic Hoodie',
                'aesthetic' => 'mix',
                'price' => 110.00,
                'description' => 'Heavyweight fleece with puffy print branding.',
                'category_slug' => 'tops',
                'colors' => ['#000000', '#FFA500'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'image' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1576566588028-4147f3842f27?q=80&w=800']
            ],
            [
                'name' => 'Transparent Vinyl Bag',
                'aesthetic' => 'mix',
                'price' => 95.00,
                'description' => 'Show off your essentials. PVC tote with leather trim.',
                'category_slug' => 'accessories',
                'colors' => ['#FFFFFF'],
                'sizes' => ['OS'],
                'image' => 'https://images.unsplash.com/photo-1591561954557-26941169b49e?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=800']
            ],
            [
                'name' => 'Patchwork Denim Jeans',
                'aesthetic' => 'mix',
                'price' => 180.00,
                'description' => 'Upcycled denim in varying washes.',
                'category_slug' => 'outerwear', // Pants
                'colors' => ['#0000FF'],
                'sizes' => ['S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=800']
            ],
            [
                'name' => 'Faux Fur Bucket Hat',
                'aesthetic' => 'mix',
                'price' => 65.00,
                'description' => '90s nostalgia with a luxurious texture.',
                'category_slug' => 'accessories',
                'colors' => ['#FF1493', '#000000'],
                'sizes' => ['S-M', 'M-L'],
                'image' => 'https://images.unsplash.com/photo-1575428652377-a2d80e2277fc?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1556306535-0f09a537f0a3?q=80&w=800']
            ],
            [
                'name' => 'Utility Cargo Skirt',
                'aesthetic' => 'mix',
                'price' => 120.00,
                'description' => 'Functional pockets in a chic midi silhouette.',
                'category_slug' => 'dresses',
                'colors' => ['#556B2F'],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'image' => 'https://images.unsplash.com/photo-1509551388413-e18d0ac5d495?q=80&w=1200',
                'gallery' => ['https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?q=80&w=800']
            ],
        ];

        foreach ($luxuryData as $p) {
            $product = Product::create([
                'name' => $p['name'],
                'slug' => Str::slug($p['name']) . '-' . rand(100, 999),
                'aesthetic' => $p['aesthetic'],
                'price' => $p['price'],
                'description' => $p['description'],
                'category_id' => $categories[$p['category_slug']] ?? null,
                'image' => $p['image'],
                'sku' => 'CHIC-' . strtoupper(Str::random(8)),
                'colors' => $p['colors'],
                'sizes' => $p['sizes'],
                'brand_name' => $p['brand_name'] ?? 'Chic Elite',
                'price_tier' => $p['price_tier'] ?? 'luxury',
                'stock' => rand(20, 100),
                'status' => 'active',
                'discover_score' => rand(100, 500)
            ]);

            // Add Primary Image to Gallery
            $product->images()->create([
                'url' => $p['image'],
                'alt_text' => $p['name'],
                'is_primary' => true,
                'sort_order' => 0
            ]);

            // Add Multi-View Gallery (Simulated using diverse Unsplash IDs)
            foreach ($p['gallery'] as $idx => $gUrl) {
                $product->images()->create([
                    'url' => $gUrl,
                    'alt_text' => $p['name'] . ' Detail Shot',
                    'is_primary' => false,
                    'sort_order' => $idx + 1
                ]);
            }

            // Create Variants for Size/Color selection
            foreach ($p['colors'] as $color) {
                foreach ($p['sizes'] as $size) {
                    $product->variants()->create([
                        'color' => $color,
                        'size' => $size,
                        'stock' => rand(5, 15)
                    ]);
                }
            }
        }
    }
}
