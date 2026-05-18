</main>
<footer class="footer" role="contentinfo">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3 class="footer-title">АвтоСклад Плюс</h3>
                <p class="footer-description">
                    Постачальник автозапчастин для легкових авто: від гальмівних колодок до електрики
                    та вузлів охолодження. Працюємо з перевіреними брендами та прозорою гарантією.
                </p>
                <div class="footer-social">
                    <a href="https://facebook.com" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       aria-label="Facebook"
                       class="social-link">
                        <span class="social-icon">📘</span>
                        <span class="social-text">Facebook</span>
                    </a>
                    <a href="https://instagram.com" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       aria-label="Instagram"
                       class="social-link">
                        <span class="social-icon">📷</span>
                        <span class="social-text">Instagram</span>
                    </a>
                    <a href="https://twitter.com" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       aria-label="Twitter"
                       class="social-link">
                        <span class="social-icon">🐦</span>
                        <span class="social-text">Twitter</span>
                    </a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3 class="footer-title">Навігація</h3>
                <nav class="footer-nav" aria-label="Футер навігація">
                    <ul class="footer-nav-list">
                        <li><a href="index.php">Головна</a></li>
                        <li><a href="cart.php">Кошик</a></li>
                        <?php if(isLoggedIn()): ?>
                            <li><a href="profile.php">Профіль</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Вхід</a></li>
                            <li><a href="register.php">Реєстрація</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            
            <div class="footer-section" id="contacts">
                <h3 class="footer-title">Контакти</h3>
                <address class="footer-contact">
                    <p class="contact-item">
                        <span class="contact-icon">📧</span>
                        <a href="mailto:zapytannya@autosklad-plus.ua" class="contact-link">zapytannya@autosklad-plus.ua</a>
                    </p>
                    <p class="contact-item">
                        <span class="contact-icon">📞</span>
                        <a href="tel:+380442900771" class="contact-link">+380 (44) 290-07-71</a>
                    </p>
                    <p class="contact-item">
                        <span class="contact-icon">🕒</span>
                        <span class="contact-text">Пн–Сб: 8:00 – 20:00</span>
                    </p>
                </address>
            </div>
            
            <div class="footer-section">
                <h3 class="footer-title">Інформація</h3>
                <ul class="footer-info-list">
                    <li><a href="#">Про нас</a></li>
                    <li><a href="#">Доставка та оплата</a></li>
                    <li><a href="#">Гарантія на запчастини</a></li>
                    <li><a href="#">Повернення товару</a></li>
                    <li><a href="#">Політика конфіденційності</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p class="copyright">
                &copy; <?= date('Y') ?> <strong>АвтоСклад Плюс</strong> — інтернет-магазин автозапчастин.
                Всі права захищені.
            </p>
            <p class="footer-meta">
                Надійні запчастини для вашого авто
            </p>
        </div>
    </div>
</footer>
<script src="script.js"></script>
</body>
</html>
