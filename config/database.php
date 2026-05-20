<?php

function database_config(): array
{
    return [
        'host' => '127.0.0.1',
        'port' => 3307,
        'database' => 'damascino_db',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
    ];
}

function db_mysqli(): mysqli
{
    $config = database_config();

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $conn = new mysqli(
        $config['host'],
        $config['username'],
        $config['password'],
        $config['database'],
        $config['port']
    );

    $conn->set_charset($config['charset']);

    return $conn;
}

function db_pdo(): PDO
{
    $config = database_config();
    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $config['host'],
        $config['port'],
        $config['database'],
        $config['charset']
    );

    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}
