<?php
/**
 * Aplicación web en PHP para madres cabeza de hogar en servicios de belleza.
 * Contempla inicio de sesión, registro, recuperación de contraseña,
 * y un menú principal con múltiples funcionalidades.
 * Basado en un modelo entidad-relación detallado.
 */

// Configuración básica de conexión a base de datos
class Database {
    private $host = "localhost";
    private $db_name = "beauty_app";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

// Clase User: Manejo de Clientes y Agentes
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $email;
    public $password;
    public $role; // CLIENT o AGENT

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo usuario
    public function register() {
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', password_hash($this->password, PASSWORD_BCRYPT));
        $stmt->bindParam(':role', $this->role);

        return $stmt->execute();
    }

    // Método para iniciar sesión
    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($this->password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Método para recuperar contraseña
    public function recoverPassword($new_password) {
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':password', password_hash($new_password, PASSWORD_BCRYPT));
        $stmt->bindParam(':email', $this->email);

        return $stmt->execute();
    }
}

// Página de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->role = $_POST['role'];

    if ($user->register()) {
        echo "<p>Registro exitoso. ¡Bienvenido!</p>";
    } else {
        echo "<p>Error en el registro. Intenta de nuevo.</p>";
    }
}

// Página de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    $logged_in_user = $user->login();

    if ($logged_in_user) {
        echo "<p>Bienvenido, " . $logged_in_user['name'] . "</p>";
    } else {
        echo "<p>Credenciales incorrectas.</p>";
    }
}

// Página de recuperación de contraseña
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['recover'])) {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->email = $_POST['email'];

    $new_password = substr(md5(time()), 0, 8);

    if ($user->recoverPassword($new_password)) {
        // Enviar correo (simplificado)
        mail($user->email, "Recuperación de contraseña", "Tu nueva contraseña es: " . $new_password);
        echo "<p>Nueva contraseña enviada a tu correo.</p>";
    } else {
        echo "<p>Error al recuperar la contraseña. Verifica tu correo.</p>";
    }
}

// Menú principal
function displayMenu() {
    echo "<ul>
            <li><a href='agenda.php'>Agenda</a></li>
            <li><a href='services.php'>Servicios</a></li>
            <li><a href='clients.php'>Clientes recurrentes</a></li>
            <li><a href='map.php'>Mapa de servicios</a></li>
            <li><a href='chat.php'>Chat en línea</a></li>
            <li><a href='info.php'>Información</a></li>
            <li><a href='settings.php'>Configuración</a></li>
            <li><a href='status.php'>Ponerme en línea</a></li>
            <li><a href='partners.php'>Socios y proveedores</a></li>
            <li><a href='logout.php'>Cerrar sesión</a></li>
        </ul>";
}

?>