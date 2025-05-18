const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const gulpIf = require('gulp-if');
const cssnano = require('gulp-cssnano');
const imagemin = require('gulp-imagemin');
const cache = require('gulp-cache');

// Paths
const paths = {
    scss: 'scss/**/*.scss',
    css: 'css/',
    dist: 'dist/',
    images: '../../images/**/*.+(png|jpg|jpeg|gif|svg)'
};

// SCSS Tasks
function compileSass() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.write('../maps'))
        .pipe(dest(paths.css));
}

function compileSassProd() {
    return src(paths.scss)
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(gulpIf('*.css', cssnano()))
        .pipe(dest(paths.dist));
}

// Watch Task
function watchFiles() {
    watch(paths.scss, compileSass);
}

// Image Optimization
function optimizeImages() {
    return src(paths.images)
        .pipe(cache(imagemin({ interlaced: true })))
        .pipe(dest('../../images'));
}

// Clear Cache
function clearCache(done) {
    cache.clearAll(done);
}

// Gulp Task Exports
exports.sass = compileSass;
exports['sass:production'] = compileSassProd;
exports.images = optimizeImages;
exports.clear = clearCache;
exports.watch = watchFiles;
exports.default = series(compileSass, watchFiles);
exports.build = series(compileSass, optimizeImages);
exports['build:production'] = series(compileSassProd);
