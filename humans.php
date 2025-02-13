<?php
require("dbconnect_mysqli.php");
require("functions.php");

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

if ($start_date && $end_date) {
    $start_date = preg_replace('/[^- \:_0-9a-zA-Z]/', '', $start_date);
    $end_date = preg_replace('/[^- \:_0-9a-zA-Z]/', '', $end_date);

    $query = "
        SELECT
            REPLACE(SUBSTRING_INDEX(vdl.outbound_cid, '<', -1), '>', '') AS extracted_number,
            COUNT(vad.lead_id) AS human_answered_calls,
            COUNT(vad.channel) AS total_calls,
            (COUNT(vad.lead_id) / COUNT(vad.channel)) * 100 AS human_answer_rate
        FROM
            vicidial_amd_log vad
        JOIN
            vicidial_dial_log vdl ON vad.lead_id = vdl.lead_id
        WHERE
            vad.AMDSTATUS = 'HUMAN'
            AND vad.call_date BETWEEN ? AND ?
            AND vdl.outbound_cid LIKE '%<%'
            AND vdl.call_date BETWEEN ? AND ?
        GROUP BY
            extracted_number
        ORDER BY
            human_answer_rate DESC
    ";

    $stmt = $link->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($link->error));
    }

    $stmt->bind_param("ssss", $start_date, $end_date, $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Human Answered Calls Report</title>
</head>
<body>
    <h1>Human Answered Calls Report</h1>
    <form method="GET" action="">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>" required>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" required>
        <input type="submit" value="Generate Report">
    </form>

    <?php if (isset($result) && $result->num_rows > 0): ?>
        <table border="1" cellpadding="3" cellspacing="0">
            <tr>
                <th>Outbound CID</th>
                <th>Number of Human Answers</th>
                <th>Total Calls</th>
                <th>Human Answer Rate (%)</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['extracted_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['human_answered_calls']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_calls']); ?></td>
                    <td><?php echo htmlspecialchars(number_format($row['human_answer_rate'], 2)); ?>%</td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php elseif (isset($result)): ?>
        <p>No records found for the selected date range.</p>
    <?php endif; ?>

    <?php
    if (isset($stmt)) {
        $stmt->close();
    }
    $link->close();
    ?>
</body>
</html>
