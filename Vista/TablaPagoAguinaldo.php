<?php 
if (session_status() == PHP_SESSION_NONE) { 
    session_start(); 
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null; 
} 
require_once '../Config/config.php'; 
?> 
<!DOCTYPE html> 
<html lang="es"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>PassWize - Lista Pago Aguinaldo</title> 
    <link rel="icon" type="image/png" href="../img/icono.png"> 
    <link rel="stylesheet" href="Estilos/TablaPagoAguinaldo.css"> 
    <link rel="stylesheet" href="Estilos/Footer2.css"> 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> 
</head> 
<body> 
    <header> 
        <?php include 'header.php'; ?> 
    </header> 
    <div class="container-tablapagoaguinaldo"> 
        <h1 class="titulo-listaEmpleados">Lista Pago Aguinaldo</h1> 
        <select id="select-empleado" name="select-empleado"> 
            <option value="">Seleccione un Empleado</option> 
            <?php 
            require_once '../Config/config.php'; 
            try { 
                $conn = getConnection(); 
                $sql = "SELECT DISTINCT Empleados_Persona_Cedula1 FROM aguinaldo"; 
                $stmt = $conn->query($sql); 
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                    echo "<option value='{$row['Empleados_Persona_Cedula1']}'>{$row['Empleados_Persona_Cedula1']}</option>"; 
                } 
            } catch (PDOException $e) { 
                echo "<option value=''>Error al cargar empleados</option>"; 
            } finally { 
                $conn = null; 
            } 
            ?> 
        </select> 
        <button id="select-aguinaldo">Seleccionar</button> 
        <table id="tabla-aguinaldo"> 
            <thead> 
                <tr> 
                    <th>Cédula Empleado</th> 
                    <th>Fecha</th> 
                    <th>Monto a Pagar</th> 
                    <th>Acciones</th> 
                </tr> 
            </thead> 
            <tbody id="cuerpo-tabla"> 
                <?php 
                try { 
                    $conn = getConnection(); 
                    $sql = "SELECT * FROM aguinaldo"; 
                    $stmt = $conn->query($sql); 
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                        echo "<tr>"; 
                        echo "<td>{$row['Empleados_Persona_Cedula1']}</td>"; 
                        echo "<td>{$row['Meses']}</td>"; 
                        echo "<td>₡ {$row['Monto_A_Pagar']}</td>"; 
                        echo "<td>
                                <button class='editar-btn' data-cedula='{$row['Empleados_Persona_Cedula1']}'>Editar</button>
                                <button class='eliminar-btn' data-cedula='{$row['Empleados_Persona_Cedula1']}'>Eliminar</button>
                              </td>"; 
                        echo "</tr>"; 
                    } 
                } catch (PDOException $e) { 
                    echo "<tr><td colspan='4'>Error al cargar datos</td></tr>"; 
                } finally { 
                    $conn = null; 
                } 
                ?> 
            </tbody> 
        </table> 
    </div> 
    <script> 
        document.getElementById('select-aguinaldo').addEventListener('click', function() { 
            const cedula = document.getElementById('select-empleado').value; 
            const tbody = document.getElementById('cuerpo-tabla'); 
            if (cedula) { 
                fetch(`../Controlador/ObtenerAguinaldoPorEmpleado.php?cedula=${cedula}`) 
                    .then(response => response.json()) 
                    .then(data => { 
                        tbody.innerHTML = ''; 
                        if (data.length > 0) { 
                            data.forEach(row => { 
                                const tr = document.createElement('tr'); 
                                tr.innerHTML = ` 
                                    <td>${row.Empleados_Persona_Cedula1}</td> 
                                    <td>${row.Meses}</td> 
                                    <td>₡ ${row.Monto_A_Pagar}</td> 
                                    <td>
                                        <button class='editar-btn' data-cedula='${row.Empleados_Persona_Cedula1}'>Editar</button>
                                        <button class='eliminar-btn' data-cedula='${row.Empleados_Persona_Cedula1}'>Eliminar</button>
                                    </td>
                                `; 
                                tbody.appendChild(tr); 
                            }); 
                        } else { 
                            tbody.innerHTML = '<tr><td colspan="4">No se encontraron datos</td></tr>'; 
                        } 
                    }) 
                    .catch(error => { 
                        console.error('Error al obtener los datos:', error); 
                        tbody.innerHTML = '<tr><td colspan="4">Error al obtener los datos</td></tr>'; 
                    }); 
            } else { 
                Swal.fire("Error", "No se ha seleccionado una cédula", "error"); 
            } 
        }); 

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.eliminar-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const cedula = this.getAttribute('data-cedula');
                    Swal.fire({
                        title: 'Confirmar eliminación',
                        text: "¿Estás seguro de que deseas eliminar este registro?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#9fc131',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`../Controlador/EliminarTablaAguinaldo.php?cedula=${cedula}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire('Eliminado', 'El registro ha sido eliminado', 'success')
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire('Error', 'Error al eliminar el registro', 'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error al eliminar el registro:', error);
                                    Swal.fire('Error', 'Error al eliminar el registro', 'error');
                                });
                        }
                    });
                });
            });

            document.querySelectorAll('.editar-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const cedula = this.getAttribute('data-cedula');
                    const today = new Date().toISOString().split('T')[0];
                    
                    Swal.fire({
                        title: 'Editar Registro',
                        confirmButtonColor: '#9fc131',
                        cancelButtonColor: '#d33',
                        html: `
                            <label for="fecha">Fecha:</label>
                            <input type="date" id="fecha" class="swal2-input" value="${today}" min="${today}" max="${today}">
                            <label for="monto">Monto:</label>
                            <input type="number" id="monto" class="swal2-input">
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Guardar',
                        cancelButtonText: 'Cancelar',
                        preConfirm: () => {
                            const fecha = Swal.getPopup().querySelector('#fecha').value;
                            const monto = Swal.getPopup().querySelector('#monto').value;
                            if (!fecha || !monto) {
                                Swal.showValidationMessage('Por favor ingrese ambos valores');
                            }
                            return { fecha, monto };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const { fecha, monto } = result.value;
                            const formData = new FormData();
                            formData.append('cedula', cedula);
                            formData.append('fecha', fecha);
                            formData.append('monto', monto);

                            fetch('../Controlador/EditarTablaAguinaldo.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    Swal.fire('Guardado', 'El registro ha sido editado', 'success')
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire('Error', 'Error al editar el registro', 'error');
                                }
                            })
                            .catch(error => console.error('Error al editar el registro:', error));
                        }
                    });
                });
            });
        });
    </script> 
</body> 
<footer id="footer"></footer> 
<script src="../JS/footer.js"></script> 
</html>