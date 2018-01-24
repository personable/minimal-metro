var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

gulp.task('styles', function() {
  gulp.src('./scss/base.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./dist/'));
  gulp.src('./scss/app.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./dist/'));
  gulp.src('./scss/onboard.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./dist/'));
});

gulp.task('autoprefix', function() {
  gulp.src('./dist/*.css')
    .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))
    .pipe(gulp.dest('./dist/'));
});

gulp.task('default',function() {
  gulp.watch('./scss/base.scss',['styles', 'autoprefix']);
  gulp.watch('./scss/app.scss',['styles', 'autoprefix']);
  gulp.watch('./scss/onboard.scss',['styles', 'autoprefix']);
});
