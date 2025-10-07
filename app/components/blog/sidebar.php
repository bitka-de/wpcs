    <!-- Sidebar -->
    <aside class="space-y-8 relative">

      <?= editComponent(__FILE__); ?>


      <!-- About Card -->
      <div class="glass rounded-2xl p-6">
        <div class="flex items-center mb-4">
          <div class="w-12 h-12 bg-gradient-to-r from-neutral-800 to-neutral-600 dark:from-neutral-200 dark:to-neutral-400 rounded-full flex items-center justify-center text-white dark:text-neutral-900 font-bold text-lg">
            JP
          </div>
          <div class="ml-4">
            <h3 class="font-bold text-lg">Jan-Paul Behrens</h3>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Developer & Writer</p>
          </div>
        </div>
        <p class="text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed">
          Passionate about clean code, great UX, and strong coffee. Building digital experiences that matter.
        </p>
      </div>

      @comp:blog.categories


      <!-- Newsletter -->
      <div class="glass rounded-2xl p-6">
        <h3 class="font-bold text-lg mb-3">Stay Updated</h3>
        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">Get the latest articles delivered to your inbox.</p>
        <div class="space-y-3">
          <input type="email" placeholder="your@email.com" class="w-full px-4 py-2 border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-900 dark:focus:ring-neutral-100 focus:border-transparent transition-all">
          <button class="w-full bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 py-2 rounded-lg hover:bg-neutral-800 dark:hover:bg-neutral-200 transition-colors font-medium">
            Subscribe
          </button>
        </div>
      </div>
    </aside>