<?php
$standards = ['class1', 'class2', 'class3', 'class4', 'class5', 'class6'];
$days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
$class_times = ['9:00am-10:00am', '10:00am-11:00am', '11:00am-12:00pm', '12:00pm-1:00pm', '1:00pm-2:00pm', '2:00pm-3:00pm', '3:00pm-4:00pm'];

$selected_class = isset($_GET['class']) ? $_GET['class'] : '';

function loadRoutineData($class) {
    $filename = $class . '_routine.json';
    if (file_exists($filename)) {
        $jsonData = file_get_contents($filename);
        return json_decode($jsonData, true);
    }
    return null;
}

$routineData = $selected_class ? loadRoutineData($selected_class) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Class Routine</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h1>Class Routine</h1>
    <form method="get" class="no-print">
        <label for="selected_class">Select Class:</label>
        <select name="class" id="selected_class">
            <option value="">Select a class</option>
            <?php foreach ($standards as $standard): ?>
                <option value="<?= $standard ?>" <?= ($selected_class == $standard) ? 'selected' : '' ?>><?= ucfirst($standard) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="View Routine">
    </form>

    <?php if ($selected_class && $routineData): ?>
        <h2>Routine for <?= ucfirst($selected_class) ?></h2>
        <table>
            <tr>
                <th>Time</th>
                <?php foreach ($days as $day): ?>
                    <th><?= ucfirst($day) ?></th>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($class_times as $time): ?>
                <tr>
                    <td><?= $time ?></td>
                    <?php foreach ($days as $day): ?>
                        <td>
                            <?= isset($routineData[$day][$time]) ? $routineData[$day][$time] : '' ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <button onclick="window.print()" class="no-print">Print Routine</button>
    <?php elseif ($selected_class): ?>
        <p>No routine data available for this class.</p>
    <?php endif; ?>
</body>
</html>