const plumber = require('gulp-plumber'),
      scss = require('gulp-sass'),
      autoprefixer = require('gulp-autoprefixer'),
      concat  = require('gulp-concat'),
      cleancss = require('gulp-clean-css'),
      filesize = require('gulp-filesize'),
      postcss = require('gulp-postcss'),
      sourcemaps = require('gulp-sourcemaps'),
      stylesPATH = {
          "input": "./scss/",
          "output": "./css/"
      };

module.exports = function () {
    $.gulp.task('styles:dev', () => {
        var plugins = [
            require('postcss-sort-media-queries')
        ];
        return $.gulp.src(stylesPATH.input + 'styles.scss')
            .pipe(plumber())
            .pipe(sourcemaps.init())
            .pipe(scss({ outputStyle: 'expanded' }))
            .pipe(concat('main.min.css'))
            .pipe(postcss(plugins))
            .pipe(autoprefixer({
                 overrideBrowserslist:  ["defaults"]
            }))
            .pipe(cleancss( {level: { 1: { specialComments: 0 } } })) // Opt., comment out when debugging
            .pipe(sourcemaps.write())
            .pipe($.gulp.dest(stylesPATH.output))
            .pipe(filesize())
            .on('end', $.browserSync.reload);
    });
    $.gulp.task('styles:build', () => {
        return $.gulp.src(stylesPATH.input + 'styles.scss')
            .pipe(scss())
            .pipe(concat('main.min.css'))
            .pipe(autoprefixer({
                 overrideBrowserslist:  ['last 3 versions']
            }))
            .pipe(cleancss( {level: { 1: { specialComments: 0 } } })) // Opt., comment out when debugging
            .pipe(concat('main.min.css'))
            .pipe($.gulp.dest(stylesPATH.output))
    });
    $.gulp.task('styles:build-min', () => {
        return $.gulp.src(stylesPATH.input + 'styles.scss')
            .pipe(scss())
            .pipe(concat('main.min.css'))
            .pipe(autoprefixer())
            .pipe(cleancss( {level: { 1: { specialComments: 0 } } })) // Opt., comment out when debugging
            .pipe($.gulp.dest(stylesPATH.output))
    });
};
