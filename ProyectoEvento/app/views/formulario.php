<?php
/**
 * Vista del formulario de inscripción.
 */
ob_start();
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header text-white p-4 bg-gradient">
                <h2 class="mb-0 fw-bold"><i class="bi bi-person-plus-fill me-2"></i>Inscripción al Evento Tecnológico</h2>
                <p class="mb-0 opacity-75">Completa tus datos para participar.</p>
            </div>
            <div class="card-body p-4">
                <form method="post" action="index.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Identidad</label>
                            <input type="text" name="identidad" class="form-control" value="<?= htmlspecialchars($datos['identidad'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($datos['nombre'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido</label>
                            <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($datos['apellido'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Edad</label>
                            <input type="number" name="edad" class="form-control" value="<?= htmlspecialchars($datos['edad'] ?? '') ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Sexo</label>
                            <div class="d-flex gap-3">
                                <?php foreach (['Masculino','Femenino','Otro'] as $sexo): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sexo" value="<?= $sexo ?>" <?= (($datos['sexo'] ?? '') === $sexo) ? 'checked' : '' ?>>
                                        <label class="form-check-label"><?= $sexo ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">País de residencia</label>
                            <select name="id_pais_residencia" class="form-select" required>
                                <option value="">Seleccione un país</option>
                                <?php foreach ($paises as $pais): ?>
                                    <option value="<?= (int)$pais['id_pais'] ?>" <?= (($datos['id_pais_residencia'] ?? '') == $pais['id_pais']) ? 'selected' : '' ?>><?= htmlspecialchars($pais['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nacionalidad</label>
                            <select name="id_nacionalidad" class="form-select" required>
                                <option value="">Seleccione una nacionalidad</option>
                                <?php foreach ($paises as $pais): ?>
                                    <option value="<?= (int)$pais['id_pais'] ?>" <?= (($datos['id_nacionalidad'] ?? '') == $pais['id_pais']) ? 'selected' : '' ?>><?= htmlspecialchars($pais['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($datos['correo'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Celular</label>
                            <input type="text" name="celular" class="form-control" value="<?= htmlspecialchars($datos['celular'] ?? '') ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Temas tecnológicos</label>
                            <div class="row g-2">
                                <?php foreach ($areas as $area): ?>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="temas[]" value="<?= (int)$area['id_area'] ?>" <?= in_array((string)$area['id_area'], $temasSeleccionados ?? [], true) ? 'checked' : '' ?>>
                                            <label class="form-check-label"><?= htmlspecialchars($area['nombre']) ?></label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observacion" class="form-control" rows="4" required><?= htmlspecialchars($datos['observacion'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha automática</label>
                            <input type="text" class="form-control" name="fecha_registro" value="<?= date('Y-m-d H:i:s') ?>" readonly>
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Guardar</button>
                            <button type="reset" class="btn btn-outline-secondary px-4"><i class="bi bi-trash me-2"></i>Limpiar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
