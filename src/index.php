<?php
// index.php

// Incluir configuración y funciones
require_once 'config.php';
require_once 'functions.php';
require_once 'templates/header.php';

// Conexión a la base de datos
$pdo = obtenerConexion();

// Mostrar las tablas
if (isset($_GET['tabla'])) {
    $tabla = $_GET['tabla'];
    switch ($tabla) {
        case 'Clientes':
            $clientes = obtenerClientes($pdo);
            echo "<h2>Clientes</h2><table>";
            echo "<tr><th>ID</th><th>Nombre</th><th>DNI</th><th>Acciones</th></tr>";
            foreach ($clientes as $cliente) {
                echo "<tr>
                        <td>" . htmlspecialchars($cliente['idCliente']) . "</td>
                        <td>" . htmlspecialchars($cliente['nombre']) . "</td>
                        <td>" . htmlspecialchars($cliente['dni']) . "</td>
                        <td>
                            <a href='?tabla=Clientes&accion=editar&id=" . htmlspecialchars($cliente['idCliente']) . "'>Editar</a> | 
                            <a href='?tabla=Clientes&accion=eliminar&id=" . htmlspecialchars($cliente['idCliente']) . "'>Eliminar</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
            break;

        case 'Vehiculos':
            $vehiculos = obtenerVehiculos($pdo);
            echo "<h2>Vehículos</h2><table>";
            echo "<tr><th>ID</th><th>Marca</th><th>Modelo</th><th>Matricula</th><th>Acciones</th></tr>";
            foreach ($vehiculos as $vehiculo) {
                echo "<tr>
                        <td>" . htmlspecialchars($vehiculo['idVehiculo']) . "</td>
                        <td>" . htmlspecialchars($vehiculo['marca']) . "</td>
                        <td>" . htmlspecialchars($vehiculo['modelo']) . "</td>
                        <td>" . htmlspecialchars($vehiculo['matricula']) . "</td>
                        <td>
                            <a href='?tabla=Vehiculos&accion=editar&id=" . htmlspecialchars($vehiculo['idVehiculo']) . "'>Editar</a> | 
                            <a href='?tabla=Vehiculos&accion=eliminar&id=" . htmlspecialchars($vehiculo['idVehiculo']) . "'>Eliminar</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
            break;

        case 'Alquiler':
            $alquileres = obtenerAlquileres($pdo);
            echo "<h2>Alquileres</h2><table>";
            echo "<tr><th>ID</th><th>Fecha Inicio</th><th>Fecha Tope</th><th>Cliente</th><th>Vehículo</th><th>Acciones</th></tr>";
            foreach ($alquileres as $alquiler) {
                echo "<tr>
                        <td>" . htmlspecialchars($alquiler['idAlquiler']) . "</td>
                        <td>" . htmlspecialchars($alquiler['fechaInicio']) . "</td>
                        <td>" . htmlspecialchars($alquiler['fechaTope']) . "</td>
                        <td>" . htmlspecialchars($alquiler['idCliente']) . "</td>
                        <td>" . htmlspecialchars($alquiler['idVehiculo']) . "</td>
                        <td>
                            <a href='?tabla=Alquiler&accion=editar&id=" . htmlspecialchars($alquiler['idAlquiler']) . "'>Editar</a> | 
                            <a href='?tabla=Alquiler&accion=eliminar&id=" . htmlspecialchars($alquiler['idAlquiler']) . "'>Eliminar</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
            break;

        case 'Incidente':
            $incidentes = obtenerIncidentes($pdo);
            echo "<h2>Incidentes</h2><table>";
            echo "<tr><th>ID</th><th>Daño</th><th>Costes</th><th>Fecha</th><th>Alquiler</th><th>Acciones</th></tr>";
            foreach ($incidentes as $incidente) {
                echo "<tr>
                        <td>" . htmlspecialchars($incidente['idIncidente']) . "</td>
                        <td>" . htmlspecialchars($incidente['daño']) . "</td>
                        <td>" . htmlspecialchars($incidente['costes']) . "</td>
                        <td>" . htmlspecialchars($incidente['fecha']) . "</td>
                        <td>" . htmlspecialchars($incidente['idAlquiler']) . "</td>
                        <td>
                            <a href='?tabla=Incidente&accion=editar&id=" . htmlspecialchars($incidente['idIncidente']) . "'>Editar</a> | 
                            <a href='?tabla=Incidente&accion=eliminar&id=" . htmlspecialchars($incidente['idIncidente']) . "'>Eliminar</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
            break;
    }
}

if (isset($_GET['accion']) && $_GET['accion'] == 'editar' && isset($_GET['id'])) {
    // Obtener los datos del cliente para editar
    $cliente = obtenerClientePorId($_GET['id'], $pdo);
    if ($cliente === false) {
        echo "<p>No se encontró el cliente.</p>";
    } else {
        echo "<h2>Editar Cliente</h2>
        <form method='POST'>
            <input type='hidden' name='idCliente' value='" . htmlspecialchars($cliente['idCliente']) . "'>
            <label for='nombre'>Nombre:</label>
            <input type='text' name='nombre' value='" . htmlspecialchars($cliente['nombre'] ?? '') . "'><br>
            <label for='dni'>DNI:</label>
            <input type='text' name='dni' value='" . htmlspecialchars($cliente['dni'] ?? '') . "'><br>
            <label for='apellidos'>Apellidos:</label>
            <input type='text' name='apellidos' value='" . htmlspecialchars($cliente['apellidos'] ?? '') . "'><br>
            <label for='numeroLicencia'>Número Licencia:</label>
            <input type='text' name='numeroLicencia' value='" . htmlspecialchars($cliente['numeroLicencia'] ?? '') . "'><br>
            <label for='direccion'>Dirección:</label>
            <input type='text' name='direccion' value='" . htmlspecialchars($cliente['direccion'] ?? '') . "'><br>
            <label for='telefono'>Teléfono:</label>
            <input type='text' name='telefono' value='" . htmlspecialchars($cliente['telefono'] ?? '') . "'><br>
            <button type='submit' name='actualizar'>Actualizar Cliente</button>
        </form>";
    }
} else {
    // Formulario para agregar un nuevo cliente
    echo "<h2>Agregar Cliente</h2>
    <form method='POST'>
        <label for='idCliente'>ID Cliente:</label>
        <input type='text' name='idCliente' required><br>
        <label for='nombre'>Nombre:</label>
        <input type='text' name='nombre' required><br>
        <label for='dni'>DNI:</label>
        <input type='text' name='dni' required><br>
        <label for='apellidos'>Apellidos:</label>
        <input type='text' name='apellidos' required><br>
        <label for='numeroLicencia'>Número Licencia:</label>
        <input type='text' name='numeroLicencia' required><br>
        <label for='direccion'>Dirección:</label>
        <input type='text' name='direccion' required><br>
        <label for='telefono'>Teléfono:</label>
        <input type='text' name='telefono' required><br>
        <button type='submit' name='agregar'>Agregar Cliente</button>
    </form>";
}

// Comprobar si el formulario se ha enviado para agregar o actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['idCliente'])) {
        $idCliente = $_POST['idCliente'];
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $numeroLicencia = $_POST['numeroLicencia'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];

        // Si se está agregando un cliente
        if (isset($_POST['agregar'])) {
            agregarCliente($idCliente, $dni, $nombre, $apellidos, $numeroLicencia, $direccion, $telefono, $pdo);
        }
        // Si se está actualizando un cliente
        elseif (isset($_POST['actualizar'])) {
            actualizarCliente($idCliente, $dni, $nombre, $apellidos, $numeroLicencia, $direccion, $telefono, $pdo);
        }
    }
}
