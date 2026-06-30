<?php
/**
 * Vista del reporte de participantes.
 */
ob_start();
?>
<div class="card shadow-lg border-0 rounded-4 overflow-hidden">
    <div class="card-header bg-gradient text-white p-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0 fw-bold"><i class="bi bi-clipboard-data me-2"></i>Reporte de Participantes</h2>
                <p class="mb-0 opacity-75">Listado completo con firma y estado de integridad.</p>
            </div>
            <a href="exportar_excel.php" class="btn btn-light"><i class="bi bi-file-earmark-excel me-2"></i>Exportar Excel</a>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Identidad</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Edad</th>
                        <th>Sexo</th>
                        <th>País</th>
                        <th>Nacionalidad</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Temas</th>
                        <th>Observaciones</th>
                        <th>Firma</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros as $registro): ?>
                        <tr>
                            <td><?= htmlspecialchars($registro['identidad']) ?></td>
                            <td><?= htmlspecialchars($registro['nombre']) ?></td>
                            <td><?= htmlspecialchars($registro['apellido']) ?></td>
                            <td><?= (int)$registro['edad'] ?></td>
                            <td><?= htmlspecialchars($registro['sexo']) ?></td>
                            <td><?= htmlspecialchars($registro['pais']) ?></td>
                            <td><?= htmlspecialchars($registro['nacionalidad'] ?? '') ?></td>
                            <td><?= htmlspecialchars($registro['correo']) ?></td>
                            <td><?= htmlspecialchars($registro['celular']) ?></td>
                            <td><?= htmlspecialchars($registro['temas'] ?? '') ?></td>
                            <td><?= htmlspecialchars($registro['observaciones'] ?? '') ?></td>
                            <td class="small text-break"><?= htmlspecialchars($registro['firma_openssl']) ?></td>
                            <td><?= htmlspecialchars(TextoHelper::formatearFecha($registro['fecha_registro'] ?? null)) ?></td>
                            <td><span class="fw-bold <?= $registro['estado_clase'] ?>"><?= htmlspecialchars($registro['estado']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
