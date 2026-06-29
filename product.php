<?php require 'config.php';
$id = (int)$_GET['id'];
$product = current(array_filter(getProducts(), fn($p)=>$p['id']==$id));
if(!$product) { header('Location: index.php'); exit; }
// Static reviews (same as original React)
$reviews = json_decode(file_get_contents(reviewS_FILE), true);
?>
<!DOCTYPE html><html><head><title><?= htmlspecialchars($product['name']) ?></title><link rel="stylesheet" href="style.css"></head><body>
<?php include 'header.php'; ?>
<main class="product-page-main">
    <div class="product-gallery">
        <div class="main-image-container"><img src="<?= htmlspecialchars($product['imgUrl']) ?>"></div>
        <div class="similar-products-section">
            <p class="section-title-sm">1 Similar Product</p>
            <div class="thumbnail-list"><div class="thumb-item active"><img src="<?= htmlspecialchars($product['imgUrl']) ?>"></div></div>
        </div>
    </div>
    <div class="product-info-card">
        <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>
        <div class="pricing-row">
            <span class="current-price"><?= $product['sellPrice'] ?></span>
            <span class="mrp-price-pd"><?= $product['mrpPrice'] ?></span>
            <span class="discount-pill"><?= $product['offPercent'] ?></span>
        </div>
        <?php if($product['freeDelivery']): ?><div class="free-delivery-tag">Free Delivery</div><?php endif; ?>
    </div>
    <div class="seller-card"><div class="seller-left"><div class="shop-icon-blue">🏪</div><div class="seller-info-text"><div class="seller-name-row"><span class="sold-by-badge">Sold by</span><span class="seller-shop-name">meesho official</span></div><div class="seller-rating-badge">4.4 ⭐</div></div></div></div>
    <div class="product-details-card"><h2 class="card-title">Product Description</h2><div class="product-desc-content">Upgrade your daily nutrition with this value-packed combo. Perfect for festivals and gifting.</div></div>
    <div class="new-reviews-container"><div class="rv-section-head"><span class="rv-section-title">Ratings & Reviews</span></div>
    <div class="reviews-summary-new"><div class="summary-left"><div class="main-rating-green">4.2 ⭐</div><p class="summary-total">3,738 ratings</p><p class="summary-reviews-count">256 reviews</p></div><div class="summary-bars"><div class="summary-bar-row"><span class="bar-label">Very Good</span><div class="bar-bg"><div class="bar-fill" style="width:43%; background:#059669"></div></div><span class="bar-count">1480</span></div></div></div>
    <div class="new-review-list"><?php foreach($reviews as $rv): ?><div class="new-review-card"><div class="rv-top-row"><div class="rv-avatar" style="background:#60014A">RS</div><div class="rv-name-col"><span class="reviewer-name"><?= $rv['name'] ?></span><?php if($rv['verified']): ?><span class="rv-verified">✓ Verified Purchase</span><?php endif; ?></div><span class="review-date"><?= $rv['date'] ?></span></div><div class="review-status-row"><div class="rv-stars"><?php for($i=0;$i<5;$i++) echo $i<$rv['rating'] ? '⭐' : '☆'; ?></div><span class="status-txt"><?= $rv['rating']>=4?'Very Good':'Good' ?></span></div><p class="review-comment"><?= $rv['comment'] ?></p><div class="rv-helpful-row"><span class="rv-helpful-label">Helpful?</span><button class="helpful-btn-new">👍 Yes (<?= $rv['helpful'] ?>)</button><button class="helpful-btn-no">👎 No</button></div></div><?php endforeach; ?></div></div>
    <div style="height:80px"></div>
</main>
<div class="button-container"><button class="buynow-button buynow-white" onclick="addToCart(<?= $product['id'] ?>)">🛒 Add to Cart</button><button class="buynow-button buynow-purple" onclick="buyNow(<?= $product['id'] ?>)">⚡ Buy Now</button></div>
<script>
function addToCart(pid){ fetch('cart.php',{method:'POST',body:'action=add&id='+pid,headers:{'Content-Type':'application/x-www-form-urlencoded'}}).then(()=>location.reload()); }
function buyNow(pid){ fetch('cart.php',{method:'POST',body:'action=add&id='+pid}).then(()=>location.href='cart.php'); }
</script>
<?php include 'footer.php'; ?>
</body></html>