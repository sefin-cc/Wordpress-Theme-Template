import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  root: '.',
  build: {
    outDir: path.resolve(__dirname, 'assets/dist'),
    emptyOutDir: true,
    rollupOptions: {
      input: {
        blocks: path.resolve(__dirname, 'assets/scss/blocks.scss'),
        bundle: path.resolve(__dirname, 'assets/js/main.js') // JS entry point
      },
      output: {
        assetFileNames: (assetInfo) => {
          // CSS files go to css folder
          if (assetInfo.name.endsWith('.css')) {
            return 'css/[name].[ext]';
          }
          return '[name].[ext]';
        },
        entryFileNames: 'js/[name].js', // JS files go to js folder
        chunkFileNames: 'js/[name].js'
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
      usePolling: true,
    }
  }
});