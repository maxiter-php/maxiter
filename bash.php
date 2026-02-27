<?php
header('Content-Type: text/plain');
$env = parse_ini_file("./env.ini", true);

function runCommand($cmd) {
    exec($cmd, $output, $returnCode);
    if ($returnCode === 0) {
        echo implode("\n", $output);
    } else {
        echo "Error: $returnCode";
    }
}

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

            runCommand($cmd);
            break;

        case 'changeUrl':

            $cmd = "php maxiter path " . $_POST['url'];

            runCommand($cmd);
            break;

        case 'newModel':
            $cmd = "php maxiter new model " . $_POST['modelName'];

            exec($cmd, $output, $returnCode);
            runCommand($cmd);
            break;

        case 'newController':
            $cmd = "php maxiter new controller " . $_POST['controllerName'];

            exec($cmd, $output, $returnCode);
            runCommand($cmd);
            break;

        case 'changeTemplate':
            $cmd = "php maxiter new template " . $_POST['templateName'];

            exec($cmd, $output, $returnCode);
            runCommand($cmd);
            break;



        case 'newView':
            if (isset($_POST['templateName']) && !empty($_POST['templateName']) && $_POST['templateName'] != "-") {
                $cmd = "php maxiter new view " . $_POST['viewName'] . " " . $_POST['templateName'];
            } else {
                $cmd = "php maxiter new view " . $_POST['viewName'];
            }

            runCommand($cmd);

            break;


        case 'newMiddleware':
            $cmd = "php maxiter new middleware " . $_POST['middlewareName'];

            runCommand($cmd);

            break;


        case 'newAPIController':
            $cmd = "php maxiter new api " . $_POST['apiControllerName'];

            runCommand($cmd);

            break;

        case 'newUnitTest':
            $cmd = "php maxiter new unittest " . $_POST['apiControllerName'] . " " . $_POST['functionName'];

            runCommand($cmd);
            break;
        case 'newLog':
            $cmd = "php maxiter new log " . $_POST['databaseName'];
            runCommand($cmd);
            break;
        case 'newTable':
            $cmd = "php maxiter new table " . $_POST['tableName'];
            runCommand($cmd);
            break;
        case 'newComponent':
            if (isset($_POST['templateName']) && $_POST['templateName'] !== "") {
                $cmd = "php maxiter new component " . $_POST['componentName'] . " " . $_POST['templateName'];
            } else {
                $cmd = "php maxiter new component " . $_POST['componentName'];
            }
            runCommand($cmd);
            break;
        case 'server':
            if (isset($_POST['port']) && $_POST['port'] !== "") {
                $cmd = "php maxiter server " . $_POST['port'];
            } else {
                $cmd = "php maxiter server";
            }
            runCommand($cmd);
            break;
        case 'openGui':
            $cmd = "php maxiter gui";
            runCommand($cmd);
            break;
        case 'pathcheck':
            $cmd = "php maxiter pathcheck";
            runCommand($cmd);
            break;
        case 'testme':
            $cmd = "php maxiter testme";
            runCommand($cmd);
            break;
        case 'configProd':
            $cmd = "php maxiter config prod";
            runCommand($cmd);
            break;
        case 'deltoprod':
            $cmd = "php maxiter deltoprod";
            runCommand($cmd);
            break;
        case 'deltoprodFolder':
            $cmd = "php maxiter -f deltoprod";
            runCommand($cmd);
            break;
        case 'deltoprodRestore':
            $cmd = "php maxiter -r deltoprod";
            runCommand($cmd);
            break;
        case 'mirrorExport':
            $cmd = "php maxiter mirror " . $_POST['databaseName'] . " export";
            runCommand($cmd);
            break;
        case 'mirrorImport':
            if (isset($_POST['date']) && $_POST['date'] !== "") {
                $cmd = "php maxiter mirror " . $_POST['databaseName'] . " import " . $_POST['date'];
            } else {
                $cmd = "php maxiter mirror " . $_POST['databaseName'] . " import";
            }
            runCommand($cmd);
            break;
        case 'update':
            $cmd = "php maxiter update";
            runCommand($cmd);
            break;
        case 'updateCli':
            if (isset($_POST['force']) && $_POST['force'] === "1") {
                $cmd = "php maxiter update cli -f";
            } else {
                $cmd = "php maxiter update cli";
            }
            runCommand($cmd);
            break;
        case 'cro':
            $cmd = "php maxiter cro";
            runCommand($cmd);
            break;
        case 'crn':
            $cmd = "php maxiter crn";
            runCommand($cmd);
            break;
    }
} else {
    echo "Invalid Request!";
}
