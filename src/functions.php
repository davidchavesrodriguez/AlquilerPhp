<?php

// Función para obtener la conexión a la base de datos
function obtenerConexion()
{
    try {
        $pdo = new PDO('sqlite:/var/www/html/database.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        exit();
    }
}

// Funciones CRUD para la tabla Clientes

// Obtener todos los clientes
function obtenerClientes($pdo)
{
    $stmt = $pdo->query("SELECT * FROM Clientes");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener un cliente por su ID
function obtenerClientePorId($idCliente, $pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM Clientes WHERE idCliente = :idCliente");
    $stmt->execute([':idCliente' => $idCliente]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function agregarCliente($idCliente, $dni, $nombre, $apellidos, $numeroLicencia, $direccion, $telefono, $pdo)
{
    try {
        $sql = "INSERT INTO Clientes (idCliente, dni, nombre, apellidos, numeroLicencia, direccion, telefono) 
                VALUES (:idCliente, :dni, :nombre, :apellidos, :numeroLicencia, :direccion, :telefono)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idCliente' => $idCliente,
            ':dni' => $dni,
            ':nombre' => $nombre,
            ':apellidos' => $apellidos,
            ':numeroLicencia' => $numeroLicencia,
            ':direccion' => $direccion,
            ':telefono' => $telefono
        ]);
        echo "<p>Cliente agregado exitosamente.</p>";
    } catch (PDOException $e) {
        echo "Error al agregar cliente: " . $e->getMessage();
    }
}


function actualizarCliente($idCliente, $dni, $nombre, $apellidos, $numeroLicencia, $direccion, $telefono, $pdo)
{
    try {
        $sql = "UPDATE Clientes SET dni = :dni, nombre = :nombre, apellidos = :apellidos, 
                numeroLicencia = :numeroLicencia, direccion = :direccion, telefono = :telefono 
                WHERE idCliente = :idCliente";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idCliente' => $idCliente,
            ':dni' => $dni,
            ':nombre' => $nombre,
            ':apellidos' => $apellidos,
            ':numeroLicencia' => $numeroLicencia,
            ':direccion' => $direccion,
            ':telefono' => $telefono
        ]);
        echo "<p>Cliente actualizado exitosamente.</p>";
    } catch (PDOException $e) {
        echo "Error al actualizar cliente: " . $e->getMessage();
    }
}


// Eliminar un cliente
function eliminarCliente($idCliente, $pdo)
{
    $stmt = $pdo->prepare("DELETE FROM Clientes WHERE idCliente = :idCliente");
    $stmt->execute([':idCliente' => $idCliente]);
}

// Funciones CRUD para la tabla Vehiculos

// Obtener todos los vehículos
function obtenerVehiculos($pdo)
{
    $stmt = $pdo->query("SELECT * FROM Vehiculos");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener un vehículo por su ID
function obtenerVehiculoPorId($idVehiculo, $pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM Vehiculos WHERE idVehiculo = :idVehiculo");
    $stmt->execute([':idVehiculo' => $idVehiculo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Agregar un nuevo vehículo
function agregarVehiculo($idVehiculo, $matricula, $marca, $modelo, $anoFabricacion, $estado, $pdo)
{
    $stmt = $pdo->prepare("INSERT INTO Vehiculos (idVehiculo, matricula, marca, modelo, anoFabricacion, estado)
                           VALUES (:idVehiculo, :matricula, :marca, :modelo, :anoFabricacion, :estado)");
    $stmt->execute([
        ':idVehiculo' => $idVehiculo,
        ':matricula' => $matricula,
        ':marca' => $marca,
        ':modelo' => $modelo,
        ':anoFabricacion' => $anoFabricacion,
        ':estado' => $estado
    ]);
}

// Actualizar un vehículo existente
function actualizarVehiculo($idVehiculo, $matricula, $marca, $modelo, $anoFabricacion, $estado, $pdo)
{
    $stmt = $pdo->prepare("UPDATE Vehiculos SET matricula = :matricula, marca = :marca, modelo = :modelo,
                           anoFabricacion = :anoFabricacion, estado = :estado WHERE idVehiculo = :idVehiculo");
    $stmt->execute([
        ':idVehiculo' => $idVehiculo,
        ':matricula' => $matricula,
        ':marca' => $marca,
        ':modelo' => $modelo,
        ':anoFabricacion' => $anoFabricacion,
        ':estado' => $estado
    ]);
}

// Eliminar un vehículo
function eliminarVehiculo($idVehiculo, $pdo)
{
    $stmt = $pdo->prepare("DELETE FROM Vehiculos WHERE idVehiculo = :idVehiculo");
    $stmt->execute([':idVehiculo' => $idVehiculo]);
}

// Funciones CRUD para la tabla Alquiler

// Obtener todos los alquileres
function obtenerAlquileres($pdo)
{
    $stmt = $pdo->query("SELECT * FROM Alquiler");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener un alquiler por su ID
function obtenerAlquilerPorId($idAlquiler, $pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM Alquiler WHERE idAlquiler = :idAlquiler");
    $stmt->execute([':idAlquiler' => $idAlquiler]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Agregar un nuevo alquiler
function agregarAlquiler($idAlquiler, $fechaInicio, $fechaTope, $kilometrajeInicial, $kilometrajeFinal, $idCliente, $idVehiculo, $pdo)
{
    $stmt = $pdo->prepare("INSERT INTO Alquiler (idAlquiler, fechaInicio, fechaTope, kilometrajeInicial, kilometrajeFinal, idCliente, idVehiculo)
                           VALUES (:idAlquiler, :fechaInicio, :fechaTope, :kilometrajeInicial, :kilometrajeFinal, :idCliente, :idVehiculo)");
    $stmt->execute([
        ':idAlquiler' => $idAlquiler,
        ':fechaInicio' => $fechaInicio,
        ':fechaTope' => $fechaTope,
        ':kilometrajeInicial' => $kilometrajeInicial,
        ':kilometrajeFinal' => $kilometrajeFinal,
        ':idCliente' => $idCliente,
        ':idVehiculo' => $idVehiculo
    ]);
}

// Actualizar un alquiler existente
function actualizarAlquiler($idAlquiler, $fechaInicio, $fechaTope, $kilometrajeInicial, $kilometrajeFinal, $idCliente, $idVehiculo, $pdo)
{
    $stmt = $pdo->prepare("UPDATE Alquiler SET fechaInicio = :fechaInicio, fechaTope = :fechaTope, kilometrajeInicial = :kilometrajeInicial,
                           kilometrajeFinal = :kilometrajeFinal, idCliente = :idCliente, idVehiculo = :idVehiculo
                           WHERE idAlquiler = :idAlquiler");
    $stmt->execute([
        ':idAlquiler' => $idAlquiler,
        ':fechaInicio' => $fechaInicio,
        ':fechaTope' => $fechaTope,
        ':kilometrajeInicial' => $kilometrajeInicial,
        ':kilometrajeFinal' => $kilometrajeFinal,
        ':idCliente' => $idCliente,
        ':idVehiculo' => $idVehiculo
    ]);
}

// Eliminar un alquiler
function eliminarAlquiler($idAlquiler, $pdo)
{
    $stmt = $pdo->prepare("DELETE FROM Alquiler WHERE idAlquiler = :idAlquiler");
    $stmt->execute([':idAlquiler' => $idAlquiler]);
}

// Funciones CRUD para la tabla Incidente

// Obtener todos los incidentes
function obtenerIncidentes($pdo)
{
    $stmt = $pdo->query("SELECT * FROM Incidente");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener un incidente por su ID
function obtenerIncidentePorId($idIncidente, $pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM Incidente WHERE idIncidente = :idIncidente");
    $stmt->execute([':idIncidente' => $idIncidente]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Agregar un nuevo incidente
function agregarIncidente($idIncidente, $daño, $costes, $fecha, $idAlquiler, $pdo)
{
    $stmt = $pdo->prepare("INSERT INTO Incidente (idIncidente, daño, costes, fecha, idAlquiler)
                           VALUES (:idIncidente, :daño, :costes, :fecha, :idAlquiler)");
    $stmt->execute([
        ':idIncidente' => $idIncidente,
        ':daño' => $daño,
        ':costes' => $costes,
        ':fecha' => $fecha,
        ':idAlquiler' => $idAlquiler
    ]);
}

// Actualizar un incidente existente
function actualizarIncidente($idIncidente, $daño, $costes, $fecha, $idAlquiler, $pdo)
{
    $stmt = $pdo->prepare("UPDATE Incidente SET daño = :daño, costes = :costes, fecha = :fecha, idAlquiler = :idAlquiler
                           WHERE idIncidente = :idIncidente");
    $stmt->execute([
        ':idIncidente' => $idIncidente,
        ':daño' => $daño,
        ':costes' => $costes,
        ':fecha' => $fecha,
        ':idAlquiler' => $idAlquiler
    ]);
}

// Eliminar un incidente
function eliminarIncidente($idIncidente, $pdo)
{
    $stmt = $pdo->prepare("DELETE FROM Incidente WHERE idIncidente = :idIncidente");
    $stmt->execute([':idIncidente' => $idIncidente]);
}
