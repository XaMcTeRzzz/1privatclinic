const uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    sourcemaps = require('gulp-sourcemaps'),
    filesize = require('gulp-filesize'),
    scriptsPATH = {
        "input": "./js/",
        "output": "./build-js/"
    },
    babel = require('gulp-babel');

module.exports = function () {
    $.gulp.task('libsJS:dev', () => {
        return $.gulp.src(['node_modules/svg4everybody/dist/svg4everybody.min.js',
                            'node_modules/swiper/js/swiper.min.js',
                            'node_modules/flatpickr/dist/flatpickr.min.js',
                            'node_modules/flatpickr/dist/l10n/ru.js',
                            'node_modules/flatpickr/dist/l10n/uk.js',
                            'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js',
                            'node_modules/wowjs/dist/wow.min.js',
                            'node_modules/inputmask/dist/inputmask.min.js',
                            'node_modules/slim-select/dist/slimselect.min.js',
                            'node_modules/scrollreveal/dist/scrollreveal.min.js',
                            'node_modules/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
                            'node_modules/hc-offcanvas-nav/dist/hc-offcanvas-nav.js']
        )
            .pipe(concat('libs.min.js'))
            .pipe($.gulp.dest(scriptsPATH.output));
    });

    $.gulp.task('libsJS:build', () => {
        return $.gulp.src([
            scriptsPATH.input + 'polifil-js.js',
            'node_modules/svg4everybody/dist/svg4everybody.min.js',
            'node_modules/swiper/js/swiper.min.js',
            'node_modules/flatpickr/dist/flatpickr.min.js',
            'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js',
            'node_modules/wowjs/dist/wow.min.js',
            'node_modules/inputmask/dist/inputmask.min.js',
            'node_modules/slim-select/dist/slimselect.min.js',
            'node_modules/scrollreveal/dist/scrollreveal.min.js',
            'node_modules/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
            'node_modules/hc-offcanvas-nav/dist/hc-offcanvas-nav.js']
        )
            .pipe(concat('libs.min.js'))
            .pipe(uglify())
            .pipe($.gulp.dest(scriptsPATH.output));
    });

    $.gulp.task('js:dev', () => {
        // return $.gulp.src(
        //     [scriptsPATH.input + '*.js',
        //     '!' + scriptsPATH.input + 'libs.min.js',
        //     '!' + scriptsPATH.input + 'scripts.min.js'
        //     ],
        // )
        return $.gulp.src(
            [
                scriptsPATH.input + 'init-plugins.js',
                scriptsPATH.input + 'main.js',
                scriptsPATH.input + 'dev.js',
                scriptsPATH.input + 'comments.js',
                scriptsPATH.input + 'filter-ajax.js',
                scriptsPATH.input + 'poll.js',
                '!' + scriptsPATH.input + 'libs.min.js',
                '!' + scriptsPATH.input + 'schedule-single-doctor.js',
                '!' + scriptsPATH.input + 'schedule-page-list.js',
                '!' + scriptsPATH.input + 'schedule-single-doctor.js'
            ],
        )
            .pipe(sourcemaps.init())
            .pipe(concat('scripts.min.js'))
            .pipe(uglify({ output: { comments: false } }))
            .pipe(sourcemaps.write('.'))
            .pipe($.gulp.dest(scriptsPATH.output))
            .pipe(filesize())
            .pipe($.browserSync.reload({
                stream: true
            }));
    });

    $.gulp.task('js:build', () => {
        return $.gulp.src([scriptsPATH.input + '*.js',
            '!' + scriptsPATH.input + 'libs.min.js'])
            .pipe(babel({
                presets: ['@babel/env']
            }))
            .pipe($.gulp.dest(scriptsPATH.output));
    });

    $.gulp.task('js:build-min', () => {
        return $.gulp.src([scriptsPATH.input + '*.js',
            '!' + scriptsPATH.input + 'libs.min.js'])
            .pipe(concat('main.min.js'))
            .pipe(uglify())
            .pipe($.gulp.dest(scriptsPATH.output));
    });
};
