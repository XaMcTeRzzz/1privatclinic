module.exports = function() {
    $.gulp.task('serve', function() {
        $.browserSync.init({
            proxy: "medzdrav-new.loc",
            notify: false,
            port: 8080
        });
    });
};
