<?php
/**
 * ЗАДАНИЕ 3: Форма обратной связи с валидацией
 *
 * Ваша задача: обработать форму и проверить введённые данные
 *
 * Что нужно сделать:
 * 1. При отправке формы (method="POST") получить из $_POST поля: name, email, message
 * 2. Валидация: имя — не пустое, не короче 2 символов; email — корректный формат; сообщение — не пустое
 * 3. Вывести ошибки под формой, если есть; иначе вывести сообщение «Данные приняты»
 * 4. Сохранять в полях формы введённые значения (чтобы при ошибке пользователь не терял ввод)
 * 5. Использовать htmlspecialchars() при выводе любых данных от пользователя
 */

$ошибки = [];
$успех = false;
$сохранённые = ['name' => '', 'email' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $сохранённые['name'] = trim($_POST['name'] ?? '');
    $сохранённые['email'] = trim($_POST['email'] ?? '');
    $сохранённые['message'] = trim($_POST['message'] ?? '');

    // Валидация имени
    if (empty($сохранённые['name'])) {
        $ошибки[] = 'Имя обязательно для заполнения';
    } elseif (mb_strlen($сохранённые['name']) < 2) {
        $ошибки[] = 'Имя должно содержать не менее 2 символов';
    } elseif (mb_strlen($сохранённые['name']) > 50) {
        $ошибки[] = 'Имя не должно превышать 50 символов';
    }

    // Валидация email
    if (empty($сохранённые['email'])) {
        $ошибки[] = 'Email обязателен для заполнения';
    } elseif (!filter_var($сохранённые['email'], FILTER_VALIDATE_EMAIL)) {
        $ошибки[] = 'Введите корректный email адрес (например: name@example.com)';
    }

    // Валидация сообщения
    if (empty($сохранённые['message'])) {
        $ошибки[] = 'Сообщение обязательно для заполнения';
    } elseif (mb_strlen($сохранённые['message']) < 10) {
        $ошибки[] = 'Сообщение должно содержать не менее 10 символов';
    } elseif (mb_strlen($сохранённые['message']) > 1000) {
        $ошибки[] = 'Сообщение не должно превышать 1000 символов';
    }

    if (empty($ошибки)) {
        $успех = true;
        // При успехе можно очистить форму или оставить данные
        // $сохранённые = ['name' => '', 'email' => '', 'message' => '']; // раскомментировать, если нужно очистить
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 3: Форма обратной связи</title>
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
            max-width: 700px;
            margin: 0 auto;
        }

        /* Карточка формы */
        .form-card {
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

        /* Сообщения об ошибках и успехе */
        .message-container {
            margin-bottom: 25px;
        }

        .error-list {
            background: #fee;
            border-left: 4px solid #e74c3c;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 15px;
        }

        .error-list li {
            color: #c0392b;
            margin-left: 20px;
            padding: 5px 0;
        }

        .success-message {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border-left: 4px solid #28a745;
            padding: 15px 20px;
            border-radius: 12px;
            color: #155724;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 12px;
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

        /* Форма */
        .feedback-form {
            background: white;
            border-radius: 20px;
            padding: 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 0.95em;
        }

        .form-group label .required {
            color: #e74c3c;
            font-size: 1.2em;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            font-size: 1em;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52,152,219,0.2);
        }

        .form-group input.error-input,
        .form-group textarea.error-input {
            border-color: #e74c3c;
            background: #fff5f5;
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .field-hint {
            font-size: 0.8em;
            color: #7f8c8d;
            margin-top: 5px;
            display: block;
        }

        /* Кнопка */
        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #2c3e50, #3498db);
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

        .submit-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(52,152,219,0.4);
        }

        /* Правила валидации */
        .validation-rules {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .validation-rules h4 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 0.9em;
        }

        .validation-rules ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .validation-rules li {
            font-size: 0.8em;
            color: #7f8c8d;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .validation-rules li::before {
            content: "✓";
            color: #27ae60;
            font-weight: bold;
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

        /* Индикатор отправки */
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
            animation: pulse 1.5s ease;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @media (max-width: 550px) {
            .card-body {
                padding: 20px;
            }
            
            .feedback-form {
                padding: 15px;
            }
            
            .card-header h1 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <div class="card-header">
                <h1>
                    <span>📝</span>
                    Форма обратной связи
                    <span>💬</span>
                </h1>
                <p>Заполните форму — мы обязательно ответим вам</p>
            </div>
            <div class="card-body">
                <!-- Сообщения -->
                <div class="message-container">
                    <?php if (!empty($ошибки)): ?>
                        <div class="error-list">
                            <strong style="display: block; margin-bottom: 8px; color: #c0392b;">❌ Пожалуйста, исправьте следующие ошибки:</strong>
                            <ul style="list-style: none;">
                                <?php foreach ($ошибки as $err): ?>
                                    <li>• <?= htmlspecialchars($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ($успех): ?>
                        <div class="success-message">
                            <span style="font-size: 1.5em;">✅</span>
                            <div>
                                <strong>Данные приняты!</strong><br>
                                Спасибо за обращение. Мы свяжемся с вами в ближайшее время.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Форма -->
                <form method="POST" class="feedback-form">
                    <div class="form-group">
                        <label>
                            <span>👤</span> Имя
                            <span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               value="<?= htmlspecialchars($сохранённые['name']) ?>"
                               placeholder="Введите ваше имя"
                               class="<?= in_array('Имя обязательно для заполнения', $ошибки) || in_array('Имя должно содержать не менее 2 символов', $ошибки) ? 'error-input' : '' ?>">
                        <small class="field-hint">От 2 до 50 символов</small>
                    </div>

                    <div class="form-group">
                        <label>
                            <span>📧</span> Email
                            <span class="required">*</span>
                        </label>
                        <input type="email" 
                               name="email" 
                               value="<?= htmlspecialchars($сохранённые['email']) ?>"
                               placeholder="example@mail.com"
                               class="<?= in_array('Email обязателен для заполнения', $ошибки) || in_array('Введите корректный email адрес (например: name@example.com)', $ошибки) ? 'error-input' : '' ?>">
                        <small class="field-hint">Введите корректный email адрес</small>
                    </div>

                    <div class="form-group">
                        <label>
                            <span>💬</span> Сообщение
                            <span class="required">*</span>
                        </label>
                        <textarea name="message" 
                                  placeholder="Опишите ваш вопрос или предложение..."
                                  class="<?= in_array('Сообщение обязательно для заполнения', $ошибки) || in_array('Сообщение должно содержать не менее 10 символов', $ошибки) ? 'error-input' : '' ?>"><?= htmlspecialchars($сохранённые['message']) ?></textarea>
                        <small class="field-hint">От 10 до 1000 символов</small>
                    </div>

                    <button type="submit" class="submit-btn">
                        <span>✉️</span>
                        Отправить сообщение
                    </button>
                </form>

                <!-- Правила валидации -->
                <div class="validation-rules">
                    <h4>📋 Правила заполнения:</h4>
                    <ul>
                        <li>Имя: от 2 до 50 символов</li>
                        <li>Email: корректный формат</li>
                        <li>Сообщение: от 10 до 1000 символов</li>
                        <li>Все поля обязательны для заполнения</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="nav-links">
            <a href="task_02.php">← Предыдущее задание</a>
            <a href="task_04.php">Следующее задание →</a>
        </div>
    </div>

    <script>
        // Автоматическая подсветка полей с ошибками при повторной отправке
        document.addEventListener('DOMContentLoaded', function() {
            const errorInputs = document.querySelectorAll('.error-input');
            if (errorInputs.length > 0) {
                errorInputs[0].focus();
            }
        });
    </script>
</body>
</html>
