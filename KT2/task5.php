<?php
/**
 * ЗАДАНИЕ 5: Форма авторизации с капчей
 *
 * Ваша задача: реализовать вход по логину и паролю с проверкой капчи
 *
 * Что нужно сделать:
 * 1. В начале скрипта вызвать session_start()
 * 2. Реализовать генерацию капчи: при загрузке страницы (или по параметру ?new_captcha=1) генерировать
 *    случайный код (например, 5 цифр), сохранять в $_SESSION['captcha_code'] и выводить на странице
 * 3. Форма: поля login, password, captcha_input и кнопка «Войти»
 * 4. Проверка при POST:
 *    — капча совпадает с $_SESSION['captcha_code'] (после проверки капчу удалить из сессии);
 *    — логин = "marik", пароль = "Marik.007"
 * 5. При успешном входе сохранить в сессию факт авторизации (например $_SESSION['user'] = 'marik') и
 *    перенаправить на страницу «Личный кабинет» (ниже — простой вывод «Вы вошли как marik»).
 * 6. На странице «Личный кабинет» проверять сессию; если пользователь не авторизован — перенаправить на форму входа
 * 7. Кнопка «Выйти» — очистить сессию и перенаправить на форму входа
 */

// Запуск сессии (должен быть до любого вывода)
session_start();

$ошибка = '';
$показать_форму = true;

// Выход из системы
if (isset($_GET['logout'])) {
    // Очищаем сессию
    $_SESSION = [];
    session_destroy();
    // Перенаправляем на страницу входа
    header('Location: task_05.php');
    exit;
}

// Если уже авторизован и не запрошен выход — показать «кабинет»
if (!empty($_SESSION['user'])) {
    $показать_форму = false;
}

// Генерация капчи (при первой загрузке или по ?new_captcha=1)
if (!isset($_SESSION['captcha_code']) || isset($_GET['new_captcha'])) {
    $код = '';
    for ($i = 0; $i < 5; $i++) {
        $код .= (string)random_int(0, 9);
    }
    $_SESSION['captcha_code'] = $код;
}

// Обработка отправки формы входа
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $показать_форму) {
    $логин = trim($_POST['login'] ?? '');
    $пароль = $_POST['password'] ?? '';
    $ввод_капчи = trim($_POST['captcha_input'] ?? '');
    $ожидаемая_капча = $_SESSION['captcha_code'] ?? '';

    // Проверка капчи
    if (empty($ввод_капчи)) {
        $ошибка = 'Пожалуйста, введите код капчи';
    } elseif ($ввод_капчи !== $ожидаемая_капча) {
        $ошибка = 'Неверный код капчи. Попробуйте ещё раз.';
        // Генерируем новую капчу при ошибке
        $новый_код = '';
        for ($i = 0; $i < 5; $i++) {
            $новый_код .= (string)random_int(0, 9);
        }
        $_SESSION['captcha_code'] = $новый_код;
    } else {
        // Капча верна, теперь проверяем логин и пароль
        if ($логин === 'marik' && $пароль === 'Marik.007') {
            // Вход успешен
            $_SESSION['user'] = $логин;
            // Генерируем новую капчу для следующего входа
            $новый_код = '';
            for ($i = 0; $i < 5; $i++) {
                $новый_код .= (string)random_int(0, 9);
            }
            $_SESSION['captcha_code'] = $новый_код;
            // Перенаправляем на эту же страницу (обновляем)
            header('Location: task_05.php');
            exit;
        } else {
            $ошибка = 'Неверный логин или пароль';
            // Генерируем новую капчу при ошибке
            $новый_код = '';
            for ($i = 0; $i < 5; $i++) {
                $новый_код .= (string)random_int(0, 9);
            }
            $_SESSION['captcha_code'] = $новый_код;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 5: Авторизация с капчей</title>
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
            max-width: 500px;
            margin: 0 auto;
        }

        /* Карточка */
        .card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
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
            font-size: 2em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 0.9em;
        }

        .card-body {
            padding: 35px;
            background: #f8f9fa;
        }

        /* Сообщение об ошибке */
        .error-message {
            background: #fee;
            border-left: 4px solid #e74c3c;
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            color: #c0392b;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.3s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Информация о входе */
        .info-box {
            background: #e8f4f8;
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            color: #2c3e50;
            font-size: 0.9em;
            border-left: 4px solid #3498db;
        }

        .info-box strong {
            color: #e74c3c;
        }

        /* Форма */
        .auth-form {
            background: white;
            border-radius: 20px;
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 0.9em;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            font-size: 1em;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52,152,219,0.2);
        }

        /* Капча */
        .captcha-block {
            background: #f0f0f0;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        .captcha-code {
            font-size: 2.5em;
            font-weight: bold;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            background: white;
            padding: 15px;
            border-radius: 12px;
            display: inline-block;
            margin: 10px 0;
            border: 2px dashed #3498db;
            color: #2c3e50;
        }

        .captcha-refresh {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #3498db;
            text-decoration: none;
            font-size: 0.85em;
            margin-top: 8px;
            transition: all 0.3s ease;
        }

        .captcha-refresh:hover {
            color: #2c3e50;
        }

        .captcha-refresh:hover span:first-child {
            display: inline-block;
            transform: rotate(180deg);
        }

        /* Кнопка входа */
        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .login-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(46,204,113,0.4);
        }

        /* Личный кабинет */
        .profile-card {
            text-align: center;
        }

        .avatar {
            font-size: 5em;
            margin-bottom: 20px;
        }

        .welcome-text {
            font-size: 1.3em;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .username {
            background: #3498db;
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            display: inline-block;
            margin: 15px 0;
            font-weight: bold;
        }

        .info-grid {
            background: #f0f0f0;
            border-radius: 15px;
            padding: 20px;
            text-align: left;
            margin: 20px 0;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .info-value {
            color: #7f8c8d;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 50px;
            margin-top: 20px;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .logout-btn:hover {
            background: #c0392b;
            transform: scale(1.02);
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
            
            .captcha-code {
                font-size: 1.5em;
                letter-spacing: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>
                    <span>🔐</span>
                    Авторизация
                    <span>🛡️</span>
                </h1>
                <p>Введите логин и пароль для входа в систему</p>
            </div>
            <div class="card-body">
                <?php if ($показать_форму): ?>
                    <!-- Форма входа -->
                    <div class="info-box">
                        📋 <strong>Тестовые данные:</strong> логин = <strong>marik</strong> | пароль = <strong>Marik.007</strong>
                    </div>

                    <?php if ($ошибка): ?>
                        <div class="error-message">
                            <span>❌</span>
                            <span><?= htmlspecialchars($ошибка) ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="auth-form">
                        <div class="captcha-block">
                            <div style="font-size: 0.85em; color: #7f8c8d;">Введите код с картинки</div>
                            <div class="captcha-code"><?= htmlspecialchars($_SESSION['captcha_code'] ?? '') ?></div>
                            <a href="task_05.php?new_captcha=1" class="captcha-refresh">
                                <span>🔄</span> Обновить капчу
                            </a>
                        </div>

                        <form method="POST">
                            <div class="form-group">
                                <label>
                                    <span>👤</span> Логин
                                </label>
                                <input type="text" 
                                       name="login" 
                                       value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" 
                                       placeholder="Введите ваш логин"
                                       autocomplete="username"
                                       required>
                            </div>

                            <div class="form-group">
                                <label>
                                    <span>🔒</span> Пароль
                                </label>
                                <input type="password" 
                                       name="password" 
                                       placeholder="Введите пароль"
                                       autocomplete="current-password"
                                       required>
                            </div>

                            <div class="form-group">
                                <label>
                                    <span>📷</span> Код капчи
                                </label>
                                <input type="text" 
                                       name="captcha_input" 
                                       placeholder="Введите 5 цифр"
                                       autocomplete="off"
                                       maxlength="10"
                                       required>
                            </div>

                            <button type="submit" class="login-btn">
                                <span>🚪</span> Войти в систему
                            </button>
                        </form>
                    </div>

                <?php else: ?>
                    <!-- Личный кабинет -->
                    <div class="profile-card">
                        <div class="avatar">
                            👨‍💻
                        </div>
                        <div class="welcome-text">
                            Добро пожаловать!
                        </div>
                        <div class="username">
                            <?= htmlspecialchars($_SESSION['user']) ?>
                        </div>
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">📅 Дата входа:</span>
                                <span class="info-value"><?= date('d.m.Y H:i:s') ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">🌐 IP адрес:</span>
                                <span class="info-value"><?= $_SERVER['REMOTE_ADDR'] ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">🖥️ Браузер:</span>
                                <span class="info-value"><?= htmlspecialchars(substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 50)) ?>...</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">🔐 Статус:</span>
                                <span class="info-value" style="color: #27ae60;">Активен</span>
                            </div>
                        </div>

                        <a href="task_05.php?logout=1" class="logout-btn">
                            <span>🚪</span> Выйти из системы
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="nav-links">
            <a href="task_04.php">← Предыдущее задание</a>
            <a href="task_06.php">Следующее задание →</a>
        </div>
    </div>
</body>
</html>
