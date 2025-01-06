<?php
include('db.php');
session_start();

// Ensure the user is logged in as a volunteer
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'volunteer') {
    header("Location: login.php");
    exit();
}

// Fetch rewards
$rewardsQuery = "SELECT * FROM rewards";
$rewardsResult = $conn->query($rewardsQuery);

// Fetch the logged-in volunteer's points
$volunteerID = $_SESSION['user_id'];
$volunteerQuery = "SELECT Points FROM volunteers WHERE VolunteerID = $volunteerID";
$volunteerResult = $conn->query($volunteerQuery);
$volunteer = $volunteerResult->fetch_assoc();
$currentPoints = $volunteer['Points'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Rewards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Claim Rewards</h1>
        <p>You have <strong><?php echo $currentPoints; ?> points</strong>. Choose a reward:</p>

        <div class="row">
            <?php while ($reward = $rewardsResult->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="images/reward_<?php echo $reward['RewardID']; ?>.png" class="card-img-top" alt="<?php echo htmlspecialchars($reward['Description']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($reward['Description']); ?></h5>
                            <p class="card-text">Cost: <?php echo $reward['PointCost']; ?> points</p>
                            <?php if ($currentPoints >= $reward['PointCost']): ?>
                                <form method="POST" action="">
                                    <input type="hidden" name="RewardID" value="<?php echo $reward['RewardID']; ?>">
                                    <button type="submit" name="claim" class="btn btn-success">Claim Reward</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Not Enough Points</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['claim'])) {
    $rewardID = (int)$_POST['RewardID'];

    // Deduct points and handle the claim
    $rewardQuery = "SELECT PointCost FROM rewards WHERE RewardID = $rewardID";
    $rewardResult = $conn->query($rewardQuery);
    $reward = $rewardResult->fetch_assoc();
    $pointCost = $reward['PointCost'];

    if ($currentPoints >= $pointCost) {
        $updatePointsQuery = "UPDATE volunteers SET Points = Points - $pointCost WHERE VolunteerID = $volunteerID";
        $conn->query($updatePointsQuery);

        echo "<script>alert('Reward claimed successfully! You will be contacted soon.');</script>";
        echo "<script>window.location.href = 'rewards.php';</script>";
    } else {
        echo "<script>alert('Not enough points to claim this reward.');</script>";
    }
}
?>
