<?php
header('Content-Type: text/plain');
$env = parse_ini_file("./env.ini", true);

// Verifica se o método é POST e se o parâmetro 'cmd' existe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bash'])) {
    $command = $_POST['bash'];

    switch ($command) {

        case 'loadTemplates':
            // Path to the templates directory
            $templatesDir = './src/template/';
            $templateFolders = [];

            // Check if directory exists
            if (is_dir($templatesDir)) {
                // Open directory handle
                if ($dh = opendir($templatesDir)) {
                    // Read each directory item
                    while (($file = readdir($dh)) !== false) {
                        // Skip current (.), parent (..) directories, and 'maxiter' folder
                        if ($file != '.' && $file != '..' && $file != 'maxiter') {
                            // Check if it's a directory
                            if (is_dir($templatesDir . $file)) {
                                // Add to templates array
                                $templateFolders[] = [
                                    'name' => $file,    // Display name
                                    'value' => $file    // Value for selection
                                ];
                            }
                        }
                    }
                    closedir($dh);
                }
            }

            // Return as JSON response
            header('Content-Type: application/json');
            echo json_encode($templateFolders);
            break;

        case 'changeUrlAuto':
            $port = null;
            if($_POST['port'] != "80") {
                $port = $_POST['port'];
            }

            $cmd = "php maxiter autopath " . $port;

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0) {
                echo implode("\n", $output);
            } else {
                echo "Error: $returnCode";
            }
            break;

        case 'changeUrl':

            $cmd = "php maxiter path " . $_POST['url'];

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0) {
                echo implode("\n", $output);
            } else {
                echo "Error: $returnCode";
            }
            break;

        case 'newModel':
            $cmd = "php maxiter new model " . $_POST['modelName'];

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0) {
                echo implode("\n", $output);
            } else {
                echo "Error: $returnCode";
            }

            break;

        case 'newController':
            $cmd = "php maxiter new controller " . $_POST['controllerName'];

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0) {
                echo implode("\n", $output);
            } else {
                echo "Error: $returnCode";
            }

            break;

        case 'changeTemplate':
            $cmd = "php maxiter new template " . $_POST['templateName'];

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0) {
                echo implode("\n", $output);
            } else {
                echo "Error: $returnCode";
            }

            break;


        case 'newView':
            if (isset($_POST['templateName']) && !empty($_POST['templateName']) && $_POST['templateName'] != "-") {
                $cmd = "php maxiter new view " . $_POST['viewName'] . " " . $_POST['templateName'];
            } else {
                $cmd = "php maxiter new view " . $_POST['viewName'];
            }

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0) {
                echo implode("\n", $output);
                // exec("start " . $env["app"]["APP_BASE_URL"] . $_POST['viewName']);
            } else {
                echo "Error: $returnCode";
            }

            break;


        case 'newMiddleware':
            $cmd = "php maxiter new middleware " . $_POST['middlewareName'];

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0) {
                echo implode("\n", $output);
            } else {
                echo "Error: $returnCode";
            }

            break;


        case 'newAPIController':
            $cmd = "php maxiter new api " . $_POST['apiControllerName'];

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0) {
                echo implode("\n", $output);
            } else {
                echo "Error: $returnCode";
            }

            break;

        case 'newUnitTest':
            $cmd = "php maxiter new unittest " . $_POST['apiControllerName'] . " " . $_POST['functionName'];

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0) {
                echo implode("\n", $output);
            } else {
                echo "Error: $returnCode";
            }

            break;
    }
} else {
    echo "Invalid Request!";
}
