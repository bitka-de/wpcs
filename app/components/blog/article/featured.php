<!-- Featured Article -->
<article class="lg:col-span-2 group relative">
    <?= editComponent(__FILE__); ?>


  <div class="glass rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">
    <div class="relative">
      <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&h=400&fit=crop" alt="Featured Article" class="w-full h-64 object-cover">
      <div class="absolute top-4 left-4">
        <span class="bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 px-3 py-1 rounded-full text-sm font-medium">Featured</span>
      </div>
    </div>
    <div class="p-8">
      <h2 class="text-3xl font-bold mb-4 group-hover:text-neutral-600 dark:group-hover:text-neutral-400 transition-colors">
        <a href="#">Building Modern Web Applications in 2025</a>
      </h2>
      <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        6. Oktober 2025 • 8 Min. read
      </p>
      <p class="text-neutral-700 dark:text-neutral-300 leading-relaxed mb-6">
        A comprehensive guide to modern web development practices, tools, and techniques that are shaping the industry in 2025. From performance optimization to user experience design.
      </p>
      <a href="#" class="inline-flex items-center text-neutral-900 dark:text-neutral-100 font-semibold hover:text-neutral-600 dark:hover:text-neutral-400 transition-colors group">
        Read More
        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
        </svg>
      </a>
    </div>
  </div>
</article>