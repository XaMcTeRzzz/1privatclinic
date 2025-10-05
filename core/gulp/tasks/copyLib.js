module.exports = function () {
    $.gulp.task('copyLib', () => {
        return $.gulp.src('./dev/static/lib/**/*.*')
            .pipe($.gulp.dest('./build/static/lib'));
    });
};