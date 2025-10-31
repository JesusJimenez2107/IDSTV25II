<?php

include "connectionController.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $auth = new AuthController();

    if ($action === 'registro') {
        $nombre   = trim($_POST['nombre'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $auth->register($nombre, $email, $password);
        exit;
    }

    if ($action === 'login') {
        $username = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $auth->login($username, $password);
        exit;
    }

    header('Location: ../index.html?msg=accion_invalida');
    exit;
} else {
    header('Location: ../index.html');
    exit;
}

class AuthController {

    private $connection;

    public function __construct() {
        $this->connection = new ConnectionController();
    }

    // ---------- Registro ------------
    public function register(string $nombre, string $email, string $password): void
    {
        if ($nombre === '' || $email === '' || $password === '') {
            header('Location: ../registro.html?error=campos_obligatorios');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: ../registro.html?error=email_invalido');
            exit;
        }

        $conn = $this->connection->connect();

        if ($conn->connect_error) {
            header('Location: ../registro.html?error=db');
            exit;
        }

        // Verificacion correo unico
        $sqlCheck = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sqlCheck);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        $existe = $stmt->num_rows > 0;
        $stmt->close();

        if ($existe) {
            header('Location: ../registro.html?error=email_ya_registrado');
            exit;
        }

        // hasheo contraseña
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el usuario
        $sqlInsert = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sqlInsert);
        $stmt->bind_param('sss', $nombre, $email, $hash);

        if ($stmt->execute()) {
            header('Location: ../index.html?msg=registro_ok');
        } else {
            header('Location: ../registro.html?error=insert_fail');
        }

        $stmt->close();
        $conn->close();
    }


    // ---------- login ------------
    public function login(string $username, string $password): void
    {
        if ($username === '' || $password === '') {
            header('Location: ../index.html?error=campos_obligatorios');
            exit;
        }

        $conn = $this->connection->connect();

        if ($conn->connect_error) {
            header('Location: ../index.html?error=db');
            exit;
        }

        // Buscar usuario
        $sql = "SELECT id, nombre, email, password FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();
        $stmt->close();
        $conn->close();

        // Validar contraseña hasheada
        if ($user && password_verify($password, $user['password'])) {
            header('Location: ../home.html');
            exit;
        } else {
            header('Location: ../index.html?error=credenciales');
            exit;
        }
    }
}


?>