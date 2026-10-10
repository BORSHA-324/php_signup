
<?php

$dsn = 'mysql:host=localhost;port=3306;dbname=myapp;charset=utf8mb4';
$pdo = new PDO($dsn, 'root', '');

$errors = [];
$success = '';

$name = '';
$age = '';
$city = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $city = trim($_POST['city'] ?? '');

    if ($name === '') {
        $errors[] = 'Name is required';
    }

    if ($city === '') {
        $errors[] = 'City is required';
    }

    if (empty($errors)) {

        $sql = 'INSERT INTO users (name, age, city)
                VALUES (:name, :age, :city)';

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            'name' => $name,
            'age' => $age === '' ? null : (int)$age,
            'city' => $city
        ]);

        $success = 'Welcome ' .
            htmlspecialchars($name, ENT_QUOTES, 'UTF-8') .
            ' from ' .
            htmlspecialchars($city, ENT_QUOTES, 'UTF-8') .
            '!';

        $name = '';
        $age = '';
        $city = '';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef4f3;
            margin: 0;
            padding: 40px;
        }

        .container {
            background-color: white;
            max-width: 400px;
            margin: auto;
            padding: 25px;
            border-radius: 8px;
            border-top: 4px solid #0f766e;
        }

        h1 {
            color: #0f766e;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #0f766e;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #115e59;
        }

        .error {
            color: #c62828;
            background-color: #ffebee;
            padding: 8px;
            border-radius: 4px;
        }

        .success {
            color: #166534;
            background-color: #dcfce7;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Sign Up</h1>

    <?php foreach ($errors as $error): ?>
        <p class="error">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endforeach; ?>

    <form method="POST">

        <p>
            <input
                type="text"
                name="name"
                placeholder="Enter your name"
                value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
        </p>

        <p>
            <input
                type="number"
                name="age"
                placeholder="Enter your age"
                value="<?= htmlspecialchars($age, ENT_QUOTES, 'UTF-8') ?>">
        </p>

        <p>
            <input
                type="text"
                name="city"
                placeholder="Enter your city"
                value="<?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8') ?>">
        </p>

        <button type="submit">Sign Up</button>

    </form>

    <?php if ($success !== ''): ?>
        <p class="success">
            <?= $success ?>
        </p>
    <?php endif; ?>

</div>

</body>
</html>
