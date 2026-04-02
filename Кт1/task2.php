<?php
/**
 * ЗАДАНИЕ 1: Простой калькулятор
 * 
 * Ваша задача: дописать код калькулятора, который выполняет основные операции
 * 
 * Что нужно сделать:
 * 1. Создать функцию calculate($a, $b, $operation), которая принимает два числа и операцию
 * 2. Функция должна поддерживать операции: '+', '-', '*', '/'
 * 3. При делении на ноль должна возвращать сообщение об ошибке
 * 4. Если операция неизвестна, вернуть сообщение об ошибке
 * 5. Дополнить код ниже, чтобы калькулятор работал
 */

function calculate($a, $b, $operation) {
    switch ($operation) {
        case '+':
            return $a + $b;
        case '-':
            return $a - $b;
        case '*':
            return $a * $b;
        case '/':
            if ($b == 0) {
                return "Ошибка: деление на ноль";
            }
            return $a / $b;
        default:
            return "Неизвестная операция";
    }
}

// ============================================
// Тестовые примеры (не изменяйте этот код)
// ============================================
$тесты = [
    [10, 5, '+', 15],
    [10, 5, '-', 5],
    [10, 5, '*', 50],
    [10, 5, '/', 2],
    [10, 0, '/', 'Ошибка: деление на ноль'],
    [10, 5, '%', 'Неизвестная операция']
];

$testResults = [];
foreach ($тесты as $тест) {
    $a = $тест[0];
    $b = $тест[1];
    $операция = $тест[2];
    $ожидаемый_результат = $тест[3];
    $результат = calculate($a, $b, $операция);
    $testResults[] = [
        'a' => $a,
        'b' => $b,
        'op' => $операция,
        'result' => $результат,
        'expected' => $ожидаемый_результат,
        'passed' => ($результат === $ожидаемый_результат)
    ];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор | Задание 1</title>
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
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Карточка калькулятора */
        .calculator-card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .calculator-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .card-header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .card-header h1 span {
            font-size: 1.2em;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 1.1em;
        }

        .calculator-body {
            padding: 40px;
            background: #f8f9fa;
        }

        /* Форма */
        .calc-form {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .input-group {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 20px;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .input-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .input-field label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-field input {
            padding: 15px 20px;
            font-size: 1.2em;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            outline: none;
            transition: all 0.3s ease;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        .input-field input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52,152,219,0.2);
        }

        .operation-select {
            text-align: center;
        }

        .operation-select label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .operation-buttons {
            display: flex;
            gap: 10px;
            background: #f0f0f0;
            padding: 8px;
            border-radius: 60px;
        }

        .op-btn {
            width: 60px;
            height: 60px;
            border: none;
            background: white;
            font-size: 1.8em;
            font-weight: bold;
            cursor: pointer;
            border-radius: 50%;
            transition: all 0.3s ease;
            color: #2c3e50;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .op-btn:hover {
            transform: scale(1.05);
            background: #3498db;
            color: white;
        }

        .op-btn.active {
            background: #3498db;
            color: white;
            box-shadow: 0 0 0 3px rgba(52,152,219,0.5);
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(52,152,219,0.4);
        }

        /* Результат */
        .result-box {
            margin-top: 30px;
            padding: 25px;
            background: linear-gradient(135deg, #2c3e50, #3498db);
            border-radius: 20px;
            text-align: center;
            color: white;
        }

        .result-label {
            font-size: 0.9em;
            opacity: 0.8;
            letter-spacing: 2px;
        }

        .result-value {
            font-size: 3em;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            margin-top: 10px;
            word-break: break-word;
        }

        /* Таблица тестов */
        .tests-section {
            background: white;
            border-radius: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        .tests-header {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            padding: 20px 30px;
        }

        .tests-header h2 {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tests-table {
            width: 100%;
            border-collapse: collapse;
        }

        .tests-table th,
        .tests-table td {
            padding: 15px 20px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .tests-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        .tests-table tr:hover {
            background: #f8f9fa;
        }

        .badge-pass {
            background: #27ae60;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .badge-fail {
            background: #e74c3c;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .expression {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            font-size: 1.1em;
        }

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
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.4);
        }

        @media (max-width: 768px) {
            .input-group {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .calculator-body {
                padding: 20px;
            }
            
            .result-value {
                font-size: 2em;
            }
            
            .tests-table th,
            .tests-table td {
                padding: 10px;
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Калькулятор -->
        <div class="calculator-card">
            <div class="card-header">
                <h1>
                    <span>🧮</span>
                    Калькулятор
                    <span>🔢</span>
                </h1>
                <p>Простые арифметические операции</p>
            </div>
            <div class="calculator-body">
                <form method="GET" class="calc-form">
                    <div class="input-group">
                        <div class="input-field">
                            <label>📊 ЧИСЛО 1</label>
                            <input type="number" 
                                   name="num1" 
                                   step="any"
                                   value="<?php echo $_GET['num1'] ?? ''; ?>" 
                                   placeholder="Введите число"
                                   required>
                        </div>
                        
                        <div class="operation-select">
                            <label>⚙️ ОПЕРАЦИЯ</label>
                            <div class="operation-buttons">
                                <button type="button" class="op-btn <?php echo (($_GET['operation'] ?? '') === '+') ? 'active' : ''; ?>" data-op="+">+</button>
                                <button type="button" class="op-btn <?php echo (($_GET['operation'] ?? '') === '-') ? 'active' : ''; ?>" data-op="-">-</button>
                                <button type="button" class="op-btn <?php echo (($_GET['operation'] ?? '') === '*') ? 'active' : ''; ?>" data-op="*">×</button>
                                <button type="button" class="op-btn <?php echo (($_GET['operation'] ?? '') === '/') ? 'active' : ''; ?>" data-op="/">÷</button>
                            </div>
                            <input type="hidden" name="operation" id="operation" value="<?php echo $_GET['operation'] ?? '+'; ?>">
                        </div>
                        
                        <div class="input-field">
                            <label>📊 ЧИСЛО 2</label>
                            <input type="number" 
                                   name="num2" 
                                   step="any"
                                   value="<?php echo $_GET['num2'] ?? ''; ?>" 
                                   placeholder="Введите число"
                                   required>
                        </div>
                    </div>
                    
                    <button type="submit" class="submit-btn">= ВЫЧИСЛИТЬ =</button>
                </form>
                
                <?php if (isset($_GET['num1']) && isset($_GET['num2']) && isset($_GET['operation'])): 
                    $num1 = (float)$_GET['num1'];
                    $num2 = (float)$_GET['num2'];
                    $operation = $_GET['operation'];
                    $result = calculate($num1, $num2, $operation);
                ?>
                <div class="result-box">
                    <div class="result-label">РЕЗУЛЬТАТ</div>
                    <div class="result-value">
                        <?php 
                        echo htmlspecialchars("$num1 $operation $num2 = $result");
                        ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Таблица тестов -->
        <div class="tests-section">
            <div class="tests-header">
                <h2>🧪 Автоматические тесты</h2>
            </div>
            <table class="tests-table">
                <thead>
                    <tr>
                        <th>Выражение</th>
                        <th>Результат</th>
                        <th>Ожидалось</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testResults as $test): ?>
                    <tr>
                        <td class="expression"><?php echo "{$test['a']} {$test['op']} {$test['b']}"; ?></td>
                        <td><?php echo htmlspecialchars($test['result']); ?></td>
                        <td><?php echo htmlspecialchars($test['expected']); ?></td>
                        <td>
                            <span class="<?php echo $test['passed'] ? 'badge-pass' : 'badge-fail'; ?>">
                                <?php echo $test['passed'] ? '✓ ПРОЙДЕН' : '✗ ОШИБКА'; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="nav-links">
            <a href="../examples/04_arrays.php">← Назад к примерам</a>
            <a href="task_02.php">Следующее задание →</a>
        </div>
    </div>
    
    <script>
        // Интерактивные кнопки операций
        const opButtons = document.querySelectorAll('.op-btn');
        const operationInput = document.getElementById('operation');
        
        opButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Убираем active у всех
                opButtons.forEach(b => b.classList.remove('active'));
                // Добавляем active текущей
                this.classList.add('active');
                // Устанавливаем значение в скрытое поле
                operationInput.value = this.dataset.op;
            });
        });
    </script>
</body>
</html>
