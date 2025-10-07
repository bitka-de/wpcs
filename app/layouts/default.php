<!DOCTYPE html>
<html lang="<?= HTML_LANG ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JP's Blog</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="/assets/script.php?filename=tw-script"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/assets/style.php">

  <style>
    .glass {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .glass-dark {
      background: rgba(23, 23, 23, 0.8);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .dark .glass {
      background: rgba(23, 23, 23, 0.8);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .theme-transition {
      transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }
  </style>
  <script>
    // Dark mode functionality
    function initTheme() {
      const savedTheme = localStorage.getItem('theme');
      const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const shouldBeDark = savedTheme === 'dark' || (!savedTheme && systemPrefersDark);

      if (shouldBeDark) {
        document.documentElement.classList.add('dark');
      }
    }

    function toggleTheme() {
      const isDark = document.documentElement.classList.contains('dark');
      if (isDark) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
      } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
      }
    }

    // Initialize theme before page load
    initTheme();
  </script>
</head>

@comp:base.header

<body class="min-h-screen flex flex-col bg-gradient-to-br from-neutral-50 via-white to-neutral-100 dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900 text-neutral-800 dark:text-neutral-200 font-sans theme-transition">

  @content
  @comp:base.footer
</body>

</html>