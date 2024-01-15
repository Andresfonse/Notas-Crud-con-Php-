<?php
include 'db.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Procesar el cierre de sesión
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Manejar la inserción de una nueva tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task'])) {
        // Otros campos del formulario
        $taskName = $_POST['task_name'];
        $taskDetails = $_POST['task_details'];
        $taskImageLink = $_POST['task_image_link']; // Nuevo campo para el enlace de la imagen

        $sql = "INSERT INTO tasks (task_name, task_details, task_image) VALUES ('$taskName', '$taskDetails', '$taskImageLink')";

        if ($conn->query($sql) === true) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Manejar la actualización de una tarea
    if (isset($_POST['edit_task'])) {
        $taskId = $_POST['edit_task'];
        $newTaskName = $_POST['new_task_name'];
        $newTaskDetails = $_POST['new_task_details'];
        $newTaskImageLink = $_POST['new_task_image_link']; // Nuevo campo para el enlace de la imagen

        $sql = "UPDATE tasks SET task_name='$newTaskName', task_details='$newTaskDetails', task_image='$newTaskImageLink' WHERE id=$taskId";

        if ($conn->query($sql) === true) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    // Manejar la eliminación de una tarea
    if (isset($_POST['delete_task'])) {
        $taskId = $_POST['delete_task'];

        $sql = "DELETE FROM tasks WHERE id=$taskId";

        if ($conn->query($sql) === true) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// completata o no la tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['taskId'];

    // Obtén el estado actual de la tarea
    $result = $conn->query("SELECT completed FROM tasks WHERE id = $taskId");
    $row = $result->fetch_assoc();
    $completed = $row['completed'];

    // Cambia el estado de la tarea
    $completed = !$completed;

    // Actualiza el estado en la base de datos
    $conn->query("UPDATE tasks SET completed = $completed WHERE id = $taskId");

    // Devuelve el nuevo estado como respuesta JSON
    echo json_encode(['completed' => $completed]);
}
// Obtener todas las tareas de la base de datos
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofnP+4zfu70x4fuCpJYY6AZGtnYF5z8U5B" crossorigin="anonymous">

    <title>Gestor de Tareas</title>

    

</head>
<body>


</head>


<!-- Formulario para agregar una nueva tarea -->
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
        background-image: url('https://i.pinimg.com/originals/73/1f/42/731f4236c7465d34f90334d1385a4b21.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: #333; /* Letra negra */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }




    .formulario {
    background: linear-gradient(45deg, #87CEEB, #ccc, #9370DB);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
    max-width: 600px;
    width: 90%;
    margin: 10px;
    box-sizing: border-box;
    margin-bottom: 20px;
}

.formulario h1 {
    font-style: italic;
    color: #222;
}

.formulario label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
    color: #333;
}

.formulario input,
.formulario textarea,
.formulario button {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

.formulario input[type="url"] {
    width: calc(100% - 20px); /* Ajuste para que el tipo de entrada de URL sea ligeramente más estrecho */
}

.formulario textarea {
    resize: vertical; /* Permitir ajuste vertical en el área de texto */
}

.formulario .bt {
    background-color: transparent;
    color: #333;
    border: 1px solid #333;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.formulario .bt:hover {
    background-color: #eee;
}


    form {
       
        padding: 20px;
        text-align: center;
        max-width: 600px;
        width: 90%; /* Modificado para ser más ancho en pantallas pequeñas */
        margin: 10px; /* Agregado un margen */
        box-sizing: border-box;
        margin-bottom: 20px; /* Espacio entre el formulario y las tarjetas */
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        font-style: italic;
        color: #666; /* Gris oscuro */
    }

    input,
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 5px;
        color: #333; /* Letra negra */
    }

   
  

    .bottom-buttons {
        display: flex;
        flex-wrap: wrap;
        max-width: 1200px;
        width: 90%; /* Modificado para ser más ancho en pantallas pequeñas */
    }

    .card {
         margin: 4%;
        background: whitesmoke;
        font-size: small;
        font-style: italic;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        margin-bottom: 20px;
        flex: 0 0 calc(20% - 20px);
        margin-right: 20px;
        box-sizing: border-box;
        text-align: center;
    }

    .card img {
        width: 100%;
        height: auto;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .card strong {
        font-size: small;
        font-style: italic;
        color: #222; /* Negro oscuro */
    }



    /* Media query para hacer el formulario más estrecho en pantallas pequeñas */
    @media (max-width: 600px) {
        form {
            width: 100%;
        }

        .bottom-buttons {
            width: 100%;
        }

        .card {
            flex: 0 0 calc(50% - 20px);
            margin-right: 0;
        }
    }


    .bt {
    background: linear-gradient(to right, #B9F38A, #8AF3EF, #D579FA);
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.8s, color 0.8s; /* Ajustado para una transición más lenta */
}

.bt:hover {
    background: linear-gradient(to right, #000000, #A09C99);
    color: #fff;
}

.bt i {
    font-style: italic; /* Letra cursiva */
}





</style>

</head>
<body>

<h1>Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>

<form method="post" action="index.php">
        <button type="submit" name="logout">Cerrar Sesión</button>
    </form>

<!-- Formulario para agregar una nueva tarea -->
<form method="post" action="index.php" class="formulario">
    <h1 style="font-style: italic; color: #222;">Gestor de Tareas</h1>

    <label for="task_name">Nueva Tarea:</label>
    <input type="text" name="task_name" placeholder="Me toca hacer Gym" required>

    <label for="task_details">Detalles:</label>
    <textarea name="task_details" placeholder="Espero que no sea tan difícil"></textarea>

    <label for="task_image_link">Enlace de la Imagen:</label>
    <input type="url" name="task_image_link" placeholder="https://ejemplo.com/imagen.jpg" required>
<br><br>
    <button type="submit" name="add_task" class="bt">Agregar Tarea</button>
</form>




<!-- Lista de tareas -->
<div class="bottom-buttons">
    <?php
if ($result->num_rows > 0) {
    $counter = 0; // Contador para las tarjetas en cada fila
    while ($row = $result->fetch_assoc()) {
        if ($counter % 3 == 0) {
            echo '<br>'; // Salto de línea después de cada fila de tarjetas
        }

        echo "<div class='card'>";
        echo "<img src='" . $row["task_image"] . "' alt='Imagen de la tarea'>";
        echo "<strong>" . $row["task_name"] . "</strong>";
        echo "<p>" . $row["task_details"] . "</p>";

        //borrar

        echo "<form method='post' action='index.php' style='display: inline;'>";
        echo "<input type='hidden' name='delete_task' value='" . $row["id"] . "'>";

        echo "<button type='button' style='background: none; border: none; padding: 0; margin: 0; cursor: pointer;' onclick='this.parentNode.submit();'><i class='far fa-trash-alt' style='color: #ff0000;'></i></button>";

        echo "</form>";
        //terimnado de form de borrar

        // Botón para abrir el modal de edición
        echo "<button onclick='openModal(" . $row["id"] . ", \"" . htmlspecialchars($row["task_name"]) . "\", \"" . htmlspecialchars($row["task_details"]) . "\")'><i class='far fa-edit'></i></button>";

        // Formulario para cambiar el estado de la tarea
        echo "<form method='post' action='toggle_status.php'>";
        echo "<input type='hidden' name='task_id' value='" . $row["id"] . "'>";
        echo "<button type='submit' style='background: none; border: none; padding: 0;'><i class='fa-regular fa-hourglass'></i></button>";
        echo "</form>";

        // Mensaje indicando el estado actual de la tarea
        echo "<p>Estado: " . ($row["completed"] ? "Completada <i class='far fa-smile'></i>" : "Pendiente <i class='far fa-frown'></i>") . "</p>";

        //formulario de borrar Tarea

        echo "</div>";

        $counter++;
    }
} else {
    echo "<p>No hay tareas</p>";
}
?>
</div>

</ul>

<!-- Modal de edición --><!-- Modal de edición -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Editar Tarea</h2>
        </div>
        <form method="post" action="index.php">
            <input type="hidden" id="edit_task_id" name="edit_task" value="">
            <label for="new_task_name">Nuevo Nombre:</label>
            <input type="text" id="new_task_name" name="new_task_name" required>
            <label for="new_task_details">Nuevos Detalles:</label>
            <textarea id="new_task_details" name="new_task_details"></textarea>
            <label for="new_task_image_link">Nuevo Enlace de la Imagen:</label>
    <input type="url" id="new_task_image_link" name="new_task_image_link" placeholder="https://ejemplo.com/imagen.jpg" required>
            <div class="modal-buttons">
                <button type="submit" class="save">Guardar Cambios</button>
                <button type="button" onclick="closeModal()" class="delete">Cancelar</button>
            </div>
        </form>
    </div>
</div>








<script>
    // Funciones para abrir y cerrar el modal
    function openModal(taskId, taskName, taskDetails) {
        document.getElementById('edit_task_id').value = taskId;
        document.getElementById('new_task_name').value = taskName;
        document.getElementById('new_task_details').value = taskDetails;
        document.getElementById('editModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Cerrar el modal si se hace clic fuera de él
    window.onclick = function(event) {
        var modal = document.getElementById('editModal');
        if (event.target === modal) {
            closeModal();
        }
    }



    function toggleTaskStatus(taskId) {
        // Envía una solicitud AJAX al servidor para cambiar el estado de la tarea
        // Puedes usar fetch, jQuery.ajax, o cualquier otra biblioteca que prefieras
        // Aquí, un ejemplo con fetch:
        fetch('toggle_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'taskId=' + taskId,
        })
        .then(response => response.json())
        .then(data => {
            // Actualiza el mensaje de estado en la tarjeta
            const taskStatusElement = document.querySelector('#taskStatus' + taskId);
            taskStatusElement.innerHTML = 'Estado: ' + (data.completed ? 'Completada' : 'Pendiente');
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
</script>


<script src="https://kit.fontawesome.com/f15154e1e9.js" crossorigin="anonymous"></script>
</body>
</html>

<?php
$conn->close();
?>
<style>
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #f8f8f8; /* Cambiado a un tono más claro */
            margin: 15% auto;
            padding: 20px;
        }