<?php
function getUnreadNotificationsCount($userId, $role) {
    global $conn;

    if ($role === 'volunteer') {
        $query = "SELECT COUNT(*) AS count FROM notifications WHERE VolunteerID = ? AND IsRead = 0";
    } elseif ($role === 'organization') {
        $query = "SELECT COUNT(*) AS count FROM notifications WHERE OrgID = ? AND IsRead = 0";
    } else {
        return 0;
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] ?? 0;
}

function getNotifications($userId, $role) {
    global $conn;

    if ($role === 'volunteer') {
        $query = "SELECT Message, DateCreated FROM notifications WHERE VolunteerID = ? ORDER BY DateCreated DESC LIMIT 10";
    } elseif ($role === 'organization') {
        $query = "SELECT Message, DateCreated FROM notifications WHERE OrgID = ? ORDER BY DateCreated DESC LIMIT 10";
    } else {
        return [];
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
    return $notifications;
}

function addNotification($userId, $role, $message) {
    global $conn;

    if ($role === 'volunteer') {
        $query = "INSERT INTO notifications (VolunteerID, Message) VALUES (?, ?)";
    } elseif ($role === 'organization') {
        $query = "INSERT INTO notifications (OrgID, Message) VALUES (?, ?)";
    } else {
        return false;
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $userId, $message);
    return $stmt->execute();
}
?>
