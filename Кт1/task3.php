<?php
/**
 * ЗАДАНИЕ 2: Работа с данными студентов
 * 
 * Ваша задача: дописать функции для работы с массивом студентов
 * 
 * Что нужно сделать:
 * 1. Создать функцию getAverageScore($students), которая вычисляет средний балл всех студентов
 * 2. Создать функцию getBestStudent($students), которая возвращает студента с наивысшим баллом
 * 3. Создать функцию getStudentsByCourse($students, $course), которая возвращает студентов определенного курса
 * 4. Создать функцию addStudent(&$students, $name, $age, $course, $score), которая добавляет нового студента
 */

// Массив студентов (не изменяйте этот массив напрямую)
$студенты = [
    ["имя" => "Иван", "возраст" => 20, "курс" => 2, "балл" => 4.5],
    ["имя" => "Мария", "возраст" => 19, "курс" => 1, "балл" => 5.0],
    ["имя" => "Алексей", "возраст" => 21, "курс" => 3, "балл" => 4.2],
    ["имя" => "Анна", "возраст" => 20, "курс" => 2, "балл" => 4.8],
    ["имя" => "Дмитрий", "возраст" => 22, "курс" => 4, "балл" => 3.9]
];

// Функция 1: Вычисление среднего балла всех студентов
function getAverageScore($students) {
    if (empty($students)) {
        return 0;
    }
    
    $сумма = 0;
    foreach ($students as $student) {
        $сумма += $student["балл"];
    }
    return $сумма / count($students);
}

// Функция 2: Поиск студента с наивысшим баллом
function getBestStudent($students) {
    if (empty($students)) {
        return null;
    }
    
    $лучший = $students[0];
    foreach ($students as $student) {
        if ($student["балл"] > $лучший["балл"]) {
            $лучший = $student;
        }
    }
    return $лучший;
}

// Функция 3: Получение студентов определенного курса
function getStudentsByCourse($students, $course) {
    $результат = [];
    foreach ($students as $student) {
        if ($student["курс"] == $course) {
            $результат[] = $student;
        }
    }
    return $результат;
}

// Функция 4: Добавление нового студента (по ссылке &)
function addStudent(&$students, $name, $age, $course, $score) {
    $новый_студент = [
        "имя" => $name,
        "возраст" => $age,
        "курс" => $course,
        "балл" => $score
    ];
    $students[] = $новый_студент;
}

// ============================================
// Тестирование функций (не изменяйте этот код)
// ============================================
$тесты_пройдены = true;
$результаты_тестов = [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 2: Работа с данными студентов</title>
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

        /* Карточка */
        .card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .card:hover {
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

        .card-header p {
            opacity: 0.9;
            font-size: 1.1em;
        }

        .card-body {
            padding: 30px;
            background: #f8f9fa;
        }

        /* Таблицы */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin: 20px 0;
        }

        .data-table th {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            padding: 15px;
            font-weight: 600;
            font-size: 1em;
        }

        .data-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .data-table tr:hover {
            background: #f8f9fa;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        /* Результаты тестов */
        .test-results {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .test-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .test-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .test-title {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .test-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .status-pass {
            background: #27ae60;
            color: white;
        }

        .status-fail {
            background: #e74c3c;
            color: white;
        }

        .test-value {
            margin-top: 10px;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }

        /* Бейджики */
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .badge-success {
            background: #27ae60;
            color: white;
        }

        .badge-info {
            background: #3498db;
            color: white;
        }

        /* Статистика */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .stat-value {
            font-size: 2.5em;
            font-weight: bold;
            margin-top: 10px;
        }

        .stat-label {
            font-size: 0.9em;
            opacity: 0.9;
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

        @media (max-width: 768px) {
            .card-body {
                padding: 20px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .test-results {
                grid-template-columns: 1fr;
            }
            
            .data-table th,
            .data-table td {
                padding: 8px 10px;
                font-size: 0.85em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Главная карточка -->
        <div class="card">
            <div class="card-header">
                <h1>
                    <span>👨‍🎓</span>
                    Управление студентами
                    <span>📚</span>
                </h1>
                <p>Функции для работы с массивом данных</p>
            </div>
            <div class="card-body">
                <!-- Статистика -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">Всего студентов</div>
                        <div class="stat-value"><?php echo count($студенты); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Средний балл</div>
                        <div class="stat-value"><?php echo number_format(getAverageScore($студенты), 2); ?></div>
                    </div>
                    <?php 
                    $лучший_стат = getBestStudent($студенты);
                    if ($лучший_стат):
                    ?>
                    <div class="stat-card">
                        <div class="stat-label">Лучший студент</div>
                        <div class="stat-value"><?php echo $лучший_стат["имя"]; ?></div>
                        <div class="stat-label">балл: <?php echo $лучший_стат["балл"]; ?></div>
                    </div>
                    <?php endif; ?>
                    <div class="stat-card">
                        <div class="stat-label">Курсов</div>
                        <div class="stat-value"><?php echo count(array_unique(array_column($студенты, "курс"))); ?></div>
                    </div>
                </div>

                <!-- Исходный список студентов -->
                <h2 style="margin: 20px 0 10px; color: #2c3e50;">📋 Исходный список студентов</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>👤 Имя</th>
                            <th>🎂 Возраст</th>
                            <th>📖 Курс</th>
                            <th>⭐ Балл</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($студенты as $студент): ?>
                        <tr>
                            <td><?php echo $студент["имя"]; ?></td>
                            <td><?php echo $студент["возраст"]; ?></td>
                            <td><?php echo $студент["курс"]; ?></td>
                            <td><?php echo $студент["балл"]; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Результаты тестов -->
                <h2 style="margin: 30px 0 10px; color: #2c3e50;">🧪 Результаты тестирования</h2>
                <div class="test-results">
                    <?php
                    // Тест 1: Средний балл
                    $средний_балл = getAverageScore($студенты);
                    $ожидаемый_средний = 4.48;
                    $тест1_пройден = abs($средний_балл - $ожидаемый_средний) < 0.01;
                    ?>
                    <div class="test-card">
                        <div class="test-title">
                            📊 Тест 1: Средний балл
                            <span class="test-status <?php echo $тест1_пройден ? 'status-pass' : 'status-fail'; ?>">
                                <?php echo $тест1_пройден ? '✓ Пройден' : '✗ Ошибка'; ?>
                            </span>
                        </div>
                        <div class="test-value">
                            Результат: <?php echo number_format($средний_балл, 2); ?><br>
                            Ожидалось: <?php echo number_format($ожидаемый_средний, 2); ?>
                        </div>
                    </div>

                    <?php
                    // Тест 2: Лучший студент
                    $лучший = getBestStudent($студенты);
                    $тест2_пройден = isset($лучший["имя"]) && $лучший["имя"] === "Мария" && $лучший["балл"] === 5.0;
                    ?>
                    <div class="test-card">
                        <div class="test-title">
                            🏆 Тест 2: Лучший студент
                            <span class="test-status <?php echo $тест2_пройден ? 'status-pass' : 'status-fail'; ?>">
                                <?php echo $тест2_пройден ? '✓ Пройден' : '✗ Ошибка'; ?>
                            </span>
                        </div>
                        <div class="test-value">
                            Результат: <?php echo isset($лучший["имя"]) ? $лучший["имя"] . " (балл: " . $лучший["балл"] . ")" : "не найден"; ?><br>
                            Ожидалось: Мария (балл: 5)
                        </div>
                    </div>

                    <?php
                    // Тест 3: Студенты 2 курса
                    $студенты_2_курса = getStudentsByCourse($студенты, 2);
                    $имена_2_курса = array_column($студенты_2_курса, "имя");
                    $тест3_пройден = count($студенты_2_курса) === 2 && in_array("Иван", $имена_2_курса) && in_array("Анна", $имена_2_курса);
                    ?>
                    <div class="test-card">
                        <div class="test-title">
                            🎓 Тест 3: Студенты 2 курса
                            <span class="test-status <?php echo $тест3_пройден ? 'status-pass' : 'status-fail'; ?>">
                                <?php echo $тест3_пройден ? '✓ Пройден' : '✗ Ошибка'; ?>
                            </span>
                        </div>
                        <div class="test-value">
                            Результат: <?php echo count($имена_2_курса) > 0 ? implode(", ", $имена_2_курса) : "нет студентов"; ?><br>
                            Ожидалось: Иван, Анна
                        </div>
                    </div>

                    <?php
                    // Тест 4: Добавление студента
                    $количество_до = count($студенты);
                    addStudent($студенты, "Елена", 19, 1, 4.7);
                    $количество_после = count($студенты);
                    $последний = end($студенты);
                    $тест4_пройден = $количество_после === $количество_до + 1 && $последний["имя"] === "Елена" && $последний["балл"] === 4.7;
                    ?>
                    <div class="test-card">
                        <div class="test-title">
                            ➕ Тест 4: Добавление студента
                            <span class="test-status <?php echo $тест4_пройден ? 'status-pass' : 'status-fail'; ?>">
                                <?php echo $тест4_пройден ? '✓ Пройден' : '✗ Ошибка'; ?>
                            </span>
                        </div>
                        <div class="test-value">
                            Результат: <?php echo $тест4_пройден ? "Добавлен: " . $последний["имя"] : "Студент не добавлен"; ?><br>
                            Ожидалось: Добавлен студент Елена
                        </div>
                    </div>
                </div>

                <!-- Обновленный список -->
                <h2 style="margin: 30px 0 10px; color: #2c3e50;">🔄 Обновленный список студентов</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>👤 Имя</th>
                            <th>🎂 Возраст</th>
                            <th>📖 Курс</th>
                            <th>⭐ Балл</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($студенты as $студент): ?>
                        <tr>
                            <td><?php echo $студент["имя"]; ?></td>
                            <td><?php echo $студент["возраст"]; ?></td>
                            <td><?php echo $студент["курс"]; ?></td>
                            <td>
                                <?php echo $студент["балл"]; ?>
                                <?php if ($студент["балл"] >= 4.7): ?>
                                    <span class="badge badge-success" style="margin-left: 10px;">Отлично</span>
                                <?php elseif ($студент["балл"] <= 4.0): ?>
                                    <span class="badge badge-info" style="margin-left: 10px; background: #e74c3c;">Хорошо бы подтянуть</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Итоговая статистика -->
                <div class="stats-grid" style="margin-top: 30px;">
                    <div class="stat-card" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">
                        <div class="stat-label">✅ Пройдено тестов</div>
                        <div class="stat-value"><?php echo ($тест1_пройден ? 1 : 0) + ($тест2_пройден ? 1 : 0) + ($тест3_пройден ? 1 : 0) + ($тест4_пройден ? 1 : 0); ?>/4</div>
                    </div>
                    <div class="stat-card" style="background: linear-gradient(135deg, #e67e22, #f39c12);">
                        <div class="stat-label">📊 Общий прогресс</div>
                        <div class="stat-value"><?php echo round((($тест1_пройден ? 1 : 0) + ($тест2_пройден ? 1 : 0) + ($тест3_пройден ? 1 : 0) + ($тест4_пройден ? 1 : 0)) / 4 * 100); ?>%</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="nav-links">
            <a href="task_01.php">← Предыдущее задание</a>
            <a href="task_03.php">Следующее задание →</a>
        </div>
    </div>
</body>
</html>
