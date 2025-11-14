<?php

include "UserModel.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    $userController = new UsersController();

    // Crear usuario
    if ($_POST['action'] === "create_user") {

        $nombre = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userController->create($nombre, $email, $password);
    }

    // Actualizar usuario
    if ($_POST['action'] === "update_user") {

        $id = (int) ($_POST['id'] ?? 0);
        $nombre = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userController->update($id, $nombre, $email, $password);
    }
}

class UsersController
{

    private $User;

    public function __construct()
    {
        $this->User = new UserModel();
    }

    public function getAll()
    {

        return $this->User->get();

    }

    public function getById($id)
    {
        return $this->User->find($id);
    }

    public function create($nombre, $email, $password)
    {

        if ($this->User->create($nombre, $email, $password)) {

            header('Location: ../users.php?status=ok');

        } else

            header('Location: ../users.php?status=error');

    }

    public function update($id, $nombre, $email, $password)
    {
        // Si no se escribió nada en password → no actualizar
        $password = trim($password);
        if ($password === '') {
            $password = null;
        }

        if ($this->User->update($id, $nombre, $email, $password)) {
            header('Location: ../users.php?status=updated');
        } else {
            header('Location: ../users.php?status=error');
        }
        exit;
    }

}


?>