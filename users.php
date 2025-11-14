<?php
#Mostrar errores en php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

#traer todos los usuarios
include "./app/UsersController.php";
$usersC = new UsersController();
$all_users = $usersC->getAll();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>

<body>

    <table>

        <tr>
            <th>
                ID
            </th>
            <th>
                Nombre
            </th>
            <th>
                Correo
            </th>
            <th>
                Contraseña
            </th>
            <th>
                Acciones
            </th>
        </tr>

        <?php if (isset($all_users) && count($all_users)): ?>
            <?php foreach ($all_users as $user): ?>
                <tr>
                    <td>
                        <?= $user['id'] ?>
                    </td>
                    <td>
                        <?= $user['nombre'] ?>
                    </td>
                    <td>
                        <?= $user['email'] ?>
                    </td>
                    <td>
                        <?= $user['password'] ?>
                    </td>
                    <td>
                        <button data-user='<?= json_encode($user) ?>'>
                            Editar
                        </button>
                        <button>
                            Eliminar
                        </button>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </table>

    <hr>

    <form id="userForm" method="post" action="./app/UsersController.php">

        <div>
            <label>Nombre</label>
            <input type="text" placeholder="write here" name="name" id="nameInput">
        </div>

        <div>
            <label>Email</label>
            <input type="email" placeholder="write here" name="email" id="emailInput">
        </div>

        <div>
            <label>Password</label>
            <input type="password" placeholder="write here" name="password" id="passwordInput">
        </div>

        <button type="submit" id="submitBtn">
            Guardar datos
        </button>

        <!-- Para saber si es create o update -->
        <input type="hidden" name="action" value="create_user" id="actionInput">
        <!-- ID sólo se usa en update -->
        <input type="hidden" name="id" id="idInput">

    </form>

    <script>
        // Cuando se hace clic en Editar, llenamos el formulario con los datos
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('button[data-user]');
            const nameInput = document.getElementById('nameInput');
            const emailInput = document.getElementById('emailInput');
            const passInput = document.getElementById('passwordInput');
            const idInput = document.getElementById('idInput');
            const actionInput = document.getElementById('actionInput');
            const submitBtn = document.getElementById('submitBtn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const user = JSON.parse(btn.dataset.user);

                    // Campos vienen como 'nombre', 'email', 'password'
                    nameInput.value = user.nombre;
                    emailInput.value = user.email;
                    passInput.value = user.password;

                    idInput.value = user.id;
                    actionInput.value = 'update_user';
                    submitBtn.textContent = 'Actualizar usuario';
                });
            });
        });
    </script>
</body>

</html>