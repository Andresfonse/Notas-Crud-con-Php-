<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['task_id'];

    // Obtén el estado actual de la tarea
    $result = $conn->query("SELECT completed FROM tasks WHERE id = $taskId");
    $row = $result->fetch_assoc();
    $completed = $row['completed'];

    // Cambia el estado de la tarea
    $completed = !$completed;

    // Actualiza el estado en la base de datos
    $conn->query("UPDATE tasks SET completed = '$completed' WHERE id = $taskId");

    // Redirecciona a la página principal después de cambiar el estado
    header("Location: index.php");
    exit();
}
?>
