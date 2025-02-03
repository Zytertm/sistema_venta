<?php
$conexion = mysqli_connect("localhost", "usuario", "contraseña", "dbventasdemo"); // Reemplaza con tus credenciales

if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


$termino_busqueda = isset($_GET['termino_busqueda']) ? $_GET['termino_busqueda'] : ''; // Manejar si no se envía término

$consulta = "SELECT p.Codigo, p.Nombre, p.Descripcion, c.Descripcion AS Categoria, p.Stock, p.PrecioVenta 
             FROM PRODUCTO p
             INNER JOIN CATEGORIA c ON p.IdCategoria = c.IdCategoria
             WHERE p.Codigo LIKE '%$termino_busqueda%' OR p.Nombre LIKE '%$termino_busqueda%' OR c.Descripcion LIKE '%$termino_busqueda%'"; // Incluir categoría en la búsqueda

$resultados = mysqli_query($conexion, $consulta);

if ($resultados) {
    echo "<table>";
    echo "<thead><tr><th>Código</th><th>Nombre</th><th>Descripción</th><th>Categoría</th><th>Stock</th><th>Precio Venta</th></tr></thead>";
    echo "<tbody>";
    if (mysqli_num_rows($resultados) > 0) {
        while ($fila = mysqli_fetch_assoc($resultados)) {
            echo "<tr>";
            echo "<td>" . $fila['Codigo'] . "</td>";
            echo "<td>" . $fila['Nombre'] . "</td>";
            echo "<td>" . $fila['Descripcion'] . "</td>";
            echo "<td>" . $fila['Categoria'] . "</td>"; // Mostrar la categoría
            echo "<td>" . $fila['Stock'] . "</td>";
            echo "<td>" . $fila['PrecioVenta'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No se encontraron productos.</td></tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "Error en la consulta: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>