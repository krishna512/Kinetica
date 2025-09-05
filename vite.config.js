import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import * as glob from 'glob';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const { resolve } = path;

/**
 * ====================================================================
 * Getting all files relative url
 *
 * For Elementor Widgets
 * ====================================================================
 */
let sass = Object.fromEntries(
  glob
    .sync('app/elementor-addon/assets/scss/**/*.scss')
    .map((file) => [
      path.relative('', file.slice(0, file.length - path.extname(file).length)),
      fileURLToPath(new URL(file, import.meta.url)),
    ])
);

sass = Object.values(sass);

let js = Object.fromEntries(
  glob
    .sync('app/elementor-addon/assets/js/**/*.js')
    .map((file) => [
      path.relative('', file.slice(0, file.length - path.extname(file).length)),
      fileURLToPath(new URL(file, import.meta.url)),
    ])
);
js = Object.values(js);

/**
 * ====================================================================
 * main scss file
 * ====================================================================
 */
const scssPaths = ['resources/scss/main.scss', 'resources/scss/filter-form.scss', 'resources/scss/event-single.scss'];

let mainSCSS = Object.fromEntries(
  scssPaths.map((file) => [
    path.relative('', file.slice(0, file.length - path.extname(file).length)),
    fileURLToPath(new URL(file, import.meta.url)),
  ])
);

mainSCSS = Object.values(mainSCSS);

const jsPaths = ['resources/js/app.js', 'resources/js/filter-form.js'];

let jsFiles = Object.fromEntries(
  jsPaths.map((file) => [
    path.relative('', file.slice(0, file.length - path.extname(file).length)),
    fileURLToPath(new URL(file, import.meta.url)),
  ])
);

jsFiles = Object.values(jsFiles);


let csf_js = Object.fromEntries(
  glob
    .sync('csf-search-filter/js/*.js')
    .map((file) => [
      path.relative('resources/js', file.slice(0, file.length - path.extname(file).length)),
      fileURLToPath(new URL(file, import.meta.url)),
    ])
);
csf_js = Object.values(csf_js);

let input = [sass, js, mainSCSS, jsFiles, csf_js];
input = [].concat(...input);

/**
 * ====================================================================
 * Configurations required by vite
 * ====================================================================
 */
export default defineConfig({
  base: '',
  plugins: [
    laravel({
      input,
      publicDirectory: 'build',
      refresh: ['**/*.php', '**.js', '**.scss', '**.css'],
    }),
  ],
  server: {
    port: 2222,
  },
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: 'build',
    assetsDir: 'assets',
    minify: 'terser', // Ensure terser is used
    terserOptions: {
      keep_classnames: true,
      keep_fnames: true,
    },
  },

  resolve: {
    alias: [
      {
        find: /~(.+)/,
        replacement: process.cwd() + '/node_modules/$1',
      },
    ],
  },
});
