//add more here if you want to include more libraries
var gulp        = require('gulp'),
uglify      = require('gulp-uglify'),
sass = require('gulp-sass'),
plumber = require('gulp-plumber'),
livereload = require('gulp-livereload');

// SCRIPTS TASK
// Minify, Concat
gulp.task('scripts', function() {
    // gulp.src('js-dev/*.js')
    // .pipe(plumber())
    // .pipe(uglify())
    // .pipe(gulp.dest('js'))
    // .pipe(livereload());
});

// STYLES TASK
// Minify CSS, Compile SASS
gulp.task('styles', function() {
    gulp.src('scss/**/*.scss')
    .pipe(plumber())
    .pipe(sass({
        outputStyle: 'compressed'
    }).on('error', sass.logError))
    .pipe(gulp.dest('css'))
    .pipe(livereload());
});

// Watch Task
gulp.task('watch', function(){

    var server = livereload();
    
    // gulp.watch('js-dev/*.js', ['scripts']);
    gulp.watch('scss/**/*.scss', ['styles']);
});


// DEFAULT TASK
// 
gulp.task('default', ['styles', 'watch']);