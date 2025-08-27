<?php
// Hide errors from the user by default, and handle them manually.
error_reporting(0);
ini_set('display_errors', 0);

$error_message = '';
$success_message = '';

if (file_exists('config/config.php')) {
    $success_message = 'The application seems to be already installed. The `config.php` file exists. Please delete it if you want to reinstall. For security, please also delete this `install.php` file.';
} elseif (isset($_POST['install'])) {
    // --- Get form data ---
    $db_host = $_POST['db_host'];
    $db_name = $_POST['db_name'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];

    // --- Basic Validation ---
    if (empty($db_host) || empty($db_name) || empty($db_user)) {
        $error_message = 'Please fill in all required database fields.';
    } else {
        // --- 1. Connect to MySQL ---
        $mysqli = new mysqli($db_host, $db_user, $db_pass);
        if ($mysqli->connect_error) {
            $error_message = 'Database connection failed: ' . $mysqli->connect_error;
        } else {
            // --- 2. Create Database ---
            if (!$mysqli->query("CREATE DATABASE IF NOT EXISTS `$db_name`")) {
                $error_message = 'Error creating database: ' . $mysqli->error;
            } else {
                $mysqli->select_db($db_name);

                // --- 3. Import SQL Schema ---
                $sql_file = 'config/database.sql';
                if (!file_exists($sql_file)) {
                    $error_message = '`database.sql` not found in the `config` directory.';
                } else {
                    $sql = file_get_contents($sql_file);
                    if ($mysqli->multi_query($sql)) {
                        // Clear results from multi_query
                        while ($mysqli->next_result()) {
                            if ($res = $mysqli->store_result()) {
                                $res->free();
                            }
                        }

                        // --- 4. Generate config.php ---
                        $url_root = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');

                        $config_content = "<?php
// DB Params
define('DB_HOST', '{$db_host}');
define('DB_USER', '{$db_user}');
define('DB_PASS', '{$db_pass}');
define('DB_NAME', '{$db_name}');

// App Root
define('APPROOT', dirname(__FILE__) . '/app');
// URL Root
define('URLROOT', '{$url_root}');
// Site Name
define('SITENAME', 'Dehradun Classifieds');
";
                        if (!file_put_contents('config/config.php', $config_content)) {
                            $error_message = 'Could not write to `config/config.php`. Please check file permissions.';
                        } else {
                            $success_message = 'Installation successful! The configuration file has been created. Please delete this `install.php` file for security reasons.';
                        }
                    } else {
                        $error_message = 'Error importing database schema: ' . $mysqli->error;
                    }
                }
            }
            $mysqli->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classifieds Website Installer</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { background-color: #fff; padding: 20px 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h1 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { background-color: #28a745; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        .btn:hover { background-color: #218838; }
        .error { color: #dc3545; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        .success { color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Website Installer</h1>
        <?php if ($error_message): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="success">
                <?php echo $success_message; ?>
                <?php if (file_exists('config/config.php')): ?>
                <p style="margin-top: 15px;"><a href="public/">Go to Homepage</a></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!file_exists('config/config.php') && !$success_message): ?>
            <p>Please provide your database details below to set up the application.</p>
            <form action="install.php" method="post">
                <div class="form-group">
                    <label for="db_host">Database Host</label>
                    <input type="text" id="db_host" name="db_host" value="localhost" required>
                </div>
                <div class="form-group">
                    <label for="db_name">Database Name</label>
                    <input type="text" id="db_name" name="db_name" value="classifieds_db" required>
                </div>
                <div class="form-group">
                    <label for="db_user">Database User</label>
                    <input type="text" id="db_user" name="db_user" value="root" required>
                </div>
                <div class="form-group">
                    <label for="db_pass">Database Password</label>
                    <input type="password" id="db_pass" name="db_pass">
                </div>
                <button type="submit" name="install" class="btn">Install</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
