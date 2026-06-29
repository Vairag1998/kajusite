<?php
session_start();
define('PRODUCTS_FILE', __DIR__ . '/products.json');
define('reviewS_FILE', __DIR__ . '/review.json');
define('CONFIG_FILE', __DIR__ . '/config.json');

// Default admin password (change this!)
define('ADMIN_PASS', 'admin@nexshop');

// --- Product handling ---
function getProducts() {
    if (!file_exists(PRODUCTS_FILE)) {
        $default = [
            [
                "id"=>1,
                "name"=>"Premium 4KG Mix Dry Fruits Combo",
                "sellPrice"=>"₹199",
                "mrpPrice"=>"₹5,999",
                "offPercent"=>"97% off",
                "rating"=>"3.9",
                "reviewCount"=>"1374",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_mgf77cmgf77cmgf7.png?v=1774764915",
                "freeDelivery"=>true
            ],
            [
                "id"=>2,
                "name"=>"Essential Grocery Mega Saver Combo",
                "sellPrice"=>"₹199.00",
                "mrpPrice"=>"₹5,999.00",
                "offPercent"=>"97% off",
                "rating"=>"3.6",
                "reviewCount"=>"6476",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_e5duave5duave5du.png?v=1774764917",
                "freeDelivery"=>true
            ],
            [
                "id"=>3,
                "name"=>"Daily Essentials Mega Saver Combo",
                "sellPrice"=>"₹199.00",
                "mrpPrice"=>"₹5,999.00",
                "offPercent"=>"97% off",
                "rating"=>"3.7",
                "reviewCount"=>"4802",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_b7k5xsb7k5xsb7k5.png?v=1774764917",
                "freeDelivery"=>true
            ],
            [
                "id"=>4,
                "name"=>"Rasoi Samagri Special Combo – 20KG Atta, 5KG Sugar, 1KG Besan & 5L Mustard Oil",
                "sellPrice"=>"₹199.00",
                "mrpPrice"=>"₹5,999.00",
                "offPercent"=>"97% off",
                "rating"=>"4.4",
                "reviewCount"=>"1343",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_j3ynhoj3ynhoj3yn.png?v=1774764914",
                "freeDelivery"=>true
            ],
            [
                "id"=>5,
                "name"=>"Grocery Essentials Combo – 10KG Rice, 10KG Atta & 5L Kachi Ghani Mustard Oil",
                "sellPrice"=>"₹199.00",
                "mrpPrice"=>"₹5,999.00",
                "offPercent"=>"97% off",
                "rating"=>"4.4",
                "reviewCount"=>"1796",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_oyjekioyjekioyje.png?v=1774764922",
                "freeDelivery"=>true
            ],
            [
                "id"=>6,
                "name"=>"5KG Premium Mix Dry Fruits Combo – Almonds, Cashews, Pistachios, Walnuts & Raisins",
                "sellPrice"=>"₹199.00",
                "mrpPrice"=>"₹5,999.00",
                "offPercent"=>"97% off",
                "rating"=>"3.7",
                "reviewCount"=>"4802",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_9avcrz9avcrz9avc.png?v=1774764871",
                "freeDelivery"=>true
            ],
            [
                "id"=>7,
                "name"=>"Surf Excel Easy Wash 10KG Pack + FREE Comfort Fabric Conditioner 1L",
                "sellPrice"=>"₹199.00",
                "mrpPrice"=>"₹5,999.00",
                "offPercent"=>"97% off",
                "rating"=>"3.7",
                "reviewCount"=>"4802",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_jyteb2jyteb2jyte.png?v=1774764921",
                "freeDelivery"=>true
            ],
            [
                "id"=>8,
                "name"=>"Super Cleaning Combo – Ariel Liquid 6.4L + Tide Powder 8KG + 3x Harpic Toilet Cleaner",
                "sellPrice"=>"₹199.00",
                "mrpPrice"=>"₹5,999.00",
                "offPercent"=>"97% off",
                "rating"=>"3.7",
                "reviewCount"=>"4802",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_5d5dyu5d5dyu5d5d.png?v=1774764922",
                "freeDelivery"=>true
            ],
            [
                "id"=>9,
                "name"=>"Super Saver Grocery Combo – Rice 5KG, Atta 10KG, Sugar 5KG & Refined Oil 5L",
                "sellPrice"=>"₹199.00",
                "mrpPrice"=>"₹5,999.00",
                "offPercent"=>"97% off",
                "rating"=>"3.7",
                "reviewCount"=>"4802",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_7i9cdo7i9cdo7i9c.png?v=1774764921",
                "freeDelivery"=>true
            ],
            [
                "id"=>10,
                "name"=>"Super Saver Grocery Combo – Rice 5KG, Atta 10KG, Sugar 5KG & Refined Oil 5L",
                "sellPrice"=>"₹199.00",
                "mrpPrice"=>"₹5,999.00",
                "offPercent"=>"97% off",
                "rating"=>"3.7",
                "reviewCount"=>"4802",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_ax3dasax3dasax3d.png?v=1774764920",
                "freeDelivery"=>true
            ],
            [
                "id"=>11,
                "name"=>"Limited Time Grocery Combo – Rice 5KG, Atta 5KG, Oil 5L, Salt 1KG & Sugar 1KG",
                "sellPrice"=>"249.00",
                "mrpPrice"=>"₹5,999.00",
                "offPercent"=>"97% off",
                "rating"=>"3.9",
                "reviewCount"=>"5520",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_rhct2trhct2trhct.png?v=1774764919",
                "freeDelivery"=>true
            ],
            [
                "id"=>12,
                "name"=>"Beverage & Grocery Combo – Tata Tea 1.5KG, Sugar 5KG, Coffee, Green Tea & Masala Tea",
                "sellPrice"=>"249.00",
                "mrpPrice"=>"₹5,999.00",
                "offPercent"=>"97% off",
                "rating"=>"3.9",
                "reviewCount"=>"5520",
                "imgUrl"=>"https://cdn.shopify.com/s/files/1/0728/8487/9496/files/Gemini_Generated_Image_tjjtxctjjtxctjjt.png?v=1774764920",
                "freeDelivery"=>true
            ],

        ];
        file_put_contents(PRODUCTS_FILE, json_encode($default, JSON_PRETTY_PRINT));
    }
    return json_decode(file_get_contents(PRODUCTS_FILE), true);
}
function saveProducts($products) {
    file_put_contents(PRODUCTS_FILE, json_encode(array_values($products), JSON_PRETTY_PRINT));
}

// --- Config (UPI, Pixel, GA) ---
function getConfig() {
    if (!file_exists(CONFIG_FILE)) {
        $default = ["upi_id"=>"mab.037326059540013@axisbank","facebook_pixel_ids"=>"","google_analytics_id"=>""];
        file_put_contents(CONFIG_FILE, json_encode($default, JSON_PRETTY_PRINT));
    }
    return json_decode(file_get_contents(CONFIG_FILE), true);
}
function saveConfig($cfg) {
    file_put_contents(CONFIG_FILE, json_encode($cfg, JSON_PRETTY_PRINT));
}

// --- Cart helpers ---
function getCart() { return $_SESSION['cart'] ?? []; }
function getCartCount() { return array_sum(array_column(getCart(), 'qty')); }
function getCartTotal() {
    $total = 0;
    foreach (getCart() as $item) {
        $price = (float) str_replace(['₹',','], '', $item['sellPrice']);
        $total += $price * $item['qty'];
    }
    return $total;
}
function updateCart($productId, $qty) {
    $cart = &$_SESSION['cart'];
    if ($qty <= 0) {
        $cart = array_filter($cart, fn($i) => $i['id'] != $productId);
    } else {
        $found = false;
        foreach ($cart as &$item) {
            if ($item['id'] == $productId) { $item['qty'] = $qty; $found = true; break; }
        }
        if (!$found) {
            $product = current(array_filter(getProducts(), fn($p) => $p['id'] == $productId));
            if ($product) {
                $cart[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'sellPrice' => $product['sellPrice'],
                    'imgUrl' => $product['imgUrl'],
                    'qty' => $qty
                ];
            }
        }
    }
}
?>