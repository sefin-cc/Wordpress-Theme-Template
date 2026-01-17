import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  root: '.', // project root for Vite (not assets/scss)
  build: {
    outDir: path.resolve(__dirname, 'assets/css'), // compiled CSS output
    emptyOutDir: true,
    rollupOptions: {
      input: {
        blocks: path.resolve(__dirname, 'assets/scss/blocks.scss')
      },
      output: {
        assetFileNames: '[name].[ext]'
      }
    }
  },
  css: {
    preprocessorOptions: {
      scss: {

      }
    }
  },
  server: {
    watch: {
      // Windows friendly polling (if needed)
      usePolling: true,
    }
  }
});
