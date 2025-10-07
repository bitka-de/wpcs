<?php

declare(strict_types=1);

$errors = [];
$oldEmail = '';
$oldUsername = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim((string)($_POST['email'] ?? ''));
  $username = trim((string)($_POST['username'] ?? ''));
  $password = (string)($_POST['password'] ?? '');
  $password_confirmation = (string)($_POST['password_confirmation'] ?? '');

  // keep old values for form redisplay (raw values; escape later for output)
  $oldEmail = $email;
  $oldUsername = $username;

  // basic validation
  if ($email === '' || $username === '' || $password === '') {
    $errors[] = 'Bitte fülle alle Pflichtfelder aus.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Ungültige E-Mail-Adresse.';
  } elseif ($password !== $password_confirmation) {
    $errors[] = 'Passwörter stimmen nicht überein.';
  } elseif (strlen($password) < 8) {
    $errors[] = 'Passwort muss mindestens 8 Zeichen haben.';
  } elseif (!preg_match('/^[A-Za-z0-9_\-]+$/', $username)) {
    $errors[] = 'Benutzername enthält ungültige Zeichen.';
  } else {
    $dir = __DIR__ . '/data';
    if (!is_dir($dir)) {
      if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
        $errors[] = 'Konnte Verzeichnis nicht erstellen.';
      }
    }

    $file = $dir . '/users.json';
    $users = [];

    if (is_file($file)) {
      $contents = @file_get_contents($file);
      $decoded = @json_decode($contents, true);
      if (is_array($decoded)) {
        $users = $decoded;
      }
    }

    // ensure unique email/username
    foreach ($users as $u) {
      if (isset($u['email']) && strtolower($u['email']) === strtolower($email)) {
        $errors[] = 'E-Mail ist bereits registriert.';
        break;
      }
      if (isset($u['username']) && strtolower($u['username']) === strtolower($username)) {
        $errors[] = 'Benutzername ist bereits vergeben.';
        break;
      }
    }

    if (empty($errors)) {
      $uid = bin2hex(random_bytes(8));
      $createdAt = (int) floor(microtime(true) * 1000);

      $newUser = [
        'id' => $uid,
        'email' => $email,
        'username' => $username,
        // store a secure hash instead of plaintext
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'master',
        'createdAt' => $createdAt,
      ];

      $users[] = $newUser;

      $json = json_encode($users, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
      if (false === @file_put_contents($file, $json . PHP_EOL, LOCK_EX)) {
        $errors[] = 'Konnte Benutzerdaten nicht speichern.';
      } else {
        // Nach erfolgreichem Anlegen die first-run.php Datei umbenennen
        $currentFile = __FILE__;
        $newFileName = dirname($currentFile) . '/_first-run.php';
        
        // Versuche die Datei umzubenennen
        if (@rename($currentFile, $newFileName)) {
          // Erfolgreich umbenannt - Redirect zur Hauptseite oder Login
          header('Location: /');
          exit;
        } else {
          // Fallback: wenn Umbenennung fehlschlägt, normaler Redirect
          header('Location: ' . $_SERVER['REQUEST_URI']);
          exit;
        }
      }
    }
  }
}

// escape values for output
$escapedEmail = htmlspecialchars((string)$oldEmail, ENT_QUOTES);
$escapedUsername = htmlspecialchars((string)$oldUsername, ENT_QUOTES);
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Registrieren</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
  <form method="post" action="<?= htmlspecialchars((string)($_SERVER['REQUEST_URI'] ?? ''), ENT_QUOTES) ?>"
  class="w-full max-w-sm bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-2xl space-y-5 animate-fadeIn"
  novalidate
  onsubmit="return handleSubmit(event);">

  <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Willkommen 👋</h1>
  <p class="text-center text-gray-500 text-sm mb-4">Erstelle dein Konto, um loszulegen</p>

  <?php if (!empty($errors)): ?>
    <div class="mb-2 text-sm text-red-600">
    <?php foreach ($errors as $err): ?>
      <div><?= htmlspecialchars((string)$err, ENT_QUOTES) ?></div>
    <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div>
    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-Mail</label>
    <input type="email" id="email" name="email" required
    value="<?= $escapedEmail ?>"
    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
    aria-describedby="email-help">
    <p id="email-help" class="text-xs text-gray-500 mt-1">Wir verwenden deine E-Mail nur für die Anmeldung.</p>
  </div>

  <div>
    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Benutzername</label>
    <input type="text" id="username" name="username" required
    value="<?= $escapedUsername ?>"
    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
    aria-describedby="username-help">
    <p id="username-help" class="text-xs text-gray-500 mt-1">Wähle einen eindeutigen Namen (ohne Sonderzeichen).</p>
  </div>

  <div>
    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Passwort</label>
    <input type="password" id="password" name="password" required
    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
    aria-describedby="password-help password-strength">
    <p id="password-help" class="text-xs text-gray-500 mt-1">Mindestens 8 Zeichen; verwende Groß-/Kleinbuchstaben und Zahlen.</p>

    <div class="mt-2">
    <div class="w-full bg-gray-200 rounded h-2 overflow-hidden">
      <div id="password-strength" class="h-full bg-gradient-to-r from-red-500 via-yellow-300 to-green-500" style="width:0%"></div>
    </div>
    <p id="password-strength-text" class="text-xs text-gray-500 mt-1">Stärke: —</p>
    </div>
  </div>

  <div>
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Passwort wiederholen</label>
    <input type="password" id="password_confirmation" name="password_confirmation" required
    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
    aria-describedby="password-confirm-help">
    <p id="password-confirm-help" class="text-xs text-red-600 mt-1 hidden" role="alert">Passwörter stimmen nicht überein.</p>
  </div>

  <div class="flex items-center space-x-2">
    <input id="showPassword" type="checkbox" class="h-4 w-4">
    <label for="showPassword" class="text-sm text-gray-700">Passwort anzeigen</label>
  </div>

  <button id="submitBtn" type="submit" disabled
    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 rounded-md font-semibold shadow-md hover:shadow-lg hover:opacity-90 transition disabled:opacity-60 disabled:cursor-not-allowed">
    Registrieren
  </button>

  </form>

  <script>
  (function () {
    const emailEl = document.getElementById('email');
    const usernameEl = document.getElementById('username');
    const pwd = document.getElementById('password');
    const pwdConfirm = document.getElementById('password_confirmation');
    const pwdStrengthBar = document.getElementById('password-strength');
    const pwdStrengthText = document.getElementById('password-strength-text');
    const pwdConfirmHelp = document.getElementById('password-confirm-help');
    const submitBtn = document.getElementById('submitBtn');
    const showPassword = document.getElementById('showPassword');

    let confirmBlurred = false;

    function scorePassword(s) {
    let score = 0;
    if (!s) return 0;
    if (s.length >= 8) score += 1;
    if (/[A-Z]/.test(s)) score += 1;
    if (/[a-z]/.test(s)) score += 1;
    if (/[0-9]/.test(s)) score += 1;
    if (/[^A-Za-z0-9]/.test(s)) score += 1;
    return score;
    }

    function updateStrength() {
    const s = pwd.value;
    const score = scorePassword(s); // 0..5
    const pct = Math.min(100, Math.round((score / 5) * 100));
    pwdStrengthBar.style.width = pct + '%';
    let label = 'Sehr schwach';
    if (score >= 4) label = 'Stark';
    else if (score === 3) label = 'Mittel';
    else if (score === 2) label = 'Schwach';
    pwdStrengthText.textContent = 'Stärke: ' + label;
    }

    function validateMatch(showError = false) {
    if (!pwd.value && !pwdConfirm.value) {
      pwdConfirmHelp.classList.add('hidden');
      return false;
    }
    const ok = pwd.value === pwdConfirm.value;
    if (showError) {
      pwdConfirmHelp.classList.toggle('hidden', ok);
    } else {
      pwdConfirmHelp.classList.add('hidden');
    }
    return ok;
    }

    function updateFormState() {
    const emailOk = emailEl.checkValidity();
    const usernameOk = usernameEl.value.trim() !== '';
    const pwdOk = pwd.value.length >= 8;
    const confirmOk = confirmBlurred ? validateMatch(false) : false;
    const allOk = emailOk && usernameOk && pwdOk && confirmOk;
    submitBtn.disabled = !allOk;
    }

    pwd.addEventListener('input', function () {
    updateStrength();
    if (!confirmBlurred) {
      pwdConfirmHelp.classList.add('hidden');
    }
    updateFormState();
    });

    pwdConfirm.addEventListener('input', function () {
    pwdConfirmHelp.classList.add('hidden');
    updateFormState();
    });

    pwdConfirm.addEventListener('blur', function () {
    confirmBlurred = true;
    validateMatch(true);
    updateFormState();
    });

    emailEl.addEventListener('input', updateFormState);

    showPassword.addEventListener('change', function () {
    const type = showPassword.checked ? 'text' : 'password';
    pwd.type = type;
    pwdConfirm.type = type;
    });

    window.handleSubmit = function (e) {
    updateStrength();
    if (!confirmBlurred) {
      confirmBlurred = true;
      validateMatch(true);
    }
    const match = validateMatch(true);
    if (!match) {
      e.preventDefault();
      pwdConfirm.focus();
      return false;
    }
    if (pwd.value.length < 8) {
      e.preventDefault();
      pwd.focus();
      return false;
    }
    submitBtn.disabled = true;
    return true;
    };

    updateStrength();
    validateMatch(false);
    updateFormState();
  })();
  </script>

  <style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fadeIn {
    animation: fadeIn 0.6s ease-out;
  }
  </style>
</body>
</html>
