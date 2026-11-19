<?php
// Render public legacy templates from an isolated, read-only content snapshot.
function cems_snapshot() {
    static $database;
    if (!$database) {
        $database = new PDO('sqlite:' . getenv('CEMS_SNAPSHOT'));
        $database->exec('PRAGMA query_only = ON');
        $database->sqliteCreateFunction('datediff', function ($left, $right) {
            if (!$left || !$right || substr($left, 0, 10) === '0000-00-00') return null;
            $a = strtotime(substr($left, 0, 10));
            $b = strtotime(substr($right, 0, 10));
            return ($a === false || $b === false) ? null : (int) round(($a - $b) / 86400);
        }, 2);
    }
    return $database;
}

class recordset {
    public $record_count, $position = 0, $page_size = -1, $eof;
    private $rows;

    public function __construct($sql) {
        if (!preg_match('/^\s*select\b/i', $sql)) throw new RuntimeException('Snapshot queries must be read-only');
        try {
            $this->rows = cems_snapshot()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $error) {
            throw new RuntimeException('Unsupported render query: ' . $sql, 0, $error);
        }
        $this->rows = array_map('array_change_key_case', $this->rows);
        $this->record_count = count($this->rows);
        $this->eof = !$this->record_count;
    }

    public function absolutepage($page) { $this->move($this->page_size * ($page - 1)); }
    public function page_count() { return (int) ceil($this->record_count / $this->page_size); }
    public function move($position) {
        $this->position = max(0, $position);
        $this->eof = $this->position >= $this->record_count;
    }
    public function movenext() { $this->move($this->position + 1); }
    public function movefirst() { $this->move(0); }
    public function field($name) { return $this->rows[$this->position][strtolower($name)] ?? ''; }
}

function execute_sql($sql) { return 0; }
function Authcode($value, $operation = 'DECODE', $key = '', $expiry = 0) {
    return ctype_digit((string) $value) ? (string) $value : '';
}

$target = $argv[1];
parse_str($argv[2] ?? '', $_GET);
$_POST = [];
if (isset($_GET['Page'])) $_POST['Page'] = $_GET['Page'];
$_REQUEST = $_GET;
$_SERVER['PHP_SELF'] = basename($target);
$_SERVER['REQUEST_METHOD'] = 'GET';
chdir(dirname($target));
require $target;
