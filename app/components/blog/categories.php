<!-- Categories -->
<div class="glass rounded-2xl p-6">
  <h3 class="font-bold text-lg mb-4">Blog Categories</h3>
  <div class="space-y-3">

    <?php
    $categories = Data::fromJsonFile(DATA_PATH . 'tags.json')->toArray();
    $article = Data::fromJsonFile(DATA_PATH . 'article.json')->toArray();
    $summary = getCategorySummary($categories, $article);
    ?>

    <?php foreach ($summary as $cat) : ?>

      <a href="<?= htmlspecialchars($cat['slug']); ?>" class="flex justify-between">
        <span class="text-sm text-neutral-600 dark:text-neutral-400">
          <?= htmlspecialchars($cat['name']); ?></span>
        <span class="text-sm font-semibold"><?= (int)$cat['count']; ?></span>
      </a>

    <?php endforeach; ?>
  </div>
</div>