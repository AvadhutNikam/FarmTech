<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// This path is correct
include dirname(__DIR__, 2) . '/database/constants.php';

/**
 * Admin Class - Corrected for Security
 */
class Admin
{
    private $con;

    public function __construct()
    {
        $this->con = new mysqli(HOST, USER, PASSWORD, DB);
        if ($this->con->connect_error) {
            die(json_encode(["status" => 303, "message" => "Database connection failed"]));
        }
    }

    // ======================
    // LOGIN FUNCTION (SECURED)
    // ======================
    public function loginAdmin($email, $password)
    {
        // Use a prepared statement to prevent SQL injection
        $stmt = $this->con->prepare("SELECT id, name, password FROM admin WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Verify the password hash instead of plain text
            if (password_verify($password, $row["password"])) {
                $_SESSION["admin_id"] = $row["id"];
                $_SESSION["admin_name"] = $row["name"];
                return ["status" => 202, "message" => "Login successful"];
            } else {
                return ["status" => 303, "message" => "Invalid password"];
            }
        } else {
            return ["status" => 303, "message" => "Admin not found"];
        }
    }

    // ======================
    // REGISTER FUNCTION (SECURED)
    // ======================
    public function registerAdmin($name, $email, $password)
    {
        // Check if email already exists using a prepared statement
        $stmt = $this->con->prepare("SELECT id FROM admin WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            return ["status" => 303, "message" => "Email already registered"];
        }

        // Hash the password for secure storage
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new admin using a prepared statement
        $stmt = $this->con->prepare("INSERT INTO admin (name, email, password, is_active) VALUES (?, ?, ?, 1)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            return ["status" => 202, "message" => "Admin registered successfully"];
        } else {
            return ["status" => 303, "message" => "Registration failed: " . $stmt->error];
        }
    }

    // ======================
    // GET ADMINS FUNCTION (This was already correct)
    // ======================
    public function getAdmins()
    {
        $sql = "SELECT id, name, email, is_active FROM admin";
        $result = $this->con->query($sql);

        if ($result && $result->num_rows > 0) {
            $admins = [];
            while ($row = $result->fetch_assoc()) {
                $admins[] = $row;
            }
            return ["status" => 202, "message" => $admins];
        } else {
            return ["status" => 303, "message" => "No admins found"];
        }
    }

    // ===================================
    // NEW DELETE FUNCTION ADDED HERE
    // ===================================
    public function deleteAdmin($id) {
        // Prevent an admin from deleting their own account
        if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] == $id) {
            return ["status" => 303, "message" => "You cannot delete your own account."];
        }

        // Use a prepared statement to prevent SQL injection
        $stmt = $this->con->prepare("DELETE FROM admin WHERE id = ?");
        $stmt->bind_param("i", $id); // 'i' for integer

        if ($stmt->execute()) {
            return ["status" => 202, "message" => "Admin deleted successfully"];
        } else {
            return ["status" => 303, "message" => "Failed to delete admin: " . $stmt->error];
        }
    }

} // <- THIS IS THE END OF THE Admin CLASS

// ======================
// Handle AJAX Requests (This was already correct)
// ======================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin = new Admin();

    if (isset($_POST["action"]) && $_POST["action"] === "login") {
        echo json_encode($admin->loginAdmin($_POST["email"], $_POST["password"]));
        exit();
    }

    if (isset($_POST["action"]) && $_POST["action"] === "register") {
        echo json_encode($admin->registerAdmin($_POST["name"], $_POST["email"], $_POST["password"]));
        exit();
    }
    
    // ========================================
    // NEW BLOCK TO HANDLE DELETE REQUEST
    // ========================================
    if (isset($_POST["action"]) && $_POST["action"] === "delete_admin") {
        echo json_encode($admin->deleteAdmin($_POST["id"]));
        exit();
    }

    if (isset($_POST["GET_ADMIN"])) {
        echo json_encode($admin->getAdmins());
        exit();
    }

    echo json_encode(["status" => 303, "message" => "Invalid request"]);
    exit();
}