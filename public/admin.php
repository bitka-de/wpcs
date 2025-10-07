<?php

declare(strict_types=1);

session_start();

// Simple logout
if (isset($_GET['logout'])) {
  session_destroy();
  header('Location: admin.php');
  exit;
}

// Check if already logged in
if (isset($_SESSION['user_id'])) {
  // User is logged in - show admin dashboard
  $username = $_SESSION['username'] ?? 'Admin';
?>

  <!DOCTYPE html>
  <html lang="de">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

  <body class="min-h-screen bg-gray-100">
    <div class="max-w-4xl mx-auto py-8 px-4">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-around items-center mb-6">
          <div class="text-center">
            <a href="/" class="text-sm text-gray-600 hover:text-purple-600 transition">
              ← zur Website
            </a>
          </div>
          <h1 class="text-2xl font-bold grow text-gray-800">Welcome, <?= htmlspecialchars($username) ?>!</h1>
          <a href="admin.php?logout=1" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
            Logout
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="font-semibold text-blue-800 mb-2">Blog Posts</h3>
            <p class="text-blue-600">Manage your articles</p>
          </div>

          <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="font-semibold text-green-800 mb-2">Categories</h3>
            <p class="text-green-600">Organize content</p>
          </div>

          <div class="bg-purple-50 p-4 rounded-lg">
            <h3 class="font-semibold text-purple-800 mb-2">Settings</h3>
            <p class="text-purple-600">Site configuration</p>
          </div>
        </div>
      </div>
    </div>
  </body>

  </html>
<?php
  exit;
}

// Handle login form submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if (empty($username) || empty($password)) {
    $error = 'Bitte fülle alle Felder aus.';
  } else {
    // Load and validate user
    $userFile = __DIR__ . '/../data/users.json';
    if (file_exists($userFile)) {
      $users = json_decode(file_get_contents($userFile), true);
      $userFound = false;

      if (is_array($users)) {
        foreach ($users as $user) {
          // Check username/email and password
          if (
            (strtolower($user['username'] ?? '') === strtolower($username) ||
              strtolower($user['email'] ?? '') === strtolower($username)) &&
            password_verify($password, $user['password'] ?? '')
          ) {
            // Login successful
            $_SESSION['user_id'] = $user['uid'] ?? '';
            $_SESSION['username'] = $user['username'] ?? '';
            $_SESSION['role'] = $user['role'] ?? 'user';
            $_SESSION['loggedin'] = true;

            header('Location: admin.php');
            exit;
          }
        }
      }
    }

    $error = 'Ungültige Anmeldedaten.';
  }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
  <div class="w-full max-w-md">
    <form method="post" class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl p-8 space-y-6">
      <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Login</h1>
        <p class="text-gray-600">Melde dich an, um fortzufahren</p>
      </div>

      <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <div>
        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
          Benutzername oder E-Mail
        </label>
        <input
          type="text"
          id="username"
          name="username"
          required
          value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
          placeholder="Dein Benutzername oder E-Mail">
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
          Passwort
        </label>
        <input
          type="password"
          id="password"
          name="password"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
          placeholder="Dein Passwort">
      </div>

      <button
        type="submit"
        class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl hover:from-purple-700 hover:to-pink-700 transition-all duration-200">
        Anmelden
      </button>

      <div class="text-center">
        <a href="/" class="text-sm text-gray-600 hover:text-purple-600 transition">
          ← Zurück zur Website
        </a>
      </div>
    </form>
  </div>
</body>

</html>