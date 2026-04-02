<?php
/**
 * ЗАДАНИЕ 4: Счётчик посещений и «корзина» в сессии
 *
 * Ваша задача: использовать сессии для хранения данных между запросами
 *
 * Что нужно сделать:
 * 1. В начале скрипта вызвать session_start() (до любого вывода)
 * 2. Реализовать счётчик посещений: при каждом заходе на страницу увеличивать значение в $_SESSION['visits']
 * 3. Реализовать простую «корзину»: массив $_SESSION['cart'] — список товаров (названия строкой).
 *    Форма добавляет товар в корзину (поле product_name), корзина выводится списком ниже.
 * 4. Добавить кнопку «Очистить корзину», которая очищает $_SESSION['cart'] и перенаправляет на эту же страницу
 * 5. Добавить кнопку «Сбросить счётчик», которая сбрасывает $_SESSION['visits'] в 0
 */

// Запуск сессии (должен быть до любого вывода)
session_start();

$сообщение = '';

// Инициализация переменных сессии, если они не существуют
if (!isset($_SESSION['visits'])) {
    $_SESSION['visits'] = 0;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Обработка действий через GET-параметры
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'clear_cart') {
        $_SESSION['cart'] = [];
        $сообщение = 'Корзина очищена.';
        // Перенаправление для предотвращения повторного выполнения
        header('Location: task_04.php');
        exit;
    }
    
    if ($_GET['action'] === 'reset_visits') {
        $_SESSION['visits'] = 0;
        $сообщение = 'Счётчик посещений сброшен.';
        header('Location: task_04.php');
        exit;
    }
}

// Увеличение счётчика посещений
$_SESSION['visits']++;

// Добавление товара в корзину из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['product_name'] ?? ''))) {
    $товар = trim($_POST['product_name']);
    // Ограничение длины названия товара
    if (strlen($товар) > 100) {
        $сообщение = 'Название товара не должно превышать 100 символов.';
    } else {
        $_SESSION['cart'][] = $товар;
        $сообщение = 'Товар "' . htmlspecialchars($товар) . '" добавлен в корзину.';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 4: Сессии | Корзина и счётчик</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Карточка */
        .card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            margin-bottom: 30px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .card-header h1 {
            font-size: 2.2em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 0.95em;
        }

        .card-body {
            padding: 35px;
            background: #f8f9fa;
        }

        /* Сообщение */
        .message {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            color: #155724;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Блоки */
        .section {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .section:hover {
            transform: translateY(-3px);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-header h2 {
            color: #2c3e50;
            font-size: 1.5em;
        }

        /* Счётчик */
        .counter-display {
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 20px;
            color: white;
            margin-bottom: 20px;
        }

        .counter-label {
            font-size: 0.9em;
            opacity: 0.9;
            letter-spacing: 2px;
        }

        .counter-value {
            font-size: 4em;
            font-weight: bold;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }

        .counter-unit {
            font-size: 0.9em;
            opacity: 0.8;
        }

        /* Корзина */
        .cart-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f0f0f0;
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .cart-count {
            background: #3498db;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .cart-items {
            list-style: none;
            margin: 15px 0;
        }

        .cart-items li {
            padding: 12px 15px;
            background: #f8f9fa;
            margin-bottom: 8px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .cart-items li:hover {
            background: #e8f4f8;
            transform: translateX(5px);
        }

        .cart-items li::before {
            content: "🛒";
            font-size: 1.2em;
        }

        .empty-cart {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            background: #f8f9fa;
            border-radius: 15px;
        }

        .empty-cart span {
            font-size: 3em;
            display: block;
            margin-bottom: 10px;
        }

        /* Форма добавления */
        .add-form {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .add-form input {
            flex: 1;
            padding: 14px 18px;
            font-size: 1em;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            outline: none;
            transition: all 0.3s ease;
        }

        .add-form input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52,152,219,0.2);
        }

        /* Кнопки */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: none;
            border-radius: 50px;
            font-size: 0.95em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
        }

        .btn-primary:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(46,204,113,0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: scale(1.02);
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
            transform: scale(1.02);
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #e67e22;
            transform: scale(1.02);
        }

        .button-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        /* Навигация */
        .nav-links {
            text-align: center;
            margin-top: 30px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 25px;
            margin: 0 10px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.4);
            transform: translateY(-2px);
        }

        @media (max-width: 550px) {
            .card-body {
                padding: 20px;
            }
            
            .counter-value {
                font-size: 2.5em;
            }
            
            .add-form {
                flex-direction: column;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .btn {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>
                    <span>🛍️</span>
                    Магазин с сессиями
                    <span>📊</span>
                </h1>
                <p>Счётчик посещений и корзина товаров</p>
            </div>
            <div class="card-body">
                <!-- Сообщение -->
                <?php if ($сообщение): ?>
                    <div class="message">
                        <span>✅</span>
                        <span><?= htmlspecialchars($сообщение) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Блок счётчика -->
                <div class="section">
                    <div class="section-header">
                        <span style="font-size: 1.8em;">👁️</span>
                        <h2>Счётчик посещений</h2>
                    </div>
                    <div class="counter-display">
                        <div class="counter-label">ВЫ ОТКРЫЛИ ЭТУ СТРАНИЦУ</div>
                        <div class="counter-value"><?= (int)$_SESSION['visits'] ?></div>
                        <div class="counter-unit">раз(а) в текущей сессии</div>
                    </div>
                    <div class="button-group">
                        <a href="task_04.php?action=reset_visits" class="btn btn-warning">
                            <span>🔄</span> Сбросить счётчик
                        </a>
                    </div>
                </div>

                <!-- Блок корзины -->
                <div class="section">
                    <div class="section-header">
                        <span style="font-size: 1.8em;">🛒</span>
                        <h2>Корзина товаров</h2>
                    </div>
                    
                    <!-- Форма добавления -->
                    <form method="POST" class="add-form">
                        <input type="text" 
                               name="product_name" 
                               placeholder="Введите название товара..."
                               required
                               autocomplete="off">
                        <button type="submit" class="btn btn-primary">
                            <span>➕</span> Добавить в корзину
                        </button>
                    </form>

                    <!-- Статистика корзины -->
                    <div class="cart-stats">
                        <span>📦 Всего товаров:</span>
                        <span class="cart-count"><?= count($_SESSION['cart']) ?> шт.</span>
                    </div>

                    <!-- Список товаров -->
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <ul class="cart-items">
                            <?php foreach ($_SESSION['cart'] as $index => $товар): ?>
                                <li>
                                    <span style="font-weight: bold; color: #3498db;"><?= $index + 1 ?>.</span>
                                    <?= htmlspecialchars($товар) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="button-group">
                            <a href="task_04.php?action=clear_cart" class="btn btn-danger">
                                <span>🗑️</span> Очистить корзину
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="empty-cart">
                            <span>🛍️</span>
                            <p>Корзина пуста</p>
                            <small>Добавьте первый товар!</small>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Информация о сессии -->
                <div class="section" style="background: #f0f0f0;">
                    <div class="section-header">
                        <span style="font-size: 1.5em;">ℹ️</span>
                        <h2 style="font-size: 1.2em;">Информация о сессии</h2>
                    </div>
                    <div style="font-size: 0.85em; color: #6c757d;">
                        <p><strong>ID сессии:</strong> <?= session_id() ?></p>
                        <p><strong>Корзина содержит:</strong> <?= count($_SESSION['cart']) ?> товар(ов)</p>
                        <p><strong>Всего посещений:</strong> <?= $_SESSION['visits'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="nav-links">
            <a href="task_03.php">← Предыдущее задание</a>
            <a href="task_05.php">Следующее задание →</a>
        </div>
    </div>
</body>
</html>
