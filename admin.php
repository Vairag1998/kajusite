<?php require 'config.php';
if(!isset($_SESSION['admin_logged_in'])){
    if($_SERVER['REQUEST_METHOD']==='POST' && $_POST['password']===ADMIN_PASS){
        $_SESSION['admin_logged_in']=true; header('Location: admin.php'); exit;
    }
    echo '<!DOCTYPE html><html><head><link rel="stylesheet" href="style.css"></head><body><div class="adm-login-wrap"><div class="adm-login-card"><div class="adm-login-logo"><span class="nexshop-logo">meesho</span></div><p class="adm-login-sub">Admin Panel</p><form method="POST"><input type="password" name="password" class="adm-pass-input" placeholder="Enter admin password"><button type="submit" class="adm-login-btn">Login</button></form><button class="adm-back-link" onclick="location.href=\'index.php\'">← Back to store</button></div></div></body></html>';
    exit;
}
// Handle POST actions
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['update_config'])) saveConfig(['upi_id'=>$_POST['upi_id'],'facebook_pixel_ids'=>$_POST['facebook_pixel_ids'],'google_analytics_id'=>$_POST['google_analytics_id']]);
    if(isset($_POST['add_product'])){
        $products=getProducts();
        $newId = max(array_column($products,'id'))+1;
        $products[]=['id'=>$newId,'name'=>$_POST['name'],'sellPrice'=>'₹'.number_format($_POST['sellPrice'],2),'mrpPrice'=>'₹'.number_format($_POST['mrpPrice'],2),'offPercent'=>$_POST['offPercent'],'imgUrl'=>$_POST['imgUrl'],'rating'=>$_POST['rating'],'reviewCount'=>$_POST['reviewCount'],'freeDelivery'=>isset($_POST['freeDelivery'])];
        saveProducts($products);
    }
    if(isset($_POST['delete_product'])){ $id=(int)$_POST['product_id']; $products=array_filter(getProducts(),fn($p)=>$p['id']!=$id); saveProducts($products); }
    if(isset($_POST['reset_products'])){ unlink(PRODUCTS_FILE); header('Location: admin.php'); exit; }
    if(isset($_FILES['csv_file']) && $_FILES['csv_file']['error']==0){
        $csv = array_map('str_getcsv', file($_FILES['csv_file']['tmp_name']));
        if(count($csv)>1){
            $headers = array_map('strtolower',array_map('trim',$csv[0]));
            $products = getProducts();
            $nextId = max(array_column($products,'id'))+1;
            for($i=1;$i<count($csv);$i++){
                $row = array_combine($headers, $csv[$i]);
                if(isset($row['name']) && !empty($row['name'])){
                    $products[]=['id'=>$nextId++,'name'=>$row['name'],'sellPrice'=>'₹'.number_format($row['sellprice']??199,2),'mrpPrice'=>'₹'.number_format($row['mrpprice']??5999,2),'offPercent'=>$row['offpercent']??'80% off','imgUrl'=>$row['imgurl']??'','rating'=>$row['rating']??'4.0','reviewCount'=>$row['reviewcount']??'100','freeDelivery'=>isset($row['freedelivery']) && ($row['freedelivery']=='true')];
                }
            }
            saveProducts($products);
        }
        header('Location: admin.php?msg=imported'); exit;
    }
    header('Location: admin.php'); exit;
}
$cfg = getConfig(); $products = getProducts();
?>
<!DOCTYPE html><html><head><title>Admin</title><link rel="stylesheet" href="style.css"></head><body>
<div class="adm-wrap"><div class="adm-header"><span><span class="nexshop-logo">meesho</span><span class="adm-header-label">Admin</span></span><div><button class="adm-store-btn" onclick="location.href='index.php'">← Store</button><button class="adm-logout-btn" onclick="location.href='?logout=1'">Logout</button></div></div>
<div class="adm-content">
    <div class="adm-section"><div class="adm-section-title">💳 Merchant UPI ID</div><div class="adm-section-body"><form method="POST"><div class="adm-input-row"><input type="text" name="upi_id" class="adm-input" value="<?= htmlspecialchars($cfg['upi_id']) ?>"><button type="submit" name="update_config" class="adm-save-btn">Save</button></div><div class="adm-input-row"><input type="text" name="facebook_pixel_ids" class="adm-input" placeholder="Pixel IDs" value="<?= htmlspecialchars($cfg['facebook_pixel_ids']) ?>"></div><div class="adm-input-row"><input type="text" name="google_analytics_id" class="adm-input" placeholder="GA4 ID" value="<?= htmlspecialchars($cfg['google_analytics_id']) ?>"></div><button type="submit" name="update_config" class="adm-save-btn">Save Settings</button></form></div></div>
    <div class="adm-section"><div class="adm-section-title">➕ Add Single Product</div><div class="adm-section-body"><form method="POST"><input type="text" name="name" class="adm-input" placeholder="Product Name" required><div class="adm-form-2col"><input type="number" step="0.01" name="sellPrice" placeholder="Sell Price"><input type="number" step="0.01" name="mrpPrice" placeholder="MRP"></div><input type="text" name="offPercent" class="adm-input" placeholder="97% off"><input type="url" name="imgUrl" class="adm-input" placeholder="Image URL"><div class="adm-form-2col"><input type="text" name="rating" placeholder="4.2"><input type="text" name="reviewCount" placeholder="500"></div><label><input type="checkbox" name="freeDelivery"> Free Delivery</label><button type="submit" name="add_product" class="adm-save-btn" style="margin-top:12px">+ Add Product</button></form></div></div>
    <div class="adm-section"><div class="adm-section-title">📤 Bulk CSV Upload</div><div class="adm-section-body"><form method="POST" enctype="multipart/form-data"><input type="file" name="csv_file" accept=".csv" required><button type="submit" name="csv_import" class="adm-save-btn">Import CSV</button></form><div class="adm-csv-example-wrap"><pre class="adm-csv-example">name,sellPrice,mrpPrice,offPercent,imgUrl,rating,reviewCount,freeDelivery
Organic Honey,199,1999,90% off,https://example.com/honey.jpg,4.5,320,true</pre></div></div></div>
    <div class="adm-section"><div class="adm-section-title">🛒 Current Products (<?= count($products) ?>)</div><div class="adm-section-body"><form method="POST" style="text-align:right; margin-bottom:12px"><button name="reset_products" class="adm-reset-btn">↺ Reset to Defaults</button></form><div class="adm-product-list"><?php foreach($products as $p): ?><div class="adm-product-row"><img src="<?= htmlspecialchars($p['imgUrl']) ?>" class="adm-thumb"><div class="adm-product-info"><div class="adm-product-name"><?= htmlspecialchars($p['name']) ?></div><div class="adm-product-meta"><?= $p['sellPrice'] ?> · <?= $p['offPercent'] ?></div></div><form method="POST"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><button type="submit" name="delete_product" class="adm-del-btn">🗑️</button></form></div><?php endforeach; ?></div></div></div>
</div></div>
<?php if(isset($_GET['msg'])) echo '<div class="adm-toast">✓ '.htmlspecialchars($_GET['msg']).'</div>'; ?>
</body></html>