<?php require 'config.php';
if(empty(getCart()) || empty($_SESSION['address'])) { header('Location: index.php'); exit; }
$config = getConfig();
$total = getCartTotal();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Payment – Meesho</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="pm-main">
    <!-- Step bar -->
    <div class="step-bar">
        <div class="step done"><div class="step-dot">✓</div><span class="step-lbl">Cart</span></div>
        <div class="step done"><div class="step-dot">✓</div><span class="step-lbl">Address</span></div>
        <div class="step active"><div class="step-dot">3</div><span class="step-lbl">Payment</span></div>
        <div class="step"><div class="step-dot">4</div><span class="step-lbl">Summary</span></div>
    </div>

    <!-- Payment header with safe badge -->
    <div class="pm-header">
        <h2 class="pm-title">Select Payment Method</h2>
        <div class="pm-safe-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="#1d4ed8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            100% SAFE PAYMENTS
        </div>
    </div>

    <!-- Payment methods card -->
    <div class="pm-card">
        <div class="pm-section-title">PAY ONLINE</div>
        
        <!-- UPI option header -->
        <div class="pm-upi-header">
            <span class="pm-upi-badge">UPI</span>
            <span class="pm-upi-label">UPI (GPay/PhonePe/Paytm)</span>
        </div>

        <!-- UPI apps list -->
        <div class="pm-apps-list" id="appsList">
            <?php 
            $apps = [
                ['id'=>'gpay', 'name'=>'Google Pay', 'logo'=>'https://cdn.shopify.com/s/files/1/0987/4102/7106/files/Untitled_design_7.png', 'desc'=>'UPI linked account'],
                ['id'=>'phonepe', 'name'=>'PhonePe', 'logo'=>'https://cdn.shopify.com/s/files/1/0988/1590/1975/files/Untitled_design_10.png', 'desc'=>'Linked UPI payment'],
                ['id'=>'paytm', 'name'=>'Paytm', 'logo'=>'https://cdn.shopify.com/s/files/1/0988/1590/1975/files/Untitled_design_8.png', 'desc'=>'UPI / Wallet'],
                ['id'=>'bhim', 'name'=>'BHIM UPI', 'logo'=>'https://cdn.shopify.com/s/files/1/0987/4102/7106/files/Untitled_design_6.png', 'desc'=>'Any UPI app'],
                ['id'=>'whatsapp', 'name'=>'WhatsApp Pay', 'logo'=>'https://cdn.shopify.com/s/files/1/0988/1590/1975/files/Untitled_design_9.png', 'desc'=>'WhatsApp UPI']
            ];
            foreach($apps as $app): ?>
            <div class="pm-app-item" data-method="<?= $app['id'] ?>">
                <div class="pm-radio-wrap">
                    <div class="pm-radio-inner"></div>
                </div>
                <div class="pm-app-info">
                    <div class="pm-app-name"><?= $app['name'] ?></div>
                    <div class="pm-app-desc"><?= $app['desc'] ?></div>
                </div>
                <img src="<?= $app['logo'] ?>" class="pm-app-logo" alt="<?= $app['name'] ?>">
            </div>
            <?php endforeach; ?>
        </div>

        <!-- QR code link -->
        <div class="pm-qr-link" id="qrLink">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="3" height="3"/><rect x="18" y="14" width="3" height="3"/><rect x="14" y="18" width="7" height="3"/></svg>
            Scan QR Code to Pay
        </div>
    </div>

    <!-- UPI ID display -->
    <div class="pm-upi-id-row">
        <span class="pm-upi-id-label">UPI ID:</span>
        <span class="pm-upi-id-value"><?= htmlspecialchars($config['upi_id']) ?></span>
    </div>

    <!-- Price details card -->
    <div class="pm-price-card">
        <div class="pm-price-row">
            <span>Total Product Price:</span>
            <span>₹<?= number_format($total,2) ?></span>
        </div>
        <div class="pm-price-divider"></div>
        <div class="pm-price-row">
            <span>Shipping:</span>
            <span class="pm-free">FREE</span>
        </div>
        <div class="pm-price-divider"></div>
        <div class="pm-price-row pm-total">
            <span>Order Total:</span>
            <span>₹<?= number_format($total,2) ?></span>
        </div>
    </div>

    <!-- Sticky footer with total and Pay button -->
    <div class="pm-sticky-footer">
        <div class="pm-footer-total">
            <span class="pm-footer-amount">₹<?= number_format($total,2) ?></span>
            <span class="pm-footer-detail" onclick="togglePriceDetails()">VIEW PRICE DETAILS</span>
        </div>
        <button class="pm-pay-btn" id="payNowBtn">PayNow</button>
    </div>
</main>

<!-- QR Modal -->
<div id="qrModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:1200; align-items:center; justify-content:center;">
    <div class="pm-qr-modal">
        <div class="pm-qr-title">Scan & Pay</div>
        <div class="pm-qr-sub">Open any UPI app and scan</div>
        <img src="https://quickchart.io/qr?size=200&text=upi://pay?pa=<?= urlencode($config['upi_id']) ?>&am=<?= $total ?>&pn=Meesho" class="pm-qr-img">
        <div class="pm-qr-upi"><?= htmlspecialchars($config['upi_id']) ?></div>
        <div class="pm-qr-apps"><span>GPay</span><span>PhonePe</span><span>Paytm</span></div>
        <button onclick="closeQR()" class="pm-close-sheet">Close</button>
    </div>
</div>

<script>
    let selectedMethod = 'gpay';
    // Radio selection
    document.querySelectorAll('.pm-app-item').forEach(item => {
        item.addEventListener('click', () => {
            document.querySelectorAll('.pm-app-item').forEach(i => i.classList.remove('selected'));
            item.classList.add('selected');
            selectedMethod = item.dataset.method;
        });
        // Set default
        if(item.dataset.method === 'gpay') item.classList.add('selected');
    });
    // Pay button
    document.getElementById('payNowBtn').addEventListener('click', () => {
        let upi = "<?= urlencode($config['upi_id']) ?>";
        let amt = "<?= $total ?>";
        let url = `upi://pay?pa=${upi}&pn=Meesho&am=${amt}&cu=INR`;
        if(selectedMethod === 'gpay') url = `gpay://upi/pay?pa=${upi}&am=${amt}`;
        else if(selectedMethod === 'phonepe') url = `phonepe://upi/pay?pa=${upi}&am=${amt}`;
        else if(selectedMethod === 'paytm') url = `paytmmp://cash_wallet?pa=${upi}&am=${amt}`;
        window.location.href = url;
    });
    // QR code modal
    document.getElementById('qrLink').addEventListener('click', () => {
        document.getElementById('qrModal').style.display = 'flex';
    });
    function closeQR() {
        document.getElementById('qrModal').style.display = 'none';
    }
    // Price details toggle (optional)
    function togglePriceDetails() {
        document.querySelector('.pm-price-card').classList.toggle('expanded');
    }
</script>
<script>
    function fixStickyFooter() {
        var footer = document.querySelector('.pm-sticky-footer');
        if (footer) {
            footer.style.position = 'fixed';
            footer.style.bottom = '0';
            footer.style.left = '0';
            footer.style.right = '0';
            footer.style.display = 'flex';
        }
    }
    window.addEventListener('load', fixStickyFooter);
    window.addEventListener('resize', fixStickyFooter);
    // Also run after a short delay for DevTools emulation
    setTimeout(fixStickyFooter, 100);
</script>

<?php include 'footer.php'; ?>
</body>
</html>