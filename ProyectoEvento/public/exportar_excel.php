<?php
/**
 * Exporta los registros a un archivo Excel en formato xlsx.
 */
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/controllers/ParticipanteController.php';

$controller = new ParticipanteController();
$registros = $controller->listarReportes();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="participantes.xlsx"');

$dir = sys_get_temp_dir() . '/participantes_xlsx_' . uniqid();
mkdir($dir, 0777, true);
mkdir($dir . '/_rels', 0777, true);
mkdir($dir . '/xl', 0777, true);
mkdir($dir . '/xl/_rels', 0777, true);
mkdir($dir . '/xl/worksheets', 0777, true);
mkdir($dir . '/docProps', 0777, true);

file_put_contents($dir . '/[Content_Types].xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
  <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
  <Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>
  <Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>
  <Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
</Types>
XML);

file_put_contents($dir . '/_rels/.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>
  <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>
</Relationships>
XML);

file_put_contents($dir . '/docProps/app.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties"
 xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">
  <Application>PHP</Application>
</Properties>
XML);

file_put_contents($dir . '/docProps/core.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties"
 xmlns:dc="http://purl.org/dc/elements/1.1/"
 xmlns:dcterms="http://purl.org/dc/terms/"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <dc:title>Participantes</dc:title>
  <dc:creator>ITECH</dc:creator>
  <cp:revision>1</cp:revision>
</cp:coreProperties>
XML);

file_put_contents($dir . '/xl/styles.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <fonts count="1"><font><sz val="11"/><name val="Calibri"/></font></fonts>
  <fills count="1"><fill><patternFill patternType="none"/></fill></fills>
  <borders count="1"><border/></borders>
  <cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>
  <cellXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/></cellXfs>
  <cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>
</styleSheet>
XML);

$rows = [];
$headers = ['Identidad','Nombre','Apellido','Edad','Sexo','País','Correo','Celular','Temas','Observaciones','Firma','Estado'];
$rows[] = $headers;
foreach ($registros as $registro) {
    $rows[] = [
        $registro['identidad'],
        $registro['nombre'],
        $registro['apellido'],
        $registro['edad'],
        $registro['sexo'],
        $registro['pais'],
        $registro['correo'],
        $registro['celular'],
        $registro['temas'] ?? '',
        $registro['observacion'],
        $registro['firma_openssl'],
        $registro['estado'],
    ];
}

$sheetXml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"></worksheet>');
$sheetData = $sheetXml->addChild('sheetData');
foreach ($rows as $index => $rowValues) {
    $row = $sheetData->addChild('row');
    $row->addAttribute('r', $index + 1);
    foreach ($rowValues as $value) {
        $cell = $row->addChild('c');
        $cell->addAttribute('t', 'inlineStr');
        $is = $cell->addChild('is');
        $t = $is->addChild('t', htmlspecialchars((string)$value, ENT_XML1, 'UTF-8'));
    }
}
file_put_contents($dir . '/xl/worksheets/sheet1.xml', $sheetXml->asXML());

file_put_contents($dir . '/xl/workbook.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"
 xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <sheets>
    <sheet name="Participantes" sheetId="1" r:id="rId1"/>
  </sheets>
</workbook>
XML);

file_put_contents($dir . '/xl/_rels/workbook.xml.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>
XML);

$zip = new ZipArchive();
$zipPath = $dir . '/participantes.xlsx';
$zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
$files = [
    '[Content_Types].xml',
    '_rels/.rels',
    'docProps/app.xml',
    'docProps/core.xml',
    'xl/workbook.xml',
    'xl/_rels/workbook.xml.rels',
    'xl/styles.xml',
    'xl/worksheets/sheet1.xml',
];
foreach ($files as $file) {
    $zip->addFile($dir . '/' . $file, $file);
}
$zip->close();

readfile($zipPath);
unlink($zipPath);
foreach (array_reverse($files) as $file) {
    $path = $dir . '/' . $file;
    if (file_exists($path)) {
        unlink($path);
    }
}
rmdir($dir . '/xl/worksheets');
rmdir($dir . '/xl/_rels');
rmdir($dir . '/xl');
rmdir($dir . '/docProps');
rmdir($dir . '/_rels');
rmdir($dir);
