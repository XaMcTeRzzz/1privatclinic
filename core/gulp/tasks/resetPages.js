let panini = require('core/gulp/tasks/panini');

module.exports = function () {
    $.gulp.task('resetPages', (done) => {
            panini.refresh();
            done();
    });
};
