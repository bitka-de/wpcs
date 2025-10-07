  <!-- Recent Articles -->
  <section class="mt-16 relative">
    <?= editComponent(__FILE__); ?>

    <h2 class="text-3xl font-bold mb-8">Recent Articles</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      <article class="glass rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=400&h=200&fit=crop" alt="Article" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="font-bold text-lg mb-2 group-hover:text-neutral-600 dark:group-hover:text-neutral-400 transition-colors">
            <a href="#">The Future of JavaScript</a>
          </h3>
          <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-3">5. Oktober 2025 • 5 Min.</p>
          <p class="text-neutral-700 dark:text-neutral-300 text-sm leading-relaxed">
            Exploring upcoming features and what they mean for developers...
          </p>
        </div>
      </article>

      <article class="glass rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400&h=200&fit=crop" alt="Article" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="font-bold text-lg mb-2 group-hover:text-neutral-600 dark:group-hover:text-neutral-400 transition-colors">
            <a href="#">Design Systems That Scale</a>
          </h3>
          <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-3">4. Oktober 2025 • 7 Min.</p>
          <p class="text-neutral-700 dark:text-neutral-300 text-sm leading-relaxed">
            Building maintainable design systems for growing teams...
          </p>
        </div>
      </article>

      <article class="glass rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
        <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?w=400&h=200&fit=crop" alt="Article" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="font-bold text-lg mb-2 group-hover:text-neutral-600 dark:group-hover:text-neutral-400 transition-colors">
            <a href="#">Performance Optimization</a>
          </h3>
          <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-3">3. Oktober 2025 • 6 Min.</p>
          <p class="text-neutral-700 dark:text-neutral-300 text-sm leading-relaxed">
            Making web applications faster and more efficient...
          </p>
        </div>
      </article>

    </div>
  </section>