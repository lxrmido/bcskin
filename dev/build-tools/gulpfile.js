var gulp  = require('gulp');
var csso  = require('gulp-csso');
var less  = require('gulp-less');

gulp.task('less', function(){
	gulp.src('../../static/**/less/*.less')
		.pipe(less())
		.pipe(csso())
		.pipe(gulp.dest('../../static/'));
});

gulp.task('watch', function(){
	gulp.watch('../../static/**/less/*.less', ['less']);
});