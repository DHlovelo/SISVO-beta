<?php

require_once __DIR__ . '/../HELPERS/auth.php';
require_once __DIR__ . '/../HELPERS/bitacora.php';

if (!function_exists('adm_h')) {
    function adm_h($valor): string
    {
        return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
    }
}

class AdminController
{
    private const BASE = '/SISVOX/PUBLIC/index.php';
    private const POR_PAGINA = 25;

    private const ENTIDADES = [
        'usuarios' => [
            'titulo'    => 'Usuarios',
            'singular'  => 'usuario',
            'tabla'     => 'nuevo_usu',
            'pk_col'    => 'CI_usu',
            'pk'        => 'CI_usu',
            'select'    => 'CI_usu, nombre_c_usu, telefono, correo, fecha_nacimiento, rol, activo, email_verificado',
            'from'      => 'nuevo_usu',
            'buscar'    => ['CI_usu', 'nombre_c_usu', 'correo'],
            'orden'     => 'nombre_c_usu ASC',
            'eliminable' => false,
            'columnas'  => ['CI_usu' => 'CI', 'nombre_c_usu' => 'Nombre', 'correo' => 'Correo', 'rol' => 'Rol', 'activo' => 'Estado'],
            'campos'    => [
                'nombre_c_usu'     => ['label' => 'Nombre completo', 'tipo' => 'text',   'req' => true,  'max' => 200],
                'telefono'         => ['label' => 'Teléfono',        'tipo' => 'text',   'req' => false, 'max' => 20],
                'correo'           => ['label' => 'Correo',          'tipo' => 'email',  'req' => true,  'max' => 100],
                'fecha_nacimiento' => ['label' => 'Fecha de nacimiento', 'tipo' => 'date', 'req' => true],
                'rol'              => ['label' => 'Rol',             'tipo' => 'select', 'req' => true,
                                       'opciones' => ['usuario' => 'Estudiante', 'institucion' => 'Institución', 'admin' => 'Administrador']],
                'activo'           => ['label' => 'Cuenta',          'tipo' => 'select', 'req' => true,
                                       'opciones' => ['1' => 'Activa', '0' => 'Desactivada']],
                'email_verificado' => ['label' => 'Correo verificado', 'tipo' => 'select', 'req' => true,
                                       'opciones' => ['1' => 'Sí', '0' => 'No']],
            ],
        ],
        'becas' => [
            'titulo'    => 'Becas',
            'singular'  => 'beca',
            'tabla'     => 'becas',
            'pk_col'    => 'id',
            'pk'        => 'b.id',
            'select'    => 'b.id, b.CI_usu, b.titulo, b.descripcion, b.requisitos, b.fecha_cierre, b.created_at, i.nombre_institucion',
            'from'      => 'becas b LEFT JOIN instituciones i ON i.CI_usu = b.CI_usu',
            'buscar'    => ['b.titulo', 'i.nombre_institucion'],
            'orden'     => 'b.created_at DESC',
            'eliminable' => true,
            'columnas'  => ['id' => '#', 'titulo' => 'Título', 'nombre_institucion' => 'Institución', 'fecha_cierre' => 'Cierre'],
            'campos'    => [
                'titulo'       => ['label' => 'Título',       'tipo' => 'text',     'req' => true,  'max' => 200],
                'descripcion'  => ['label' => 'Descripción',  'tipo' => 'textarea', 'req' => false, 'max' => 5000],
                'requisitos'   => ['label' => 'Requisitos',   'tipo' => 'textarea', 'req' => false, 'max' => 5000],
                'fecha_cierre' => ['label' => 'Fecha de cierre', 'tipo' => 'date',  'req' => true],
            ],
        ],
        'convocatorias' => [
            'titulo'    => 'Convocatorias',
            'singular'  => 'convocatoria',
            'tabla'     => 'convocatorias',
            'pk_col'    => 'id',
            'pk'        => 'c.id',
            'select'    => 'c.id, c.CI_usu, c.titulo, c.categoria, c.descripcion, c.fecha_cierre, c.created_at, i.nombre_institucion',
            'from'      => 'convocatorias c LEFT JOIN instituciones i ON i.CI_usu = c.CI_usu',
            'buscar'    => ['c.titulo', 'c.categoria', 'i.nombre_institucion'],
            'orden'     => 'c.created_at DESC',
            'eliminable' => true,
            'columnas'  => ['id' => '#', 'titulo' => 'Título', 'categoria' => 'Categoría', 'nombre_institucion' => 'Institución', 'fecha_cierre' => 'Cierre'],
            'campos'    => [
                'titulo'       => ['label' => 'Título',    'tipo' => 'text',     'req' => true,  'max' => 200],
                'categoria'    => ['label' => 'Categoría', 'tipo' => 'text',     'req' => true,  'max' => 100],
                'descripcion'  => ['label' => 'Descripción', 'tipo' => 'textarea', 'req' => false, 'max' => 5000],
                'fecha_cierre' => ['label' => 'Fecha de cierre', 'tipo' => 'date', 'req' => true],
            ],
        ],
        'instituciones' => [
            'titulo'    => 'Instituciones',
            'singular'  => 'institución',
            'tabla'     => 'instituciones',
            'pk_col'    => 'id',
            'pk'        => 'i.id',
            'select'    => 'i.id, i.CI_usu, i.nombre_institucion, i.nit, i.telefono, i.verificado',
            'from'      => 'instituciones i',
            'buscar'    => ['i.nombre_institucion', 'i.nit'],
            'orden'     => 'i.verificado ASC, i.nombre_institucion ASC',
            'eliminable' => false,
            'columnas'  => ['id' => '#', 'nombre_institucion' => 'Nombre', 'nit' => 'NIT', 'telefono' => 'Teléfono', 'verificado' => 'Verificación'],
            'campos'    => [
                'nombre_institucion' => ['label' => 'Nombre', 'tipo' => 'text', 'req' => true,  'max' => 150],
                'nit'                => ['label' => 'NIT',    'tipo' => 'text', 'req' => false, 'max' => 50],
                'telefono'           => ['label' => 'Teléfono', 'tipo' => 'text', 'req' => false, 'max' => 20],
                'verificado'         => ['label' => 'Verificación', 'tipo' => 'select', 'req' => true,
                                         'opciones' => ['0' => 'Pendiente', '1' => 'Verificada']],
            ],
        ],
        'directorio' => [
            'titulo'    => 'Directorio de universidades',
            'singular'  => 'universidad',
            'tabla'     => 'directorio_instituciones',
            'pk_col'    => 'id',
            'pk'        => 'd.id',
            'select'    => 'd.id, d.categoria, d.sigla, d.nombre, d.tipo, d.regimen, d.anio_creacion, d.sedes, d.direccion, d.telefono, d.sitio_web, d.observaciones',
            'from'      => 'directorio_instituciones d',
            'buscar'    => ['d.nombre', 'd.sigla', 'd.sedes'],
            'orden'     => "d.categoria ASC, (d.tipo = 'Pública') DESC, (d.tipo = 'Privada') DESC, d.nombre ASC",
            // No se elimina desde aquí: borrar una universidad borraría en cascada todas sus carreras (institucion_carrera)
            'eliminable' => false,
            'columnas'  => ['id' => '#', 'sigla' => 'Sigla', 'nombre' => 'Nombre', 'tipo' => 'Tipo', 'categoria' => 'Categoría', 'telefono' => 'Teléfono'],
            'campos'    => [
                'categoria'     => ['label' => 'Categoría', 'tipo' => 'select', 'req' => true,
                                    'opciones' => ['universidad' => 'Universidad', 'instituto' => 'Instituto']],
                'sigla'         => ['label' => 'Sigla',            'tipo' => 'text',     'req' => false, 'max' => 30,  'nullable' => true],
                'nombre'        => ['label' => 'Nombre',           'tipo' => 'text',     'req' => true,  'max' => 200],
                'tipo'          => ['label' => 'Tipo (Pública, Privada, Especial…)', 'tipo' => 'text', 'req' => false, 'max' => 30, 'nullable' => true],
                'anio_creacion' => ['label' => 'Año de creación', 'tipo' => 'text',     'req' => false, 'max' => 80,  'nullable' => true],
                'telefono'      => ['label' => 'Teléfono',         'tipo' => 'text',     'req' => false, 'max' => 80,  'nullable' => true],
                'sitio_web'     => ['label' => 'Sitio web',        'tipo' => 'text',     'req' => false, 'max' => 150, 'nullable' => true],
                'regimen'       => ['label' => 'Régimen',          'tipo' => 'textarea', 'req' => false, 'max' => 5000, 'nullable' => true],
                'sedes'         => ['label' => 'Sedes',            'tipo' => 'textarea', 'req' => false, 'max' => 5000, 'nullable' => true],
                'direccion'     => ['label' => 'Dirección',        'tipo' => 'textarea', 'req' => false, 'max' => 5000, 'nullable' => true],
                'observaciones' => ['label' => 'Observaciones',    'tipo' => 'textarea', 'req' => false, 'max' => 5000, 'nullable' => true],
            ],
        ],
    ];

    private PDO $pdo;
    private array $admin = [];

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
        $this->verificarAdmin();
    }

    /* ===================== Seguridad ===================== */

    /** Comprueba en la base de datos (no solo en la sesión) que sigue siendo un admin activo. */
    private function verificarAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $ci = $_SESSION['CI_usu'] ?? null;
        if (!$ci) {
            $this->ir('login');
        }

        try {
            $stmt = $this->pdo->prepare('SELECT CI_usu, nombre_c_usu, rol, activo FROM nuevo_usu WHERE CI_usu = ?');
            $stmt->execute([$ci]);
            $u = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('[admin] ' . $e->getMessage());
            http_response_code(500);
            exit('Falta preparar la base de datos: ejecuta config/migracion_admin_bitacora.sql en phpMyAdmin.');
        }

        if (!$u || $u['rol'] !== 'admin' || (int) $u['activo'] !== 1) {
            bitacora_registrar_seguro('acceso_denegado', 'ruta', $_GET['route'] ?? '', null, null,
                'Intento de acceso al panel de administración');
            $this->ir('home');
        }

        $this->admin = ['ci' => $u['CI_usu'], 'nombre' => $u['nombre_c_usu'], 'rol' => 'admin'];
    }

    private function exigirPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Método no permitido.');
        }
        if (!csrf_validar()) {
            bitacora_registrar_seguro('csrf_invalido', 'ruta', $_GET['route'] ?? '', null, null, 'Token CSRF inválido o ausente');
            http_response_code(403);
            exit('Solicitud no válida. Vuelve atrás, recarga la página e inténtalo de nuevo.');
        }
    }

    /* ===================== Utilidades ===================== */

    private function ir(string $route, array $query = []): void
    {
        $query = array_merge(['route' => $route], $query);
        header('Location: ' . self::BASE . '?' . http_build_query($query));
        exit;
    }

    private function flash(string $tipo, string $mensaje): void
    {
        $_SESSION['admin_flash'] = ['tipo' => $tipo, 'msg' => $mensaje];
    }

    private function entidad(?string $e): array
    {
        if ($e === null || !isset(self::ENTIDADES[$e])) {
            $this->flash('error', 'Sección no válida.');
            $this->ir('admin_dashboard');
        }
        return self::ENTIDADES[$e];
    }

    private function buscarFila(array $cfg, string $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT {$cfg['select']} FROM {$cfg['from']} WHERE {$cfg['pk']} = ? LIMIT 1");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    /** @return array{0: array, 1: array} [datos válidos, errores] */
    private function validar(array $cfg, array $entrada): array
    {
        $datos = [];
        $errores = [];

        foreach ($cfg['campos'] as $campo => $def) {
            $valor = $entrada[$campo] ?? '';
            $valor = is_string($valor) ? trim($valor) : '';
            $etq = $def['label'];

            if ($valor === '') {
                if (!empty($def['req'])) {
                    $errores[] = "«{$etq}» es obligatorio.";
                }
                $datos[$campo] = '';
                continue;
            }

            switch ($def['tipo']) {
                case 'email':
                    if (!filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                        $errores[] = "«{$etq}» no es un correo válido.";
                    }
                    break;
                case 'date':
                    $p = explode('-', $valor);
                    if (count($p) !== 3 || !ctype_digit(implode('', $p)) || !checkdate((int) $p[1], (int) $p[2], (int) $p[0])) {
                        $errores[] = "«{$etq}» no es una fecha válida.";
                    }
                    break;
                case 'select':
                    if (!array_key_exists($valor, $def['opciones'])) {
                        $errores[] = "«{$etq}» tiene un valor no permitido.";
                    }
                    break;
            }

            if (isset($def['max']) && mb_strlen($valor) > $def['max']) {
                $errores[] = "«{$etq}» no puede superar {$def['max']} caracteres.";
            }

            $datos[$campo] = $valor;
        }

        return [$datos, $errores];
    }

    /* ===================== Páginas ===================== */

    public function index(): void
    {
        $conteo = fn(string $sql) => (int) $this->pdo->query($sql)->fetchColumn();

        $stats = [
            'usuarios'        => $conteo("SELECT COUNT(*) FROM nuevo_usu"),
            'admins'          => $conteo("SELECT COUNT(*) FROM nuevo_usu WHERE rol = 'admin' AND activo = 1"),
            'inst_pendientes' => $conteo("SELECT COUNT(*) FROM instituciones WHERE verificado = 0"),
            'becas'           => $conteo("SELECT COUNT(*) FROM becas"),
            'convocatorias'   => $conteo("SELECT COUNT(*) FROM convocatorias"),
            'directorio'      => $conteo("SELECT COUNT(*) FROM directorio_instituciones"),
        ];

        $bitacoraLista = true;
        $ultimos = [];
        $fallidos24h = 0;
        try {
            $fallidos24h = $conteo("SELECT COUNT(*) FROM bitacora WHERE accion = 'login_fallido' AND fecha >= NOW() - INTERVAL 1 DAY");
            $ultimos = $this->pdo->query("SELECT * FROM bitacora ORDER BY id DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $bitacoraLista = false;
        }

        $admin = $this->admin;
        require __DIR__ . '/../../VIEWS/ADMIN/dashboard.php';
    }

    public function listado(): void
    {
        $e = $_GET['e'] ?? null;
        $cfg = $this->entidad($e);

        $q = trim((string) ($_GET['q'] ?? ''));
        $pagina = max(1, (int) ($_GET['p'] ?? 1));

        $where = '';
        $params = [];
        if ($q !== '') {
            $like = '%' . addcslashes($q, '%_\\') . '%';
            $partes = [];
            foreach ($cfg['buscar'] as $col) {
                $partes[] = "$col LIKE ?";
                $params[] = $like;
            }
            $where = 'WHERE (' . implode(' OR ', $partes) . ')';
        }

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$cfg['from']} $where");
        $stmt->execute($params);
        $total = (int) $stmt->fetchColumn();
        $paginas = max(1, (int) ceil($total / self::POR_PAGINA));
        $pagina = min($pagina, $paginas);
        $offset = ($pagina - 1) * self::POR_PAGINA;

        $stmt = $this->pdo->prepare(
            "SELECT {$cfg['select']} FROM {$cfg['from']} $where ORDER BY {$cfg['orden']} LIMIT " . self::POR_PAGINA . " OFFSET $offset"
        );
        $stmt->execute($params);
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $admin = $this->admin;
        require __DIR__ . '/../../VIEWS/ADMIN/listado.php';
    }

    public function editar(): void
    {
        $e = $_GET['e'] ?? null;
        $cfg = $this->entidad($e);

        $fila = $this->buscarFila($cfg, (string) ($_GET['id'] ?? ''));
        if (!$fila) {
            $this->flash('error', 'Registro no encontrado.');
            $this->ir('admin_listado', ['e' => $e]);
        }

        $errores = [];
        $admin = $this->admin;
        require __DIR__ . '/../../VIEWS/ADMIN/editar.php';
    }

    public function guardar(): void
    {
        $this->exigirPost();

        $e = $_POST['e'] ?? null;
        $cfg = $this->entidad($e);
        $id = (string) ($_POST['id'] ?? '');

        $actual = $this->buscarFila($cfg, $id);
        if (!$actual) {
            $this->flash('error', 'Registro no encontrado.');
            $this->ir('admin_listado', ['e' => $e]);
        }

        [$datos, $errores] = $this->validar($cfg, $_POST);
        $nuevaClave = null;

        if ($e === 'usuarios' && !$errores) {
            // No dejar el sistema sin administradores ni bloquearse a uno mismo
            if ($id === (string) $this->admin['ci'] && ($datos['rol'] !== 'admin' || $datos['activo'] !== '1')) {
                $errores[] = 'No puedes quitarte el rol de administrador ni desactivar tu propia cuenta.';
            }

            $dup = $this->pdo->prepare('SELECT COUNT(*) FROM nuevo_usu WHERE correo = ? AND CI_usu <> ?');
            $dup->execute([$datos['correo'], $id]);
            if ((int) $dup->fetchColumn() > 0) {
                $errores[] = 'Ese correo ya pertenece a otra cuenta.';
            }

            $clave = (string) ($_POST['nueva_contrasena'] ?? '');
            if ($clave !== '') {
                if (mb_strlen($clave) < 8) {
                    $errores[] = 'La nueva contraseña debe tener al menos 8 caracteres.';
                } else {
                    $nuevaClave = password_hash($clave, PASSWORD_DEFAULT);
                }
            }
        }

        if ($errores) {
            $fila = array_merge($actual, $datos);
            $admin = $this->admin;
            require __DIR__ . '/../../VIEWS/ADMIN/editar.php';
            return;
        }

        // Solo los campos que realmente cambiaron
        $antes = [];
        $despues = [];
        foreach ($datos as $campo => $valor) {
            if ((string) $actual[$campo] !== (string) $valor) {
                $antes[$campo] = $actual[$campo];
                $despues[$campo] = $valor;
            }
        }
        if (!$antes && $nuevaClave === null) {
            $this->flash('info', 'No hiciste ningún cambio.');
            $this->ir('admin_listado', ['e' => $e]);
        }

        try {
            $this->pdo->beginTransaction();

            $sets = [];
            $vals = [];
            foreach (array_keys($despues) as $campo) {
                $sets[] = "$campo = ?";
                $vals[] = ($datos[$campo] === '' && !empty($cfg['campos'][$campo]['nullable']))
                    ? null
                    : $datos[$campo];
            }
            if ($nuevaClave !== null) {
                $sets[] = 'contrasena = ?';
                $vals[] = $nuevaClave;
            }
            $vals[] = $id;

            $this->pdo->prepare("UPDATE {$cfg['tabla']} SET " . implode(', ', $sets) . " WHERE {$cfg['pk_col']} = ?")
                ->execute($vals);

            // La contraseña nunca se guarda en la bitácora; solo queda constancia del restablecimiento
            $detalle = $nuevaClave !== null ? 'Contraseña restablecida por el administrador' : null;
            bitacora_registrar('editar', $e, $id, $antes, $despues, $detalle, $this->admin);

            $this->pdo->commit();
        } catch (Throwable $ex) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log('[admin] ' . $ex->getMessage());
            $this->flash('error', 'No se pudo guardar el cambio. No se modificó nada.');
            $this->ir('admin_listado', ['e' => $e]);
        }

        $this->flash('ok', 'Cambios guardados y registrados en la bitácora.');
        $this->ir('admin_listado', ['e' => $e]);
    }

    public function eliminar(): void
    {
        $this->exigirPost();

        $e = $_POST['e'] ?? null;
        $cfg = $this->entidad($e);
        if (empty($cfg['eliminable'])) {
            http_response_code(403);
            exit('Esta sección no permite eliminar registros.');
        }

        $id = (string) ($_POST['id'] ?? '');
        $actual = $this->buscarFila($cfg, $id);
        if (!$actual) {
            $this->flash('error', 'Registro no encontrado.');
            $this->ir('admin_listado', ['e' => $e]);
        }

        try {
            $this->pdo->beginTransaction();
            $this->pdo->prepare("DELETE FROM {$cfg['tabla']} WHERE {$cfg['pk_col']} = ?")->execute([$id]);
            bitacora_registrar('eliminar', $e, $id, $actual, null, 'Registro eliminado', $this->admin);
            $this->pdo->commit();
        } catch (Throwable $ex) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log('[admin] ' . $ex->getMessage());
            $this->flash('error', 'No se pudo eliminar. No se modificó nada.');
            $this->ir('admin_listado', ['e' => $e]);
        }

        $this->flash('ok', 'Registro eliminado (queda copia de sus datos en la bitácora).');
        $this->ir('admin_listado', ['e' => $e]);
    }

    /* ===================== Bitácora ===================== */

    private function filtrosBitacora(): array
    {
        $f = [
            'desde'   => trim((string) ($_GET['desde'] ?? '')),
            'hasta'   => trim((string) ($_GET['hasta'] ?? '')),
            'q'       => trim((string) ($_GET['q'] ?? '')),
            'accion'  => trim((string) ($_GET['accion'] ?? '')),
            'entidad' => trim((string) ($_GET['entidad'] ?? '')),
        ];

        $where = [];
        $params = [];

        $esFecha = fn(string $s) => (bool) preg_match('/^\d{4}-\d{2}-\d{2}$/', $s);
        if ($esFecha($f['desde'])) {
            $where[] = 'fecha >= ?';
            $params[] = $f['desde'] . ' 00:00:00';
        }
        if ($esFecha($f['hasta'])) {
            $where[] = 'fecha <= ?';
            $params[] = $f['hasta'] . ' 23:59:59';
        }
        if ($f['q'] !== '') {
            $like = '%' . addcslashes($f['q'], '%_\\') . '%';
            $where[] = '(nombre LIKE ? OR CI_usu LIKE ? OR detalle LIKE ? OR entidad_id LIKE ?)';
            array_push($params, $like, $like, $like, $like);
        }
        if ($f['accion'] !== '') {
            $where[] = 'accion = ?';
            $params[] = $f['accion'];
        }
        if ($f['entidad'] !== '') {
            $where[] = 'entidad = ?';
            $params[] = $f['entidad'];
        }

        return [$f, $where ? 'WHERE ' . implode(' AND ', $where) : '', $params];
    }

    public function bitacora(): void
    {
        [$filtros, $where, $params] = $this->filtrosBitacora();
        $pagina = max(1, (int) ($_GET['p'] ?? 1));

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM bitacora $where");
        $stmt->execute($params);
        $total = (int) $stmt->fetchColumn();
        $paginas = max(1, (int) ceil($total / self::POR_PAGINA));
        $pagina = min($pagina, $paginas);
        $offset = ($pagina - 1) * self::POR_PAGINA;

        $stmt = $this->pdo->prepare("SELECT * FROM bitacora $where ORDER BY id DESC LIMIT " . self::POR_PAGINA . " OFFSET $offset");
        $stmt->execute($params);
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $acciones = $this->pdo->query('SELECT DISTINCT accion FROM bitacora ORDER BY accion')->fetchAll(PDO::FETCH_COLUMN);
        $entidades = $this->pdo->query("SELECT DISTINCT entidad FROM bitacora WHERE entidad IS NOT NULL ORDER BY entidad")->fetchAll(PDO::FETCH_COLUMN);

        $admin = $this->admin;
        require __DIR__ . '/../../VIEWS/ADMIN/bitacora.php';
    }

    public function bitacoraCsv(): void
    {
        [$filtros, $where, $params] = $this->filtrosBitacora();

        $stmt = $this->pdo->prepare("SELECT * FROM bitacora $where ORDER BY id DESC LIMIT 5000");
        $stmt->execute($params);

        // La exportación también queda registrada
        bitacora_registrar_seguro('exportar_bitacora', 'bitacora', null, null, null,
            'Filtros: ' . json_encode(array_filter($filtros), JSON_UNESCAPED_UNICODE), $this->admin);

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="bitacora_' . date('Ymd_His') . '.csv"');
        echo "\xEF\xBB\xBF";

        $out = fopen('php://output', 'w');
        fputcsv($out, ['id', 'fecha', 'CI', 'nombre', 'rol', 'accion', 'entidad', 'entidad_id', 'detalle', 'datos_antes', 'datos_despues', 'ip']);

        // Evita inyección de fórmulas al abrir el CSV en Excel
        $seguro = function ($v) {
            $v = (string) $v;
            return ($v !== '' && strpos("=+-@\t\r", $v[0]) !== false) ? "'" . $v : $v;
        };

        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($out, array_map($seguro, [
                $r['id'], $r['fecha'], $r['CI_usu'], $r['nombre'], $r['rol'], $r['accion'],
                $r['entidad'], $r['entidad_id'], $r['detalle'], $r['datos_antes'], $r['datos_despues'], $r['ip'],
            ]));
        }
        fclose($out);
        exit;
    }
}