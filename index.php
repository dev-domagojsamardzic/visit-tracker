<?php
    require __DIR__ . '/vendor/autoload.php';

    use App\Models\Visits;
    use App\Html\Table;

    $startDate = $endDate = $errorMessage = '';

    // Validate method
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $errorMessage = 'Invalid request method';
    }

    // Check if parameters are present
    if (isset($_GET['start_date'], $_GET['end_date'])) {

        // Sanitize inputs
        $startDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['start_date']) ? $_GET['start_date'] : '';
        $endDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['end_date']) ? $_GET['end_date'] : '';

        // Validate parameters
        if (!$startDate || !$endDate) {
            $errorMessage = 'Invalid parameter format present.';
        }
        elseif (strtotime($startDate) > strtotime($endDate)) {
            $errorMessage = 'Start date cannot be greater than end date.';
        }
    }

    if (empty($errorMessage)) {

        $visitsObj = new Visits();
        $visits = $visitsObj->getVisits($startDate, $endDate);

        $table = new Table($visits, ['URL', 'Unique visits']);
    }
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
    if (empty($errorMessage)) {
        echo $table->render();
    }
    else {
        echo '<div class="error-message">' . htmlspecialchars($errorMessage) . '</div>';
    }
?>
<script src="./assets/main.js"></script>
</body>
</html>