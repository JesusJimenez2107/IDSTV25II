<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "connectionController.php";

class UserModel
{

    private $connection;

    public function __construct()
    {
        $this->connection = new ConnectionController();
    }

    public function get()
    {
        $conn = $this->connection->connect();

        $query = "select * from usuarios";
        $prepared_query = $conn->prepare($query);
        $prepared_query->execute();

        $results = $prepared_query->get_result();
        $users = $results->fetch_all(MYSQLI_ASSOC);

        return $users;
    }

    // Obtener un usuario por id
    public function find($id)
    {
        $conn = $this->connection->connect();

        $query = "SELECT * FROM usuarios WHERE id = ?";
        $prepared_query = $conn->prepare($query);
        $prepared_query->bind_param('i', $id);
        $prepared_query->execute();

        $result = $prepared_query->get_result();
        return $result->fetch_assoc();
    }

    // Crear usuario
    public function create($nombre, $email, $password)
    {
        $conn = $this->connection->connect();

        // Igual que en AuthController:
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";

        $prepared_query = $conn->prepare($query);
        $prepared_query->bind_param('sss', $nombre, $email, $passwordHash);

        return $prepared_query->execute();
    }

    //editar usuario
    public function update($id, $nombre, $email, $password = null)
    {
        $conn = $this->connection->connect();

        // Si NO se cambia la contraseña
        if ($password === null || $password === '') {
            $query = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
            $prepared_query = $conn->prepare($query);
            $prepared_query->bind_param('ssi', $nombre, $email, $id);
        } else {
            // Si se cambia, se hashea
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $query = "UPDATE usuarios SET nombre = ?, email = ?, password = ? WHERE id = ?";
            $prepared_query = $conn->prepare($query);
            $prepared_query->bind_param('sssi', $nombre, $email, $passwordHash, $id);
        }

        return $prepared_query->execute();
    }

    public function delete($id)
    {

        $conn = $this->connection->connect();
        $query = "delete FROM `usuarios` WHERE id = ?";

        $prepared_query = $conn->prepare($query);

        $prepared_query->bind_param('i', $id);

        $prepared_query->execute();

        $results = $prepared_query->get_result();

        if ($results->errno) {
            return false;
        } else
            return true;
    }
}


?>