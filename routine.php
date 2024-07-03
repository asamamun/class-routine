<?php
//i am trying to develop class routine:
/* $standards = ['class1', 'class2', 'class3', 'class4', 'class5', 'class6'];
$day = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
$class_time= ['9:00am-10:00am', '10:00am-11:00am', '11:00am-12:00pm', '12:00pm-1:00pm', '1:00pm-2:00pm', '2:00pm-3:00pm', '3:00pm-4:00pm'];
$subjects = ['English', 'Maths', 'Science', 'Social Science', 'Bangla', 'Arabic', 'Computer Science', 'Chemistry', 'Physics'];
i want to create a table in html where admin can enter class routine and save it as JSON. in every call user will select subject from $subjects */
?>
<?php
$standards = ['class1', 'class2', 'class3', 'class4', 'class5', 'class6'];
$days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
$class_times = ['9:00am-10:00am', '10:00am-11:00am', '11:00am-12:00pm', '12:00pm-1:00pm', '1:00pm-2:00pm', '2:00pm-3:00pm', '3:00pm-4:00pm'];
$subjects = ['English', 'Maths', 'Science', 'Social Science', 'Bangla', 'Arabic', 'Computer Science', 'Chemistry', 'Physics'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $routine = [];
    foreach ($standards as $standard) {
        foreach ($days as $day) {
            foreach ($class_times as $time) {
                $key = "{$standard}_{$day}_{$time}";
                if (isset($_POST[$key])) {
                    $routine[$standard][$day][$time] = $_POST[$key];
                }
            }
        }
    }
    // Save as JSON
    $json = json_encode($routine, JSON_PRETTY_PRINT);
    file_put_contents('routine.json', $json);
    echo "Routine saved successfully!";
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
        <?php foreach ($standards as $standard): ?>
            <h2><?= ucfirst($standard) ?></h2>
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
                                <select name="<?= "{$standard}_{$day}_{$time}" ?>">
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
        <?php endforeach; ?>
        <br>
        <input type="submit" value="Save Routine">
    </form>
</body>
</html>
