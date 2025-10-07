<!-- HERO -->
<section class="pt-24 pb-16 px-6 relative">

  <?= editComponent(__FILE__); ?>


  <div class="max-w-4xl mx-auto text-center">
    <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-neutral-900 via-neutral-700 to-neutral-600 dark:from-neutral-100 dark:via-neutral-300 dark:to-neutral-400 bg-clip-text text-transparent leading-tight">
      Welcome to my
      <span class="block">digital space</span>
    </h1>
    <p class="text-xl text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto leading-relaxed">
      Thoughts, ideas, and stories from a developer's journey through code, design, and life.
    </p>
    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
      <a href="#articles" class="inline-flex items-center px-6 py-3 bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 font-medium rounded-xl hover:bg-neutral-800 dark:hover:bg-neutral-200 transition-all duration-300 shadow-lg hover:shadow-xl">
        Read Articles
        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
      </a>
      <a href="#about" class="inline-flex items-center px-6 py-3 glass font-medium rounded-xl hover:bg-white/90 dark:hover:bg-neutral-800/90 transition-all duration-300">
        About Me
      </a>
    </div>
  </div>
</section>