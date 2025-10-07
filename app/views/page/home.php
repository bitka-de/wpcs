@comp:hero

<!-- MAIN -->
<main id="articles" class="flex-1 max-w-6xl mx-auto px-6 py-16">

  <!-- Articles Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- Featured Article -->
    @comp:blog.article.featured
    <!-- Sidebar -->
    @comp:blog.sidebar
  </div>

  <!-- Recent Articles -->
    @comp:blog.article.recent

</main>