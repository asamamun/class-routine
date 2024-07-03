<?php
$standards = ['class1', 'class2', 'class3', 'class4', 'class5', 'class6'];
$days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
$class_times = ['9:00am-10:00am', '10:00am-11:00am', '11:00am-12:00pm', '12:00pm-1:00pm', '1:00pm-2:00pm', '2:00pm-3:00pm', '3:00pm-4:00pm'];
$subjects = ['English', 'Maths', 'Science', 'Social Science', 'Bangla', 'Arabic', 'Computer Science', 'Chemistry', 'Physics'];

$selected_class = isset($_POST['selected_class']) ? $_POST['selected_class'] : '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_routine'])) {
    $routine = [];
    foreach ($days as $day) {
        foreach ($class_times as $time) {
            $key = "{$selected_class}_{$day}_{$time}";
            if (isset($_POST[$key])) {
                $routine[$day][$time] = $_POST[$key];
            }
        }
    }
    // Save as JSON
    $json = json_encode($routine, JSON_PRETTY_PRINT);
    $filename = $selected_class . '_routine.json';
    file_put_contents($filename, $json);
    echo "Routine for {$selected_class} saved successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Routine</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Class Routine</h1>
    <form method="post">
        <label for="selected_class">Select Class:</label>
        <select name="selected_class" id="selected_class">
            <option value="">Select a class</option>
            <?php foreach ($standards as $standard): ?>
                <option value="<?= $standard ?>" <?= ($selected_class == $standard) ? 'selected' : '' ?>><?= ucfirst($standard) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Select Class">
    </form>

    <?php if ($selected_class): ?>
        <h2>Routine for <?= ucfirst($selected_class) ?></h2>
        <form method="post">
            <input type="hidden" name="selected_class" value="<?= $selected_class ?>">
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
                                <select name="<?= "{$selected_class}_{$day}_{$time}" ?>">
                                    <option value="">Select Subject</option>
                                    <?php foreach ($subjects as $subject): ?>
                                        <option value="<?= $subject ?>"><?= $subject ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <input type="submit" name="save_routine" value="Save Routine">
        </form>
    <?php endif; ?>
</body>
</html>