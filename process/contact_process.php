<?php
$secretKey ='YOUR_SECRET_KEY'; // Replace with your actual secret key

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$fullName = trim($_POST['fullName'] ?? '');
$email    = trim($_POST['email'] ?? '');
$message  = trim($_POST['message'] ?? '');

$token = $_POST['token'] ?? '';

if (empty($fullName)) {
    echo json_encode(['success' => false, 'message' => 'Full name is required.']);
    exit;
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'A valid email address is required.']);
    exit;
}

if (empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Project details are required.']);
    exit;
}

$verify = file_get_contents(
    "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$token"
);

$result = json_decode($verify);

if (!$result->success || $result->score < 0.5) {
    echo json_encode([
        'success' => false,
        'message' => 'Bot detected'
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Thank you, ' . htmlspecialchars($fullName) . '! Your message has been received.'
]);
exit;