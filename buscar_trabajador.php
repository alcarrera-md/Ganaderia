<?php
include 'conexion.php';

$q = isset($_GET['q']) ? "%" . $_GET['q'] . "%" : "%";

$query = "SELECT t.*, 
                 (SELECT a.tarea 
                  FROM asignaciones a 
                  WHERE a.trabajador_id = t.id 
                  ORDER BY a.fecha_asignacion DESC 
                  LIMIT 1) AS ultima_tarea,
                 (SELECT a.fecha_asignacion 
                  FROM asignaciones a 
                  WHERE a.trabajador_id = t.id 
                  ORDER BY a.fecha_asignacion DESC 
                  LIMIT 1) AS ultima_fecha,
                 (SELECT c.nombre 
                  FROM corrales c
                  JOIN asignaciones a ON a.corral_id = c.id
                  WHERE a.trabajador_id = t.id 
                  ORDER BY a.fecha_asignacion DESC 
                  LIMIT 1) AS corral
          FROM trabajadores t
          WHERE t.nombre LIKE ?";

$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $q);
$stmt->execute();
$result = $stmt->get_result();

while ($trabajador = $result->fetch_assoc()):
?>
    <tr>
        <td><?php echo htmlspecialchars($trabajador['nombre']); ?></td>
        <td><?php echo $trabajador['ultima_tarea'] ?: 'N/A'; ?></td>
        <td><?php echo $trabajador['ultima_fecha'] ?: 'N/A'; ?></td>
        <td><?php echo !empty($trabajador['corral']) ? htmlspecialchars($trabajador['corral']) : 'N/A'; ?></td>
        <td>
            <a href="form_trabajador.php?id=<?php echo $trabajador['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
            <a href="eliminar_trabajador.php?id=<?php echo $trabajador['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este trabajador?');">Eliminar</a>
        </td>
    </tr>
<?php endwhile; ?>
