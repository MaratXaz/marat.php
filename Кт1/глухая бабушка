<?php
session_start();

// Инициализация счётчика
if (!isset($_SESSION['poka_count'])) {
    $_SESSION['poka_count'] = 0;
}

$response = "";
$input = "";
$showInput = true; // Показывать поле ввода, пока не попрощались

// Обработка отправленной формы
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phrase'])) {
    $input = trim($_POST['phrase']);
    
    // Проверка на одиночное "ПОКА!"
    if ($input === "ПОКА!") {
        $_SESSION['poka_count']++;
        
        if ($_SESSION['poka_count'] === 3) {
            $response = "ДО СВИДАНИЯ, МИЛЫЙ!";
            $showInput = false;
            session_destroy();
        } else {
            $year = rand(1930, 1950);
            $response = "НЕТ, НИ РАЗУ С $year ГОДА!";
        }
    } else {
        // Сбрасываем счётчик, если введено не "ПОКА!"
        $_SESSION['poka_count'] = 0;
        
        // Проверяем, кричит ли пользователь
        if (substr($input, -1) === "!") {
            $year = rand(1930, 1950);
            $response = "НЕТ, НИ РАЗУ С $year ГОДА!";
        } else {
            $response = "АСЬ?! ГОВОРИ ГРОМЧЕ, ВНУЧЕК!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Глухая бабушка 👵</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            width: 100%;
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

        .header {
            background: linear-gradient(135deg, #8B4513, #A0522D);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.2em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .header h1 span {
            font-size: 1.5em;
        }

        .header p {
            opacity: 0.9;
            font-size: 0.95em;
        }

        .babushka-section {
            background: #f5f0e8;
            padding: 30px;
            text-align: center;
            border-bottom: 3px solid #deb887;
        }

        .babushka-avatar {
            font-size: 80px;
            margin-bottom: 15px;
            display: inline-block;
            animation: wobble 3s ease infinite;
        }

        @keyframes wobble {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
        }

        .babushka-response {
            background: #fff9ef;
            border-left: 8px solid #8B4513;
            padding: 20px;
            border-radius: 15px;
            font-size: 1.4em;
            font-weight: bold;
            color: #4a2a0e;
            word-wrap: break-word;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .babushka-response::before {
            content: "👵 ";
            font-size: 1.2em;
        }

        .chat-area {
            padding: 30px;
            background: #fff;
        }

        .last-phrase {
            background: #e8f4f8;
            padding: 12px 18px;
            border-radius: 20px;
            margin-bottom: 25px;
            color: #2c5a6e;
            font-style: italic;
            border-right: 4px solid #4a90e2;
        }

        .last-phrase::before {
            content: "🗣️ Вы сказали: ";
            font-weight: bold;
            font-style: normal;
            color: #1a3a48;
        }

        .input-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .input-field {
            flex: 1;
            padding: 15px 20px;
            font-size: 1.1em;
            border: 2px solid #deb887;
            border-radius: 50px;
            outline: none;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .input-field:focus {
            border-color: #8B4513;
            box-shadow: 0 0 0 3px rgba(139,69,19,0.2);
        }

        .btn {
            padding: 15px 30px;
            font-size: 1.1em;
            font-weight: bold;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #8B4513;
            color: white;
        }

        .btn:hover {
            background: #A0522D;
            transform: scale(1.02);
        }

        .btn-reset {
            background: #6c757d;
        }

        .btn-reset:hover {
            background: #5a6268;
        }

        .counter-info {
            margin-top: 20px;
            padding: 10px;
            background: #f0e6d2;
            border-radius: 15px;
            text-align: center;
            font-size: 0.9em;
            color: #6b4c2c;
        }

        .counter-info span {
            font-weight: bold;
            font-size: 1.2em;
            color: #8B4513;
        }

        .tips {
            background: #fff9ef;
            padding: 15px 25px;
            border-top: 1px solid #deb887;
            font-size: 0.85em;
            color: #6b4c2c;
            text-align: center;
        }

        .tips ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 8px;
        }

        .tips li {
            display: inline-block;
        }

        .goodbye {
            text-align: center;
            padding: 20px;
            background: #d4edda;
            border-radius: 15px;
            color: #155724;
            font-weight: bold;
            font-size: 1.2em;
        }

        @media (max-width: 550px) {
            .header h1 { font-size: 1.5em; }
            .babushka-response { font-size: 1.1em; }
            .input-group { flex-direction: column; }
            .btn { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <span>👵</span>
                Глухая бабушка
                <span>🔊</span>
            </h1>
            <p>«ЧЕГО СКАЗАТЬ-ТО ХОТЕЛ, МИЛОК?!»</p>
        </div>

        <div class="babushka-section">
            <div class="babushka-avatar">
                🧣👵📢
            </div>
            <div class="babushka-response">
                <?php 
                if ($response) {
                    echo htmlspecialchars($response);
                } else {
                    echo "ЧЕГО СКАЗАТЬ-ТО ХОТЕЛ, МИЛОК?!";
                }
                ?>
            </div>
        </div>

        <div class="chat-area">
            <?php if ($showInput): ?>
                <?php if ($input): ?>
                    <div class="last-phrase">
                        <?php echo htmlspecialchars($input); ?>
                    </div>
                <?php endif; ?>

                <form method="post" id="chatForm">
                    <div class="input-group">
                        <input type="text" 
                               name="phrase" 
                               class="input-field" 
                               placeholder="Напишите что-нибудь бабушке..."
                               autocomplete="off"
                               autofocus
                               required>
                        <button type="submit" class="btn">🗣️ Сказать</button>
                        <button type="button" class="btn btn-reset" onclick="resetChat()">🔄 Сбросить</button>
                    </div>
                </form>

                <div class="counter-info">
                    📢 <span><?php echo $_SESSION['poka_count']; ?></span> / 3 раз(а) сказано «ПОКА!» подряд<br>
                    <small>💡 Чтобы попрощаться, крикните <strong>ПОКА!</strong> три раза подряд (каждый раз отдельно)</small>
                </div>
            <?php else: ?>
                <div class="goodbye">
                    🥺👋 ДО СВИДАНИЯ, МИЛЫЙ! 👋🥺<br><br>
                    <button type="button" class="btn" onclick="location.reload()">🔄 Начать новый разговор</button>
                </div>
            <?php endif; ?>
        </div>

        <div class="tips">
            <strong>📢 Как общаться с бабушкой:</strong>
            <ul>
                <li>✍️ Обычная фраза → «АСЬ?! ГОВОРИ ГРОМЧЕ!»</li>
                <li>🔊 Фраза с <strong>!</strong> в конце → «НЕТ, НИ РАЗУ С 19ХХ!»</li>
                <li>👋 Три раза <strong>ПОКА!</strong> подряд → попрощаться</li>
            </ul>
        </div>
    </div>

    <script>
        function resetChat() {
            if (confirm('Начать разговор с начала?')) {
                window.location.href = '?reset=1';
            }
        }

        // Автофокус на поле ввода
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector('.input-field');
            if (input) input.focus();
        });

        // Обработка Enter
        document.getElementById('chatForm')?.addEventListener('submit', function(e) {
            const input = document.querySelector('.input-field');
            if (input && input.value.trim() === '') {
                e.preventDefault();
                alert('Напишите что-нибудь бабушке!');
            }
        });
    </script>
</body>
</html>


