<nav class="space-x-8 hidden md:block">

  <?php
  $menu = getHeaderMenu();
  foreach ($menu as $item) :
  ?>

    <a href="<?= htmlspecialchars($item['url']); ?>" class="text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100 transition-all duration-300 font-medium"><?= htmlspecialchars($item['label']); ?></a>

  <?php endforeach; ?>

</nav>