<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meesho – India's Largest Online Marketplace</title>
    <link rel="stylesheet" href="style.css">
    <?php $cfg = getConfig(); if($cfg['facebook_pixel_ids']): ?>
    <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');<?php foreach(explode(',',$cfg['facebook_pixel_ids']) as $pix) echo "fbq('init', '".trim($pix)."');\n"; ?>fbq('track', 'PageView');</script>
    <?php endif; ?>
    <?php if($cfg['google_analytics_id']): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($cfg['google_analytics_id']) ?>"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= htmlspecialchars($cfg['google_analytics_id']) ?>');</script>
    <?php endif; ?>
</head>
<body>
<?php include 'header.php'; ?>

<main>
    <!-- Promo banners & timer -->
    <div class="home-promo">
        <img src="https://cdn.shopify.com/s/files/1/0981/2262/9416/files/2f53o_1.gif?v=1773923883" alt="Biggest Brand Bash" class="full-width-img">
        <img src="https://cdn.shopify.com/s/files/1/0786/1610/1096/files/1.webp?v=1774803568" alt="Maha Sale" class="full-width-img">
        <div class="offer-strip">⏰ Offer Valid for Only 24 Hours — Hurry, Limited Stock! 🔥</div>
        <img src="https://cdn.shopify.com/s/files/1/0981/2262/9416/files/xwgyl_800_1.webp?v=1773923882" alt="Benefits" class="full-width-img">
        <div class="deals-section">
            <div class="deals-container">
                <span class="deals-label">Meesho Daily Deals ⚡</span>
                <div class="timer-box">💣 <span class="timer-text" id="countdown">--h : --m : --s</span></div>
            </div>
        </div>
    </div>

    <div class="products-section">
        <h4 class="section-title">Products For You</h4>
        <div class="product-list" id="productGrid">
            <?php foreach(getProducts() as $product): ?>
            <div class="product-card" onclick="location.href='product.php?id=<?= $product['id'] ?>'">
                <div class="product-img"><img src="<?= htmlspecialchars($product['imgUrl']) ?>" loading="lazy"></div>
                <div class="product-details">
                    <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                    <div class="product-price">
                        <span class="sell-price"><?= $product['sellPrice'] ?></span>
                        <span class="mrp-price"><?= $product['mrpPrice'] ?></span>
                        <span class="off-percentage"><?= $product['offPercent'] ?></span>
                    </div>
                    <?php if($product['freeDelivery']): ?><p class="free-delivery">Free Delivery</p><?php endif; ?>
                    <div class="ratings-row">
                        <div class="rating-section">
                            <div class="rating-chip"><span class="rating-num"><?= $product['rating'] ?></span> ⭐</div>
                            <span class="review-count">(<?= $product['reviewCount'] ?>)</span>
                        </div>
                    </div>
                    <button class="add-to-cart-btn" onclick="event.stopPropagation(); addToCart(<?= $product['id'] ?>)">Add to Cart</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<script>
function addToCart(pid) {
    fetch('cart.php', { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body:'action=add&id='+pid })
        .then(r=>r.json()).then(d=>{ if(d.success) location.reload(); });
}
// Timer
function updateTimer() {
    const now = new Date();
    const end = new Date(); end.setHours(23,59,59,999);
    const diff = end - now;
    if(diff<=0) document.getElementById('countdown').innerText = "00h : 00m : 00s";
    else {
        const h = Math.floor(diff/3600000);
        const m = Math.floor((diff%3600000)/60000);
        const s = Math.floor((diff%60000)/1000);
        document.getElementById('countdown').innerText = `${String(h).padStart(2,'0')}h : ${String(m).padStart(2,'0')}m : ${String(s).padStart(2,'0')}s`;
    }
}
setInterval(updateTimer,1000); updateTimer();
</script>
</body>
</html>