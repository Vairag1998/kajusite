<?php require 'config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=(int)$_POST['id'];
    if($_POST['action']==='add') updateCart($id, getCartItemQty($id)+1);
    if($_POST['action']==='update') updateCart($id, (int)$_POST['qty']);
    echo json_encode(['success'=>true,'count'=>getCartCount()]); exit;
}
function getCartItemQty($id){ foreach(getCart() as $i) if($i['id']==$id) return $i['qty']; return 0; }
$cartItems = getCart();
$subtotal = getCartTotal();
?>
<!DOCTYPE html><html><head><title>Cart</title><link rel="stylesheet" href="style.css"></head><body>
<?php include 'header.php'; ?>
<main class="cart-page-main">
    <div class="step-bar"><div class="step active"><div class="step-dot">1</div><span class="step-lbl">Cart</span></div><div class="step"><div class="step-dot">2</div><span class="step-lbl">Address</span></div><div class="step"><div class="step-dot">3</div><span class="step-lbl">Payment</span></div></div>
    <div class="cp-section-card"><div class="cp-cart-title">Cart</div><?php if(empty($cartItems)): ?><div class="empty-wrap"><h2>Your cart is empty!</h2><button class="empty-shop-btn" onclick="location.href='index.php'">Start Shopping</button></div><?php else: foreach($cartItems as $item): ?><div class="cp-item-row-wrap"><div class="cp-item-row"><img src="<?= htmlspecialchars($item['imgUrl']) ?>" class="cp-item-img"><div class="cp-item-details"><div class="cp-item-top"><div class="cp-item-name"><?= htmlspecialchars($item['name']) ?></div><button class="cp-delete-btn" onclick="updateQty(<?= $item['id'] ?>,0)">🗑️</button></div><div class="cp-price-row"><span class="cp-price-now"><?= $item['sellPrice'] ?></span></div><div class="cp-qty-row"><button class="cp-qty-btn" onclick="updateQty(<?= $item['id'] ?>, <?= $item['qty']-1 ?>)">−</button><span class="cp-qty-val"><?= $item['qty'] ?></span><button class="cp-qty-btn" onclick="updateQty(<?= $item['id'] ?>, <?= $item['qty']+1 ?>)">+</button></div></div></div></div><?php endforeach; endif; ?></div>
    <div class="cp-section-card"><div class="cp-delivery-title">Delivery Options</div><div class="cp-delivery-option selected"><div class="cp-radio-circle"><div class="cp-radio-dot"></div></div><div class="cp-delivery-info"><div class="cp-delivery-name">Standard Delivery</div><div class="cp-delivery-sub">Delivery in 4 to 5 days</div></div><div class="cp-delivery-price cp-free-val">FREE</div></div></div>
    <div class="cp-section-card"><div class="cp-summary-row"><span class="cp-sum-label">Total Product Price:</span><span class="cp-sum-val">₹<?= number_format($subtotal,2) ?></span></div><div class="cp-summary-divider"></div><div class="cp-summary-row"><span class="cp-sum-label">Shipping:</span><span class="cp-sum-val cp-free-val">FREE</span></div><div class="cp-summary-divider"></div><div class="cp-summary-row cp-summary-total"><span class="cp-sum-label">Order Total :</span><span class="cp-sum-val">₹<?= number_format($subtotal,2) ?></span></div></div>
    <div class="cp-safety-card"><img src="https://cdn.shopify.com/s/files/1/0987/4102/7106/files/WhatsApp_Image_2026-02-13_at_1.19.12_PM.jpg?v=1770980679" class="cp-safety-img"></div>
    <div style="height:80px"></div>
</main>
<div class="cp-sticky-footer"><div class="cp-footer-price">₹<?= number_format($subtotal,2) ?></div><button class="cp-continue-btn" onclick="location.href='checkout.php'">Continue</button></div>
<script>function updateQty(id,qty){ fetch('cart.php',{method:'POST',body:'action=update&id='+id+'&qty='+qty,headers:{'Content-Type':'application/x-www-form-urlencoded'}}).then(()=>location.reload()); }</script>
<?php include 'footer.php'; ?>
</body></html>