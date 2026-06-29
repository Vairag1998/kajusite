<?php $cartCount = getCartCount(); ?>
<div class="meesho-header">
    <div class="header-container">
        <div class="header-topRow">
            <div class="header-left">
                <button class="hamburger-btn" onclick="alert('Menu')">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="#333" stroke-width="2" fill="none">
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <a href="index.php" class="brand-logo">
                    <span class="nexshop-logo">meesho</span>
                </a>
            </div>
            <div class="header-right">
                <a href="#" class="header-icon">
                    <svg viewBox="0 0 24 24" width="24" height="24">
                        <path fill="#ED3843" d="M22 9.174c0 3.724-1.87 7.227-9.67 12.38a.58.58 0 0 1-.66 0C3.87 16.401 2 12.898 2 9.174S4.59 3.67 7.26 3.66c3.22-.081 4.61 3.573 4.74 3.774.13-.201 1.52-3.855 4.74-3.774C19.41 3.669 22 5.45 22 9.174Z"/>
                    </svg>
                </a>
                <a href="cart.php" class="header-icon cart-wrapper">
                    <svg viewBox="0 0 24 24" width="24" height="24">
                        <path fill="#9F2089" d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                    <?php if($cartCount > 0): ?><span class="badge"><?= $cartCount ?></span><?php endif; ?>
                </a>
            </div>
        </div>
        <div class="header-search">
            <div class="search-box">
                <svg viewBox="0 0 24 24" width="20" height="20" stroke="#94a3b8" stroke-width="2" fill="none">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" placeholder="Search for Sarees, Kurtis, Cosmetics, etc." id="searchInput">
            </div>
        </div>
    </div>
</div>