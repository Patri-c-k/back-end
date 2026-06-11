<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>5kvt</title>
  <link class="styles" rel="stylesheet" href="style(1).css">
</head>
<body>
  <header class="header">
    <div class="top-bar">
      <div class="container top-bar__container">
        <nav class="top-nav">
          <a href="#">Доставка и оплата</a>
          <a href="#">Контакты</a>
        </nav>
        <div class="top-slogan">
          <span class="gray-text">Построй и обустрой</span>
          <span class="dots">•••</span>
          <span>Всё для дома, дачи и стройки!</span>
        </div>
        <div class="top-actions">
          <button class="icon-btn" aria-label="Сравнение">
            <img src="icons/bar-chart-line 1.png" alt="Сравнение">
          </button>
          <button class="icon-btn" aria-label="Избранное">
            <img src="icons/heart-line 5.png" alt="Избранное">
          </button>
          <a href="cart.php" class="icon-btn" aria-label="Корзина" style="text-decoration:none;display:inline-flex;align-items:center;">
            <img src="icons/Vector.png" alt="Корзина">
            <span style="background:#ff9900;color:#fff;border-radius:50%;padding:2px 6px;font-size:11px;margin-left:5px;">
              <?= array_sum($_SESSION['cart'] ?? []) ?>
            </span>
          </a>
          <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="profile.php" class="icon-btn" aria-label="Личный кабинет" style="text-decoration:none;display:inline-flex;align-items:center;gap:4px;color:#fff;font-size:12px;">
              <img src="icons/user.png" alt="Профиль" style="width:20px;height:20px;">
              <?= htmlspecialchars($_SESSION['user_name']) ?>
            </a>
          <?php else: ?>
            <a href="auth.php" class="icon-btn" aria-label="Войти" style="text-decoration:none;display:inline-flex;align-items:center;gap:4px;color:#fff;font-size:12px;">
              <img src="icons/user.png" alt="Войти" style="width:20px;height:20px;">
              Войти
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="main-bar">
      <div class="container main-bar__container">
        <a href="/" class="logo-link">
          <img src="images/5kvt-brand-logo.png" alt="5 KVT" class="site-logo">
        </a>

        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Открыть меню">
          <span></span>
        </button>

        <a href="tel:+74997199994" class="phone-link">+7 (499) 719-99-94</a>

        <form class="search-form" method="GET" action="index.php#catalog">
          <input type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Что ищем?..." class="search-input">
          <button type="submit" class="search-btn">Поиск</button>
        </form>

        <div class="socials">
          <a href="#" class="social-icon"><img src="icons/instagram.png" alt="Instagram"></a>
          <a href="#" class="social-icon"><img src="icons/vkontakte.png" alt="VK"></a>
          <a href="#" class="social-icon"><img src="icons/facebook (1) 1.png" alt="Facebook"></a>
          <a href="#" class="social-icon"><img src="icons/movie 1.png" alt="YouTube"></a>
        </div>

        <a href="#" class="btn-addresses">Адреса магазинов</a>

        <a href="<?= !empty($_SESSION['user_id']) ? 'profile.php' : 'auth.php' ?>" class="profile-link" aria-label="Личный кабинет">
          <img src="icons/user.png" alt="Профиль" class="profile-logo">
        </a>
      </div>
    </div>

    <div class="menu-bar">
      <div class="container menu-bar__container menu-bar__container--bg">
        <div class="catalog-wrapper">
          <button class="catalog-btn" id="catalogBtn">
            <span class="burger-lines"></span>
            Каталог
          </button>
          
          <div class="catalog-dropdown" id="catalogDropdown">
            <nav class="catalog-categories">
              <div class="catalog-dropdown__header">
                <span class="burger-lines"></span>
                Каталог
              </div>
              <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                  <a href="index.php?category=<?= urlencode($cat['code']) ?>#catalog"
                     class="catalog-dropdown__item <?= (($category ?? '') === $cat['code']) ? 'active' : '' ?>">
                    <?= htmlspecialchars($cat['name']) ?> <span class="arrow-right"></span>
                  </a>
                <?php endforeach; ?>
              <?php else: ?>
                <a href="#" class="catalog-dropdown__item active" data-category="accumulators">Аккумуляторы <span class="arrow-right"></span></a>
                <a href="#" class="catalog-dropdown__item" data-category="control-blocks">Блоки контроля <span class="arrow-right"></span></a>
                <a href="#" class="catalog-dropdown__item" data-category="generators">Генераторы <span class="arrow-right"></span></a>
                <a href="#" class="catalog-dropdown__item" data-category="climate">Климатическая техника <span class="arrow-right"></span></a>
                <a href="#" class="catalog-dropdown__item" data-category="heating">Отопление <span class="arrow-right"></span></a>
              <?php endif; ?>
            </nav>
            <div class="catalog-subpanel">
              <div class="subpanel-content active" id="cat-accumulators">
                <div class="subpanel-grid">
                  <div class="subpanel-col">
                    <div class="subpanel-group">
                      <a href="#" class="subpanel-title"><span class="toggle-icon">+</span> Автомобильные АКБ</a>
                      <div class="subpanel-nested">
                        <a href="#">Кальциевые (Ca/Ca)</a>
                        <a href="#">Гибридные (Sb/Ca)</a>
                        <a href="#">Гелевые (GEL)</a>
                      </div>
                    </div>
                    <div class="subpanel-group">
                      <a href="#" class="subpanel-title"><span class="toggle-icon">+</span> Промышленные АКБ</a>
                      <div class="subpanel-nested">
                        <a href="#">Для ИБП</a>
                        <a href="#">Для солнечных батарей</a>
                      </div>
                    </div>
                    <div class="subpanel-group"><a href="#" class="subpanel-title"><span class="toggle-icon">+</span> Зарядные устройства</a></div>
                  </div>
                  <div class="subpanel-col">
                    <div class="subpanel-group"><a href="#" class="subpanel-title"><span class="toggle-icon">+</span> Клеммы и провода</a></div>
                    <div class="subpanel-group"><a href="#" class="subpanel-title"><span class="toggle-icon">+</span> Аксессуары</a></div>
                    <div class="subpanel-group"><a href="#" class="subpanel-title"><span class="toggle-icon">+</span> Тестеры батарей</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <nav class="main-nav">
          <?php if (!empty($categories)): ?>
            <?php foreach (array_slice($categories, 0, 7) as $cat): ?>
              <a href="index.php?category=<?= urlencode($cat['code']) ?>#catalog"
                 class="nav-item <?= (($category ?? '') === $cat['code']) ? 'nav-item--active' : '' ?>">
                <?= htmlspecialchars($cat['name']) ?>
              </a>
            <?php endforeach; ?>
          <?php else: ?>
            <a href="#" class="nav-item">Аккумуляторы</a>
            <a href="#" class="nav-item">Блоки контроля</a>
            <a href="#" class="nav-item">Генераторы</a>
            <a href="#" class="nav-item">Климатическая техника</a>
            <a href="#" class="nav-item">Отопление</a>
            <a href="#" class="nav-item">Перфораторы</a>
            <a href="#" class="nav-item nav-item--muted">Люстры <span class="nav-arrow"></span></a>
          <?php endif; ?>
        </nav>
      </div>
    </div>
  </header>

  <!-- ===================== HERO BANNER ===================== -->
  <section class="hero-banner">
    <div class="container hero-banner__container hero-banner__container--bg">
      <div class="hero-content">
        <h1 class="hero-title">Сильнее<br>Снегопада</h1>
        <p class="hero-description">
          Большой выбор снегоуборочных машин. Качественные устройства для любого бюджета
        </p>
        <div class="hero-controls">
          <a href="#catalog" class="btn-more">Подробнее</a>
          <div class="slider-arrows">
            <button class="arrow-btn arrow-btn--prev" aria-label="Назад"></button>
            <button class="arrow-btn arrow-btn--next" aria-label="Вперед"></button>
          </div>
        </div>
      </div>
      <div class="hero-image-wrapper">
        <img src="images/ChatGPT Image 29 мая 2026 г., 16_03_28(2).png" alt="Снегоуборщик" class="hero-image">
        <div class="badge badge--orange">от 10800 ₽</div>
        <div class="badge badge--blue">СНЕГОУБОРЩИКИ</div>
      </div>
    </div>
  </section>

  <!-- Flash корзины (показывается вверху после добавления товара) -->
  <?php if (!empty($_SESSION['cart_flash'])): ?>
    <div style="background:#d4edda;border:1px solid #c3e6cb;color:#155724;
                padding:12px 20px;text-align:center;font-size:15px;font-weight:600;">
      ✅ <?= htmlspecialchars($_SESSION['cart_flash']) ?>
    </div>
    <?php unset($_SESSION['cart_flash']); ?>
  <?php endif; ?>

  <!-- ===================== НОВОСТИ ========================= -->
  <?php if (!empty($news)): ?>
  <section class="products-section" id="news-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Новости и акции</h2>
      </div>
      <div class="slider-window">
        <div class="products-grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
          <?php foreach ($news as $n): ?>
            <div style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.07);display:flex;flex-direction:column;">
              <?php if ($n['image']): ?>
                <img src="<?= htmlspecialchars($n['image']) ?>" alt="" style="width:100%;height:160px;object-fit:cover;">
              <?php endif; ?>
              <div style="padding:16px;flex:1;">
                <h3 style="font-size:15px;font-weight:700;margin:0 0 8px;"><?= htmlspecialchars($n['title']) ?></h3>
                <p style="font-size:13px;color:#555;margin:0;"><?= htmlspecialchars($n['body']) ?></p>
                <p style="font-size:11px;color:#aaa;margin:8px 0 0;"><?= date('d.m.Y', strtotime($n['created_at'])) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ===================== ТОВАРЫ МЕСЯЦА =================== -->
  <section class="products-section" id="slider-months">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Товары месяца</h2>
        <div class="slider-arrows">
          <button class="arrow-btn arrow-btn--prev month-prev" aria-label="Назад"></button>
          <button class="arrow-btn arrow-btn--next month-next" aria-label="Вперед"></button>
        </div>
      </div>
      <div class="slider-window">
        <div class="products-grid">
          <?php foreach ($monthProducts as $p): ?>
            <article class="product-card">
              <div class="product-card__top">
                <?php if ($p['is_new']): ?>
                  <div class="product-badge product-badge--new">NEW</div>
                <?php elseif ($p['is_promo']): ?>
                  <div class="product-badge product-badge--sell">SALE</div>
                <?php endif; ?>
                <button type="button" class="wishlist-btn" aria-label="В избранное">
                  <img src="icons/heart-line 14.png" alt="">
                </button>
                <div class="product-image">
                  <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                </div>
              </div>
              <div class="product-card__info">
                <span class="product-brand"><?= htmlspecialchars($p['brand']) ?></span>
                <h3 class="product-name"><?= htmlspecialchars($p['name']) ?></h3>
              </div>
              <div class="product-card__footer-wrap">
                <div class="product-card__footer">
                  <?php if ($p['old_price']): ?>
                    <div class="product-price-block">
                      <span class="product-price"><?= number_format($p['price'], 0, '.', ' ') ?> ₽</span>
                      <span class="product-price--old"><?= number_format($p['old_price'], 0, '.', ' ') ?> ₽</span>
                    </div>
                  <?php else: ?>
                    <div class="product-price"><?= number_format($p['price'], 0, '.', ' ') ?> ₽</div>
                  <?php endif; ?>
                  <button class="compare-btn" aria-label="Сравнить">
                    <img src="icons/bar-chart-line 2.png" alt="">
                  </button>
                </div>
                <a href="index.php?action=add_to_cart&id=<?= $p['id'] ?>"
                   class="product-cart-btn">
                  <img src="icons/Vector3.png" alt="">В корзину
                </a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== НОВИНКИ ========================= -->
  <section class="novinki-section" id="slider-news">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Новинки</h2>
        <div class="slider-arrows">
          <button class="arrow-btn arrow-btn--prev news-prev" aria-label="Назад"></button>
          <button class="arrow-btn arrow-btn--next news-next" aria-label="Вперед"></button>
        </div>
      </div>
      <div class="slider-window">
        <div class="products-grid">
          <?php
          // Новинки — товары с is_new=1
          $newProducts = array_filter($products, fn($p) => $p['is_new']);
          if (empty($newProducts)) $newProducts = array_slice($monthProducts, 0, 4);
          foreach ($newProducts as $p):
          ?>
            <article class="product-card">
              <div class="product-card__top">
                <div class="product-badge product-badge--new">NEW</div>
                <button type="button" class="wishlist-btn" aria-label="В избранное">
                  <img src="icons/heart-line 14.png" alt="">
                </button>
                <div class="product-image">
                  <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                </div>
              </div>
              <div class="product-card__info">
                <span class="product-brand"><?= htmlspecialchars($p['brand']) ?></span>
                <h3 class="product-name"><?= htmlspecialchars($p['name']) ?></h3>
              </div>
              <div class="product-card__footer-wrap">
                <div class="product-card__footer">
                  <div class="product-price"><?= number_format($p['price'], 0, '.', ' ') ?> ₽</div>
                  <button class="compare-btn" aria-label="Сравнить">
                    <img src="icons/bar-chart-line 2.png" alt="">
                  </button>
                </div>
                <a href="index.php?action=add_to_cart&id=<?= $p['id'] ?>" class="product-cart-btn">
                  <img src="icons/Vector3.png" alt="">В корзину
                </a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== ПРОМО-БАННЕР ==================== -->
  <section class="promo-banner-section">
    <div class="container">
      <div class="promo-banner">
        <div class="promo-banner__image-left">
          <img src="images/ups-power-station.png" alt="ИБП Гарант">
        </div>
        <div class="promo-banner__content">
          <h2 class="promo-banner__title">
            Стабилизаторы<br>
            и Источники бесперебойного<br>
            питания энергии
          </h2>
          <a href="index.php?category=accumulators#catalog" class="promo-banner__btn">Перейти в каталог</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== АКЦИИ НЕДЕЛИ ==================== -->
  <section class="products-section" id="slider-promo">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Акции недели</h2>
        <div class="slider-arrows">
          <button class="arrow-btn arrow-btn--prev promo-prev" aria-label="Назад"></button>
          <button class="arrow-btn arrow-btn--next promo-next" aria-label="Вперед"></button>
        </div>
      </div>
      <div class="slider-window">
        <div class="products-grid">
          <?php
          $saleProducts = array_filter($monthProducts, fn($p) => $p['is_promo']);
          if (empty($saleProducts)) $saleProducts = array_slice($monthProducts, 0, 5);
          foreach ($saleProducts as $p):
          ?>
            <article class="product-card">
              <div class="product-card__top">
                <div class="product-badge product-badge--sell">SALE</div>
                <button type="button" class="wishlist-btn" aria-label="В избранное">
                  <img src="icons/heart-line 14.png" alt="">
                </button>
                <div class="product-image">
                  <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                </div>
              </div>
              <div class="product-card__info">
                <span class="product-brand"><?= htmlspecialchars($p['brand']) ?></span>
                <h3 class="product-name"><?= htmlspecialchars($p['name']) ?></h3>
              </div>
              <div class="product-card__footer-wrap">
                <div class="product-card__footer">
                  <?php if ($p['old_price']): ?>
                    <div class="product-price-block">
                      <span class="product-price"><?= number_format($p['price'], 0, '.', ' ') ?> ₽</span>
                      <span class="product-price--old"><?= number_format($p['old_price'], 0, '.', ' ') ?> ₽</span>
                    </div>
                  <?php else: ?>
                    <div class="product-price"><?= number_format($p['price'], 0, '.', ' ') ?> ₽</div>
                  <?php endif; ?>
                  <button class="compare-btn" aria-label="Сравнить">
                    <img src="icons/bar-chart-line 2.png" alt="">
                  </button>
                </div>
                <a href="index.php?action=add_to_cart&id=<?= $p['id'] ?>" class="product-cart-btn">
                  <img src="icons/Vector3.png" alt="">В корзину
                </a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== ПРЕИМУЩЕСТВА ==================== -->
  <section class="advantages-section">
    <div class="container">
      <h2 class="advantages-title">Наши преимущества</h2>
      <div class="advantages-grid">
        <div class="advantage-card">
          <div class="advantage-card__icon-wrap">
            <img src="icons/luggage-cart-line 1.png" alt="Доставка" class="advantage-card__icon">
          </div>
          <h3 class="advantage-card__title">Удобная доставка 24/7</h3>
          <p class="advantage-card__desc">Мы работаем с проверенными транспортными компаниями</p>
        </div>
        <div class="advantage-card">
          <div class="advantage-card__icon-wrap">
            <img src="icons/hand-coin-line 1.png" alt="Оплата" class="advantage-card__icon">
          </div>
          <h3 class="advantage-card__title">Оплата любым способом</h3>
          <p class="advantage-card__desc">7 способов оплаты для вашего удобства</p>
        </div>
        <div class="advantage-card">
          <div class="advantage-card__icon-wrap">
            <img src="icons/shield-star-line 1.png" alt="Гарантия" class="advantage-card__icon">
          </div>
          <h3 class="advantage-card__title">Гарантия качества</h3>
          <p class="advantage-card__desc">Перед покупкой мы надежно проверяем товар</p>
        </div>
        <div class="advantage-card">
          <div class="advantage-card__icon-wrap">
            <img src="icons/user-2-line 1.png" alt="Поддержка" class="advantage-card__icon">
          </div>
          <h3 class="advantage-card__title">Онлайн поддержка</h3>
          <p class="advantage-card__desc">Менеджеры оперативно ответят на звонок или заявку</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== КАТАЛОГ С ФИЛЬТРОМ ============== -->
  <section id="catalog" style="padding: 40px 0; background: #f4f6f8;">
    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 15px;">

      <!-- Форма фильтра -->
      <form method="GET" action="index.php#catalog"
            style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;
                   background:#fff;border:1px solid #e0e0e0;border-radius:8px;
                   padding:16px 20px;margin-bottom:28px;box-shadow:0 2px 6px rgba(0,0,0,.05);">

        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
               placeholder="🔍 Поиск товаров..."
               style="flex:1;min-width:200px;padding:9px 12px;border:1px solid #ccc;border-radius:6px;font-family:inherit;font-size:14px;">

        <select name="category"
                style="padding:9px 12px;border:1px solid #ccc;border-radius:6px;font-family:inherit;font-size:14px;">
          <option value="">Все категории</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat['code']) ?>"
              <?= $category === $cat['code'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <select name="sort"
                style="padding:9px 12px;border:1px solid #ccc;border-radius:6px;font-family:inherit;font-size:14px;">
          <option value="">По умолчанию</option>
          <option value="price_asc"  <?= $sort==='price_asc'  ? 'selected':'' ?>>Цена: сначала дешевле</option>
          <option value="price_desc" <?= $sort==='price_desc' ? 'selected':'' ?>>Цена: сначала дороже</option>
          <option value="name_asc"   <?= $sort==='name_asc'   ? 'selected':'' ?>>По названию А→Я</option>
        </select>

        <button type="submit"
                style="padding:9px 22px;background:#ff9900;color:#fff;border:none;border-radius:6px;font-weight:700;cursor:pointer;font-size:14px;">
          Применить
        </button>
        <a href="index.php#catalog" style="color:#666;text-decoration:none;font-size:13px;">Сбросить</a>
      </form>

      <!-- Заголовок -->
      <div style="margin-bottom:16px;">
        <h2 style="font-size:22px;font-weight:700;margin:0;">
          <?= $search ? 'Результаты поиска: «'.htmlspecialchars($search).'»' : 'Каталог товаров' ?>
        </h2>
        <p style="color:#888;font-size:13px;margin:4px 0 0;">
          Найдено товаров: <?= $totalCount ?>
        </p>
      </div>

      <!-- Сетка товаров -->
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:20px;">
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $p): ?>
            <article style="background:#fff;border:1px solid #e8e8e8;border-radius:10px;
                            overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.06);
                            display:flex;flex-direction:column;">
              <div style="position:relative;padding:16px;text-align:center;background:#fafafa;">
                <?php if ($p['is_new']): ?>
                  <span style="position:absolute;top:10px;left:10px;background:#28a745;color:#fff;
                               font-size:11px;font-weight:700;padding:3px 8px;border-radius:4px;">NEW</span>
                <?php elseif ($p['is_promo']): ?>
                  <span style="position:absolute;top:10px;left:10px;background:#dc3545;color:#fff;
                               font-size:11px;font-weight:700;padding:3px 8px;border-radius:4px;">SALE</span>
                <?php endif; ?>
                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>"
                     style="max-height:140px;max-width:100%;object-fit:contain;">
              </div>
              <div style="padding:12px 14px;flex:1;display:flex;flex-direction:column;gap:4px;">
                <span style="font-size:11px;color:#999;"><?= htmlspecialchars($p['brand']) ?></span>
                <h3 style="font-size:14px;font-weight:600;margin:0;line-height:1.4;">
                  <?= htmlspecialchars($p['name']) ?>
                </h3>
                <span style="font-size:11px;color:#bbb;"><?= htmlspecialchars($p['category_name']) ?></span>
                <div style="margin-top:auto;padding-top:10px;">
                  <span style="font-size:18px;font-weight:700;color:#1a1a1a;">
                    <?= number_format($p['price'], 0, '.', ' ') ?> ₽
                  </span>
                  <?php if ($p['old_price']): ?>
                    <span style="font-size:13px;color:#aaa;text-decoration:line-through;margin-left:6px;">
                      <?= number_format($p['old_price'], 0, '.', ' ') ?> ₽
                    </span>
                  <?php endif; ?>
                </div>
              </div>
              <div style="padding:0 14px 14px;">
                <a href="index.php?action=add_to_cart&id=<?= $p['id'] ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&sort=<?= urlencode($sort) ?>&page=<?= $page ?>"
                   style="display:block;width:100%;box-sizing:border-box;padding:10px;
                          background:#ff9900;color:#fff;text-align:center;border-radius:6px;
                          text-decoration:none;font-weight:700;font-size:14px;">
                  🛒 В корзину
                </a>
              </div>
            </article>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="grid-column:1/-1;text-align:center;color:#888;padding:40px 0;font-size:16px;">
            Товары не найдены. Попробуйте изменить запрос или сбросить фильтры.
          </p>
        <?php endif; ?>
      </div>

      <!-- Пагинация -->
      <?php if ($totalPages > 1): ?>
        <nav style="margin-top:36px;display:flex;gap:8px;justify-content:center;flex-wrap:wrap;">
          <?php
          $baseParams = array_filter([
              'search'   => $search,
              'category' => $category,
              'sort'     => $sort,
          ]);
          ?>
          <?php if ($page > 1): ?>
            <a href="index.php?<?= http_build_query($baseParams + ['page' => $page - 1]) ?>#catalog"
               style="padding:9px 15px;border:1px solid #ddd;border-radius:6px;text-decoration:none;color:#333;">
              ‹ Пред.
            </a>
          <?php endif; ?>
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="index.php?<?= http_build_query($baseParams + ['page' => $i]) ?>#catalog"
               style="padding:9px 14px;border:1px solid <?= $i===$page?'#ff9900':'#ddd' ?>;
                      border-radius:6px;text-decoration:none;font-weight:<?= $i===$page?'700':'400' ?>;
                      color:<?= $i===$page?'#fff':'#333' ?>;background:<?= $i===$page?'#ff9900':'#fff' ?>;">
              <?= $i ?>
            </a>
          <?php endfor; ?>
          <?php if ($page < $totalPages): ?>
            <a href="index.php?<?= http_build_query($baseParams + ['page' => $page + 1]) ?>#catalog"
               style="padding:9px 15px;border:1px solid #ddd;border-radius:6px;text-decoration:none;color:#333;">
              След. ›
            </a>
          <?php endif; ?>
        </nav>
      <?php endif; ?>

    </div>
  </section>

  <!-- ===================== ФУТЕР =========================== -->
  <footer class="main-footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col footer-col--contacts">
          <a href="/" class="footer-logo">
            <img src="images/5kvt-brand-logo.png" alt="5 KVT">
          </a>
          <a href="tel:+74997199994" class="footer-phone">+7 (499) 719-99-94</a>
          <a href="mailto:info@5kvt.ru" class="footer-email">info@5kvt.ru</a>
          <p class="footer-text">Ежедневно 9:30 - 20:00 (МСК)</p>
          <p class="footer-text footer-text--address">
            117218, г. Москва,<br>
            пр-кт Нахимовский .,дом 30/43,<br>
            kв. 81
          </p>
        </div>

        <div class="footer-col">
          <h4 class="footer-col__title">Информация</h4>
          <ul class="footer-menu">
            <li><a href="#">Доставка</a></li>
            <li><a href="#">Оплата</a></li>
            <li><a href="#">Производители</a></li>
            <li><a href="#">Подарочные сертификаты</a></li>
            <li><a href="#">Партнерская программа</a></li>
            <li><a href="#">Акции</a></li>
            <li><a href="index.php#catalog">Все товары</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4 class="footer-col__title">Служба поддержки</h4>
          <ul class="footer-menu footer-menu--margin">
            <li><a href="#">Возврат товара</a></li>
          </ul>
          <h4 class="footer-col__title">Личный кабинет</h4>
          <ul class="footer-menu">
            <li><a href="<?= !empty($_SESSION['user_id']) ? 'profile.php' : 'auth.php' ?>">Личный кабинет</a></li>
            <li><a href="#">История заказов</a></li>
            <li><a href="#">Избранное</a></li>
            <li><a href="#">Рассылка</a></li>
          </ul>
        </div>

        <div class="footer-col footer-col--actions">
          <div class="footer-socials">
            <a href="#" aria-label="WhatsApp"><img src="icons/iconfinder-social-media-applications-23whatsapp-4102606_113811 1.png" alt=""></a>
            <a href="#" aria-label="Telegram"><img src="icons/viber-svgrepo-com 1.png" alt=""></a>
            <span class="footer-socials__text">Напишите нам</span>
          </div>
          <a href="#" class="btn-footer-support">
            <img src="icons/futer.png" alt="">
            Служба поддержки
          </a>
          <div class="footer-payments">
            <h5 class="footer-payments__title">Принимаем к оплате</h5>
            <div class="footer-payments__logos">
              <img src="icons/Group 42.png" alt="Mastercard">
              <img src="icons/Group 39.png" alt="Maestro">
              <img src="icons/Group 40.png" alt="Visa">
              <img src="icons/Group 41.png" alt="Мир">
            </div>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p class="footer-copyright">Все права защищены. Указанная стоимость товаров и условия их приобретения действительны на текущую дату.</p>
      </div>
    </div>
  </footer>

  <!-- МОБИЛЬНЫЙ ОВЕРЛЕЙ И ДРОВЕР -->
  <div class="mobile-nav-overlay" id="mobileNavOverlay"></div>
  <div class="mobile-nav-drawer" id="mobileNavDrawer">
    <div class="mobile-nav-drawer__header">
      <span class="mobile-nav-drawer__logo"><span>&#x21AF;</span>5КВТ</span>
      <button class="mobile-nav-drawer__close" id="mobileNavClose" aria-label="Закрыть">&#x00D7;</button>
    </div>
    <div class="mobile-nav-drawer__list" id="mobileNavList">
      <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $cat): ?>
          <a class="mobile-nav-item" href="index.php?category=<?= urlencode($cat['code']) ?>#catalog">
            <?= htmlspecialchars($cat['name']) ?>
          </a>
        <?php endforeach; ?>
      <?php else: ?>
        <a class="mobile-nav-item" data-sub="accumulators">Аккумуляторы <span class="arrow-right"></span></a>
        <a class="mobile-nav-item" href="#">Генераторы</a>
        <a class="mobile-nav-item" href="#">Инструменты</a>
      <?php endif; ?>
    </div>
    <div class="mobile-nav-subpanel" id="mobileSubpanel">
      <button class="mobile-nav-subpanel__back" id="mobileSubBack">Назад</button>
      <div class="mobile-nav-subpanel__items" id="mobileSubItems"></div>
    </div>
  </div>

  <script src="script(1).js"></script>
</body>
</html>
