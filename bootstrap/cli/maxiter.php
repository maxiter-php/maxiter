<?php
if (!defined('MAXITER_PROJECT_ROOT')) {
    define('MAXITER_PROJECT_ROOT', dirname(dirname(__DIR__)));
}

require_once MAXITER_PROJECT_ROOT . '/bootstrap/config.php';

// require __DIR__ . "/app/models/LoadModel.php";

class MaxiterConfiguration
{
    public function generateController($fileName)
    {
        $path = MAXITER_PROJECT_ROOT . '/app/controllers/' . $fileName . ".php";

        // Content to be written to the file
        $content = "<?php\n" .
            "/*\n" .
            "The controller file handles user input and interaction. It processes requests,\n" .
            "invokes business logic, and updates the model as needed.\n" .
            "\n" .
            "@author Victor Béser\n" .
            "*/\n" .
            "require __DIR__ . '/../models/LoadModel.php';\n" .
            "require __DIR__ . '/../models/SecureRequestModel.php';\n\n" .
            "class " . ucfirst($fileName) . " {\n\n" .
            "    public function main() {\n" .
            "        // Your code here\n" .
            "    }\n\n" .
            "}\n\n" .
            "\$controller = new " . ucfirst($fileName) . "();\n" .
            "(isset(\$_POST['controller']) && !empty(\$_POST['controller'])) ? \$controller->{\$_POST['controller']}() : \$controller->main();\n";

        // Create the /app directory if it doesn't exist
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/app');
        // Create the /app/controllers directory if it doesn't exist
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/app/controllers');

        // Check if the file already exists
        if (file_exists($path)) {
            echo "This controller already exists\n";
        } else {
            // Create the file and write the content
            file_put_contents($path, $content);
            echo "Controller $fileName created\n";
        }
    }

    public function generatePage($fileName, $baseContent = null)
    {
        $path = MAXITER_PROJECT_ROOT . '/resources/views/pages/' . $fileName . '/' . $fileName . ".php";
        $cssPath = MAXITER_PROJECT_ROOT . '/resources/views/pages/' . $fileName . '/css/' . $fileName . '.css';
        $jsPath = MAXITER_PROJECT_ROOT . '/resources/views/pages/' . $fileName . '/js/' . $fileName . '.js';

        // Content to be written to the PHP file
        if ($baseContent == null) {
            $content =
                "<!-- \n" .
                "This is your new page, it's already routed in Maxiter application\n" .
                "and everything you need is included here.\n" .
                "Happy Coding!\n" .
                "\n" .
                "@author Victor Béser\n" .
                "-->\n" .
                '<?php include __DIR__ . "/../_header/header.php"; ?>' . "\n" .
                "<!-- Page Title -->\n" .
                '<?php PagesTitleModel::title("Maxiter - ' . ucfirst($fileName) . '"); ?>' . "\n" .
                '<link rel="stylesheet" href="<?php echo EnvModel::env("APP_BASE_URL") ?>/resources/views/pages/' . $fileName . '/css/' . $fileName . '.css">' . "\n" .
                "<!--**********************************\n" .
                "        Main wrapper start\n" .
                "***********************************-->\n" .
                '<div id="main-wrapper">' . "\n" .
                "\n" .
                "    <!-- NAVBAR -->\n" .
                '    <?php include __DIR__ . "/../_navbar/navbar.php"; ?>' . "\n" .
                "    <!-- NAVBAR -->\n" .
                "\n" .
                "    <!-- SIDEBAR -->\n" .
                '    <?php include __DIR__ . "/../_sidenav/sidenav.php"; ?>' . "\n" .
                "    <!-- SIDEBAR -->\n" .
                "\n" .
                "    <!--**********************************\n" .
                "            Content body start\n" .
                "        ***********************************-->\n" .
                '    <div class="content-body">' . "\n" .
                "        <!-- row -->\n" .
                "        <div class=\"container-fluid\">" . "\n" .
                "\n" .
                "            <!-- CARDS -->\n" .
                '            <?php include __DIR__ . "/../_cards/cards.php"; ?>' . "\n" .
                "            <!-- CARDS -->\n" .
                "\n" .
                "            <div class=\"row\">" . "\n" .
                "                <div class=\"col-xl-12 col-lg-8 col-md-8\">" . "\n" .
                "                    <div class=\"card\">" . "\n" .
                "                        <div class=\"card-header\">" . "\n" .
                "                            <h4 class=\"card-title\"><?php echo EnvModel::env(\"APP_NAME\") ?> - " . ucfirst($fileName) . "</h4>\n" .
                "                        </div>" . "\n" .
                "                        <div class=\"card-body\">" . "\n" .
                "                            <div class=\"row\">" . "\n" .
                "                                <div style=\"text-align:justify;\" class=\"col-xl-12 col-lg-8\">" . "\n" .
                "                                    <!-- CODE HERE HERE -->\n\n" .
                "                                </div>" . "\n" .
                "                            </div>" . "\n" .
                "                        </div>" . "\n" .
                "                    </div>" . "\n" .
                "                </div>" . "\n" .
                "\n" .
                "            </div>" . "\n" .
                "\n" .
                "        </div>" . "\n" .
                "    </div>" . "\n" .
                "    <!--**********************************\n" .
                "            Content body end\n" .
                "        ***********************************-->\n" .
                "\n" .
                "</div>" . "\n" .
                "<!--**********************************\n" .
                "        Main wrapper end\n" .
                "    ***********************************-->" . "\n" .
                "\n" .
                '<script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/pages/' . $fileName . '/js/' . $fileName . '.js"></script>' . "\n" .
                '<?php include __DIR__ . "/../_footer/footer.php"; ?>';
        }


        $this->createDirectory(MAXITER_PROJECT_ROOT . '/resources');
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/resources/views');
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/resources/views/pages');
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/resources/views/pages/' . $fileName . '/');
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/resources/views/pages/' . $fileName . '/css/');
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/resources/views/pages/' . $fileName . '/js/');

        // Check if the PHP file already exists
        if (file_exists($path)) {
            echo "This page already exists\n";
        } else {
            // Create the PHP file and write the content

            if ($baseContent == null) {
                file_put_contents($path, $content);
            } else if ($baseContent != null) {
                $indexFile = MAXITER_PROJECT_ROOT . "\\src\\template\\$baseContent\\index.html";

                // Check if the index file exists
                if (file_exists($indexFile)) {
                    // Read the content of index.html
                    $fileContent = file_get_contents($indexFile);

                    // Use regular expression to extract content between @header markers
                    if (preg_match('/@body(.*?)@body/s', $fileContent, $matches)) {
                        // $matches[1] will contain the content between the @header markers

                        // Create the body.php file and write the extracted content
                        $bodyFile = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\$fileName\\$fileName.php";
                        if (file_put_contents($path, $matches[1])) {
                            echo "Page $fileName will be created using the index.html with @body tag as content.\n";
                        } else {
                            echo "Failed to create $fileName.php file.\n";
                        }
                    } else {
                        echo "No content found between @body markers.\n";
                    }
                } else {
                    echo "The index.html file does not exist.\n";
                }
            }

            echo "Page $fileName created\n";
        }

        // Content for the CSS file
        $cssContent = "/* Styles for $fileName page */\n";
        file_put_contents($cssPath, $cssContent);
        echo "CSS file $fileName.css created\n";

        // Content for the JS file
        $jsContent = "// JavaScript for $fileName page\n";
        file_put_contents($jsPath, $jsContent);
        echo "JS file $fileName.js created\n";

        // FINAL CONFIGURATIONS CHANGING TAGS WITH PATH VAR
        if ($baseContent != null) {
            // PAGE
            $page = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\$fileName\\$fileName.php";
            // The content to prepend
            $preContent = "<?php include __DIR__ . '/../_header/header.php'; ?>\n
<!-- Page Title -->\n
<?php PagesTitleModel::title('Maxiter - $fileName Page'); ?>\n
<link rel='stylesheet' href='<?php echo EnvModel::env('APP_BASE_URL') ?>resources/views/pages/$fileName/css/$fileName.css'>\n";
            // Check if the $fileName.php file exists
            if (file_exists($page)) {
                // Read the current content of the file
                $currentContent = file_get_contents($page);

                // Prepend the new content to the existing content
                $newContent = $preContent . $currentContent;

                // Write the new content back to the file
                if (file_put_contents($page, $newContent)) {
                    echo "Successfully added the configuration at the beginning of $fileName.php.\n";
                } else {
                    echo "Failed to update $fileName.php.\n";
                }
            } else {
                echo "The $fileName.php file does not exist.\n";
            }
            // The content to append
            $appendContent = "<script src='<?php echo EnvModel::env('APP_BASE_URL') ?>resources/views/pages/$fileName/js/$fileName.js'></script>\n
<?php include __DIR__ . '/../_footer/footer.php'; ?>";

            // Check if the $fileName.php file exists
            if (file_exists($page)) {
                // Read the current content of the file
                $currentContent = file_get_contents($page);

                // Append the new content to the existing content
                $newContent = $currentContent . $appendContent;

                // Write the new content back to the file
                if (file_put_contents($page, $newContent)) {
                    echo "Successfully added the configuration at the end of $fileName.php.\n";
                } else {
                    echo "Failed to update $fileName.php.\n";
                }
            } else {
                echo "The $fileName.php file does not exist.\n";
            }

            // All SRC or URL IMAGE HOMEPAGE
            // Check if the home.php file exists
            if (file_exists($page)) {
                // Read the current content of the file
                $content = file_get_contents($page);

                // Regular expression to find and modify img src paths
                $content = preg_replace_callback('/<img[^>]*src=["\']([^"\']+)["\']/i', function ($matches) {
                    $originalSrc = $matches[1];  // The original src value
                    // Check if the path is relative (i.e., not starting with "http" or "//")
                    if (strpos($originalSrc, 'http') === false && strpos($originalSrc, '//') === false) {
                        // Prepend the base URL and resources/views/ to the src path
                        $modifiedSrc = '<?php echo EnvModel::env(\'APP_BASE_URL\') ?>resources/views/' . $originalSrc;
                        return str_replace($originalSrc, $modifiedSrc, $matches[0]);
                    }
                    // If the src is already an absolute URL, return it unchanged
                    return $matches[0];
                }, $content);

                // Regular expression to find and modify background-image url() paths
                $content = preg_replace_callback('/background-image:\s*url\(["\']?([^"\')]+)["\']?\)/i', function ($matches) {
                    $originalUrl = $matches[1];  // The original URL in the background-image
                    // Check if the path is relative
                    if (strpos($originalUrl, 'http') === false && strpos($originalUrl, '//') === false) {
                        // Prepend the base URL and resources/views/ to the background-image URL
                        $modifiedUrl = 'url(<?php echo EnvModel::env(\'APP_BASE_URL\') ?>resources/views/' . $originalUrl . ')';
                        // Replace only the part inside the url() function with the modified URL
                        return preg_replace('/url\(["\']?([^"\')]+)["\']?\)/', $modifiedUrl, $matches[0]);
                    }
                    // If the URL is already absolute, return it unchanged
                    return $matches[0];
                }, $content);

                // Regular expression to find and modify img src paths
                $content = preg_replace_callback('/<source[^>]*src=["\']([^"\']+)["\']/i', function ($matches) {
                    $originalSrc = $matches[1];  // The original src value
                    // Check if the path is relative (i.e., not starting with "http" or "//")
                    if (strpos($originalSrc, 'http') === false && strpos($originalSrc, '//') === false) {
                        // Prepend the base URL and resources/views/ to the src path
                        $modifiedSrc = '<?php echo EnvModel::env(\'APP_BASE_URL\') ?>resources/views/' . $originalSrc;
                        return str_replace($originalSrc, $modifiedSrc, $matches[0]);
                    }
                    // If the src is already an absolute URL, return it unchanged
                    return $matches[0];
                }, $content);

                // Write the modified content back to the file
                if (file_put_contents($page, $content)) {
                    echo "Successfully updated the src and background-image paths in $fileName.php.\n";
                } else {
                    echo "Failed to update the $fileName.php file.\n";
                }
            } else {
                echo "The $fileName.php file does not exist.\n";
            }
        }

        echo "Note that this is not 100% perfect due the massive exceptions we get when different types of devs create different templates many different ways, please check out the src, href, and stuff.";
    }

    public function generateModel($fileName)
    {
        $className = ucfirst($fileName);
        $path = MAXITER_PROJECT_ROOT . '/app/models/' . $className . ".php";

        // Conteúdo do model a ser criado
        $content = "<?php\n" .
            "/*\n" .
            "The model represents the application's data and business logic. It manages data retrieval, \n" .
            "storage, and manipulation, often interacting with the database. \n" .
            "The model encapsulates rules and validation to ensure data integrity.\n" .
            "\n" .
            "@author Victor Béser\n" .
            "*/\n" .
            "class " . $className . " {\n\n" .
            "    public static function main() {\n" .
            "        // Your code here\n" .
            "    }\n\n" .
            "}";

        $this->createDirectory(MAXITER_PROJECT_ROOT . '/app');
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/app/models');

        if (file_exists($path)) {
            echo "This model already exists\n";
        } else {
            file_put_contents($path, $content);
            echo "Model " . $className . " created\n";
            $this->registerModelInBootstrap($className);
        }
    }

    private function registerModelInBootstrap($className)
    {
        $bootstrapModelsPath = MAXITER_PROJECT_ROOT . '/bootstrap/models.php';

        if (!file_exists($bootstrapModelsPath) || !is_writable($bootstrapModelsPath)) {
            echo "bootstrap/models.php not found or not writable\n";
            return;
        }

        $bootstrapModelsContent = file_get_contents($bootstrapModelsPath);
        $newRequireLine = "require_once __DIR__ . '/../app/models/" . $className . ".php';";

        if (strpos($bootstrapModelsContent, $newRequireLine) !== false) {
            echo "Require statement for " . $className . " already exists in bootstrap/models.php\n";
            return;
        }

        $pattern = '/(require_once\s+__DIR__\s*\.\s*\'\/\.\.\/app\/models\/.*?\.php\';\s*)$/m';

        if (!preg_match_all($pattern, $bootstrapModelsContent, $matches, PREG_OFFSET_CAPTURE)) {
            echo "Could not find the last require statement to append new model require.\n";
            return;
        }

        $lastMatch = end($matches[0]);
        $position = $lastMatch[1] + strlen($lastMatch[0]);
        $bootstrapModelsContent = substr_replace($bootstrapModelsContent, "\n" . $newRequireLine, $position, 0);

        file_put_contents($bootstrapModelsPath, $bootstrapModelsContent);
        echo "Added " . $className . " require to bootstrap/models.php\n";
    }


    public function generateLogModel($database)
    {
        $path = MAXITER_PROJECT_ROOT . '/app/models/LogModel.php';

        if (!isset($database) || empty($database)) {
            echo "Error: php maxiter new log [database]";
            exit();
        }

        // Content to be written to the file
        $content = "<?php\n" .
            "/*\n" .
            "This is the log file, use it statically where you want using LogModel::log(\"Your log text here\")\n" .
            "\n" .
            "@author Victor Béser\n" .
            "*/\n" .
            "class LogModel {\n\n" .
            "    private static \$log;\n" .
            "    public static function log(\$log) {\n" .
            "        \$currentDateTime = new DateTime();\n" .
            "        \$formattedDateTime = \$currentDateTime->format('Y-m-d H:i:s');\n\n" .
            "        self::\$log = mb_strtoupper(\$log);\n\n" .
            "        \$query = \"INSERT INTO logs (log, created_at) VALUES (:log, :date)\";\n" .
            "        \$result = DatabaseModel::connection(\"$database\")->execute(\$query, [\n" .
            "            \":log\" => self::\$log,\n" .
            "            \":date\" => \$formattedDateTime,\n" .
            "        ]);\n" .
            "    }\n\n" .
            "}";

        // Create the /app directory if it doesn't exist
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/app');
        // Create the /app/models directory if it doesn't exist
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/app/models');

        // Check if the file already exists
        if (file_exists($path)) {
            echo "This model already exists\n";
        } else {
            // Create the file and write the content
            file_put_contents($path, $content);
            echo "LogModel with database '$database' created\n";
        }
    }

    public function generateSQL($table)
    {

        $path = MAXITER_PROJECT_ROOT . '/src/tables/' . $table . '.sql';

        switch ($table) {

            case 'users':
                $content = "-- Create the users table\n" .
                    "CREATE TABLE users (\n" .
                    "    id INT AUTO_INCREMENT PRIMARY KEY,\n" .
                    "    username VARCHAR(50) NOT NULL UNIQUE,\n" .
                    "    password VARCHAR(255) NOT NULL,\n" .
                    "    email VARCHAR(100) NOT NULL UNIQUE,\n" .
                    "    first_name VARCHAR(50),\n" .
                    "    last_name VARCHAR(50),\n" .
                    "    phone_number VARCHAR(15),\n" .
                    "    address VARCHAR(255),\n" .
                    "    city VARCHAR(50),\n" .
                    "    state VARCHAR(50),\n" .
                    "    zip_code VARCHAR(10),\n" .
                    "    country VARCHAR(50),\n" .
                    "    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
                    "    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP\n" .
                    ");\n\n" .
                    "-- Insert data into the users table\n" .
                    "INSERT INTO users (username, password, email, first_name, last_name, phone_number, address, city, state, zip_code, country) VALUES\n" .
                    "('johndoe', MD5('password123'), 'johndoe@example.com', 'John', 'Doe', '1234567890', '123 Main St', 'Anytown', 'Anystate', '12345', 'USA'),\n" .
                    "('janedoe', MD5('mypassword'), 'janedoe@example.com', 'Jane', 'Doe', '0987654321', '456 Elm St', 'Othertown', 'Otherstate', '54321', 'USA'),\n" .
                    "('alice', MD5('alicepassword'), 'alice@example.com', 'Alice', 'Smith', '1112223333', '789 Maple Ave', 'Sometown', 'Somestate', '67890', 'USA'),\n" .
                    "('bob', MD5('bobpassword'), 'bob@example.com', 'Bob', 'Johnson', '4445556666', '321 Oak St', 'Differenttown', 'Differentstate', '09876', 'USA');";
                break;

            case 'logs':
                $content = "-- Create the logs table\n" .
                    "CREATE TABLE logs (\n" .
                    "    id INT AUTO_INCREMENT PRIMARY KEY,\n" .
                    "    log TEXT NOT NULL,\n" .
                    "    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n" .
                    ");\n\n" .
                    "-- Insert data into the logs table\n" .
                    "INSERT INTO logs (log) VALUES\n" .
                    "('User johndoe logged in successfully'),\n" .
                    "('User janedoe attempted to access restricted area'),\n" .
                    "('User alice updated profile information'),\n" .
                    "('User bob logged out');";
                break;


            case 'products':
                $content = "-- Create the products table\n" .
                    "CREATE TABLE products (\n" .
                    "    id INT AUTO_INCREMENT PRIMARY KEY,\n" .
                    "    name VARCHAR(100) NOT NULL,\n" .
                    "    description TEXT,\n" .
                    "    price DECIMAL(10, 2) NOT NULL,\n" .
                    "    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
                    "    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP\n" .
                    ");\n\n" .
                    "-- Insert data into the products table\n" .
                    "INSERT INTO products (name, description, price) VALUES\n" .
                    "('Product 1', 'Description for Product 1', 19.99),\n" .
                    "('Product 2', 'Description for Product 2', 29.99),\n" .
                    "('Product 3', 'Description for Product 3', 39.99),\n" .
                    "('Product 4', 'Description for Product 4', 49.99);";
                break;

            case 'orders':
                $content = "-- Create the orders table\n" .
                    "CREATE TABLE orders (\n" .
                    "    id INT AUTO_INCREMENT PRIMARY KEY,\n" .
                    "    user_id INT NOT NULL,\n" .
                    "    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
                    "    status VARCHAR(50) NOT NULL,\n" .
                    "    total DECIMAL(10, 2) NOT NULL,\n" .
                    "    FOREIGN KEY (user_id) REFERENCES users(id)\n" .
                    ");\n\n" .
                    "-- Insert data into the orders table\n" .
                    "INSERT INTO orders (user_id, status, total) VALUES\n" .
                    "(1, 'Pending', 59.98),\n" .
                    "(2, 'Completed', 29.99),\n" .
                    "(1, 'Shipped', 39.99),\n" .
                    "(3, 'Cancelled', 19.99);";
                break;

            case 'customers':
                $content = "-- Create the customers table\n" .
                    "CREATE TABLE customers (\n" .
                    "    id INT AUTO_INCREMENT PRIMARY KEY,\n" .
                    "    name VARCHAR(100) NOT NULL,\n" .
                    "    email VARCHAR(100) NOT NULL UNIQUE,\n" .
                    "    phone_number VARCHAR(15),\n" .
                    "    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
                    "    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP\n" .
                    ");\n\n" .
                    "-- Insert data into the customers table\n" .
                    "INSERT INTO customers (name, email, phone_number) VALUES\n" .
                    "('Alice Smith', 'alice@example.com', '1234567890'),\n" .
                    "('Bob Johnson', 'bob@example.com', '0987654321'),\n" .
                    "('Charlie Brown', 'charlie@example.com', '5551234567'),\n" .
                    "('Diana Prince', 'diana@example.com', '4449876543');";
                break;

            case 'roles':
                $content = "-- Create the roles table\n" .
                    "CREATE TABLE roles (\n" .
                    "    id INT AUTO_INCREMENT PRIMARY KEY,\n" .
                    "    role_name VARCHAR(50) NOT NULL UNIQUE,\n" .
                    "    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
                    "    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP\n" .
                    ");\n\n" .
                    "-- Insert data into the roles table\n" .
                    "INSERT INTO roles (role_name) VALUES\n" .
                    "('Admin'),\n" .
                    "('Editor'),\n" .
                    "('Viewer'),\n" .
                    "('Guest');";
                break;

            case 'permissions':
                $content = "-- Create the permissions table\n" .
                    "CREATE TABLE permissions (\n" .
                    "    id INT AUTO_INCREMENT PRIMARY KEY,\n" .
                    "    permission_name VARCHAR(50) NOT NULL UNIQUE,\n" .
                    "    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
                    "    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP\n" .
                    ");\n\n" .
                    "-- Insert data into the permissions table\n" .
                    "INSERT INTO permissions (permission_name) VALUES\n" .
                    "('Create'),\n" .
                    "('Read'),\n" .
                    "('Update'),\n" .
                    "('Delete');";
                break;

            default:
                $content = "-- Create the $table table\n" .
                    "CREATE TABLE $table (\n" .
                    "    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL\n" .
                    ");";
                break;
        }


        // Create the /app directory if it doesn't exist
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/src');
        // Create the /app/models directory if it doesn't exist
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/src/tables');

        // Check if the file already exists
        if (file_exists($path)) {
            echo "This table already exists\n";
        } else {
            // Create the file and write the content
            file_put_contents($path, $content);
            echo "Table '$table' created in path /src/tables/\n";
        }
    }

    public function initServer($port = null)
    {
        chdir(MAXITER_PROJECT_ROOT);

        if ($port === null) {
            $url = "http://localhost:7000";  // A URL que você quer abrir

            if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
                // Windows: usa o comando 'start' para abrir a URL
                exec("start " . $url);
            } elseif (strncasecmp(PHP_OS, 'Linux', 5) == 0) {
                // Linux: usa o comando 'xdg-open' para abrir a URL
                exec("xdg-open " . $url);
            } elseif (strncasecmp(PHP_OS, 'Darwin', 6) == 0) {
                // macOS: usa o comando 'open' para abrir a URL
                exec("open " . $url);
            } else {
                echo "Sistema operacional não suportado para abrir URLs automaticamente.";
            }
            exec("php -S localhost:7000 bootstrap/server/router.php");
        } else {
            $url = "http://localhost:$port";  // A URL que você quer abrir

            if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
                // Windows: usa o comando 'start' para abrir a URL
                exec("start " . $url);
            } elseif (strncasecmp(PHP_OS, 'Linux', 5) == 0) {
                // Linux: usa o comando 'xdg-open' para abrir a URL
                exec("xdg-open " . $url);
            } elseif (strncasecmp(PHP_OS, 'Darwin', 6) == 0) {
                // macOS: usa o comando 'open' para abrir a URL
                exec("open " . $url);
            } else {
                echo "Sistema operacional não suportado para abrir URLs automaticamente.";
            }
            exec("php -S localhost:$port bootstrap/server/router.php");
        }
    }

    public function initGUI()
    {
        $path = $this->detectProjectUrl();
        echo "Opening GUI using auto-detected base URL: $path\n";
        exec("start " . $path . "gui.html");
    }

    public function setPath($pathUrl)
    {
        echo "Manual base URL configuration is no longer required.\n";
        echo "The framework now detects the base URL automatically at runtime.\n";
        echo "Ignored value: " . rtrim($pathUrl, '/') . "/\n";
    }

    public function autoSetUpPath($port = null)
    {
        $url = $this->detectProjectUrl($port);

        echo "Auto-detected base URL: $url\n";
        echo "No file update is necessary anymore.\n";

        return $url;
    }



    // ############################################################################ //
    // ############################################################################ //
    // ############################ SET NEW TEMPLATE ############################## //
    // ############################################################################ //
    // ############################################################################ //

    public function setNewTemplate($templateFolder)
    {
        // Folder paths
        $viewsFolder = MAXITER_PROJECT_ROOT . "\\resources\\views";  // Destination folder
        $templateFolder = MAXITER_PROJECT_ROOT . "\\src\\template\\$templateFolder";  // Template source folder
        $indexFile = $templateFolder . "\\index.html";

        // Remove the views folder if it exists
        echo "Removing views folder...\n";
        if (is_dir($viewsFolder)) {
            // Check if the system is Windows or Unix-like (Linux/Mac)
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Use the command to remove the folder on Windows
                exec("rd /s /q \"$viewsFolder\"");
            } else {
                // Use the command to remove the folder on Linux/Mac
                exec("rm -rf \"$viewsFolder\"");
            }
        } else {
            echo "Views folder not found.\n";
        }

        // Check if the folder was successfully removed
        if (!is_dir($viewsFolder)) {
            echo "Views folder removed successfully or not found.\n";
        } else {
            echo "Failed to remove views folder.\n";
        }

        // Recreate the views folder
        echo "Creating views folder...\n";
        if (mkdir($viewsFolder, 0777, true)) {
            echo "Views folder created successfully.\n";
        } else {
            echo "Failed to create views folder.\n";
            return;
        }

        // Check if the source folder exists
        if (is_dir($templateFolder)) {
            // Get the files from the template
            $files = scandir($templateFolder);

            // Iterate over the files in the source folder
            foreach ($files as $file) {
                // Ignore the entries "." and ".."
                if ($file != '.' && $file != '..') {
                    $sourcePath = $templateFolder . '\\' . $file; // Full path of the source file
                    $destinationPath = $viewsFolder . '\\' . $file; // Full path of the destination file

                    // Check if it's a directory (subfolder) and copy the subfolder and its files
                    if (is_dir($sourcePath)) {
                        // Create the subfolder in the destination, if it doesn't exist
                        if (!is_dir($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }
                        echo "Subfolder '$file' copied successfully!\n";

                        // Copy all files and subfolders within the subfolder
                        $this->copyDirectoryContents($sourcePath, $destinationPath);
                    }
                }
            }
        } else {
            echo "The source folder '$templateFolder' does not exist.\n";
        }


        // Create pages folder and subfolders
        $pagesFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages";
        echo "Creating pages folder...\n";
        if (mkdir($pagesFolder, 0777, true)) {
            echo "Pages folder created successfully.\n";
        } else {
            echo "Failed to create Pages folder.\n";
            return;
        }
        // _header
        $headerFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_header";
        echo "Creating _header component...\n";
        if (!is_dir($headerFolder)) {
            if (mkdir($headerFolder, 0777, true)) {
                echo "_header component created successfully.\n";
            } else {
                echo "Failed to create _header component.\n";
            }
        } else {
            echo "_header component already exists.\n";
        }

        // _footer
        $footerFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_footer";
        echo "Creating _footer component...\n";
        if (!is_dir($footerFolder)) {
            if (mkdir($footerFolder, 0777, true)) {
                echo "_footer component created successfully.\n";
            } else {
                echo "Failed to create _footer component.\n";
            }
        } else {
            echo "_footer component already exists.\n";
        }

        // _navbar
        $navbarFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_navbar";
        echo "Creating _navbar component...\n";
        if (!is_dir($navbarFolder)) {
            if (mkdir($navbarFolder, 0777, true)) {
                echo "_navbar component created successfully.\n";
            } else {
                echo "Failed to create _navbar component.\n";
            }
        } else {
            echo "_navbar component already exists.\n";
        }

        // _sidebar
        $sidebarFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_sidebar";
        echo "Creating _sidebar component...\n";
        if (!is_dir($sidebarFolder)) {
            if (mkdir($sidebarFolder, 0777, true)) {
                echo "_sidebar component created successfully.\n";
            } else {
                echo "Failed to create _sidebar component.\n";
            }
        } else {
            echo "_sidebar component already exists.\n";
        }

        // home
        $homeFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\home";
        echo "Creating home folder...\n";
        if (!is_dir($homeFolder)) {
            if (mkdir($homeFolder, 0777, true)) {
                echo "Home folder created successfully.\n";
            } else {
                echo "Failed to create Home folder.\n";
            }
        } else {
            echo "Home folder already exists.\n";
        }

        // Creating files and content
        // Path to the index.html template file
        // $indexFile = $templateFolder . "\\index.html";

        // _header folder path
        $headerFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_header";

        // Check if the index file exists
        if (file_exists($indexFile)) {
            // Read the content of index.html
            $fileContent = file_get_contents($indexFile);

            // Use regular expression to extract content between @header markers
            if (preg_match('/@header(.*?)@header/s', $fileContent, $matches)) {
                // $matches[1] will contain the content between the @header markers

                // Create the _header folder if it doesn't exist
                if (!is_dir($headerFolder)) {
                    if (mkdir($headerFolder, 0777, true)) {
                        echo "_header folder created successfully.\n";
                    } else {
                        echo "Failed to create _header folder.\n";
                    }
                }

                // Create the header.php file and write the extracted content
                $headerFile = $headerFolder . "\\header.php";
                if (file_put_contents($headerFile, $matches[1])) {
                    echo "header.php file created successfully inside the _header folder.\n";
                } else {
                    echo "Failed to create header.php file.\n";
                }
            } else {
                echo "No content found between @header markers.\n";
            }
        } else {
            echo "The index.html file does not exist.\n";
        }



        // _footer folder path
        $footerFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_footer";

        // Check if the index file exists
        if (file_exists($indexFile)) {
            // Read the content of index.html
            $fileContent = file_get_contents($indexFile);

            // Use regular expression to extract content between @header markers
            if (preg_match('/@footer(.*?)@footer/s', $fileContent, $matches)) {
                // $matches[1] will contain the content between the @header markers

                // Create the _header folder if it doesn't exist
                if (!is_dir($footerFolder)) {
                    if (mkdir($footerFolder, 0777, true)) {
                        echo "_footer folder created successfully.\n";
                    } else {
                        echo "Failed to create _footer folder.\n";
                    }
                }

                // Create the footer.php file and write the extracted content
                $footerFile = $footerFolder . "\\footer.php";
                if (file_put_contents($footerFile, $matches[1])) {
                    echo "footer.php file created successfully inside the _footer folder.\n";
                } else {
                    echo "Failed to create footer.php file.\n";
                }
            } else {
                echo "No content found between @footer markers.\n";
            }
        } else {
            echo "The index.html file does not exist.\n";
        }



        // _navbar folder path
        $navbarFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_navbar";

        // Check if the index file exists
        if (file_exists($indexFile)) {
            // Read the content of index.html
            $fileContent = file_get_contents($indexFile);

            // Use regular expression to extract content between @header markers
            if (preg_match('/@navbar(.*?)@navbar/s', $fileContent, $matches)) {
                // $matches[1] will contain the content between the @header markers

                // Create the _header folder if it doesn't exist
                if (!is_dir($navbarFolder)) {
                    if (mkdir($navbarFolder, 0777, true)) {
                        echo "_navbar folder created successfully.\n";
                    } else {
                        echo "Failed to create _navbar folder.\n";
                    }
                }

                // Create the navbar.php file and write the extracted content
                $navbarFile = $navbarFolder . "\\navbar.php";
                if (file_put_contents($navbarFile, $matches[1])) {
                    echo "navbar.php file created successfully inside the _navbar folder.\n";
                } else {
                    echo "Failed to create navbar.php file.\n";
                }
            } else {
                echo "No content found between @navbar markers.\n";
            }
        } else {
            echo "The index.html file does not exist.\n";
        }

        // _sidebar folder path
        $sidebarFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_sidebar";

        // Check if the index file exists
        if (file_exists($indexFile)) {
            // Read the content of index.html
            $fileContent = file_get_contents($indexFile);

            // Use regular expression to extract content between @header markers
            if (preg_match('/@sidebar(.*?)@sidebar/s', $fileContent, $matches)) {
                // $matches[1] will contain the content between the @header markers

                // Create the _header folder if it doesn't exist
                if (!is_dir($sidebarFolder)) {
                    if (mkdir($sidebarFolder, 0777, true)) {
                        echo "_sidebar folder created successfully.\n";
                    } else {
                        echo "Failed to create _sidebar folder.\n";
                    }
                }

                // Create the sidebar.php file and write the extracted content
                $sidebarFile = $sidebarFolder . "\\sidebar.php";
                if (file_put_contents($sidebarFile, $matches[1])) {
                    echo "sidebar.php file created successfully inside the _sidebar folder.\n";
                } else {
                    echo "Failed to create sidebar.php file.\n";
                }
            } else {
                echo "No content found between @sidebar markers.\n";
            }
        } else {
            echo "The index.html file does not exist.\n";
        }


        // _body folder path
        $bodyFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\home";

        // Check if the index file exists
        if (file_exists($indexFile)) {
            // Read the content of index.html
            $fileContent = file_get_contents($indexFile);

            // Use regular expression to extract content between @header markers
            if (preg_match('/@body(.*?)@body/s', $fileContent, $matches)) {
                // $matches[1] will contain the content between the @header markers

                // Create the _header folder if it doesn't exist
                if (!is_dir($bodyFolder)) {
                    if (mkdir($bodyFolder, 0777, true)) {
                        echo "Home folder created successfully.\n";
                    } else {
                        echo "Failed to create Home folder.\n";
                    }
                }

                // Create the body.php file and write the extracted content
                $bodyFile = $bodyFolder . "\\home.php";
                if (file_put_contents($bodyFile, $matches[1])) {
                    echo "home.php file created successfully inside the home folder.\n";
                } else {
                    echo "Failed to create home.php file.\n";
                }
            } else {
                echo "No content found between @body markers.\n";
            }
        } else {
            echo "The index.html file does not exist.\n";
        }

        // home JS folder creation
        $homeFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\home\\js";
        echo "Creating Home JS file file...\n";
        if (!is_dir($homeFolder)) {
            if (mkdir($homeFolder, 0777, true)) {
                echo "Home JS file created successfully.\n";
            } else {
                echo "Failed to create Home JS file.\n";
            }
        } else {
            echo "Home JS file already exists.\n";
        }
        // home JS folder path
        $homeJSFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\home\\js";
        // Create the home.js file and write the extracted content
        $homeJSFile = $homeJSFolder . "\\home.js";
        if (file_put_contents($homeJSFile, "// JavaScript for home page")) {
            echo "home.js file created successfully inside the home/js folder.\n";
        } else {
            echo "Failed to create home.js file.\n";
        }

        // home css folder creation
        $homeFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\home\\css";
        echo "Creating Home css file file...\n";
        if (!is_dir($homeFolder)) {
            if (mkdir($homeFolder, 0777, true)) {
                echo "Home css file created successfully.\n";
            } else {
                echo "Failed to create Home css file.\n";
            }
        } else {
            echo "Home css file already exists.\n";
        }
        // home css folder path
        $homecssFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\home\\css";
        // Create the home.css file and write the extracted content
        $homecssFile = $homecssFolder . "\\home.css";
        if (file_put_contents($homecssFile, ' /* Styles for home page */ ')) {
            echo "home.css file created successfully inside the home/css folder.\n";
        } else {
            echo "Failed to create home.js file.\n";
        }



        // Add final configurations

        // HEADER
        $headerFile = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_header\\header.php";
        // The content to prepend
        $preContent = "<?php require __DIR__ . \"/../../../../app/models/LoadModel.php\"; ?>\n";
        // Check if the header.php file exists
        if (file_exists($headerFile)) {
            // Read the current content of the file
            $currentContent = file_get_contents($headerFile);

            // Prepend the new content to the existing content
            $newContent = $preContent . $currentContent;

            // Write the new content back to the file
            if (file_put_contents($headerFile, $newContent)) {
                echo "Successfully added the configuration at the beginning of header.php.\n";
            } else {
                echo "Failed to update header.php.\n";
            }
        } else {
            echo "The header.php file does not exist.\n";
        }
        // Check if the header.php file exists
        if (file_exists($headerFile)) {
            // Read the content of the header.php file
            $content = file_get_contents($headerFile);

            // Use regular expression to find all <link> tags and modify the href
            $content = preg_replace_callback('/<link[^>]*href="([^"]+)"/', function ($matches) {
                // The original href value
                $originalHref = $matches[1];

                // Modify the href by prepending the base URL
                $modifiedHref = '<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/' . $originalHref;

                // Replace the href in the <link> tag with the modified href
                return str_replace($originalHref, $modifiedHref, $matches[0]);
            }, $content);

            // Write the modified content back to the header.php file
            if (file_put_contents($headerFile, $content)) {
                echo "Successfully updated the href in <link> tags.\n";
            } else {
                echo "Failed to update the header.php file.\n";
            }
        } else {
            echo "The header.php file does not exist.\n";
        }

        // Check if the header.php file exists
        if (file_exists($headerFile)) {
            // Read the current content of the file
            $content = file_get_contents($headerFile);

            // Regular expression to find the <title> tag and replace its content
            $content = preg_replace('/<title[^>]*>.*<\/title>/i', '<title id="page_title"></title>', $content);

            // Write the modified content back to the file
            if (file_put_contents($headerFile, $content)) {
                echo "Successfully updated the title tag in header.php.\n";
            } else {
                echo "Failed to update the header.php file.\n";
            }
        } else {
            echo "The header.php file does not exist.\n";
        }

        // FOOTER
        $footerFile = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_footer\\footer.php";
        // The content to prepend
        $preContent = "<script>\n
                            // Page Title Definition \n
                            document.querySelector('#page_title').innerHTML = <?php echo json_encode(PagesTitleModel::getTitle()); ?>\n
                        </script>";
        // Check if the footer.php file exists
        if (file_exists($footerFile)) {
            // Read the current content of the file
            $currentContent = file_get_contents($footerFile);

            // Prepend the new content to the existing content
            $newContent = $preContent . $currentContent;

            // Write the new content back to the file
            if (file_put_contents($footerFile, $newContent)) {
                echo "Successfully added the configuration at the beginning of footer.php.\n";
            } else {
                echo "Failed to update footer.php.\n";
            }
        } else {
            echo "The footer.php file does not exist.\n";
        }
        // Check if the footer.php file exists
        if (file_exists($footerFile)) {
            // Read the content of the footer.php file
            $content = file_get_contents($footerFile);

            // Use regular expression to find all <link> tags and modify the href
            $content = preg_replace_callback('/<script[^>]*src="([^"]+)"/', function ($matches) {
                // The original href value
                $originalHref = $matches[1];

                // Modify the href by prepending the base URL
                $modifiedHref = '<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/' . $originalHref;

                // Replace the href in the <link> tag with the modified href
                return str_replace($originalHref, $modifiedHref, $matches[0]);
            }, $content);

            // Write the modified content back to the footer.php file
            if (file_put_contents($footerFile, $content)) {
                echo "Successfully updated the src in <script> tags.\n";
            } else {
                echo "Failed to update the footer.php file.\n";
            }
        } else {
            echo "The footer.php file does not exist.\n";
        }



        // HOMEPAGE
        $homeFile = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\home\\home.php";
        // The content to prepend
        $preContent = "<?php include __DIR__ . '/../_header/header.php'; ?>\n
<!-- Page Title -->\n
<?php PagesTitleModel::title('Maxiter - Home Page'); ?>\n
<link rel='stylesheet' href='<?php echo EnvModel::env('APP_BASE_URL') ?>resources/views/pages/home/css/home.css'>\n";
        // Check if the home.php file exists
        if (file_exists($homeFile)) {
            // Read the current content of the file
            $currentContent = file_get_contents($homeFile);

            // Prepend the new content to the existing content
            $newContent = $preContent . $currentContent;

            // Write the new content back to the file
            if (file_put_contents($homeFile, $newContent)) {
                echo "Successfully added the configuration at the beginning of home.php.\n";
            } else {
                echo "Failed to update home.php.\n";
            }
        } else {
            echo "The home.php file does not exist.\n";
        }
        // The content to append
        $appendContent = "<script src='<?php echo EnvModel::env('APP_BASE_URL') ?>resources/views/pages/home/js/home.js'></script>\n
<?php include __DIR__ . '/../_footer/footer.php'; ?>";

        // Check if the home.php file exists
        if (file_exists($homeFile)) {
            // Read the current content of the file
            $currentContent = file_get_contents($homeFile);

            // Append the new content to the existing content
            $newContent = $currentContent . $appendContent;

            // Write the new content back to the file
            if (file_put_contents($homeFile, $newContent)) {
                echo "Successfully added the configuration at the end of home.php.\n";
            } else {
                echo "Failed to update home.php.\n";
            }
        } else {
            echo "The home.php file does not exist.\n";
        }

        // All SRC or URL IMAGE HOMEPAGE
        // Check if the home.php file exists
        if (file_exists($homeFile)) {
            // Read the current content of the file
            $content = file_get_contents($homeFile);

            // Regular expression to find and modify img src paths
            $content = preg_replace_callback('/<img[^>]*src=["\']([^"\']+)["\']/i', function ($matches) {
                $originalSrc = $matches[1];  // The original src value
                // Check if the path is relative (i.e., not starting with "http" or "//")
                if (strpos($originalSrc, 'http') === false && strpos($originalSrc, '//') === false) {
                    // Prepend the base URL and resources/views/ to the src path
                    $modifiedSrc = '<?php echo EnvModel::env(\'APP_BASE_URL\') ?>resources/views/' . $originalSrc;
                    return str_replace($originalSrc, $modifiedSrc, $matches[0]);
                }
                // If the src is already an absolute URL, return it unchanged
                return $matches[0];
            }, $content);

            // Regular expression to find and modify background-image url() paths
            $content = preg_replace_callback('/background-image:\s*url\(["\']?([^"\')]+)["\']?\)/i', function ($matches) {
                $originalUrl = $matches[1];  // The original URL in the background-image
                // Check if the path is relative
                if (strpos($originalUrl, 'http') === false && strpos($originalUrl, '//') === false) {
                    // Prepend the base URL and resources/views/ to the background-image URL
                    $modifiedUrl = 'url(<?php echo EnvModel::env(\'APP_BASE_URL\') ?>resources/views/' . $originalUrl . ')';
                    // Replace only the part inside the url() function with the modified URL
                    return preg_replace('/url\(["\']?([^"\')]+)["\']?\)/', $modifiedUrl, $matches[0]);
                }
                // If the URL is already absolute, return it unchanged
                return $matches[0];
            }, $content);

            // Regular expression to find and modify img src paths
            $content = preg_replace_callback('/<source[^>]*src=["\']([^"\']+)["\']/i', function ($matches) {
                $originalSrc = $matches[1];  // The original src value
                // Check if the path is relative (i.e., not starting with "http" or "//")
                if (strpos($originalSrc, 'http') === false && strpos($originalSrc, '//') === false) {
                    // Prepend the base URL and resources/views/ to the src path
                    $modifiedSrc = '<?php echo EnvModel::env(\'APP_BASE_URL\') ?>resources/views/' . $originalSrc;
                    return str_replace($originalSrc, $modifiedSrc, $matches[0]);
                }
                // If the src is already an absolute URL, return it unchanged
                return $matches[0];
            }, $content);

            // Write the modified content back to the file
            if (file_put_contents($homeFile, $content)) {
                echo "Successfully updated the src and background-image paths in home.php.\n";
            } else {
                echo "Failed to update the home.php file.\n";
            }
        } else {
            echo "The home.php file does not exist.\n";
        }

        // All SRC or URL IMAGE FOOTER
        $footerFile = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_footer\\footer.php";
        // Check if the footer.php file exists
        if (file_exists($footerFile)) {
            // Read the current content of the file
            $content = file_get_contents($footerFile);

            // Regular expression to find and modify img src paths
            $content = preg_replace_callback('/<img[^>]*src=["\']([^"\']+)["\']/i', function ($matches) {
                $originalSrc = $matches[1];  // The original src value
                // Check if the path is relative (i.e., not starting with "http" or "//")
                if (strpos($originalSrc, 'http') === false && strpos($originalSrc, '//') === false) {
                    // Prepend the base URL and resources/views/ to the src path
                    $modifiedSrc = '<?php echo EnvModel::env(\'APP_BASE_URL\') ?>resources/views/' . $originalSrc;
                    return str_replace($originalSrc, $modifiedSrc, $matches[0]);
                }
                // If the src is already an absolute URL, return it unchanged
                return $matches[0];
            }, $content);

            // Regular expression to find and modify background-image url() paths
            $content = preg_replace_callback('/background-image:\s*url\(["\']?([^"\')]+)["\']?\)/i', function ($matches) {
                $originalUrl = $matches[1];  // The original URL in the background-image
                // Check if the path is relative
                if (strpos($originalUrl, 'http') === false && strpos($originalUrl, '//') === false) {
                    // Prepend the base URL and resources/views/ to the background-image URL
                    $modifiedUrl = 'url(<?php echo EnvModel::env(\'APP_BASE_URL\') ?>resources/views/' . $originalUrl . ')';
                    // Replace only the part inside the url() function with the modified URL
                    return preg_replace('/url\(["\']?([^"\')]+)["\']?\)/', $modifiedUrl, $matches[0]);
                }
                // If the URL is already absolute, return it unchanged
                return $matches[0];
            }, $content);

            // Write the modified content back to the file
            if (file_put_contents($footerFile, $content)) {
                echo "Successfully updated the src and background-image paths in footer.php.\n";
            } else {
                echo "Failed to update the footer.php file.\n";
            }
        } else {
            echo "The footer.php file does not exist.\n";
        }
    }


    // Helper function to copy the contents of a subfolder (recursively)
    private function copyDirectoryContents($sourceDir, $destinationDir)
    {
        // Get the files and folders inside the source directory
        $items = scandir($sourceDir);

        // Iterate over the items in the subfolder
        foreach ($items as $item) {
            if ($item != '.' && $item != '..') {
                $sourcePath = $sourceDir . '\\' . $item;
                $destinationPath = $destinationDir . '\\' . $item;

                if (is_dir($sourcePath)) {
                    // If it's a directory, create it in the destination and copy its contents
                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    // Recursively copy the contents of the subfolder
                    $this->copyDirectoryContents($sourcePath, $destinationPath);
                } else {
                    // If it's a file, copy it
                    copy($sourcePath, $destinationPath);
                    echo "File '$item' copied successfully!\n";
                }
            }
        }
    }



    // ############################################################################ //
    // ############################################################################ //
    // ############################ SET NEW TEMPLATE ############################## //
    // ############################################################################ //
    // ############################################################################ //



    public function generateApiController($fileName)
    {
        $className = ucfirst($fileName);
        $controllerPath = MAXITER_PROJECT_ROOT . '/app/controllers/' . $className . ".php";
        $routePath = MAXITER_PROJECT_ROOT . '/routes/api.php';
        $defaultRoute = '/' . $this->toKebabCase($this->stripControllerSuffix($className));

        // Content to be written to the file
        $controllerContent = "<?php\n" .
            "/*\n" .
            "The API controller file handles user input and interaction. It processes requests,\n" .
            "invokes business logic, and returns as needed.\n" .
            "\n" .
            "@author Victor Béser\n" .
            "*/\n" .
            "require __DIR__ . '/../models/LoadModel.php';\n" .
            "require __DIR__ . '/../models/SecureRequestModel.php';\n\n" .
            "class " . $className . " {\n\n" .
            "    public function main() {\n" .
            "        // Your code here\n" .
            "    }\n\n" .
            "}\n";

        // Create the /app directory if it doesn't exist
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/app');
        // Create the /app/controllers directory if it doesn't exist
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/app/controllers');
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/routes');

        // Check if the file already exists
        if (file_exists($controllerPath)) {
            echo "This controller already exists\n";
        } else {
            // Create the file and write the content
            file_put_contents($controllerPath, $controllerContent);
            echo "Controller $fileName created\n";
        }

        $this->appendApiControllerRoute($routePath, $className, $defaultRoute);
    }

    private function appendApiControllerRoute($routePath, $className, $defaultRoute)
    {
        $routeBlock = "\nApiModel::controller('" . $className . "', function () {\n" .
            "    ApiModel::get('" . $defaultRoute . "', 'main');\n" .
            "    // ApiModel::get('" . $defaultRoute . "/{id}', 'show');\n" .
            "    // ApiModel::post('" . $defaultRoute . "', 'store', 'YourMiddleware');\n" .
            "});\n";

        if (!file_exists($routePath)) {
            $baseContent = "<?php\n" .
                "/*\n" .
                "Configure your API routes here.\n" .
                "Only declare routes in this file.\n" .
                "\n" .
                "@author Victor Béser\n" .
                "*/\n";

            file_put_contents($routePath, $baseContent . $routeBlock);
            echo "API route added to /routes/api.php with route " . $defaultRoute . "\n";
            return;
        }

        $routeContent = file_get_contents($routePath);
        if (strpos($routeContent, "ApiModel::controller('" . $className . "'") !== false) {
            echo "Route declaration for " . $className . " already exists in /routes/api.php\n";
            return;
        }

        $routeContent = rtrim($routeContent) . $routeBlock;
        file_put_contents($routePath, $routeContent . "\n");

        echo "API route added to /routes/api.php with route " . $defaultRoute . "\n";
    }

    public function generateMiddleware($fileName)
    {
        $path = MAXITER_PROJECT_ROOT . '/app/middlewares/' . $fileName . ".php";

        // Content to be written to the file
        $content = "<?php\n" .
            "/*\n" .
            "A middleware is a function that processes incoming requests \n" .
            "before they reach the main application or route handler.\n" .
            "It can modify requests, responses, or handle tasks like\n" .
            "authentication, logging, and error handling.\n" .
            "\n" .
            "@author Victor Béser\n" .
            "*/\n" .
            "// require __DIR__ . '/../models/LoadModel.php';\n\n" .
            "class " . ucfirst($fileName) . " {\n\n" .
            "    public static function handle() {\n" .
            "        // Your code here\n" .
            "    }\n\n" .
            "}";

        // Create the /app directory if it doesn't exist
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/app');
        // Create the /app/controllers directory if it doesn't exist
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/app/middlewares');

        // Check if the file already exists
        if (file_exists($path)) {
            echo "This middleware already exists\n";
        } else {
            // Create the file and write the content
            file_put_contents($path, $content);
            echo "Middleware $fileName created\n";
        }
    }

    public function generateUnitTest($fileName, $functionName)
    {
        $path = MAXITER_PROJECT_ROOT . '/tests/' . $fileName . "Test.php";

        // Content to be written to the file
        $content = "<?php\n" .
            "/*\n" .
            "This is an example of how to implement unit test into your application. \n" .
            "Feel free to try using PHP 8+ or PHP 5.3 legacy version below. \n" .
            "Checkout the /app/controllers/UnitTestController.php and /tests/UnitTestControllerTest.php \n" .
            "to see an example of how implement unit test in Maxiter!\n" .
            "\n" .
            "@author Victor Béser\n" .
            "*/\n" .
            "define('PHPUNIT_RUNNING', true);\n" .
            "use PHPUnit\Framework\TestCase;\n" .
            "require_once __DIR__ . '/../app/controllers/" . $fileName . ".php';\n\n" .
            "class " . ucfirst($fileName . "Test") . " extends TestCase {\n\n" .
            "    public function test" . ucfirst($functionName) . "() {\n" .
            "        // Your code here \n\n" .
            "    }\n\n" .
            "}";

        // Create the /tests directory if it doesn't exist
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/tests');

        // Check if the file already exists
        if (file_exists($path)) {
            echo "This unit test already exists\n";
        } else {
            // Create the file and write the content
            file_put_contents($path, $content);
            echo "Unit test " . $fileName . "Test created in /tests/ for the controller in /app/controllers/$fileName.php\n";
            echo "Do not forget to use composer install command to install necessary dependencies for the Unit Test";
        }
    }

    public function PHPUnitTest()
    {


        $cmd = "php ./vendor/bin/phpunit";
        exec($cmd, $output, $returnCode);
        if ($returnCode === 0) {
            echo implode("\n", $output);
        } else {
            echo "Error: $returnCode";
        }
    }

    public function configProdEnv()
    {
        $gitignorePath = MAXITER_PROJECT_ROOT . '/.gitignore-example';

        $entries = array(
            'vendor/',
            'bash.php',
            'gui.html',
            'maxiter',
            'phpunit.xml',
            'README.md',
            'release_notes.txt',
        );

        $current = file_exists($gitignorePath) ? file($gitignorePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

        $merged = array_unique(array_merge($current, $entries));

        sort($merged);

        file_put_contents($gitignorePath, implode(PHP_EOL, $merged) . PHP_EOL);

        echo "Generated .gitignore-example with non-prod files\n";
    }

    public function configProdEnvDel($mode = 'delete')
    {
        $baseDir = MAXITER_PROJECT_ROOT;
        $targetDir = $baseDir . '/_non-prod-files';

        $checkOnly = ($mode === 'check');
        $deleteMode = ($mode === 'delete');
        $moveMode = ($mode === 'move');
        $restoreMode = ($mode === 'restore');

        $files = array(
            array('type' => 'file', 'path' => 'bash.php', 'reason' => 'Shell PHP script (dev only)'),
            array('type' => 'file', 'path' => 'gui.html', 'reason' => 'GUI tools (dev only)'),
            array('type' => 'file', 'path' => 'phpunit.xml', 'reason' => 'PHPUnit config (tests only)'),
            array('type' => 'file', 'path' => 'phpunit.xml.dist', 'reason' => 'PHPUnit config (tests only)'),
            array('type' => 'file', 'path' => 'README.md', 'reason' => 'Documentation'),
            array('type' => 'file', 'path' => 'README', 'reason' => 'Documentation'),
            array('type' => 'file', 'path' => 'maxiter.md', 'reason' => 'Documentation'),
            array('type' => 'file', 'path' => 'release_notes.txt', 'reason' => 'Release notes'),
            array('type' => 'file', 'path' => 'CHANGELOG.md', 'reason' => 'Changelog (dev only)'),
            array('type' => 'file', 'path' => 'CONTRIBUTING.md', 'reason' => 'Contrib guide (dev only)'),
            array('type' => 'file', 'path' => '.phpunit.result.cache', 'reason' => 'PHPUnit cache'),
            array('type' => 'file', 'path' => '.gitignore', 'reason' => 'Git config (dev only)'),
            array('type' => 'file', 'path' => '.gitignore-example', 'reason' => 'Git config (dev only)'),
            array('type' => 'file', 'path' => '.gitattributes', 'reason' => 'Git config (dev only)'),
            array('type' => 'file', 'path' => '.travis.yml', 'reason' => 'CI pipeline (dev only)'),
            array('type' => 'file', 'path' => '.github', 'reason' => 'GitHub CI workflows'),
            array('type' => 'file', 'path' => '.circleci', 'reason' => 'CI pipeline (dev only)'),
            array('type' => 'file', 'path' => '.editorconfig', 'reason' => 'IDE formatter (dev only)'),
            array('type' => 'file', 'path' => '.vscode', 'reason' => 'IDE config (dev only)'),
            array('type' => 'file', 'path' => '.idea', 'reason' => 'IDE config (dev only)'),
            array('type' => 'file', 'path' => 'phpcs.xml', 'reason' => 'Code style (dev only)'),
            array('type' => 'file', 'path' => 'phpcs.xml.dist', 'reason' => 'Code style (dev only)'),
            array('type' => 'file', 'path' => 'phpmd.xml', 'reason' => 'Mess detector (dev only)'),
            array('type' => 'file', 'path' => 'psalm.xml', 'reason' => 'Static analysis (dev only)'),
            array('type' => 'file', 'path' => 'psalm.xml.dist', 'reason' => 'Static analysis (dev only)'),
            array('type' => 'file', 'path' => 'phpstan.neon', 'reason' => 'Static analysis (dev only)'),
            array('type' => 'file', 'path' => 'phpstan.neon.dist', 'reason' => 'Static analysis (dev only)'),
            array('type' => 'file', 'path' => 'infection.json.dist', 'reason' => 'Mutation testing (dev only)'),
            array('type' => 'file', 'path' => 'box.json', 'reason' => 'Phar build (dev only)'),
            array('type' => 'file', 'path' => 'Dockerfile', 'reason' => 'Container build (CI/dev only)'),
            array('type' => 'file', 'path' => 'docker-compose.yml', 'reason' => 'Container stack (dev only)'),
            array('type' => 'file', 'path' => 'docker-compose.override.yml', 'reason' => 'Container stack (dev only)'),
            array('type' => 'file', 'path' => 'Makefile', 'reason' => 'Build/run tasks (dev only)'),
            array('type' => 'dir',  'path' => 'tests', 'reason' => 'Unit/feature tests'),
            array('type' => 'dir',  'path' => 'test', 'reason' => 'Unit/feature tests'),
            array('type' => 'dir',  'path' => 'Tests', 'reason' => 'Unit/feature tests'),
            array('type' => 'dir',  'path' => '__tests__', 'reason' => 'Unit/feature tests'),
            array('type' => 'dir',  'path' => 'spec', 'reason' => 'Spec/BDD tests'),
            array('type' => 'dir',  'path' => 'features', 'reason' => 'Behat BDD tests'),
            array('type' => 'dir',  'path' => 'coverage', 'reason' => 'Code coverage report'),
            array('type' => 'dir',  'path' => 'build', 'reason' => 'Build artifacts (dev only)'),
            array('type' => 'dir',  'path' => 'docs', 'reason' => 'Documentation folder'),
            array('type' => 'dir',  'path' => 'documentation', 'reason' => 'Documentation folder'),
            array('type' => 'dir',  'path' => '.github', 'reason' => 'GitHub workflows/configs'),
            array('type' => 'dir',  'path' => '.vscode', 'reason' => 'IDE config (dev only)'),
            array('type' => 'dir',  'path' => '.idea', 'reason' => 'IDE config (dev only)'),
            array('type' => 'file', 'path' => 'bootstrap/server/.maxiter_dev_server', 'reason' => 'Dev server flag (dev only)'),
            array('type' => 'file', 'path' => 'bootstrap/server/.maxiter_dev_server', 'reason' => 'Dev server flag (dev only)'),
            array('type' => 'dir',  'path' => '_non-prod-files', 'reason' => 'Previous non-prod backup folder'),
        );

        $envFiles = array(
            'env.ini', '.env', '.env.example', '.env-example', '.env.local', '.env.production',
            '.env.staging', '.env.ci', '.env.test', '.env.dev', '.env.development',
        );
        foreach ($envFiles as $e) {
            $files[] = array('type' => 'file', 'path' => $e, 'reason' => 'Env/config file (prod MUST be set manually)');
        }

        $logFiles = array(
            'error_log', 'access_log', 'debug.log', 'app.log',
        );
        foreach ($logFiles as $l) {
            $files[] = array('type' => 'file', 'path' => $l, 'reason' => 'Log file');
        }

        $maxiterDevRoot = rtrim(str_replace('\\', '/', $baseDir), '/');
        $globPatterns = array(
            '_test_*.php', 'test_*.php', '*_test.php',
            '*.log', '*.tmp', '*.bak', '*.swp', '*.swo', '*~',
        );
        $scannedGlob = array();
        foreach ($globPatterns as $pat) {
            $matches = @glob($maxiterDevRoot . '/' . $pat, GLOB_NOSORT | GLOB_ERR);
            if (is_array($matches)) {
                foreach ($matches as $m) {
                    $rel = substr(str_replace('\\', '/', $m), strlen($maxiterDevRoot) + 1);
                    if ($rel === '' || $rel === false || strpos($rel, '/') !== false) continue;
                    $isDot = ($rel[0] === '.');
                    if ($isDot && !in_array($rel, array('.env', '.env.example'))) continue;
                    $scannedGlob[$rel] = $rel;
                }
            }
            $matches2 = @glob($maxiterDevRoot . '/_*_*.php', GLOB_NOSORT | GLOB_ERR);
            if (is_array($matches2)) {
                foreach ($matches2 as $m) {
                    $rel = substr(str_replace('\\', '/', $m), strlen($maxiterDevRoot) + 1);
                    if ($rel === '' || $rel === false || strpos($rel, '/') !== false) continue;
                    $scannedGlob[$rel] = $rel;
                }
            }
        }
        foreach ($scannedGlob as $rel) {
            $files[] = array('type' => is_dir($maxiterDevRoot . '/' . $rel) ? 'dir' : 'file', 'path' => $rel, 'reason' => 'Glob pattern dev-only file');
        }

        $seen = array();
        $finalEntries = array();
        foreach ($files as $f) {
            $key = strtolower(str_replace('\\', '/', $f['path']));
            if (isset($seen[$key])) continue;
            $seen[$key] = true;
            $finalEntries[] = $f;
        }
        $entries = $finalEntries;
        unset($finalEntries, $files, $seen, $scannedGlob);

        $stats = array(
            'processed_dirs'   => 0,
            'processed_files'  => 0,
            'not_found'        => 0,
            'skipped'          => 0,
            'bytes_freed'      => 0,
        );

        $pad = 46;
        $colorRed = "\033[0;31m";
        $colorGreen = "\033[0;32m";
        $colorYellow = "\033[0;33m";
        $colorCyan = "\033[0;36m";
        $colorDim = "\033[2;37m";
        $colorReset = "\033[0m";

        if ($checkOnly) {
            echo PHP_EOL . "{$colorCyan}╔══════════════════════════════════════════════════════════════════════╗{$colorReset}" . PHP_EOL;
            echo "{$colorCyan}║  MAXITER: DELTOPROD PREVIEW (CHECK MODE - NO FILES CHANGED)         ║{$colorReset}" . PHP_EOL;
            echo "{$colorCyan}╚══════════════════════════════════════════════════════════════════════╝{$colorReset}" . PHP_EOL . PHP_EOL;
        } else {
            if ($deleteMode) {
                echo PHP_EOL . "{$colorRed}╔══════════════════════════════════════════════════════════════════════╗{$colorReset}" . PHP_EOL;
                echo "{$colorRed}║  WARNING: DELETE MODE - FILES WILL BE PERMANENTLY REMOVED               ║{$colorReset}" . PHP_EOL;
                echo "{$colorRed}║  Use \"-f deltoprod\" (move) to move to _non-prod-files instead       ║{$colorReset}" . PHP_EOL;
                echo "{$colorRed}╚══════════════════════════════════════════════════════════════════════╝{$colorReset}" . PHP_EOL . PHP_EOL;
            }
        }

        if ($restoreMode && !is_dir($targetDir)) {
            echo "Directory not found: _non-prod-files (nothing to restore)\n";
            return;
        }
        if ($moveMode && !is_dir($targetDir)) {
            if (!$checkOnly) { @mkdir($targetDir, 0755, true); }
            echo ($checkOnly ? "{$colorYellow}[PREVIEW]{$colorReset} " : "") . "Created directory: _non-prod-files\n";
        }

        $rmDir = function ($dirPath) use (&$stats, $colorRed, $colorDim, $colorReset, $deleteMode, $moveMode, $restoreMode, $checkOnly) {
            if (!is_dir($dirPath)) return;
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($dirPath, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($iterator as $item) {
                if ($item->isFile()) {
                    $p = $item->getPathname();
                    $sz = @filesize($p);
                    if ($sz > 0) $stats['bytes_freed'] += $sz;
                    if ($checkOnly) { $stats['processed_files']++; continue; }
                    if (@unlink($p)) {
                        $stats['processed_files']++;
                        if ($deleteMode) echo "   {$colorDim}Deleted file inside dir: {$p}{$colorReset}\n";
                    }
                } elseif ($item->isDir()) {
                    $p = $item->getPathname();
                    if ($checkOnly) { continue; }
                    @rmdir($p);
                }
            }
            if ($checkOnly) { return; }
            @rmdir($dirPath);
        };

        $dirSize = function ($dirPath) {
            $total = 0;
            if (!is_dir($dirPath)) return $total;
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($dirPath, RecursiveDirectoryIterator::SKIP_DOTS)
            );
            foreach ($iterator as $item) {
                if ($item->isFile()) {
                    $s = @filesize($item->getPathname());
                    if ($s > 0) $total += $s;
                }
            }
            return $total;
        };

        $fmtBytes = function ($bytes) {
            $units = array('B','KB','MB','GB');
            $i = 0; $b = (float)$bytes;
            while ($b >= 1024 && $i < count($units) - 1) { $b /= 1024; $i++; }
            return number_format($b, 2, ',', '.') . ' ' . $units[$i];
        };

        $copyDir = function ($src, $dst) use (&$stats) {
            if (!is_dir($src)) return false;
            if (!is_dir($dst)) { @mkdir($dst, 0755, true); }
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($iterator as $item) {
                $subPath = $iterator->getSubPathName();
                $target = $dst . '/' . $subPath;
                if ($item->isDir()) {
                    if (!is_dir($target)) @mkdir($target, 0755, true);
                } else {
                    $sz = @filesize($item->getPathname());
                    if (@copy($item->getPathname(), $target)) {
                        if ($sz > 0) $stats['bytes_freed'] += $sz;
                    }
                }
            }
            return true;
        };

        $deleteDirContents = function ($dirPath) use ($rmDir) {
            $rmDir($dirPath);
        };

        foreach ($entries as $idx => $entry) {
            $type = $entry['type'];
            $relPath = str_replace('\\', '/', $entry['path']);
            $reason = !empty($entry['reason']) ? $entry['reason'] : 'non-prod';
            $labelType = ($type === 'dir') ? "[DIR]" : "[FILE]";
            $fullPath = $baseDir . '/' . $relPath;

            if ($restoreMode) {
                $src = $targetDir . '/' . basename($relPath);
                $dest = $fullPath;
            } else {
                $src = $fullPath;
                $dest = $targetDir . '/' . basename($relPath);
            }

            $exists = false;
            if ($restoreMode) {
                $exists = (file_exists($src) || is_dir($src));
            } else {
                $exists = ($type === 'dir') ? is_dir($src) : is_file($src);
            }
            if (!$exists) {
                $stats['not_found']++;
                if ($checkOnly) {
                    echo "{$colorDim}  [SKIP] " . str_pad($labelType . ' ' . $relPath, $pad, ' ') . "   (not found)  {$reason}{$colorReset}\n";
                }
                continue;
            }

            if (strpos(basename($relPath), '_non-prod-files') !== false && !$restoreMode && !$deleteMode && !$moveMode && !$checkOnly) {
                $stats['skipped']++;
                continue;
            }

            $sizeHuman = '';
            if ($type === 'dir') {
                $sz = $dirSize($src);
            } else {
                $sz = @filesize($src);
                $sz = ($sz === false) ? 0 : (int)$sz;
            }
            if ($sz > 0) {
                $sizeHuman = '(' . $fmtBytes($sz) . ')';
            }

            if ($checkOnly) {
                $color = ($type === 'dir') ? $colorYellow : $colorCyan;
                echo "  {$color}[REMOVE]{$colorReset} " . str_pad($labelType . ' ' . $relPath . ' ' . $sizeHuman, $pad, ' ') . " {$reason}\n";
                $stats['bytes_freed'] += $sz;
                if ($type === 'dir') {
                    $stats['processed_dirs']++;
                    $it = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS)
                    );
                    $count = 0;
                    foreach ($it as $f) { if ($f->isFile()) $count++; }
                    $stats['processed_files'] += $count;
                } else {
                    $stats['processed_files']++;
                }
                continue;
            }

            if ($deleteMode) {
                if ($type === 'dir') {
                    $deleteDirContents($src);
                    if (is_dir($src)) @rmdir($src);
                    $stats['processed_dirs']++;
                    echo " {$colorRed}[DELETE_DIR]{$colorReset} {$relPath} {$sizeHuman}\n";
                } else {
                    if (@unlink($src)) {
                        $stats['processed_files']++;
                        echo " {$colorRed}[DELETE_FILE]{$colorReset} {$relPath} {$sizeHuman}\n";
                    } else {
                        $stats['skipped']++;
                        echo " {$colorYellow}[SKIP_FAIL]{$colorReset} {$relPath} {$sizeHuman}\n";
                    }
                }
            } elseif ($moveMode) {
                if (is_file($dest) || is_dir($dest)) {
                    $backupTarget = $targetDir . '/' . basename($relPath) . '~bak_' . date('YmdHis');
                    if (@rename($dest, $backupTarget)) {
                        echo " {$colorDim}[MOVED_EXISTING_BAK] " . basename($dest) . " -> " . basename($backupTarget) . "{$colorReset}\n";
                    }
                }
                if ($type === 'dir') {
                    $copyDir($src, $dest);
                    $deleteDirContents($src);
                    if (is_dir($src)) @rmdir($src);
                    $stats['processed_dirs']++;
                    echo " {$colorGreen}[MOVE_DIR]{$colorReset} {$relPath} -> _non-prod-files/ {$sizeHuman}\n";
                } else {
                    if (@rename($src, $dest)) {
                        $stats['processed_files']++;
                        echo " {$colorGreen}[MOVE_FILE]{$colorReset} {$relPath} -> _non-prod-files/ {$sizeHuman}\n";
                    } else {
                        if (@copy($src, $dest) && @unlink($src)) {
                            $stats['processed_files']++;
                            echo " {$colorGreen}[COPY+DEL]{$colorReset} {$relPath} -> _non-prod-files/ {$sizeHuman}\n";
                        } else {
                            $stats['skipped']++;
                            echo " {$colorYellow}[SKIP_FAIL]{$colorReset} {$relPath} {$sizeHuman}\n";
                        }
                    }
                }
            } elseif ($restoreMode) {
                if (is_file($dest) || is_dir($dest)) {
                    $backupTarget = $dest . '~restored_bak_' . date('YmdHis');
                    if (@rename($dest, $backupTarget)) {
                        echo " {$colorDim}[RESTORE_BAK] existing -> " . basename($backupTarget) . "{$colorReset}\n";
                    }
                }
                if ($type === 'dir') {
                    $copyDir($src, $dest);
                    $deleteDirContents($src);
                    if (is_dir($src)) @rmdir($src);
                    $stats['processed_dirs']++;
                    echo " {$colorGreen}[RESTORE_DIR]{$colorReset} _non-prod-files/" . basename($relPath) . " -> root {$sizeHuman}\n";
                } else {
                    if (@rename($src, $dest)) {
                        $stats['processed_files']++;
                        echo " {$colorGreen}[RESTORE_FILE]{$colorReset} _non-prod-files/" . basename($relPath) . " -> root {$sizeHuman}\n";
                    } else {
                        if (@copy($src, $dest) && @unlink($src)) {
                            $stats['processed_files']++;
                            echo " {$colorGreen}[COPY+DEL]{$colorReset} _non-prod-files/" . basename($relPath) . " -> root {$sizeHuman}\n";
                        } else {
                            $stats['skipped']++;
                            echo " {$colorYellow}[SKIP_FAIL]{$colorReset} {$relPath} {$sizeHuman}\n";
                        }
                    }
                }
            }
        }

        if ($restoreMode && is_dir($targetDir)) {
            $it = new FilesystemIterator($targetDir, FilesystemIterator::SKIP_DOTS);
            $empty = true;
            foreach ($it as $f) { $empty = false; break; }
            if ($empty) { @rmdir($targetDir); }
        }

        echo PHP_EOL . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        if ($checkOnly) {
            echo " {$colorGreen}✓ PREVIEW MODE (no files were changed){$colorReset}\n";
            echo "   Files that would be removed/moved ......... {$stats['processed_files']}\n";
            echo "   Dirs  that would be removed/moved ......... {$stats['processed_dirs']}\n";
            echo "   Space that would be freed ................. {$fmtBytes($stats['bytes_freed'])}\n";
            echo "   Files not found ........................... {$stats['not_found']}\n";
        } else {
            if ($deleteMode) {
                echo " {$colorRed}DELETE MODE executed.{$colorReset}\n";
            } elseif ($moveMode) {
                echo " {$colorGreen}MOVE MODE executed. Everything is in _non-prod-files/{$colorReset}\n";
            } elseif ($restoreMode) {
                echo " {$colorGreen}RESTORE MODE executed. Files returned to root.{$colorReset}\n";
            }
            echo "   Files processed .......................... {$stats['processed_files']}\n";
            echo "   Dirs  processed .......................... {$stats['processed_dirs']}\n";
            echo "   Files not found .......................... {$stats['not_found']}\n";
            echo "   Skipped/failed ........................... {$stats['skipped']}\n";
            echo "   Space freed .............................. {$fmtBytes($stats['bytes_freed'])}\n";
        }
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

        if (!$checkOnly && $deleteMode) {
            echo PHP_EOL . "{$colorYellow}TIP: Before deploying to production, double-check with check mode first:{$colorReset}\n";
            echo "       {$colorCyan}php maxiter -c deltoprod{$colorReset}\n";
        }
    }

    public function newComponent($componentName, $templateFolder = null)
    {


        $componentFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_$componentName";
        echo "Creating _$componentName component...\n";
        if (!is_dir($componentFolder)) {
            if (mkdir($componentFolder, 0777, true)) {
                echo "_$componentName component created successfully in /resources/views/pages/_$componentName\n";
            } else {
                echo "Failed to create _$componentName component.\n";
            }
        } else {
            echo "_$componentName component already exists.\n";
        }

        if ($templateFolder == null) {

            // Create the header.php file and write the extracted content
            $componentFile = $componentFolder . "\\$componentName.php";
            $content = "<!--********** $componentName ***********-->\n<!-- Include this file in any file using the command below: -->\n<!-- " . '<?php include __DIR__ . "/../_' . $componentName . '/' . $componentName . '.php"; ?>' . " -->";
            if (file_put_contents($componentFile, $content)) {
                echo "$componentName.php file created successfully inside the _$componentName folder.\n";
            } else {
                echo "Failed to create $componentName.php file.\n";
            }
        } else {


            // Creating files and content
            // Path to the index.html template file
            $templateFolder = MAXITER_PROJECT_ROOT . "\\src\\template\\$templateFolder";  // Template source folder
            $indexFile = $templateFolder . "\\index.html";

            // _header folder path
            $headerFolder = MAXITER_PROJECT_ROOT . "\\resources\\views\\pages\\_$componentName";

            // Check if the index file exists
            if (file_exists($indexFile)) {
                // Read the content of index.html
                $fileContent = file_get_contents($indexFile);

                // Use regular expression to extract content between @header markers
                $pattern = '/@' . $componentName . '(.*?)@' . $componentName . '/s';
                if (preg_match($pattern, $fileContent, $matches)) {
                    // $matches[1] will contain the content between the @header markers

                    // Create the _header folder if it doesn't exist
                    if (!is_dir($headerFolder)) {
                        if (mkdir($headerFolder, 0777, true)) {
                            echo "_header folder created successfully.\n";
                        } else {
                            echo "Failed to create _header folder.\n";
                        }
                    }

                    // Create the header.php file and write the extracted content
                    $headerFile = $headerFolder . "\\$componentName.php";
                    if (file_put_contents($headerFile, $matches[1])) {
                        echo "$componentName.php file created successfully inside the _$componentName folder.\n";
                    } else {
                        echo "Failed to create $componentName.php file.\n";
                    }
                } else {
                    echo "No content found between @$componentName markers.\n";
                }
            } else {
                echo "The index.html file does not exist.\n";
            }
        }
    }

    public function mirrorExport($databaseName)
    {
        $env = maxiter_load_env_config();

        if (empty($env)) {
            echo "No environment configuration found. Create env.ini or .env\n";
            return null;
        }

        $sectionName = maxiter_find_database_section($env, $databaseName);

        if ($sectionName === null) {
            echo "Database '$databaseName' not found in env.ini/.env\n";
            return null;
        }

        $driver = maxiter_get_env_value($env, $sectionName, 'DRIVER', null);
        $host   = maxiter_get_env_value($env, $sectionName, 'HOST', 'localhost');
        $port   = maxiter_get_env_value($env, $sectionName, 'PORT', '');
        $user   = maxiter_get_env_value($env, $sectionName, 'USER', '');
        $pass   = maxiter_get_env_value($env, $sectionName, 'PASS', '');
        $dbName = maxiter_get_env_value($env, $sectionName, 'DB', $sectionName);

        if ($driver === null || $driver === '') {
            echo "DRIVER not defined for database section [$sectionName]\n";
            return null;
        }

        // Normalize driver and set file extension
        $driverKey = strtolower(trim($driver));
        if (in_array($driverKey, ['mariadb'])) {
            $driverKey = 'mysql';
        }
        if (in_array($driverKey, ['psql', 'postgres', 'postgresql'])) {
            $driverKey = 'pgsql';
        }
        if (in_array($driverKey, ['sql server', 'sqlserver', 'mssql'])) {
            $driverKey = 'sqlsrv';
        }
        if (in_array($driverKey, ['oci', 'ora'])) {
            $driverKey = 'oracle';
        }

        $defaultExt = ($driverKey === 'sqlsrv') ? 'bak' : (($driverKey === 'oracle') ? 'dmp' : 'sql');
        $exportExtValue = maxiter_get_env_value($env, $sectionName, 'EXPORT_EXT', '');
        $exportExt  = $exportExtValue !== '' ? trim($exportExtValue) : $defaultExt;

        // Prepare mirror directory and target file: src/mirror/<dbName>/<dbName>-<timestamp>.<ext>
        $mirrorDir = MAXITER_PROJECT_ROOT . '/src/mirror';
        $this->createDirectory($mirrorDir);
        $dbDir    = $mirrorDir . '/' . $dbName;
        $this->createDirectory($dbDir);
        // Clean up existing exports from the same day before creating a new one
        $today = date('Ymd');
        try {
            $items = scandir($dbDir);
            foreach ($items as $it) {
                if ($it === '.' || $it === '..') continue;
                $full = $dbDir . '/' . $it;
                // Match full dump file for today: <db>-YYYYMMDD-HHMMSS.<ext>
                if (is_file($full)) {
                    if (preg_match('/^' . preg_quote($dbName, '/') . '-' . $today . '-\d{6}\.' . preg_quote($exportExt, '/') . '$/i', $it)) {
                        @unlink($full);
                    }
                }
                // Match per-table dir for today: tables-YYYYMMDD-HHMMSS
                if (is_dir($full)) {
                    if (preg_match('/^tables-' . $today . '-\d{6}$/i', $it)) {
                        $this->removeDirectory($full);
                    }
                }
            }
        } catch (Throwable $e) {
            echo "Warning: failed to cleanup same-day exports: " . $e->getMessage() . "\n";
        }

        $timestamp = date('Ymd-His');
        $fileName  = $dbName . '-' . $timestamp . '.' . $exportExt;
        $filePath  = $dbDir . '/' . $fileName;
        $tablesDir = $dbDir . '/tables-' . $timestamp;
        $this->createDirectory($tablesDir);

        // Environment flags used below
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        // Optional command prefix (e.g., "docker exec -i <container>") for running dumps inside containers
        $execPrefix = isset($env[$sectionName]['EXEC_PREFIX']) ? trim($env[$sectionName]['EXEC_PREFIX']) : '';
        $isDockerExec = $execPrefix !== '' && (stripos($execPrefix, 'docker exec') !== false || stripos($execPrefix, 'docker-compose exec') !== false);

        // Try to list tables using PDO (for per-table dumps)
        $tables = [];
        try {
            if ($driverKey === 'mysql') {
                $dsn = 'mysql:host=' . $host . ';' . ($port !== '' ? 'port=' . $port . ';' : '') . 'dbname=' . $dbName . ';charset=utf8mb4';
            } else if ($driverKey === 'pgsql' || $driverKey === 'postgres' || $driverKey === 'postgresql') {
                $dsn = 'pgsql:host=' . $host . ';' . ($port !== '' ? 'port=' . $port . ';' : '') . 'dbname=' . $dbName;
            } else {
                $dsn = '';
            }
            if ($dsn !== '') {
                $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                if ($driverKey === 'mysql') {
                    $stmt = $pdo->query('SHOW TABLES');
                    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                        if (!empty($row[0])) $tables[] = $row[0];
                    }
                } else {
                    $stmt = $pdo->query("SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname = 'public'");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        if (!empty($row['tablename'])) $tables[] = $row['tablename'];
                    }
                }
            }
        } catch (Throwable $e) {
            echo "Warning: failed to list tables via PDO: " . $e->getMessage() . "\n";
        }



        if ($driverKey === 'mysql') {
            // Resolve mysqldump binary: allow override via env.ini, then Windows XAMPP path, else PATH
            $mysqldump = isset($env[$sectionName]['MYSQLDUMP_PATH']) && $env[$sectionName]['MYSQLDUMP_PATH'] !== '' ? $env[$sectionName]['MYSQLDUMP_PATH'] : 'mysqldump';
            if ($isWindows && $mysqldump === 'mysqldump') {
                $defaultWinPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
                if (file_exists($defaultWinPath)) {
                    $mysqldump = $defaultWinPath;
                }
            }

            // Use --result-file to avoid redirecting errors into the dump file (Windows-friendly)
            echo "Exporting database '$dbName' to '$filePath'...\n";
            $this->flushOutput();
            $cmd = ($execPrefix !== '' ? $execPrefix . ' ' : '') . '"' . $mysqldump . '"'
                . ' --host="' . $host . '"'
                . ($port !== '' ? ' --port="' . $port . '"' : '')
                . ' --user="' . $user . '"'
                . ' --password="' . $pass . '"'
                . ' --routines --events --triggers --single-transaction --add-drop-table'
                . ' --result-file="' . $filePath . '"'
                . ' "' . $dbName . '"';

            shell_exec($cmd);

            if (file_exists($filePath) && filesize($filePath) > 0) {
                echo "Exported: $filePath (" . round(filesize($filePath) / 1024, 1) . " KB)\n";
                // Export each table individually
                $count = 0;
                foreach ($tables as $table) {
                    echo "  -> Exporting table '$table'...";
                    $this->flushOutput();
                    $tableFile = $tablesDir . '/' . $table . '.sql';
                    $tcmd = ($execPrefix !== '' ? $execPrefix . ' ' : '') . '"' . $mysqldump . '"'
                        . ' --host="' . $host . '"'
                        . ($port !== '' ? ' --port="' . $port . '"' : '')
                        . ' --user="' . $user . '"'
                        . ' --password="' . $pass . '"'
                        . ' --triggers --single-transaction --add-drop-table'
                        . ' --result-file="' . $tableFile . '"'
                        . ' "' . $dbName . '" "' . $table . '"';

                    shell_exec($tcmd);
                    if (file_exists($tableFile) && filesize($tableFile) > 0) {
                        echo " OK (" . round(filesize($tableFile) / 1024, 1) . " KB)\n";
                        $count++;
                    } else {
                        echo " FAILED\n";
                    }
                }
                if (!empty($tables)) {
                    echo "Exported tables: $count to $tablesDir\n";
                }
                return $filePath;
            } else {
                echo "Failed to export MySQL database. Ensure mysqldump is installed and credentials are correct.\n";
                return null;
            }
        } else if ($driverKey === 'pgsql') {
            // Resolve pg_dump binary: allow override via env.ini, else PATH
            $pgDump = isset($env[$sectionName]['PG_DUMP_PATH']) && $env[$sectionName]['PG_DUMP_PATH'] !== '' ? $env[$sectionName]['PG_DUMP_PATH'] : 'pg_dump';

            if ($isWindows) {
                echo "Exporting database '$dbName' to '$filePath'...\n";
                $this->flushOutput();
                if ($isDockerExec) {
                    // Pass PGPASSWORD to the container environment
                    $cmd = $execPrefix . ' -e PGPASSWORD="' . $pass . '" ' . '"' . $pgDump . '"'
                        . ' --host="' . $host . '"'
                        . ($port !== '' ? ' --port="' . $port . '"' : '')
                        . ' --username="' . $user . '"'
                        . ' --format=p --no-owner'
                        . ' --file="' . $filePath . '"'
                        . ' "' . $dbName . '" 2>&1';
                } else {
                    $cmd = 'set "PGPASSWORD=' . $pass . '" && ' . '"' . $pgDump . '"'
                        . ' --host="' . $host . '"'
                        . ($port !== '' ? ' --port="' . $port . '"' : '')
                        . ' --username="' . $user . '"'
                        . ' --format=p --no-owner'
                        . ' --file="' . $filePath . '"'
                        . ' "' . $dbName . '" 2>&1';
                }
            } else {
                echo "Exporting database '$dbName' to '$filePath'...\n";
                $this->flushOutput();
                if ($isDockerExec) {
                    // Pass PGPASSWORD to the container environment
                    $cmd = $execPrefix . ' -e PGPASSWORD="' . $pass . '" ' . '"' . $pgDump . '"'
                        . ' --host="' . $host . '"'
                        . ($port !== '' ? ' --port="' . $port . '"' : '')
                        . ' --username="' . $user . '"'
                        . ' --format=p --no-owner'
                        . ' --file="' . $filePath . '"'
                        . ' "' . $dbName . '" 2>&1';
                } else {
                    $cmd = 'PGPASSWORD="' . $pass . '" ' . '"' . $pgDump . '"'
                        . ' --host="' . $host . '"'
                        . ($port !== '' ? ' --port="' . $port . '"' : '')
                        . ' --username="' . $user . '"'
                        . ' --format=p --no-owner'
                        . ' --file="' . $filePath . '"'
                        . ' "' . $dbName . '" 2>&1';
                }
            }

            shell_exec($cmd);

            if (file_exists($filePath) && filesize($filePath) > 0) {
                echo "Exported: $filePath (" . round(filesize($filePath) / 1024, 1) . " KB)\n";
                // Export each table individually
                $count = 0;
                foreach ($tables as $table) {
                    echo "  -> Exporting table '$table'...";
                    $this->flushOutput();
                    $tableFile = $tablesDir . '/' . $table . '.sql';
                    if ($isWindows) {
                        if ($isDockerExec) {
                            $tc = $execPrefix . ' -e PGPASSWORD="' . $pass . '" ' . '"' . $pgDump . '"'
                                . ' --host="' . $host . '"'
                                . ($port !== '' ? ' --port="' . $port . '"' : '')
                                . ' --username="' . $user . '"'
                                . ' --format=p --no-owner'
                                . ' -t public."' . $table . '"'
                                . ' --file="' . $tableFile . '"'
                                . ' "' . $dbName . '"';
                        } else {
                            $tc = 'set "PGPASSWORD=' . $pass . '" && ' . '"' . $pgDump . '"'
                                . ' --host="' . $host . '"'
                                . ($port !== '' ? ' --port="' . $port . '"' : '')
                                . ' --username="' . $user . '"'
                                . ' --format=p --no-owner'
                                . ' -t public."' . $table . '"'
                                . ' --file="' . $tableFile . '"'
                                . ' "' . $dbName . '"';
                        }
                    } else {
                        if ($isDockerExec) {
                            $tc = $execPrefix . ' -e PGPASSWORD="' . $pass . '" ' . '"' . $pgDump . '"'
                                . ' --host="' . $host . '"'
                                . ($port !== '' ? ' --port="' . $port . '"' : '')
                                . ' --username="' . $user . '"'
                                . ' --format=p --no-owner'
                                . ' -t public."' . $table . '"'
                                . ' --file="' . $tableFile . '"'
                                . ' "' . $dbName . '"';
                        } else {
                            $tc = 'PGPASSWORD="' . $pass . '" ' . '"' . $pgDump . '"'
                                . ' --host="' . $host . '"'
                                . ($port !== '' ? ' --port="' . $port . '"' : '')
                                . ' --username="' . $user . '"'
                                . ' --format=p --no-owner'
                                . ' -t public."' . $table . '"'
                                . ' --file="' . $tableFile . '"'
                                . ' "' . $dbName . '"';
                        }
                    }

                    shell_exec($tc);
                    if (file_exists($tableFile) && filesize($tableFile) > 0) {
                        echo " OK (" . round(filesize($tableFile) / 1024, 1) . " KB)\n";
                        $count++;
                    } else {
                        echo " FAILED\n";
                    }
                }
                if (!empty($tables)) {
                    echo "Exported tables: $count to $tablesDir\n";
                }
                return $filePath;
            } else {
                echo "Failed to export PostgreSQL database. Ensure pg_dump is installed and credentials are correct.\n";
                return null;
            }
        } else if ($driverKey === 'sqlsrv') {
            // SQL Server: generate a full database backup (.bak) using sqlcmd
            $sqlcmd = isset($env[$sectionName]['SQLCMD_PATH']) && $env[$sectionName]['SQLCMD_PATH'] !== '' ? $env[$sectionName]['SQLCMD_PATH'] : 'sqlcmd';
            $server = $host . ($port !== '' ? ',' . $port : '');

            echo "Exporting SQL Server database '$dbName' to '$filePath'...\n";
            $this->flushOutput();

            // Allow custom command override if provided
            $customCmd = trim(maxiter_get_env_value($env, $sectionName, 'CUSTOM_EXPORT_CMD', ''));
            if ($customCmd !== '') {
                $replacements = [
                    '%HOST%' => $host,
                    '%PORT%' => $port,
                    '%USER%' => $user,
                    '%PASS%' => $pass,
                    '%DB%'   => $dbName,
                    '%FILE%' => $filePath,
                ];
                $cmd = ($execPrefix !== '' ? $execPrefix . ' ' : '') . strtr($customCmd, $replacements);
            } else {
                $backupQuery = "BACKUP DATABASE [" . $dbName . "] TO DISK = N'" . $filePath . "' WITH INIT, COPY_ONLY";
                $cmd = ($execPrefix !== '' ? $execPrefix . ' ' : '') . '"' . $sqlcmd . '"'
                    . ' -S "' . $server . '"'
                    . ' -U "' . $user . '" -P "' . $pass . '"'
                    . ' -Q "' . $backupQuery . '" -b';
            }

            shell_exec($cmd);
            if (file_exists($filePath) && filesize($filePath) > 0) {
                echo "Exported: $filePath (" . round(filesize($filePath) / 1024, 1) . " KB)\n";
                // Per-table SQL scripts are not supported via sqlcmd by default
                echo "Note: per-table .sql exports are not available for SQL Server.\n";
                return $filePath;
            } else {
                echo "Failed to export SQL Server database. Ensure sqlcmd is installed, credentials are correct, and the path is writable.\n";
                return null;
            }
        } else if ($driverKey === 'oracle') {
            // Oracle: require a custom export command due to tooling variability (expdp/sqlplus)
            echo "Exporting Oracle database '$dbName' to '$filePath'...\n";
            $this->flushOutput();

            $customCmd = trim(maxiter_get_env_value($env, $sectionName, 'CUSTOM_EXPORT_CMD', ''));
            if ($customCmd === '') {
                echo "Oracle export requires CUSTOM_EXPORT_CMD in env.ini/.env (templated with %HOST%, %PORT%, %USER%, %PASS%, %DB%, %FILE%).\n";
                echo "Example: expdp %USER%/%PASS%@%HOST%:%PORT%/%DB% full=y dumpfile=%FILE%\n";
                return null;
            }

            $replacements = [
                '%HOST%' => $host,
                '%PORT%' => ($port !== '' ? $port : '1521'),
                '%USER%' => $user,
                '%PASS%' => $pass,
                '%DB%'   => $dbName,
                '%FILE%' => $filePath,
            ];
            $cmd = ($execPrefix !== '' ? $execPrefix . ' ' : '') . strtr($customCmd, $replacements);
            shell_exec($cmd);
            if (file_exists($filePath) && filesize($filePath) > 0) {
                echo "Exported: $filePath (" . round(filesize($filePath) / 1024, 1) . " KB)\n";
                echo "Note: Oracle per-table .sql exports are not available by default in this mode.\n";
                return $filePath;
            } else {
                echo "Failed to export Oracle database. Check CUSTOM_EXPORT_CMD tooling and ensure the target path is mounted/writable.\n";
                return null;
            }
        } else {
            echo "Unsupported driver '$driver' for export. Supported: mysql/mariadb, pgsql/psql, sql server (sqlcmd), oracle (custom).\n";
            return null;
        }
    }

    public function mirrorImport($databaseName, $date = null)
    {
        $env = maxiter_load_env_config();

        if (empty($env)) {
            echo "No environment configuration found. Create env.ini or .env\n";
            return null;
        }

        $sectionName = maxiter_find_database_section($env, $databaseName);

        if ($sectionName === null) {
            echo "Database '$databaseName' not found in env.ini/.env\n";
            return null;
        }

        $driver = maxiter_get_env_value($env, $sectionName, 'DRIVER', null);
        $host   = maxiter_get_env_value($env, $sectionName, 'HOST', 'localhost');
        $port   = maxiter_get_env_value($env, $sectionName, 'PORT', '');
        $user   = maxiter_get_env_value($env, $sectionName, 'USER', '');
        $pass   = maxiter_get_env_value($env, $sectionName, 'PASS', '');
        $dbName = maxiter_get_env_value($env, $sectionName, 'DB', $sectionName);

        if ($driver === null || $driver === '') {
            echo "DRIVER not defined for database section [$sectionName]\n";
            return null;
        }

        // Normalize driver and determine file extension
        $driverKey = strtolower(trim($driver));
        if (in_array($driverKey, ['mariadb'])) {
            $driverKey = 'mysql';
        }
        if (in_array($driverKey, ['psql', 'postgres', 'postgresql'])) {
            $driverKey = 'pgsql';
        }
        if (in_array($driverKey, ['sql server', 'sqlserver', 'mssql'])) {
            $driverKey = 'sqlsrv';
        }
        if (in_array($driverKey, ['oci', 'ora'])) {
            $driverKey = 'oracle';
        }

        $defaultExt = ($driverKey === 'sqlsrv') ? 'bak' : (($driverKey === 'oracle') ? 'dmp' : 'sql');
        $importExtValue = maxiter_get_env_value($env, $sectionName, 'EXPORT_EXT', '');
        $importExt  = $importExtValue !== '' ? trim($importExtValue) : $defaultExt;

        // Prepare mirror directory: src/mirror/<dbName>
        $mirrorDir = MAXITER_PROJECT_ROOT . '/src/mirror';
        $dbDir     = $mirrorDir . '/' . $dbName;
        if (!is_dir($dbDir)) {
            echo "Import directory not found: $dbDir\n";
            return null;
        }

        // Environment flags and optional exec prefix (e.g., docker exec)
        $isWindows  = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $execPrefix = isset($env[$sectionName]['EXEC_PREFIX']) ? trim($env[$sectionName]['EXEC_PREFIX']) : '';
        $isDockerExec = $execPrefix !== '' && (stripos($execPrefix, 'docker exec') !== false || stripos($execPrefix, 'docker-compose exec') !== false);

        // Optional date filter (expected format dd-mm-yyyy). If provided, only full dump is considered.
        $targetYmd = null; // YYYYMMDD
        if ($date !== null && trim($date) !== '') {
            $dateNorm = str_replace(['/', '.', ' '], ['-', '-', '-'], trim($date));
            if (preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $dateNorm, $m)) {
                // Build YYYYMMDD from dd-mm-yyyy
                $targetYmd = $m[3] . $m[2] . $m[1];
                echo "Filtering by date: " . $m[1] . '-' . $m[2] . '-' . $m[3] . "\n";
                $this->flushOutput();
            } else {
                echo "Invalid date format '$date' (expected dd-mm-yyyy). Using latest.\n";
                $this->flushOutput();
            }
        }

        // Locate full dump file by name timestamp; prefer latest or match specific date
        $pattern = $dbDir . '/' . $dbName . '-*.' . $importExt;
        $selectedFile = null;
        $bestStamp = -1; // numeric YYYYMMDDHHMMSS
        $files = glob($pattern);
        if (is_array($files)) {
            foreach ($files as $f) {
                if (!is_file($f)) {
                    continue;
                }
                $base = basename($f);
                // Match -YYYYMMDD-HHMMSS before extension
                $extEsc = preg_quote($importExt, '/');
                if (preg_match('/-([0-9]{8})-([0-9]{6})\.' . $extEsc . '$/i', $base, $m)) {
                    $ymd = $m[1];
                    $his = $m[2];
                    if ($targetYmd !== null && $ymd !== $targetYmd) {
                        continue;
                    }
                    $stamp = (int)($ymd . $his);
                    if ($stamp > $bestStamp) {
                        $bestStamp = $stamp;
                        $selectedFile = $f;
                    }
                }
            }
        }

        // If no full dump selected and no date filter, locate latest per-table directory
        $latestTablesDir = null;
        if ($selectedFile === null && $targetYmd === null) {
            $candidateDirs = glob($dbDir . '/tables-*');
            if (is_array($candidateDirs)) {
                $bestDirStamp = -1;
                foreach ($candidateDirs as $d) {
                    if (!is_dir($d)) {
                        continue;
                    }
                    $base = basename($d);
                    if (preg_match('/tables-([0-9]{8})-([0-9]{6})$/', $base, $m)) {
                        $stamp = (int)($m[1] . $m[2]);
                        if ($stamp > $bestDirStamp) {
                            $bestDirStamp = $stamp;
                            $latestTablesDir = $d;
                        }
                    }
                }
            }
        }

        if ($selectedFile !== null) {
            echo "Importing database '$dbName' from '$selectedFile'...\n";
            $this->flushOutput();

            if ($driverKey === 'mysql') {
                // Resolve mysql client binary
                $mysql = isset($env[$sectionName]['MYSQL_PATH']) && $env[$sectionName]['MYSQL_PATH'] !== '' ? $env[$sectionName]['MYSQL_PATH'] : 'mysql';
                if ($isWindows && $mysql === 'mysql') {
                    $defaultWinPath = 'C:\\xampp\\mysql\\bin\\mysql.exe';
                    if (file_exists($defaultWinPath)) {
                        $mysql = $defaultWinPath;
                    }
                }

                // Overwrite: drop and recreate database to import cleanly
                $dropCreateCmd = ($execPrefix !== '' ? $execPrefix . ' ' : '') . '"' . $mysql . '"'
                    . ' --host="' . $host . '"'
                    . ($port !== '' ? ' --port="' . $port . '"' : '')
                    . ' --user="' . $user . '"'
                    . ' --password="' . $pass . '"'
                    . ' -e "DROP DATABASE IF EXISTS `' . $dbName . '`; CREATE DATABASE `' . $dbName . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"';
                $dropCreateStatus = 0;
                $dropCreateOutput = [];
                @exec($dropCreateCmd, $dropCreateOutput, $dropCreateStatus);
                if ($dropCreateStatus !== 0) {
                    echo "Warning: failed to drop/recreate database '$dbName' (exit $dropCreateStatus). Proceeding with import.\n";
                }

                // Use client-side source to import the file (works on Windows and avoids redirection issues)
                // Normalize Windows path separators for mysql 'source' command
                $selectedFileForMysql = str_replace('\\', '/', $selectedFile);
                $cmd = ($execPrefix !== '' ? $execPrefix . ' ' : '') . '"' . $mysql . '"'
                    . ' --host="' . $host . '"'
                    . ($port !== '' ? ' --port="' . $port . '"' : '')
                    . ' --user="' . $user . '"'
                    . ' --password="' . $pass . '"'
                    . ' "' . $dbName . '"'
                    . ' -e "SET FOREIGN_KEY_CHECKS=0; source ' . $selectedFileForMysql . '; SET FOREIGN_KEY_CHECKS=1;"';
                $importStatus = 0;
                $importOutput = [];
                @exec($cmd, $importOutput, $importStatus);
                if ($importStatus === 0) {
                    echo "Imported: $selectedFile\n";
                    return $selectedFile;
                } else {
                    echo "Import failed for '$selectedFile' (exit $importStatus).\n";
                    return null;
                }
            } else if ($driverKey === 'pgsql') {
                // Resolve psql binary
                $psql = isset($env[$sectionName]['PSQL_PATH']) && $env[$sectionName]['PSQL_PATH'] !== '' ? $env[$sectionName]['PSQL_PATH'] : 'psql';

                if ($isWindows) {
                    if ($isDockerExec) {
                        $cmd = $execPrefix . ' -e PGPASSWORD="' . $pass . '" ' . '"' . $psql . '"'
                            . ' -h "' . $host . '"'
                            . ($port !== '' ? ' -p "' . $port . '"' : '')
                            . ' -U "' . $user . '"'
                            . ' -d "' . $dbName . '"'
                            . ' -v ON_ERROR_STOP=1'
                            . ' -f "' . $selectedFile . '"';
                    } else {
                        $cmd = 'set "PGPASSWORD=' . $pass . '" && ' . '"' . $psql . '"'
                            . ' -h "' . $host . '"'
                            . ($port !== '' ? ' -p "' . $port . '"' : '')
                            . ' -U "' . $user . '"'
                            . ' -d "' . $dbName . '"'
                            . ' -v ON_ERROR_STOP=1'
                            . ' -f "' . $selectedFile . '"';
                    }
                } else {
                    if ($isDockerExec) {
                        $cmd = $execPrefix . ' -e PGPASSWORD="' . $pass . '" ' . '"' . $psql . '"'
                            . ' -h "' . $host . '"'
                            . ($port !== '' ? ' -p "' . $port . '"' : '')
                            . ' -U "' . $user . '"'
                            . ' -d "' . $dbName . '"'
                            . ' -v ON_ERROR_STOP=1'
                            . ' -f "' . $selectedFile . '"';
                    } else {
                        $cmd = 'PGPASSWORD="' . $pass . '" ' . '"' . $psql . '"'
                            . ' -h "' . $host . '"'
                            . ($port !== '' ? ' -p "' . $port . '"' : '')
                            . ' -U "' . $user . '"'
                            . ' -d "' . $dbName . '"'
                            . ' -v ON_ERROR_STOP=1'
                            . ' -f "' . $selectedFile . '"';
                    }
                }

                shell_exec($cmd);
                echo "Imported: $selectedFile\n";
                return $selectedFile;
            } else if ($driverKey === 'sqlsrv') {
                // SQL Server restore from .bak
                $sqlcmd = isset($env[$sectionName]['SQLCMD_PATH']) && $env[$sectionName]['SQLCMD_PATH'] !== '' ? $env[$sectionName]['SQLCMD_PATH'] : 'sqlcmd';
                $server  = $host . ($port !== '' ? ',' . $port : '');
                $serverFile = isset($env[$sectionName]['SERVER_FILE_PATH']) && $env[$sectionName]['SERVER_FILE_PATH'] !== '' ? $env[$sectionName]['SERVER_FILE_PATH'] : $selectedFile;

                echo "Note: SQL Server requires the .bak to be readable by the server service.\n";
                $restoreQuery = "RESTORE DATABASE [" . $dbName . "] FROM DISK = N'" . $serverFile . "' WITH REPLACE";
                $cmd = ($execPrefix !== '' ? $execPrefix . ' ' : '') . '"' . $sqlcmd . '"'
                    . ' -S "' . $server . '" -U "' . $user . '" -P "' . $pass . '"'
                    . ' -Q "' . $restoreQuery . '" -b';

                shell_exec($cmd);
                echo "Restore command executed. Check SQL Server for completion.\n";
                return $selectedFile;
            } else if ($driverKey === 'oracle') {
                // Oracle import requires a custom command (impdp/sqlplus) with directory objects set up
                $customCmd = trim(maxiter_get_env_value($env, $sectionName, 'CUSTOM_IMPORT_CMD', ''));
                if ($customCmd === '') {
                    echo "Oracle import requires CUSTOM_IMPORT_CMD in env.ini/.env (templated with %HOST%, %PORT%, %USER%, %PASS%, %DB%, %FILE%).\n";
                    echo "Example: impdp %USER%/%PASS%@%HOST%:%PORT%/%DB% full=y dumpfile=%FILE%\n";
                    return null;
                }
                $replacements = [
                    '%HOST%' => $host,
                    '%PORT%' => ($port !== '' ? $port : '1521'),
                    '%USER%' => $user,
                    '%PASS%' => $pass,
                    '%DB%'   => $dbName,
                    '%FILE%' => $selectedFile,
                ];
                $cmd = ($execPrefix !== '' ? $execPrefix . ' ' : '') . strtr($customCmd, $replacements);
                shell_exec($cmd);
                echo "Import command executed for Oracle.\n";
                return $selectedFile;
            } else {
                echo "Unsupported driver '$driver' for import.\n";
                return null;
            }
        } else if ($latestTablesDir !== null) {
            echo "No full dump found. Importing per-table from '$latestTablesDir'...\n";
            $this->flushOutput();

            // Gather table files
            $tableFiles = [];
            $items = scandir($latestTablesDir);
            foreach ($items as $it) {
                if ($it !== '.' && $it !== '..' && substr($it, -4) === '.sql') {
                    $tableFiles[] = $latestTablesDir . '/' . $it;
                }
            }

            if ($driverKey === 'mysql') {
                $mysql = isset($env[$sectionName]['MYSQL_PATH']) && $env[$sectionName]['MYSQL_PATH'] !== '' ? $env[$sectionName]['MYSQL_PATH'] : 'mysql';
                if ($isWindows && $mysql === 'mysql') {
                    $defaultWinPath = 'C:\\xampp\\mysql\\bin\\mysql.exe';
                    if (file_exists($defaultWinPath)) {
                        $mysql = $defaultWinPath;
                    }
                }
                // Overwrite: drop and recreate database before per-table import
                $dropCreateCmd = ($execPrefix !== '' ? $execPrefix . ' ' : '') . '"' . $mysql . '"'
                    . ' --host="' . $host . '"'
                    . ($port !== '' ? ' --port="' . $port . '"' : '')
                    . ' --user="' . $user . '"'
                    . ' --password="' . $pass . '"'
                    . ' -e "DROP DATABASE IF EXISTS `' . $dbName . '`; CREATE DATABASE `' . $dbName . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"';
                @shell_exec($dropCreateCmd);
                $count = 0;
                foreach ($tableFiles as $tf) {
                    $tableName = basename($tf, '.sql');
                    echo "  -> Importing table '$tableName'...";
                    $this->flushOutput();
                    $tfForMysql = str_replace('\\', '/', $tf);
                    $cmd = ($execPrefix !== '' ? $execPrefix . ' ' : '') . '"' . $mysql . '"'
                        . ' --host="' . $host . '"'
                        . ($port !== '' ? ' --port="' . $port . '"' : '')
                        . ' --user="' . $user . '"'
                        . ' --password="' . $pass . '"'
                        . ' "' . $dbName . '"'
                        . ' -e "SET FOREIGN_KEY_CHECKS=0; source ' . $tfForMysql . '; SET FOREIGN_KEY_CHECKS=1;"';
                    $tableStatus = 0;
                    $tableOutput = [];
                    @exec($cmd, $tableOutput, $tableStatus);
                    if ($tableStatus === 0) {
                        echo " OK\n";
                        $count++;
                    } else {
                        echo " FAILED (exit $tableStatus)\n";
                    }
                }
                echo "Imported $count tables from $latestTablesDir\n";
                return $latestTablesDir;
            } else if ($driverKey === 'pgsql') {
                $psql = isset($env[$sectionName]['PSQL_PATH']) && $env[$sectionName]['PSQL_PATH'] !== '' ? $env[$sectionName]['PSQL_PATH'] : 'psql';
                $count = 0;
                foreach ($tableFiles as $tf) {
                    $tableName = basename($tf, '.sql');
                    echo "  -> Importing table '$tableName'...";
                    $this->flushOutput();
                    if ($isWindows) {
                        if ($isDockerExec) {
                            $tc = $execPrefix . ' -e PGPASSWORD="' . $pass . '" ' . '"' . $psql . '"'
                                . ' -h "' . $host . '"'
                                . ($port !== '' ? ' -p "' . $port . '"' : '')
                                . ' -U "' . $user . '"'
                                . ' -d "' . $dbName . '"'
                                . ' -v ON_ERROR_STOP=1'
                                . ' -f "' . $tf . '"';
                        } else {
                            $tc = 'set "PGPASSWORD=' . $pass . '" && ' . '"' . $psql . '"'
                                . ' -h "' . $host . '"'
                                . ($port !== '' ? ' -p "' . $port . '"' : '')
                                . ' -U "' . $user . '"'
                                . ' -d "' . $dbName . '"'
                                . ' -v ON_ERROR_STOP=1'
                                . ' -f "' . $tf . '"';
                        }
                    } else {
                        if ($isDockerExec) {
                            $tc = $execPrefix . ' -e PGPASSWORD="' . $pass . '" ' . '"' . $psql . '"'
                                . ' -h "' . $host . '"'
                                . ($port !== '' ? ' -p "' . $port . '"' : '')
                                . ' -U "' . $user . '"'
                                . ' -d "' . $dbName . '"'
                                . ' -v ON_ERROR_STOP=1'
                                . ' -f "' . $tf . '"';
                        } else {
                            $tc = 'PGPASSWORD="' . $pass . '" ' . '"' . $psql . '"'
                                . ' -h "' . $host . '"'
                                . ($port !== '' ? ' -p "' . $port . '"' : '')
                                . ' -U "' . $user . '"'
                                . ' -d "' . $dbName . '"'
                                . ' -v ON_ERROR_STOP=1'
                                . ' -f "' . $tf . '"';
                        }
                    }
                    shell_exec($tc);
                    echo " OK\n";
                    $count++;
                }
                echo "Imported $count tables from $latestTablesDir\n";
                return $latestTablesDir;
            } else {
                echo "Per-table import not supported for driver '$driver'.\n";
                return null;
            }
        } else {
            if ($targetYmd !== null) {
                echo "No full dump found for date '$date' in $dbDir\n";
            } else {
                echo "No dump file or per-table directory found in $dbDir\n";
            }
            return null;
        }
    }

    private function flushOutput()
    {
        if (function_exists('ob_get_level') && ob_get_level() > 0) {
            @ob_flush();
        }
        @flush();
        if (defined('STDOUT')) {
            @fflush(STDOUT);
        }
        if (defined('STDERR')) {
            @fflush(STDERR);
        }
    }

    private function createDirectory($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    private function detectProjectUrl($port = null)
    {
        $cwd = getcwd();
        $hostname = 'localhost';
        $openPort = $port;
        $commonPorts = array(80, 90, 3000, 3001, 4200, 5000, 5173, 5500, 6000, 7000, 8000, 8001, 8080, 8081, 8888, 9000, 9090);

        if ($openPort === null) {
            foreach ($commonPorts as $testPort) {
                $fp = @fsockopen($hostname, $testPort, $errno, $errstr, 0.1);
                if ($fp) {
                    fclose($fp);
                    $openPort = $testPort;
                    break;
                }
            }
        }

        if ($openPort === null) {
            $openPort = 80;
        }

        $docRoot = null;
        $docRootCandidates = array('htdocs', 'www', 'public_html');
        foreach ($docRootCandidates as $candidate) {
            $pos = strpos($cwd, $candidate);
            if ($pos !== false) {
                $docRoot = substr($cwd, 0, $pos + strlen($candidate));
                break;
            }
        }

        if ($docRoot === null) {
            $docRoot = dirname(dirname($cwd));
        }

        $relativePath = trim(str_replace($docRoot, '', $cwd), '/');
        $relativePath = str_replace('\\', '/', $relativePath);

        $url = "http://$hostname";
        if ($openPort != 80) {
            $url .= ":$openPort";
        }

        if (!empty($relativePath)) {
            $url .= '/' . ltrim($relativePath, '/');
        }

        return rtrim($url, '/') . '/';
    }

    private function stripControllerSuffix($name)
    {
        $stripped = preg_replace('/Controller$/i', '', $name);
        return !empty($stripped) ? $stripped : $name;
    }

    private function toKebabCase($value)
    {
        $value = preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $value);
        $value = preg_replace('/[^a-zA-Z0-9]+/', '-', $value);
        $value = trim($value, '-');

        return strtolower(!empty($value) ? $value : 'api');
    }

    private function removeDirectory($dir)
    {
        if (!is_dir($dir)) return;
        $items = scandir($dir);
        foreach ($items as $it) {
            if ($it === '.' || $it === '..') continue;
            $full = $dir . '/' . $it;
            if (is_dir($full)) {
                $this->removeDirectory($full);
            } else {
                @unlink($full);
            }
        }
        @rmdir($dir);
    }

    public function versioning($legacyPath)
    {
        $sourceRoot = $this->resolveVersioningPath($legacyPath);
        $targetRoot = MAXITER_PROJECT_ROOT;

        if ($sourceRoot === false || !is_dir($sourceRoot)) {
            echo "Error: invalid path. Use: php maxiter versioning \"[PATH]\"\n";
            return;
        }

        $sourceRoot = realpath($sourceRoot);
        $targetRoot = realpath($targetRoot);

        if ($sourceRoot === false || $targetRoot === false) {
            echo "Error: could not resolve source or target project path.\n";
            return;
        }

        if (strtolower($sourceRoot) === strtolower($targetRoot)) {
            echo "Error: the source project cannot be the same as the current project.\n";
            return;
        }

        $sourceProject = $this->inspectVersioningProject($sourceRoot);
        $targetProject = $this->inspectVersioningProject($targetRoot);

        if (!$sourceProject['valid']) {
            echo "Error: the informed PATH does not look like a valid Maxiter project.\n";
            foreach ($sourceProject['messages'] as $message) {
                echo "- " . $message . "\n";
            }
            return;
        }

        if (!$targetProject['valid']) {
            echo "Error: the current directory is not a valid Maxiter project for versioning.\n";
            foreach ($targetProject['messages'] as $message) {
                echo "- " . $message . "\n";
            }
            return;
        }

        $this->createDirectory($targetProject['pages']);
        $this->createDirectory($targetProject['controllers']);
        $this->createDirectory($targetProject['models']);
        $this->createDirectory($targetProject['middlewares']);

        $backupRoot = $targetRoot . '/src/versioning_backup/' . date('Ymd_His');

        echo "Starting Maxiter versioning update...\n";
        echo "Old project: " . $sourceRoot . "\n";
        echo "New project: " . $targetRoot . "\n";
        echo "Backup folder: " . $backupRoot . "\n";

        $pagesStats = $this->syncVersioningDirectory(
            $sourceProject['pages'],
            $targetProject['pages'],
            true,
            false,
            $backupRoot,
            $targetRoot
        );

        $controllersStats = $this->syncVersioningDirectory(
            $sourceProject['controllers'],
            $targetProject['controllers'],
            true,
            false,
            $backupRoot,
            $targetRoot
        );

        $middlewaresStats = array(
            'copied' => 0,
            'overwritten' => 0,
            'skipped' => 0,
            'directories_created' => 0,
            'backed_up' => 0,
        );
        if ($sourceProject['middlewares'] !== null) {
            $middlewaresStats = $this->syncVersioningDirectory(
                $sourceProject['middlewares'],
                $targetProject['middlewares'],
                true,
                false,
                $backupRoot,
                $targetRoot
            );
        } else {
            echo "Source project has no /app/middlewares directory. Skipping middlewares.\n";
        }

        $modelsStats = $this->syncVersioningDirectory(
            $sourceProject['models'],
            $targetProject['models'],
            false,
            true,
            null,
            $targetRoot
        );

        echo "\nVersioning finished successfully.\n";
        $this->printVersioningStats('Pages', $pagesStats);
        $this->printVersioningStats('Controllers', $controllersStats);
        $this->printVersioningStats('Middlewares', $middlewaresStats);
        $this->printVersioningStats('Models', $modelsStats);
        echo "Important: controllers from the old project were overwritten, models already present were preserved.\n";
        echo "Review the backup folder if you need to restore any overwritten file.\n";
    }

    private function resolveVersioningPath($path)
    {
        $path = trim($path);
        $path = trim($path, "\"'");

        if ($path === '') {
            return false;
        }

        if (is_dir($path)) {
            return $path;
        }

        $relativePath = getcwd() . DIRECTORY_SEPARATOR . $path;
        if (is_dir($relativePath)) {
            return $relativePath;
        }

        return false;
    }

    private function inspectVersioningProject($projectRoot)
    {
        $messages = array();
        $result = array(
            'valid' => true,
            'messages' => array(),
            'root' => $projectRoot,
            'pages' => $projectRoot . '/resources/views/pages',
            'controllers' => $projectRoot . '/app/controllers',
            'models' => $projectRoot . '/app/models',
            'middlewares' => null,
        );

        $requiredPaths = array(
            $projectRoot . '/index.php' => 'Missing index.php',
            $projectRoot . '/app/controllers' => 'Missing /app/controllers',
            $projectRoot . '/app/models' => 'Missing /app/models',
            $projectRoot . '/app/models/LoadModel.php' => 'Missing /app/models/LoadModel.php',
            $projectRoot . '/resources/views/pages' => 'Missing /resources/views/pages',
        );

        foreach ($requiredPaths as $requiredPath => $errorMessage) {
            if (!file_exists($requiredPath)) {
                $messages[] = $errorMessage;
            }
        }

        if (!file_exists($projectRoot . '/env.ini') && !file_exists($projectRoot . '/.env')) {
            $messages[] = 'Missing env.ini or .env';
        }

        if (file_exists($projectRoot . '/app/middlewares')) {
            $result['middlewares'] = $projectRoot . '/app/middlewares';
        }

        $result['messages'] = $messages;
        $result['valid'] = count($messages) === 0;

        return $result;
    }

    private function syncVersioningDirectory($sourceDir, $targetDir, $overwriteExisting, $skipExisting, $backupRoot, $targetRoot)
    {
        $stats = array(
            'copied' => 0,
            'overwritten' => 0,
            'skipped' => 0,
            'directories_created' => 0,
            'backed_up' => 0,
        );

        if (!is_dir($sourceDir)) {
            return $stats;
        }

        if (!is_dir($targetDir)) {
            $this->createDirectory($targetDir);
            $stats['directories_created']++;
        }

        $items = scandir($sourceDir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $sourcePath = $sourceDir . '/' . $item;
            $targetPath = $targetDir . '/' . $item;

            if (is_dir($sourcePath)) {
                $childStats = $this->syncVersioningDirectory(
                    $sourcePath,
                    $targetPath,
                    $overwriteExisting,
                    $skipExisting,
                    $backupRoot,
                    $targetRoot
                );
                $stats = $this->mergeVersioningStats($stats, $childStats);
                continue;
            }

            if (file_exists($targetPath)) {
                if ($skipExisting) {
                    $stats['skipped']++;
                    continue;
                }

                if ($overwriteExisting) {
                    if (
                        $backupRoot !== null &&
                        $targetRoot !== null &&
                        $this->backupVersioningFile($targetPath, $targetRoot, $backupRoot)
                    ) {
                        $stats['backed_up']++;
                    }

                    if (copy($sourcePath, $targetPath)) {
                        $stats['overwritten']++;
                    } else {
                        echo "Failed to overwrite file: " . $targetPath . "\n";
                    }
                    continue;
                }

                $stats['skipped']++;
                continue;
            }

            if (copy($sourcePath, $targetPath)) {
                $stats['copied']++;
            } else {
                echo "Failed to copy file: " . $sourcePath . "\n";
            }
        }

        return $stats;
    }

    private function backupVersioningFile($targetPath, $targetRoot, $backupRoot)
    {
        $normalizedTargetRoot = str_replace('\\', '/', $targetRoot);
        $normalizedTargetPath = str_replace('\\', '/', $targetPath);

        if (strpos(strtolower($normalizedTargetPath), strtolower($normalizedTargetRoot)) !== 0) {
            return false;
        }

        $relativePath = ltrim(substr($normalizedTargetPath, strlen($normalizedTargetRoot)), '/');
        if ($relativePath === '') {
            return false;
        }

        $backupPath = rtrim($backupRoot, '/\\') . '/' . $relativePath;
        $backupDirectory = dirname($backupPath);
        if (!is_dir($backupDirectory)) {
            $this->createDirectory($backupDirectory);
        }

        return copy($targetPath, $backupPath);
    }

    private function mergeVersioningStats($baseStats, $newStats)
    {
        foreach ($newStats as $key => $value) {
            if (!isset($baseStats[$key])) {
                $baseStats[$key] = 0;
            }
            $baseStats[$key] += $value;
        }

        return $baseStats;
    }

    private function printVersioningStats($label, $stats)
    {
        echo $label . ": copied " . $stats['copied']
            . ", overwritten " . $stats['overwritten']
            . ", skipped " . $stats['skipped']
            . ", backed up " . $stats['backed_up']
            . ".\n";
    }

    public function codeversion($phpVersion)
    {
        $phpVersion = $this->normalizeCodeVersion($phpVersion);
        if ($phpVersion === false) {
            echo "Error: invalid PHP version. Example: php maxiter codeversion 5.3\n";
            return;
        }

        $directories = array(
            MAXITER_PROJECT_ROOT . '/app/models',
            MAXITER_PROJECT_ROOT . '/app/controllers',
            MAXITER_PROJECT_ROOT . '/app/middlewares',
        );

        $files = $this->collectCodeVersionFiles($directories);
        sort($files);

        $reportDirectory = MAXITER_PROJECT_ROOT . '/src/codeversion/' . $phpVersion;
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/src');
        $this->createDirectory(MAXITER_PROJECT_ROOT . '/src/codeversion');
        $this->createDirectory($reportDirectory);

        $findings = array();
        foreach ($files as $filePath) {
            $issues = $this->inspectCodeVersionFile($filePath, $phpVersion);
            if (count($issues) > 0) {
                $findings[$filePath] = $issues;
            }
        }

        $timestamp = date('Ymd_His');
        $reportPath = $reportDirectory . '/verification-' . $timestamp . '.txt';
        $reportLines = array();
        $reportLines[] = 'Maxiter Code Version Verification';
        $reportLines[] = 'Target PHP version: ' . $phpVersion;
        $reportLines[] = 'Generated at: ' . date('Y-m-d H:i:s');
        $reportLines[] = 'Project root: ' . MAXITER_PROJECT_ROOT;
        $reportLines[] = '';

        if (count($findings) === 0) {
            $reportLines[] = 'No incompatibilities found in app/models, app/controllers and app/middlewares.';
        } else {
            foreach ($findings as $filePath => $issues) {
                $reportLines[] = '[' . $this->relativeCodeVersionPath($filePath) . ']';
                foreach ($issues as $issue) {
                    $reportLines[] = 'line ' . $issue['line'] . ': ' . $issue['message'];
                    $reportLines[] = 'code: ' . trim($issue['code']);
                }
                $reportLines[] = '';
            }
        }

        file_put_contents($reportPath, implode(PHP_EOL, $reportLines) . PHP_EOL);

        echo "Verification completed for PHP " . $phpVersion . ".\n";
        echo "Files checked: " . count($files) . "\n";
        echo "Files with incompatibilities: " . count($findings) . "\n";
        echo "Report generated: " . $reportPath . "\n";
    }

    private function normalizeCodeVersion($phpVersion)
    {
        $phpVersion = trim($phpVersion);
        $phpVersion = trim($phpVersion, "\"'");

        if (!preg_match('/^\d+\.\d+(\.\d+)?$/', $phpVersion)) {
            return false;
        }

        return $phpVersion;
    }

    private function collectCodeVersionFiles($directories)
    {
        $files = array();

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                continue;
            }

            $items = scandir($directory);
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }

                $path = $directory . '/' . $item;
                if (is_dir($path)) {
                    $files = array_merge($files, $this->collectCodeVersionFiles(array($path)));
                } else if (substr($item, -4) === '.php') {
                    $files[] = $path;
                }
            }
        }

        return $files;
    }

    private function inspectCodeVersionFile($filePath, $phpVersion)
    {
        $code = file_get_contents($filePath);
        if ($code === false) {
            return array();
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES);
        if ($lines === false) {
            $lines = array();
        }

        $issues = array();
        $issueMap = array();

        $regexRules = $this->getCodeVersionRegexRules();
        foreach ($lines as $index => $lineContent) {
            $lineNumber = $index + 1;
            if (preg_match('/^\s*(\/\/|#|\*|\/\*|\*\/)/', $lineContent)) {
                continue;
            }

            foreach ($regexRules as $rule) {
                if (version_compare($phpVersion, $rule['min_version'], '<') && preg_match($rule['pattern'], $lineContent)) {
                    $this->addCodeVersionIssue($issues, $issueMap, $lineNumber, $rule['message'], $lineContent);
                }
            }
        }

        $tokenIssues = $this->inspectCodeVersionTokens($code, $phpVersion, $lines);
        foreach ($tokenIssues as $issue) {
            $this->addCodeVersionIssue(
                $issues,
                $issueMap,
                $issue['line'],
                $issue['message'],
                $issue['code']
            );
        }

        usort($issues, array($this, 'sortCodeVersionIssues'));

        return $issues;
    }

    private function getCodeVersionRegexRules()
    {
        return array(
            array('min_version' => '5.4', 'pattern' => '/\btrait\s+[A-Za-z_]/', 'message' => 'traits require PHP 5.4+'),
            array('min_version' => '5.5', 'pattern' => '/::class\b/', 'message' => 'class name resolution (::class) requires PHP 5.5+'),
            array('min_version' => '5.5', 'pattern' => '/\byield\b/', 'message' => 'yield requires PHP 5.5+'),
            array('min_version' => '5.5', 'pattern' => '/\bfinally\b/', 'message' => 'finally requires PHP 5.5+'),
            array('min_version' => '5.6', 'pattern' => '/\.\.\./', 'message' => 'variadics or argument unpacking (...) require PHP 5.6+'),
            array('min_version' => '7.0', 'pattern' => '/\?\?/', 'message' => 'null coalescing operator (??) requires PHP 7.0+'),
            array('min_version' => '7.0', 'pattern' => '/<=>/', 'message' => 'spaceship operator (<=>) requires PHP 7.0+'),
            array('min_version' => '7.0', 'pattern' => '/function\s+[^(]*\([^)]*\)\s*:\s*[A-Za-z_\\\\][A-Za-z0-9_\\\\]*/', 'message' => 'return type declarations require PHP 7.0+'),
            array('min_version' => '7.0', 'pattern' => '/function\s+[^(]*\([^)]*\b(?:string|int|float|bool)\s+\$\w+/', 'message' => 'scalar parameter types require PHP 7.0+'),
            array('min_version' => '7.1', 'pattern' => '/function\s+[^(]*\([^)]*\)\s*:\s*\?[A-Za-z_\\\\][A-Za-z0-9_\\\\]*/', 'message' => 'nullable return types require PHP 7.1+'),
            array('min_version' => '7.1', 'pattern' => '/function\s+[^(]*\([^)]*\?[A-Za-z_\\\\][A-Za-z0-9_\\\\]*\s+\$\w+/', 'message' => 'nullable parameter types require PHP 7.1+'),
            array('min_version' => '7.1', 'pattern' => '/function\s+[^(]*\([^)]*\biterable\s+\$\w+/', 'message' => 'iterable parameter type requires PHP 7.1+'),
            array('min_version' => '7.2', 'pattern' => '/function\s+[^(]*\([^)]*\bobject\s+\$\w+/', 'message' => 'object parameter type requires PHP 7.2+'),
            array('min_version' => '7.4', 'pattern' => '/\bfn\s*\(/', 'message' => 'arrow functions require PHP 7.4+'),
            array('min_version' => '7.4', 'pattern' => '/\b(public|protected|private)\s+(static\s+)?(?!static\b)[A-Za-z_\\\\][A-Za-z0-9_\\\\]*\s+\$\w+/', 'message' => 'typed properties require PHP 7.4+'),
            array('min_version' => '8.0', 'pattern' => '/\?\->/', 'message' => 'nullsafe operator (?->) requires PHP 8.0+'),
            array('min_version' => '8.0', 'pattern' => '/#\s*\[/', 'message' => 'attributes require PHP 8.0+'),
            array('min_version' => '8.0', 'pattern' => '/function\s+[^(]*\([^)]*\)\s*:\s*[^ ]+\|[^ ]+/', 'message' => 'union return types require PHP 8.0+'),
            array('min_version' => '8.0', 'pattern' => '/function\s+[^(]*\([^)]*[^,]\|[^,]*\$\w+/', 'message' => 'union parameter types require PHP 8.0+'),
            array('min_version' => '8.1', 'pattern' => '/\benum\s+[A-Za-z_]/', 'message' => 'enums require PHP 8.1+'),
            array('min_version' => '8.1', 'pattern' => '/\breadonly\b/', 'message' => 'readonly properties require PHP 8.1+')
        );
    }

    private function inspectCodeVersionTokens($code, $phpVersion, $lines)
    {
        $issues = array();
        $tokens = token_get_all($code);
        $currentLine = 1;
        $previousSignificant = null;

        foreach ($tokens as $token) {
            if (is_array($token)) {
                $tokenId = $token[0];
                $tokenText = $token[1];
                $tokenLine = $token[2];

                if (version_compare($phpVersion, '7.0', '<') && $tokenId === T_CLASS && $this->isAnonymousClassToken($previousSignificant)) {
                    $issues[] = array(
                        'line' => $tokenLine,
                        'message' => 'anonymous classes require PHP 7.0+',
                        'code' => $this->getCodeVersionLine($lines, $tokenLine),
                    );
                }

                if (
                    defined('T_MATCH') &&
                    version_compare($phpVersion, '8.0', '<') &&
                    $tokenId === T_MATCH &&
                    !$this->isFunctionNamedMatchToken($previousSignificant)
                ) {
                    $issues[] = array(
                        'line' => $tokenLine,
                        'message' => 'match expression requires PHP 8.0+',
                        'code' => $this->getCodeVersionLine($lines, $tokenLine),
                    );
                }

                if (version_compare($phpVersion, '5.5', '<') && $this->isDoubleColonClassToken($previousSignificant, $token)) {
                    $issues[] = array(
                        'line' => $tokenLine,
                        'message' => 'class name resolution (::class) requires PHP 5.5+',
                        'code' => $this->getCodeVersionLine($lines, $tokenLine),
                    );
                }

                if (!in_array($tokenId, array(T_WHITESPACE, T_COMMENT, T_DOC_COMMENT), true)) {
                    $previousSignificant = array('type' => $tokenId, 'text' => $tokenText);
                }

                $currentLine = $tokenLine + substr_count($tokenText, "\n");
            } else {
                $tokenLine = $currentLine;

                if ($token === '[' && version_compare($phpVersion, '5.4', '<') && $this->isShortArrayStartToken($previousSignificant)) {
                    $issues[] = array(
                        'line' => $tokenLine,
                        'message' => 'short array syntax [] requires PHP 5.4+',
                        'code' => $this->getCodeVersionLine($lines, $tokenLine),
                    );
                }

                if (trim($token) !== '') {
                    $previousSignificant = array('type' => 'char', 'text' => $token);
                }

                $currentLine += substr_count($token, "\n");
            }
        }

        return $issues;
    }

    private function isShortArrayStartToken($previousSignificant)
    {
        if ($previousSignificant === null) {
            return true;
        }

        if ($previousSignificant['type'] === 'char') {
            return in_array($previousSignificant['text'], array('=', '(', ',', '[', '!', '+', '-', '*', '/', '%', '&', '|', '^', '~', '?', ':', ';', '{'), true);
        }

        return in_array(
            $previousSignificant['type'],
            array(T_RETURN, T_DOUBLE_ARROW, T_AS, T_CASE, T_ECHO, T_PRINT, T_EXIT, T_OPEN_TAG, T_OPEN_TAG_WITH_ECHO),
            true
        );
    }

    private function isAnonymousClassToken($previousSignificant)
    {
        return $previousSignificant !== null && $previousSignificant['type'] === T_NEW;
    }

    private function isDoubleColonClassToken($previousSignificant, $token)
    {
        if ($previousSignificant === null || !is_array($token)) {
            return false;
        }

        return (
            $previousSignificant['type'] === T_DOUBLE_COLON &&
            strtolower($token[1]) === 'class'
        );
    }

    private function isFunctionNamedMatchToken($previousSignificant)
    {
        return $previousSignificant !== null && $previousSignificant['type'] === T_FUNCTION;
    }

    private function getCodeVersionLine($lines, $lineNumber)
    {
        return isset($lines[$lineNumber - 1]) ? $lines[$lineNumber - 1] : '';
    }

    private function addCodeVersionIssue(&$issues, &$issueMap, $lineNumber, $message, $code)
    {
        $issueKey = $lineNumber . '|' . $message;
        if (isset($issueMap[$issueKey])) {
            return;
        }

        $issueMap[$issueKey] = true;
        $issues[] = array(
            'line' => $lineNumber,
            'message' => $message,
            'code' => $code,
        );
    }

    private function sortCodeVersionIssues($left, $right)
    {
        if ($left['line'] == $right['line']) {
            return strcmp($left['message'], $right['message']);
        }

        return ($left['line'] < $right['line']) ? -1 : 1;
    }

    private function relativeCodeVersionPath($filePath)
    {
        $normalizedRoot = str_replace('\\', '/', MAXITER_PROJECT_ROOT);
        $normalizedPath = str_replace('\\', '/', $filePath);

        if (strpos(strtolower($normalizedPath), strtolower($normalizedRoot)) === 0) {
            return ltrim(substr($normalizedPath, strlen($normalizedRoot)), '/');
        }

        return $normalizedPath;
    }

    public function selfUpdate()
    {
        echo "🔍 Checking for updates...\n";

        $env = maxiter_load_env_config();
        $user = maxiter_get_env_value($env, 'app', 'UPDATE_USER', 'maxiter-php');
        $repo = maxiter_get_env_value($env, 'app', 'UPDATE_REPO', 'maxiter');
        $branch = maxiter_get_env_value($env, 'app', 'UPDATE_BRANCH', 'main');

        $localVersionFile = MAXITER_PROJECT_ROOT . "/version.json";
        $remoteVersionUrl = "https://raw.githubusercontent.com/$user/$repo/$branch/version.json";

        if (!file_exists($localVersionFile)) {
            echo "❌ Local version not found.\n";
            return;
        }

        $local = json_decode(file_get_contents($localVersionFile), true);
        $remote = json_decode(file_get_contents($remoteVersionUrl), true);

        if (!$remote) {
            echo "❌ Could not check remote version.\n";
            return;
        }

        if ($remote['version'] == $local['version']) {
            echo "✔ Maxiter is already up to date (v{$local['version']}).\n";
            return;
        }

        echo "📥 New version found: {$remote['version']} (current {$local['version']})\n";

        $zipUrl = "https://github.com/$user/$repo/archive/refs/heads/$branch.zip";
        $zipFile = MAXITER_PROJECT_ROOT . "/maxiter_update.zip";

        file_put_contents($zipFile, file_get_contents($zipUrl));

        echo "📦 Downloaded update package.\n";

        $extractPath = MAXITER_PROJECT_ROOT . "/update_temp";
        mkdir($extractPath);

        $zip = new ZipArchive();
        if ($zip->open($zipFile) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();
        }

        echo "📂 Extracted update.\n";

        $manifest = json_decode(file_get_contents($extractPath . "/$repo-$branch/manifest.json"), true);
        if (!$manifest || !isset($manifest["files"])) {
            echo "❌ Manifest not found.\n";
            return;
        }

        foreach ($manifest["files"] as $file => $hash) {

            $localPath = MAXITER_PROJECT_ROOT . "/" . $file;
            $remotePath = $extractPath . "/$repo-$branch/" . $file;

            if (!file_exists($remotePath)) continue;

            if (!file_exists($localPath)) {
                // instalar novo
                copy($remotePath, $localPath);
                echo "✨ Installed new file: $file\n";
                continue;
            }

            // comparar hash para saber se foi modificado pelo usuário
            $localHash = "sha1-" . sha1_file($localPath);

            if ($localHash === $hash) {
                // seguro atualizar
                copy($remotePath, $localPath);
                echo "✔ Updated: $file\n";
            } else {
                echo "⚠ Skipped (modified by user): $file\n";
            }
        }

        file_put_contents($localVersionFile, json_encode($remote, JSON_PRETTY_PRINT));

        unlink($zipFile);
        $this->removeDirectory($extractPath);

        echo "\n🎉 Maxiter updated to v{$remote['version']}!\n";
    }

    public function selfUpdateCLI($force = false)
    {
        echo "🔍 Checking for CLI update...\n";

        $env = maxiter_load_env_config();
        $user = maxiter_get_env_value($env, 'app', 'UPDATE_USER', 'maxiter-php');
        $repo = maxiter_get_env_value($env, 'app', 'UPDATE_REPO', 'maxiter');
        $branch = maxiter_get_env_value($env, 'app', 'UPDATE_BRANCH', 'main');

        $manifestUrl = "https://raw.githubusercontent.com/$user/$repo/$branch/manifest.json";
        $manifest = json_decode(@file_get_contents($manifestUrl), true);
        if (!$manifest || !isset($manifest['files']) || !isset($manifest['files']['maxiter'])) {
            echo "❌ Manifest missing CLI entry.\n";
            return;
        }

        $localCliPath = MAXITER_PROJECT_ROOT . "/maxiter";
        $remoteCliUrl = "https://raw.githubusercontent.com/$user/$repo/$branch/maxiter";
        $remoteCli = @file_get_contents($remoteCliUrl);
        if ($remoteCli === false || $remoteCli === '') {
            echo "❌ Remote CLI not found.\n";
            return;
        }

        $expected = strtolower($manifest['files']['maxiter']);

        $localCliContent = file_exists($localCliPath) ? @file_get_contents($localCliPath) : '';
        $localCliNormalized = $localCliContent !== '' ? str_replace(["\r\n", "\r"], "\n", $localCliContent) : '';
        $remoteCliNormalized = str_replace(["\r\n", "\r"], "\n", $remoteCli);

        $remoteHash = "sha1-" . sha1($remoteCliNormalized);
        $localHash = file_exists($localCliPath) ? ("sha1-" . sha1($localCliNormalized)) : '';

        if (!file_exists($localCliPath)) {
            file_put_contents($localCliPath, $remoteCli);
            echo "✨ Installed CLI.\n";
            return;
        }

        if ($localHash === $remoteHash) {
            echo "✔ CLI is already up to date.\n";
            return;
        }

        if ($force) {
            $backupDir = MAXITER_PROJECT_ROOT . "/src/temp";
            $this->createDirectory($backupDir);
            $date = date('Ymd-His');
            $bak = $backupDir . "/maxiter-" . $date . ".bak";
            @copy($localCliPath, $bak);
            file_put_contents($localCliPath, $remoteCli);
            echo "✔ CLI updated (forced). Backup saved at " . $bak . "\n";
            return;
        }

        if ($localHash === $expected) {
            $backupDir = MAXITER_PROJECT_ROOT . "/src/temp";
            $this->createDirectory($backupDir);
            $date = date('Ymd-His');
            $bak = $backupDir . "/maxiter-" . $date . ".bak";
            @copy($localCliPath, $bak);
            file_put_contents($localCliPath, $remoteCli);
            echo "✔ CLI updated. Backup saved at " . $bak . "\n";
        } else {
            echo "⚠ Skipped CLI (modified by user).\n";
        }
    }

    public function pathCheck()
    {
        echo "Detected base URL: " . $this->detectProjectUrl() . PHP_EOL;
        echo "Base URL configuration in env.ini/path.js is no longer required." . PHP_EOL;
    }

    public function cro()
    {
        // Config Route for Old
        $indexPath = MAXITER_PROJECT_ROOT . '/index.php';
        if (!file_exists($indexPath)) {
            echo "index.php not found";
            return;
        }

        $contents = file_get_contents($indexPath);
        $contents = str_replace('$routes = new Routes();', '$routes = new Routes($url);', $contents);
        $contents = str_replace('$routes->routes($url);', '// $routes->routes($url);', $contents);
        file_put_contents($indexPath, $contents);
        echo "Config Route for Old success in index.php";
    }

    public function crn()
    {
        // Config Route for New
        $indexPath = MAXITER_PROJECT_ROOT . '/index.php';
        if (!file_exists($indexPath)) {
            echo "index.php not found";
            return;
        }

        $contents = file_get_contents($indexPath);
        $contents = str_replace('$routes = new Routes($url);', '$routes = new Routes();', $contents);
        $contents = str_replace('// $routes->routes($url);', '$routes->routes($url);', $contents);
        file_put_contents($indexPath, $contents);
        echo "Config Route for New success in index.php";
    }
}

class MaxiterDevServer
{
    private $port;
    private $host;
    private $projectRoot;
    private $routerFile;
    private $serverProcess = null;
    private $serverPipes = [];
    private $fileHashes = [];
    private $watchedDirs = [];
    private $watchedExtensions = [];
    private $lastHeartbeat = 0;
    private $heartbeatInterval = 15;
    private $pollInterval = 500000;
    private $restartCount = 0;
    private $maxRestarts = 50;
    private $restartWindow = 60;
    private $restartTimestamps = [];
    private $shutdownRequested = false;
    private $isWindows;

    private $lrSocket = null;
    private $lrHost = '127.0.0.1';
    private $lrPort = 0;
    private $lrClients = [];
    private $lrEnabled = false;
    private $lrFlagFile = '';
    private $lrBroadcastCount = 0;
    private $lrLastPing = 0;
    private $lrPingInterval = 20;
    private $browserOpened = false;
    private $lrClientsSSE = [];

    public function __construct($port = 7000, $host = 'localhost')
    {
        $this->port = $port;
        $this->host = $host;
        $this->projectRoot = MAXITER_PROJECT_ROOT;
        $this->routerFile = $this->projectRoot . '/bootstrap/server/router.php';
        $this->isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $this->lrFlagFile = $this->projectRoot . '/bootstrap/server/.maxiter_dev_server';

        $this->watchedDirs = [
            $this->projectRoot . '/app',
            $this->projectRoot . '/bootstrap',
            $this->projectRoot . '/routes',
            $this->projectRoot . '/resources/views/pages',
            $this->projectRoot . '/index.php',
        ];

        $this->watchedExtensions = [
            'php', 'phtml', 'php3', 'php4', 'php5',
            'css', 'js', 'html', 'htm',
            'ini', 'env', 'json', 'yml', 'yaml', 'xml',
        ];
    }

    public function run()
    {
        $this->registerGlobalErrorHandlers();
        $this->startLiveReloadServer();
        $this->writeFlagFile();
        $this->printBanner();
        $this->registerSignalHandlers();
        $this->buildFileHashSnapshot();
        $this->startServer();

        $lastCheck = 0;

        while (!$this->shutdownRequested) {
            try {
                usleep($this->pollInterval);

                $now = time();
                $this->pollLiveReload();
                $changed = $this->detectChanges();

                if (!empty($changed)) {
                    $relChanged = array_map(array($this, 'relativePath'), $changed);
                    foreach ($relChanged as $f) {
                        $this->log('CHANGE', $f);
                    }

                    $hasPhp = false;
                    $hasConfig = false;
                    foreach ($changed as $file) {
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        if (in_array($ext, array('php', 'phtml', 'php3', 'php4', 'php5'))) {
                            $hasPhp = true;
                        }
                        if (in_array($ext, array('ini', 'json', 'yml', 'yaml', 'xml')) || basename($file) === '.env' || basename($file) === 'env.ini') {
                            $hasConfig = true;
                        }
                    }

                    $this->broadcastReload($relChanged);

                    if ($hasPhp || $hasConfig) {
                        $this->log('HMR', 'PHP/config changes detected, bouncing server + reload page.');
                        $this->restartServer();
                    } else {
                        $this->log('HMR', 'Static changes detected, browser reload in same tab.');
                    }

                    $this->buildFileHashSnapshot();
                    continue;
                }

                if ($this->serverProcess !== null) {
                    $status = @proc_get_status($this->serverProcess);
                    if ($status && !$status['running']) {
                        $exitCode = isset($status['exitcode']) ? $status['exitcode'] : '?';
                        $this->log('WARN', "Server process stopped (exit=$exitCode). Auto-recovering...");
                        $this->closeServerPipes();
                        @proc_close($this->serverProcess);
                        $this->serverProcess = null;
                        usleep(300000);
                        $this->startServer();
                    }
                } else {
                    if ($this->canRestart()) {
                        $this->log('WARN', 'No active server process. Spawning a new one...');
                        usleep(200000);
                        $this->startServer();
                    }
                }

                if ($now - $this->lrLastPing >= $this->lrPingInterval) {
                    $this->broadcastPing();
                    $this->lrLastPing = $now;
                }

                if ($now - $this->lastHeartbeat >= $this->heartbeatInterval) {
                    $this->printHeartbeat();
                    $this->lastHeartbeat = $now;
                }

                if (function_exists('pcntl_signal_dispatch')) {
                    @pcntl_signal_dispatch();
                }
            } catch (\Throwable $e) {
                $rel = $this->relativePath($e->getFile());
                $this->log('ERROR', get_class($e) . ': ' . $e->getMessage() . " at $rel:" . $e->getLine());
                $this->log('WARN', 'Recovering watch loop from exception... will continue in 1s.');
                sleep(1);
            } catch (\Exception $e) {
                $rel = $this->relativePath($e->getFile());
                $this->log('ERROR', get_class($e) . ': ' . $e->getMessage() . " at $rel:" . $e->getLine());
                $this->log('WARN', 'Recovering watch loop from exception... will continue in 1s.');
                sleep(1);
            }
        }

        $this->shutdown();
    }

    private function printBanner()
    {
        $version = @file_get_contents($this->projectRoot . '/version.json');
        $versionStr = 'latest';
        if ($version !== false) {
            $data = @json_decode($version, true);
            if (is_array($data) && isset($data['version'])) {
                $versionStr = $data['version'];
            }
        }

        $pollMs = number_format($this->pollInterval / 1000, 0);
        $relRouter = $this->relativePath($this->routerFile);
        $lrInfo = $this->lrEnabled ? "ws://{$this->lrHost}:{$this->lrPort} (LiveReload: ON)" : 'OFF';
        $bannerPHP = <<<BANNERPHP
\033[36m
  __  __            _   _ _
 |  \/  | __ ___  _| |_(_) |_ ___ _ __
 | |\/| |/ _` \ \/ / __| | __/ _ \ '__|
 | |  | | (_| |>  <| |_| | ||  __/ |
 |_|  |_|\__,_/_/\_\\__|_|\__\___|_|

\033[0m\033[1;37m  +-------------------------------------------------------+
  |  \033[32mMaxiter Dev Server\033[0m\033[1;37m        \033[33mv{$versionStr}\033[0m\033[1;37m                   |
  +-------------------------------------------------------+
  |  \033[36mURL:\033[0m      http://{$this->host}:{$this->port}                     \033[1;37m|
  |  \033[36mHMR:\033[0m      {$lrInfo}\033[1;37m |
  |  \033[36mRouter:\033[0m   {$relRouter}
  |  \033[36mWatch:\033[0m    app/ bootstrap/ routes/ views/ index.php  \033[1;37m|
  |  \033[36mPolling:\033[0m  ~{$pollMs}ms                                   \033[1;37m|
  +-------------------------------------------------------+
  |  Press \033[31mCtrl+C\033[0m\033[1;37m to stop the server                    |
  +-------------------------------------------------------+
\033[0m

BANNERPHP;
        echo $bannerPHP;
        $this->flushOutput();
    }

    private function printHeartbeat()
    {
        $status = ($this->serverProcess !== null) ? proc_get_status($this->serverProcess) : ['running' => false];
        $statusStr = $status['running'] ? "\033[32mALIVE\033[0m" : "\033[31mDOWN\033[0m";
        $pid = $status['running'] ? 'PID ' . $status['pid'] : '-';
        $mem = $this->formatBytes(@memory_get_usage(true));
        $ts = date('H:i:s');
        $this->log('HEARTBEAT', "[$ts] status=$statusStr $pid | mem=$mem | restarts={$this->restartCount}");
    }

    private function buildFileHashSnapshot()
    {
        $this->fileHashes = [];
        foreach ($this->watchedDirs as $dir) {
            if (is_file($dir)) {
                $this->fileHashes[$dir] = @md5_file($dir) . '|' . @filemtime($dir);
            } elseif (is_dir($dir)) {
                $this->scanDirectory($dir);
            }
        }
    }

    private function scanDirectory($dir)
    {
        $items = @scandir($dir);
        if ($items === false) return;

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            if ($item === 'vendor' || $item === '.git' || $item === 'node_modules') continue;
            if (strpos($item, '.log') !== false || strpos($item, '.cache') !== false) continue;

            $full = $dir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($full)) {
                $this->scanDirectory($full);
            } elseif (is_file($full)) {
                $ext = strtolower(pathinfo($full, PATHINFO_EXTENSION));
                if (in_array($ext, $this->watchedExtensions, true) || $item === '.env' || $item === 'env.ini') {
                    $this->fileHashes[$full] = @md5_file($full) . '|' . @filemtime($full);
                }
            }
        }
    }

    private function detectChanges()
    {
        $changed = [];
        $currentHashes = [];

        foreach ($this->watchedDirs as $dir) {
            if (is_file($dir)) {
                $currentHashes[$dir] = @md5_file($dir) . '|' . @filemtime($dir);
            } elseif (is_dir($dir)) {
                $this->collectCurrentHashes($dir, $currentHashes);
            }
        }

        foreach ($currentHashes as $file => $hash) {
            if (!isset($this->fileHashes[$file]) || $this->fileHashes[$file] !== $hash) {
                $changed[] = $file;
            }
        }

        foreach ($this->fileHashes as $file => $hash) {
            if (!isset($currentHashes[$file])) {
                $changed[] = $file;
            }
        }

        $this->fileHashes = $currentHashes;
        return $changed;
    }

    private function collectCurrentHashes($dir, &$collection)
    {
        $items = @scandir($dir);
        if ($items === false) return;

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            if ($item === 'vendor' || $item === '.git' || $item === 'node_modules') continue;
            if (strpos($item, '.log') !== false || strpos($item, '.cache') !== false) continue;

            $full = $dir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($full)) {
                $this->collectCurrentHashes($full, $collection);
            } elseif (is_file($full)) {
                $ext = strtolower(pathinfo($full, PATHINFO_EXTENSION));
                if (in_array($ext, $this->watchedExtensions, true) || $item === '.env' || $item === 'env.ini') {
                    $collection[$full] = @md5_file($full) . '|' . @filemtime($full);
                }
            }
        }
    }

    private function startServer()
    {
        if (!$this->canRestart()) {
            $this->log('ERROR', "Too many restarts ({$this->restartCount} in {$this->restartWindow}s). Throttling...");
            sleep(5);
            $this->restartTimestamps = [];
        }

        $this->restartTimestamps[] = time();
        $this->restartTimestamps = array_filter($this->restartTimestamps, function ($t) {
            return (time() - $t) <= $this->restartWindow;
        });

        if (!file_exists($this->routerFile)) {
            $this->log('ERROR', "Router file not found: {$this->routerFile}");
            return false;
        }

        $host = escapeshellarg($this->host);
        $port = escapeshellarg((string)$this->port);
        $router = escapeshellarg($this->routerFile);

        if ($this->isWindows) {
            $phpBin = $this->findPHPBinary();
            $cmd = '"' . $phpBin . '" -S ' . $this->host . ':' . $this->port . ' ' . $router;
            $descriptorspec = [
                0 => ['pipe', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ];
        } else {
            $phpBin = $this->findPHPBinary();
            $cmd = escapeshellcmd($phpBin) . ' -S ' . escapeshellarg($this->host . ':' . $this->port) . ' ' . $router;
            $descriptorspec = [
                0 => ['pipe', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ];
        }

        $cwd = $this->projectRoot;
        $env = null;
        $options = $this->isWindows ? ['bypass_shell' => true] : [];

        $this->log('START', "Spawning PHP dev server on http://{$this->host}:{$this->port}...");
        $this->flushOutput();

        $process = @proc_open($cmd, $descriptorspec, $pipes, $cwd, $env, $options);

        if (!is_resource($process)) {
            $this->log('ERROR', "Failed to start server. proc_open() returned false.");
            return false;
        }

        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);

        $this->serverProcess = $process;
        $this->serverPipes = $pipes;

        usleep(400000);
        $status = proc_get_status($this->serverProcess);
        if ($status['running']) {
            $this->log('READY', "Server running on \033[4;32mhttp://{$this->host}:{$this->port}\033[0m (PID {$status['pid']})");
            if (!$this->browserOpened) {
                $this->browserOpened = true;
                $this->openBrowser("http://{$this->host}:{$this->port}");
            }
            return true;
        } else {
            $stderr = @stream_get_contents($pipes[2]);
            $this->log('ERROR', "Server failed to start: " . trim($stderr));
            $this->closeServerPipes();
            @proc_close($this->serverProcess);
            $this->serverProcess = null;
            return false;
        }
    }

    private function restartServer()
    {
        $this->restartCount++;
        $this->killServerProcess();
        usleep(200000);
        $this->startServer();
    }

    private function killServerProcess()
    {
        if ($this->serverProcess === null) return;

        $status = proc_get_status($this->serverProcess);
        $pid = isset($status['pid']) ? $status['pid'] : null;

        $this->closeServerPipes();

        if (is_resource($this->serverProcess)) {
            if ($this->isWindows && $pid !== null) {
                @exec('taskkill /F /T /PID ' . (int)$pid . ' 2>NUL');
            } else {
                if (function_exists('proc_terminate')) {
                    @proc_terminate($this->serverProcess, 15);
                    usleep(200000);
                    @proc_terminate($this->serverProcess, 9);
                }
            }
            @proc_close($this->serverProcess);
        }

        $this->serverProcess = null;
        $this->serverPipes = [];
    }

    private function closeServerPipes()
    {
        if (!empty($this->serverPipes)) {
            foreach ($this->serverPipes as $pipe) {
                if (is_resource($pipe)) {
                    @fclose($pipe);
                }
            }
            $this->serverPipes = [];
        }
    }

    private function canRestart()
    {
        return count($this->restartTimestamps) < $this->maxRestarts;
    }

    private function openBrowser($url)
    {
        if ($this->isWindows) {
            @pclose(@popen('start "" "' . $url . '"', 'r'));
        } elseif (strtoupper(substr(PHP_OS, 0, 5)) === 'LINUX') {
            @exec('xdg-open ' . escapeshellarg($url) . ' > /dev/null 2>&1 &');
        } elseif (strtoupper(substr(PHP_OS, 0, 6)) === 'DARWIN') {
            @exec('open ' . escapeshellarg($url) . ' > /dev/null 2>&1 &');
        }
    }

    private function findPHPBinary()
    {
        if (defined('PHP_BINARY') && PHP_BINARY !== '') {
            return PHP_BINARY;
        }
        if ($this->isWindows) {
            $paths = [
                'C:\\xampp\\php\\php.exe',
                'C:\\php\\php.exe',
            ];
            foreach ($paths as $p) {
                if (file_exists($p)) return $p;
            }
        }
        return 'php';
    }

    private function registerGlobalErrorHandlers()
    {
        $self = $this;
        set_error_handler(function ($errno, $errstr, $errfile, $errline) use ($self) {
            if (!(error_reporting() & $errno)) return false;
            $levels = [
                E_WARNING             => 'WARNING',
                E_NOTICE              => 'NOTICE',
                E_USER_ERROR          => 'USER_ERROR',
                E_USER_WARNING        => 'USER_WARNING',
                E_USER_NOTICE         => 'USER_NOTICE',
                E_STRICT              => 'STRICT',
                E_RECOVERABLE_ERROR   => 'RECOVERABLE',
                E_DEPRECATED          => 'DEPRECATED',
                E_USER_DEPRECATED     => 'USER_DEPRECATED',
            ];
            $tag = isset($levels[$errno]) ? $levels[$errno] : 'ERROR';
            $rel = $self->relativePath($errfile);
            $self->log('WARN', "PHP $tag at $rel:$errline - $errstr");
            return true;
        });

        set_exception_handler(function ($e) use ($self) {
            $rel = $self->relativePath($e->getFile());
            $msg = get_class($e) . ': ' . $e->getMessage() . " at $rel:" . $e->getLine();
            $self->log('ERROR', $msg);
            if (!$self->shutdownRequested) {
                $self->log('WARN', 'Recovering from uncaught exception... loop continues.');
            }
        });

        register_shutdown_function(function () use ($self) {
            $err = error_get_last();
            if ($err !== null) {
                $fatal = [E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING];
                if (in_array($err['type'], $fatal, true)) {
                    $rel = $self->relativePath($err['file']);
                    $msg = 'Fatal: ' . $err['message'] . " at $rel:" . $err['line'];
                    @file_put_contents('php://stderr', '[FATAL] ' . $msg . PHP_EOL);
                }
            }
        });
    }

    private function registerSignalHandlers()
    {
        if (function_exists('pcntl_async_signals')) {
            @pcntl_async_signals(true);
        }
        if (function_exists('pcntl_signal')) {
            $handler = function ($signo) {
                $this->log('SIGNAL', "Received signal $signo. Shutting down gracefully...");
                $this->shutdownRequested = true;
            };
            @pcntl_signal(SIGINT, $handler);
            @pcntl_signal(SIGTERM, $handler);
            if (defined('SIGHUP')) {
                @pcntl_signal(SIGHUP, $handler);
            }
        }
        if ($this->isWindows && function_exists('sapi_windows_set_ctrl_handler')) {
            @sapi_windows_set_ctrl_handler(function ($event) {
                if ($event === PHP_WINDOWS_EVENT_CTRL_C || $event === PHP_WINDOWS_EVENT_CTRL_BREAK) {
                    $this->log('SIGNAL', 'Ctrl+C pressed. Shutting down gracefully...');
                    $this->shutdownRequested = true;
                    return true;
                }
                return false;
            });
        }
    }

    private function shutdown()
    {
        $this->log('STOP', 'Stopping Maxiter Dev Server...');
        $this->killServerProcess();
        $this->stopLiveReloadServer();
        $this->removeFlagFile();
        $this->log('BYE', "Goodbye! (total restarts: {$this->restartCount}, broadcasts: {$this->lrBroadcastCount})");
        echo "\n";
        exit(0);
    }

    private function writeFlagFile()
    {
        if ($this->lrEnabled && $this->lrPort > 0) {
            $dir = dirname($this->lrFlagFile);
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }
            @file_put_contents($this->lrFlagFile, (string)$this->lrPort);
        }
    }

    private function removeFlagFile()
    {
        if (file_exists($this->lrFlagFile)) {
            @unlink($this->lrFlagFile);
        }
    }

    private function startLiveReloadServer()
    {
        $basePort = $this->port + 1000;
        $maxTries = 50;
        $server = null;
        $boundPort = 0;

        for ($i = 0; $i < $maxTries; $i++) {
            $candidate = $basePort + $i;
            $errno = 0;
            $errstr = '';
            $addr = 'tcp://' . $this->lrHost . ':' . $candidate;
            $s = @stream_socket_server(
                $addr,
                $errno,
                $errstr,
                STREAM_SERVER_BIND | STREAM_SERVER_LISTEN,
                stream_context_create([
                    'socket' => [
                        'backlog'        => 32,
                        'so_reuseport'   => 1,
                        'so_reuseaddr'   => 1,
                        'tcp_nodelay'    => 1,
                    ],
                ])
            );
            if (is_resource($s)) {
                $server = $s;
                $boundPort = $candidate;
                @stream_set_blocking($server, false);
                break;
            }
        }

        if ($server === null) {
            $this->log('WARN', 'Could not bind LiveReload stream socket; using server restart fallback only.');
            return;
        }

        $this->lrSocket = $server;
        $this->lrPort = $boundPort;
        $this->lrEnabled = true;
        $this->log('INFO', "LiveReload socket listening on ws://{$this->lrHost}:{$this->lrPort}/__maxiter_live");
    }

    private function stopLiveReloadServer()
    {
        foreach ($this->lrClients as $id => $c) {
            if (isset($c['socket']) && is_resource($c['socket'])) {
                @stream_socket_shutdown($c['socket'], STREAM_SHUT_RDWR);
                @fclose($c['socket']);
            }
        }
        $this->lrClients = [];
        $this->lrClientsSSE = [];
        if ($this->lrSocket !== null && is_resource($this->lrSocket)) {
            @stream_socket_shutdown($this->lrSocket, STREAM_SHUT_RDWR);
            @fclose($this->lrSocket);
        }
        $this->lrSocket = null;
        $this->lrEnabled = false;
    }

    private function pollLiveReload()
    {
        if (!$this->lrEnabled || !is_resource($this->lrSocket)) return;

        $read = [];
        $read[(int)$this->lrSocket] = $this->lrSocket;
        foreach ($this->lrClients as $id => $c) {
            if (isset($c['socket']) && is_resource($c['socket'])) {
                $read[(int)$c['socket']] = $c['socket'];
            }
        }
        $write = null;
        $except = null;
        $origCount = count($read);
        $changed = @stream_select($read, $write, $except, 0, 0);
        if ($changed === false || $changed < 1) return;
        $this->log('INFO:poll', "stream_select: $changed/$origCount ready");

        foreach ($read as $s) {
            if ($s === $this->lrSocket) {
                $client = @stream_socket_accept($this->lrSocket, 0, $peerName);
                if (is_resource($client)) {
                    @stream_set_blocking($client, false);
                    $id = (int)$client;
                    $this->log('INFO', "Accepted new client id=$id peer=" . ($peerName ?: '?'));
                    $this->lrClients[$id] = [
                        'socket'     => $client,
                        'handshake'  => false,
                        'buffer'     => '',
                        'last_seen'  => microtime(true),
                        'is_sse'     => false,
                    ];
                }
                continue;
            }

            $id = (int)$s;
            if (!isset($this->lrClients[$id])) continue;
            $chunk = '';
            $bytesRead = 0;
            $socketDead = false;
            while (true) {
                $piece = @fread($s, 8192);
                if ($piece === false) {
                    $meta = stream_get_meta_data($s);
                    if (!empty($meta['timed_out'])) {
                        break;
                    }
                    $socketDead = true;
                    break;
                }
                if ($piece === '' || $piece === null) {
                    $meta = stream_get_meta_data($s);
                    if (!empty($meta['eof'])) {
                        $socketDead = true;
                    }
                    break;
                }
                $chunk .= $piece;
                $bytesRead += strlen($piece);
                if (strlen($piece) < 8192) break;
            }
            if ($socketDead) {
                $this->log('INFO', "Closing client id=$id (socket dead)");
                $this->closeClient($id);
                continue;
            }
            if ($bytesRead === 0) continue;
            $this->lrClients[$id]['last_seen'] = microtime(true);
            $this->lrClients[$id]['buffer'] .= $chunk;

            if (!$this->lrClients[$id]['handshake']) {
                $this->log('INFO', "tryHandshake id=$id buflen=" . strlen($this->lrClients[$id]['buffer']));
                $this->tryHandshake($id);
            } else {
                $this->handleClientData($id, $chunk);
            }
        }

        $now = microtime(true);
        foreach (array_keys($this->lrClients) as $id) {
            if (!isset($this->lrClients[$id])) continue;
            $c = $this->lrClients[$id];
            if (!$c['handshake'] && ($now - $c['last_seen']) > 3.0) {
                $this->log('WARN', "Dropping client id=$id (handshake timeout)");
                $this->closeClient($id);
                continue;
            }
            if ($c['handshake'] && ($now - $c['last_seen']) > 120.0) {
                $this->closeClient($id);
            }
        }
    }

    private function tryHandshake($id)
    {
        $client = &$this->lrClients[$id];
        $buf = &$client['buffer'];
        if (strpos($buf, "\r\n\r\n") === false && strpos($buf, "\n\n") === false) return;

        $this->log('INFO', "tryHandshake id=$id parsing headers (".strlen($buf)." bytes)");

        $headers = $buf;
        if (preg_match('#^GET[^\r\n]+\sHTTP/[\d.]+#i', $headers) !== 1) {
            $this->log('WARN', "tryHandshake id=$id not a GET request; closing");
            $this->closeClient($id);
            return;
        }

        $isSse = (stripos($headers, 'text/event-stream') !== false) || (stripos($headers, 'Accept:') !== false && preg_match('#Accept:\s*([^\r\n]+)#i', $headers, $m) && stripos($m[1], 'text/event-stream') !== false);
        if ($isSse) {
            $response = "HTTP/1.1 200 OK\r\n"
                . "Content-Type: text/event-stream\r\n"
                . "Cache-Control: no-store, no-cache, must-revalidate\r\n"
                . "Connection: keep-alive\r\n"
                . "Access-Control-Allow-Origin: *\r\n"
                . "X-Accel-Buffering: no\r\n\r\n"
                . "retry: 1500\n\n";
            $this->log('INFO', "tryHandshake id=$id SSE mode; sending headers len=".strlen($response));
            $sent = $this->writeToSocket($client['socket'], $response);
            if ($sent === false) {
                $this->log('WARN', "tryHandshake id=$id SSE write FAIL");
                $this->closeClient($id);
                return;
            }
            $client['handshake'] = true;
            $client['is_sse'] = true;
            $client['buffer'] = '';
            $this->lrClientsSSE[$id] = $id;
            $this->log('INFO', "tryHandshake id=$id SSE OK");
            return;
        }

        $hasUpgrade = (stripos($headers, 'Upgrade: websocket') !== false);
        $hasKey = preg_match('#Sec-WebSocket-Key:\s*([^\r\n]+)#i', $headers, $keyMatch);
        if (!$hasUpgrade || !$hasKey) {
            $httpOk = "HTTP/1.1 200 OK\r\n"
                . "Content-Type: application/json\r\n"
                . "Access-Control-Allow-Origin: *\r\n"
                . "Connection: close\r\n\r\n"
                . json_encode(['ok' => true, 'hmr' => true, 'port' => $this->lrPort]);
            $this->log('INFO', "tryHandshake id=$id HTTP fallback response (no ws upgrade)");
            $this->writeToSocket($client['socket'], $httpOk);
            $this->closeClient($id);
            return;
        }

        $key = trim($keyMatch[1]);
        $accept = base64_encode(sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
        $response = "HTTP/1.1 101 Switching Protocols\r\n"
            . "Upgrade: websocket\r\n"
            . "Connection: Upgrade\r\n"
            . "Sec-WebSocket-Accept: {$accept}\r\n"
            . "Access-Control-Allow-Origin: *\r\n\r\n";
        $this->log('INFO', "tryHandshake id=$id WS upgrade response len=".strlen($response));
        $sent = $this->writeToSocket($client['socket'], $response);
        if ($sent === false) {
            $this->log('WARN', "tryHandshake id=$id WS write FAIL");
            $this->closeClient($id);
            return;
        }
        $client['handshake'] = true;
        $client['is_sse'] = false;
        $client['buffer'] = '';
        $this->log('INFO', "tryHandshake id=$id WS OK");
    }

    private function handleClientData($id, $data)
    {
        $client = &$this->lrClients[$id];
        if ($client['is_sse']) {
            if (strlen($client['buffer']) > 65536) {
                $this->closeClient($id);
            }
            return;
        }
    }

    private function closeClient($id)
    {
        if (!isset($this->lrClients[$id])) return;
        $c = $this->lrClients[$id];
        if (isset($c['socket']) && is_resource($c['socket'])) {
            @stream_socket_shutdown($c['socket'], STREAM_SHUT_RDWR);
            @fclose($c['socket']);
        }
        unset($this->lrClients[$id]);
        unset($this->lrClientsSSE[$id]);
    }

    private function writeToSocket($socket, $data)
    {
        if (!is_resource($socket)) return false;
        $len = strlen($data);
        if ($len === 0) return true;
        $written = 0;
        $max = 30;
        $attempt = 0;
        while ($written < $len && $attempt < $max) {
            $chunk = substr($data, $written);
            $res = @fwrite($socket, $chunk, strlen($chunk));
            if ($res === false || $res === 0 || $res === null) {
                $meta = stream_get_meta_data($socket);
                if (!empty($meta['timed_out']) || !empty($meta['blocked'])) {
                    usleep(10000);
                    $attempt++;
                    continue;
                }
                if ($written > 0) {
                    usleep(5000);
                    $attempt++;
                    continue;
                }
                return false;
            }
            $written += (int)$res;
            $attempt++;
        }
        if ($written > 0 && $written < $len) {
            @fflush($socket);
        }
        return $written === $len;
    }

    private function wsEncodeFrame($payload, $opcode = 0x01)
    {
        $length = strlen($payload);
        $out = chr(0x80 | ($opcode & 0x0F));
        if ($length <= 125) {
            $out .= chr($length);
        } elseif ($length <= 65535) {
            $out .= chr(126) . pack('n', $length);
        } else {
            if (PHP_VERSION_ID >= 50600) {
                $out .= chr(127) . pack('J', $length);
            } else {
                $hi = ($length & 0xFFFFFFFF00000000) >> 32;
                $lo = ($length & 0x00000000FFFFFFFF);
                $out .= chr(127) . pack('N2', $hi, $lo);
            }
        }
        return $out . $payload;
    }

    private function broadcastReload($files = [])
    {
        $this->lrBroadcastCount++;
        $msg = json_encode(['type' => 'reload', 'files' => $files, 'ts' => microtime(true)]);
        $wsFrame = $this->wsEncodeFrame($msg);
        $ssePayload = "event: reload\ndata: " . $msg . "\n\n";
        $this->log('INFO', "broadcastReload: to ".count($this->lrClients)." clients (msg=".strlen($wsFrame)." ws bytes)");

        $dead = [];
        foreach ($this->lrClients as $id => $c) {
            if (!$c['handshake']) continue;
            if ($c['is_sse']) {
                $this->log('INFO', "broadcastReload SSE -> id=$id");
                $ok = $this->writeToSocket($c['socket'], $ssePayload);
            } else {
                $this->log('INFO', "broadcastReload WS -> id=$id");
                $ok = $this->writeToSocket($c['socket'], $wsFrame);
            }
            if ($ok === false) {
                $this->log('WARN', "broadcastReload FAIL id=$id");
                $dead[] = $id;
            } else {
                $this->log('INFO', "broadcastReload OK id=$id");
            }
        }
        foreach ($dead as $id) $this->closeClient($id);
    }

    private function broadcastPing()
    {
        if (!$this->lrEnabled) return;
        $msg = json_encode(['type' => 'ping', 'ts' => microtime(true)]);
        $wsFrame = $this->wsEncodeFrame($msg, 0x09);
        $ssePayload = "event: ping\ndata: {$msg}\n\n";
        $dead = [];
        foreach ($this->lrClients as $id => $c) {
            if (!$c['handshake']) continue;
            if ($c['is_sse']) {
                $ok = $this->writeToSocket($c['socket'], $ssePayload);
            } else {
                $ok = $this->writeToSocket($c['socket'], $wsFrame);
            }
            if ($ok === false) $dead[] = $id;
        }
        foreach ($dead as $id) $this->closeClient($id);
    }

    private function log($level, $message)
    {
        $levelColors = [
            'START'     => ['\033[1;35m', 'BOOT'],
            'READY'     => ['\033[1;32m', ' OK '],
            'STOP'      => ['\033[1;31m', 'EXIT'],
            'BYE'       => ['\033[1;36m', 'BYE '],
            'CHANGE'    => ['\033[1;33m', 'FS   '],
            'RELOAD'    => ['\033[1;33m', 'HMR  '],
            'HEARTBEAT' => ['\033[2;37m', 'HB   '],
            'WARN'      => ['\033[1;33m', 'WARN'],
            'ERROR'     => ['\033[1;31m', 'ERR '],
            'SIGNAL'    => ['\033[1;34m', 'SIG '],
            'INFO'      => ['\033[0;36m', 'INFO'],
            'INFO:poll' => ['\033[0;36m', 'POLL'],
        ];

        if (isset($levelColors[$level])) {
            list($color, $tag) = $levelColors[$level];
        } else {
            $color = '\033[0;37m';
            $tag = str_pad(substr($level, 0, 4), 4);
        }

        $outColor = $this->supportsColors() ? $color : '';
        $reset = $this->supportsColors() ? '\033[0m' : '';

        $ts = date('H:i:s');
        $line = "{$outColor}[{$tag}]{$reset} [{$ts}] {$message}" . PHP_EOL;
        echo $line;
        $this->flushOutput();
    }

    private function supportsColors()
    {
        static $supports = null;
        if ($supports !== null) return $supports;
        if ($this->isWindows) {
            $supports = (function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support(STDOUT))
                || getenv('ANSICON') !== false
                || getenv('ConEmuANSI') === 'ON'
                || getenv('TERM') !== false;
        } else {
            $supports = defined('STDOUT') && @stream_isatty(STDOUT);
        }
        return $supports;
    }

    private function relativePath($file)
    {
        $root = rtrim(str_replace('\\', '/', $this->projectRoot), '/') . '/';
        $norm = str_replace('\\', '/', $file);
        if (strpos($norm, $root) === 0) {
            return substr($norm, strlen($root));
        }
        return $file;
    }

    private function formatBytes($bytes)
    {
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        if ($bytes < 1073741824) return round($bytes / 1048576, 1) . ' MB';
        return round($bytes / 1073741824, 2) . ' GB';
    }

    private function flushOutput()
    {
        if (function_exists('ob_get_level') && ob_get_level() > 0) {
            @ob_flush();
        }
        @flush();
        if (defined('STDOUT')) @fflush(STDOUT);
        if (defined('STDERR')) @fflush(STDERR);
    }
}

// Check if arguments were passed
if ($argc < 2) {

    echo
    "\n\033[1;36mMaxiter CLI Usage\033[0m\n" .
        "\n" .
        "  \033[33mDev server (hot reload):\033[0m\n" .
        "    php maxiter serve           [port]   Start dev server with file watching & hot reload\n" .
        "    php maxiter serve 8080               Custom port, hot reload enabled\n" .
        "\n" .
        "  \033[33mLegacy server:\033[0m\n" .
        "    php maxiter server          [port]   Simple PHP built-in server (no watch)\n" .
        "\n" .
        "Check the Maxiter Documentation here: https://maxiter-docs.vercel.app/\n\n";

    exit(1);
}

// Instantiate the MaxiterConfiguration class
$config = new MaxiterConfiguration();

// deltoprod pre-parser: aceita flags em QUALQUER posicao (deltoprod -c, -c deltoprod, deltoprod --move, etc)
{
    $deltoprodFlag = null;
    $deltoprodPos = null;
    for ($i = 1; $i < count($argv); $i++) {
        if ($argv[$i] === 'deltoprod') { $deltoprodPos = $i; }
        if (in_array($argv[$i], array('-f','-r','-c','-d','--force','--restore','--check','--delete','--move'), true)) {
            if ($argv[$i] === '-f' || $argv[$i] === '--force' || $argv[$i] === '--move')  $deltoprodFlag = 'move';
            if ($argv[$i] === '-r' || $argv[$i] === '--restore')                         $deltoprodFlag = 'restore';
            if ($argv[$i] === '-c' || $argv[$i] === '--check')                           $deltoprodFlag = 'check';
            if ($argv[$i] === '-d' || $argv[$i] === '--delete')                          $deltoprodFlag = 'delete';
        }
    }
    if ($deltoprodPos !== null) {
        if ($deltoprodFlag === null) $deltoprodFlag = 'delete';
        $config->configProdEnvDel($deltoprodFlag);
        exit;
    }
    unset($deltoprodFlag, $deltoprodPos);
}

// Check if the second argument is 'new' and the third is 'controller'
if ($argv[1] === 'new' && $argv[2] === 'controller') {
    if (!isset($argv[3]) || empty($argv[3])) {
        echo "Error: php maxiter new controller [controller_name]";
        exit();
    }
    $config->generateController($argv[3]);
} else if ($argv[1] === 'new' && $argv[2] === 'model') {
    if (!isset($argv[3]) || empty($argv[3])) {
        echo "Error: php maxiter new model [model_name]";
        exit();
    }
    $config->generateModel($argv[3]);
} else if ($argv[1] === 'new' && $argv[2] === 'view') {
    if (!isset($argv[3]) || empty($argv[3])) {
        echo "Error: php maxiter new view [view_name] [optional: template_name]";
        exit();
    }
    if (isset($argv[4])) {
        $config->generatePage($argv[3], $argv[4]);
    } else {
        $config->generatePage($argv[3]);
    }
} else if ($argv[1] === 'new' && $argv[2] === 'log') {

    if (!isset($argv[3]) || empty($argv[3])) {
        echo "Error: php maxiter new log [database]";
        exit();
    }
    $config->generateLogModel($argv[3]);
} else if ($argv[1] === 'new' && $argv[2] === 'table') {
    if (!isset($argv[3]) || empty($argv[3])) {
        echo "Error: php maxiter new table [table_name]";
        exit();
    }
    $config->generateSQL($argv[3]);
} else if ($argv[1] === 'serve') {
    $port = 7000;
    if (isset($argv[2]) && !empty($argv[2]) && ctype_digit($argv[2])) {
        $port = (int)$argv[2];
    }
    $host = 'localhost';
    if (isset($argv[3]) && !empty($argv[3])) {
        $host = $argv[3];
    }
    $dev = new MaxiterDevServer($port, $host);
    $dev->run();
} else if ($argv[1] === 'server') {
    $useWatch = false;
    $port = null;
    for ($i = 2; $i < $argc; $i++) {
        if ($argv[$i] === '--watch' || $argv[$i] === '-w') {
            $useWatch = true;
        } else if (ctype_digit($argv[$i])) {
            $port = (int)$argv[$i];
        }
    }
    if ($useWatch) {
        $p = ($port !== null) ? $port : 7000;
        $dev = new MaxiterDevServer($p, 'localhost');
        $dev->run();
    } else {
        if ($port !== null) {
            $config->initServer($port);
        } else {
            $config->initServer();
        }
    }
} else if ($argv[1] === 'gui') {
    if (!isset($argv[2]) || empty($argv[2])) {
        $config->initGUI();
    }
} else if ($argv[1] === 'path') {
    if (!isset($argv[2]) || empty($argv[2])) {
        echo "Error: php maxiter path [base_url_path] || Example: php maxiter path http://localhost/maxiter/ * Don't forget the / at the end!";
        exit();
    }
    $config->setPath($argv[2]);
} else if ($argv[1] === 'new' && $argv[2] === 'template') {
    if (!isset($argv[3]) || empty($argv[3])) {
        echo "Error: php maxiter new template [template_folder_name]";
        exit();
    }

    echo "Warning! This will erase all your actual /views data and set up a new configuration using the template in src/template/" . $argv[3] . ".";
    $config->setNewTemplate($argv[3]);
    // $handle = fopen("php://stdin", "r");
    // $response = trim(fgets($handle));  
    // fclose($handle);
    // if (strtolower($response) === 'y' || strtolower($response) === 'yes') {
    //     $config->setNewTemplate($argv[3]);
    // } else {
    //     echo "Operation cancelled.";
    // }
} else if ($argv[1] === 'new' && $argv[2] === 'api') {
    if (!isset($argv[3]) || empty($argv[3])) {
        echo "Error: php maxiter new api [api_controller_name]";
        exit();
    }
    $config->generateApiController($argv[3]);
} else if ($argv[1] === 'new' && $argv[2] === 'middleware') {
    if (!isset($argv[3]) || empty($argv[3])) {
        echo "Error: php maxiter new middleware [middleware_name]";
        exit();
    }
    $config->generateMiddleware($argv[3]);
} else if ($argv[1] === 'new' && $argv[2] === 'unittest') {
    if (!isset($argv[3]) || empty($argv[3]) || !isset($argv[4]) || empty($argv[4])) {
        echo "Error: php maxiter new unittest [controller_name] [function_name]";
        exit();
    }
    $config->generateUnitTest($argv[3], $argv[4]);
} else if ($argv[1] === 'testme') {
    if (!isset($argv[1]) || empty($argv[1])) {
        echo "Error: php maxiter testme";
        exit();
    }
    $config->PHPUnitTest();
} else if ($argv[1] === 'config' && $argv[2] === 'prod') {
    if (!isset($argv[1]) || empty($argv[1]) || !isset($argv[2]) || empty($argv[2])) {
        echo "Error: php maxiter config prod";
        exit();
    }
    $config->configProdEnv();
} else if ($argv[1] === 'autopath') {
    if (!isset($argv[1]) || empty($argv[1])) {
        echo "Error: php maxiter autopath [port]";
        exit();
    }
    if (isset($argv[2])) {
        $config->autoSetUpPath($argv[2]);
    } else {
        $config->autoSetUpPath();
    }
} else if ($argv[1] === 'new' && $argv[2] === 'component') {
    if (!isset($argv[3]) || empty($argv[3])) {
        echo "Error: php maxiter new component [component_name] [template_name]";
        exit();
    }
    if (isset($argv[4])) {
        $config->newComponent($argv[3], $argv[4]);
    } else {
        $config->newComponent($argv[3]);
    }
} else if ($argv[1] === 'mirror' && $argv[3] === 'export') {
    if (!isset($argv[1]) || empty($argv[1]) || !isset($argv[2]) || empty($argv[2]) || !isset($argv[3]) || empty($argv[3])) {
        echo "Error: php maxiter mirror [database_name] export";
        exit();
    }
    $config->mirrorExport($argv[2]);
} else if ($argv[1] === 'mirror' && $argv[3] === 'import') {
    if (!isset($argv[1]) || empty($argv[1]) || !isset($argv[2]) || empty($argv[2]) || !isset($argv[3]) || empty($argv[3])) {
        echo "Error: php maxiter mirror [database_name] import [date]";
        exit();
    }
    $config->mirrorImport($argv[2], isset($argv[4]) ? $argv[4] : null);
} else if ($argv[1] === 'update') {
    if (isset($argv[2]) && $argv[2] === 'cli') {
        $force = isset($argv[3]) && $argv[3] === '-f';
        $config->selfUpdateCLI($force);
    } else {
        $config->selfUpdate();
    }
} else if ($argv[1] === 'pathcheck') {
    if (!isset($argv[1]) || empty($argv[1])) {
        echo "Error: php maxiter pathcheck";
        exit();
    }
    $config->pathCheck();
} else if ($argv[1] === 'cro') {
    if (!isset($argv[1]) || empty($argv[1])) {
        echo "Error: php maxiter cro";
        exit();
    }
    $config->cro();
} else if ($argv[1] === 'crn') {
    if (!isset($argv[1]) || empty($argv[1])) {
        echo "Error: php maxiter crn";
        exit();
    }
    $config->crn();
} else if ($argv[1] === 'versioning') {
    if (!isset($argv[2]) || empty($argv[2])) {
        echo "Error: php maxiter versioning \"[PATH]\"";
        exit();
    }
    $config->versioning($argv[2]);
} else if ($argv[1] === 'versioncode' || $argv[1] === 'codeversion') {
    if (!isset($argv[2]) || empty($argv[2])) {
        echo "Error: php maxiter codeversion \"[PHP_VERSION]\"";
        exit();
    }
    $config->codeversion($argv[2]);
} else {
    echo "Command not found\n";
}
