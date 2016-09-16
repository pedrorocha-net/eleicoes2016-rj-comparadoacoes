gulp = require 'gulp'

$ = require('gulp-load-plugins')({
  pattern: ['gulp-*', 'run-sequence']
});

sources =
  scss: 'src/assets/scss/**/*.scss'
  coffee: 'src/assets/coffee/**/*.coffee'
  html: 'src/assets/coffee/**/*.html'

destinations =
  css: 'dist/assets/css'
  js: 'dist/assets/js'


###
  Compile SASS files
###
gulp.task 'style', ->
  gulp.src(sources.scss)
  .pipe($.sass({compass: true, style: 'expanded'}))
  .on('error', $.sass.logError)
  .pipe(gulp.dest(destinations.css))


###
  Run Coffee files through Coffee Lint
###
gulp.task 'lint', ->
  gulp.src(sources.coffee)
  .pipe($.coffeelint())
  .pipe($.coffeelint.reporter())


###
  Compile Coffeescript files
###
gulp.task 'coffee', ->
  gulp.src(sources.coffee)
  .pipe($.plumber())
  .pipe($.coffee({bare: true}))
  .pipe($.concat('app.js'))
  .pipe(gulp.dest(destinations.js))


###
  Convert HTML partials to angularTemplateCache JS files
###
gulp.task 'partials', () ->
  gulp.src(sources.html)
  .pipe($.angularTemplatecache(
    "standalone": true
    "root": '/assets/js'
  ))
  .pipe(gulp.dest(destinations.js))


###
  Copy index HTML file on changes
###
gulp.task 'watch-index-html', () ->
  gulp.src('src/index.html')
  .pipe(gulp.dest('dist'))


###
  Keep watching files for changes to update them automatically
###
gulp.task 'watch', ->
  gulp.watch sources.scss, ['style']
  gulp.watch sources.coffee, ['lint', 'coffee']
  gulp.watch sources.html, ['partials']
  gulp.watch 'src/index.html', ['watch-index-html']


###
  Run tasks to deploy new version
###
gulp.task 'build', [
  'style',
  'coffee',
  'partials',
  'watch-index-html'
]


gulp.task 'deploy', () ->
  gulp.src('./dist/**/*')
  .pipe($.ghPages())

###
  Default command to run when calling just "gulp"
###
gulp.task 'default', ['watch']