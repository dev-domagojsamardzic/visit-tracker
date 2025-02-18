<?php

    require_once 'src/Visits.php';
    require_once 'src/html/Table.php';

    $startDate = $endDate = '';

    // Validate method
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }

    // Check if parameters are present
    if (isset($_GET['start_date'], $_GET['end_date'])) {
        // Sanitize inputs
        $startDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['start_date']) ? $_GET['start_date'] : '';
        $endDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['end_date']) ? $_GET['end_date'] : '';

        // Validate parameters
        if (!$startDate || !$endDate) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid parameter present.']);
            exit;
        }
    }

    $visitsObj = new Visits();
    $visits = $visitsObj->getVisits($startDate, $endDate);

    $table = new Table($visits, ['URL', 'Unique visits']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unique visits</title>
    <link type="text/css" href="./assets/main.css" rel="stylesheet">
</head>
<body>

<h1>Unique visits overview</h1>

<!-- Date Range Form -->
<form method="GET" action="">
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>" required>

    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>" required>

    <input type="submit" value="Filter">
    <input type="button" id="resetBtn" value="Reset">
</form>

<?php
    echo $table->render();
?>
<script src="./assets/main.js"></script>
</body>
</html>