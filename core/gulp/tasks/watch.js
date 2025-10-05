module.exports = function () {
    $.gulp.task('watch', function () {
        $.gulp.watch('../**/*.php');
        $.gulp.watch('./scss/**/*.scss', $.gulp.series('styles:dev'));
        $.gulp.watch('./js/**/*.js', $.gulp.series('js:dev'));
    });
};