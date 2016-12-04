/* = gulp.js plugins
 * =========================================================== */
var fs = require('fs');
var gulp = require('gulp');
var concat = require('gulp-concat');
var cleanCSS = require('gulp-clean-css');
var replace = require('gulp-replace');
var header = require('gulp-header');
var uglify = require('gulp-uglify');
var md5File = require('md5-file');


/* = Global vars
 * =========================================================== */
var assets = JSON.parse(fs.readFileSync('./assets.json'));
var webroot = './webroot';

/* = Functions
 * =========================================================== */
var getBanner = function (filename, dir) {
    var md5 = md5File.sync(dir + filename);

    return [
        '/**',
        ' * ' + filename,
        ' * ==========',
        ' *',
        ' * by Mathieu Bour',
        ' *',
        ' * Build md5: ' + md5,
        ' */',
        ''
    ].join('\n');
};

var getFiles = function (mode, type) {
    var files = [];
    for (var i in assets[mode][type]) {
        var path = assets[mode][type][i];
        files.push(webroot + path);
    }
    return files;
};

/* = Tasks
 * =========================================================== */
// Move fonts
gulp.task('fonts', function () {
    var publicFonts = assets['public']['fonts'];

    for (var src in publicFonts) {
        gulp.src(webroot + src).pipe(gulp.dest(webroot + publicFonts[src]))
    }
});

// Create public.css
gulp.task('css_public_content', function () {
    var piped = gulp.src(getFiles('public', 'css'))
        .pipe(concat('public.css'))
        .pipe(cleanCSS({
            keepSpecialComments: 0,
            compatibility: 'ie8'
        }));

    for (var searchStr in assets['public']['css_replace']) {
        var replaceStr = assets['public']['css_replace'][searchStr];
        piped = piped.pipe(replace(searchStr, replaceStr));
    }
    return piped.pipe(gulp.dest(webroot + '/css/'));
});
gulp.task('css_public', ['css_public_content'], function () {
    return gulp.src('webroot/css/public.css')
        .pipe(header(getBanner('public.css', webroot + '/css/')))
        .pipe(gulp.dest(webroot + '/css/'));
});

// Create public.js
gulp.task('js_public_content', function () {
    return gulp.src(getFiles('public', 'js'))
        .pipe(concat('public.js'))
        .pipe(uglify())
        .pipe(gulp.dest(webroot + '/js/'))
});
gulp.task('js_public', ['js_public_content'], function () {
    return gulp.src(webroot + '/js/public.js')
        .pipe(header(getBanner('public.js', webroot + '/js/')))
        .pipe(gulp.dest(webroot + '/js/'));
});

// Create admin.css
gulp.task('css_admin_content', function () {
    var piped = gulp.src(getFiles('admin', 'css'))
        .pipe(concat('admin.css'))
        .pipe(cleanCSS({
            keepSpecialComments: 0,
            compatibility: 'ie8'
        }));

    for (var searchStr in assets['admin']['css_replace']) {
        var replaceStr = assets['admin']['css_replace'][searchStr];
        piped = piped.pipe(replace(searchStr, replaceStr));
    }
    return piped.pipe(gulp.dest(webroot + '/css/'));
});
gulp.task('css_admin', ['css_admin_content'], function () {
    return gulp.src('webroot/css/admin.css')
        .pipe(header(getBanner('admin.css', webroot + '/css/')))
        .pipe(gulp.dest(webroot + '/css/'));
});

// Create admin.js
gulp.task('js_admin_content', function () {
    return gulp.src(getFiles('admin', 'js'))
        .pipe(concat('admin.js'))
        .pipe(uglify())
        .pipe(gulp.dest(webroot + '/js/'))
});
gulp.task('js_admin', ['js_admin_content'], function () {
    return gulp.src(webroot + '/js/admin.js')
        .pipe(header(getBanner('admin.js', webroot + '/js/')))
        .pipe(gulp.dest(webroot + '/js/'));
});

// Create ticket.css
gulp.task('css_ticket_content', function () {
    var piped = gulp.src(getFiles('ticket', 'css'))
        .pipe(concat('ticket.css'))
        .pipe(cleanCSS({
            keepSpecialComments: 0,
            compatibility: 'ie8'
        }));

    for (var searchStr in assets['ticket']['css_replace']) {
        var replaceStr = assets['ticket']['css_replace'][searchStr];
        piped = piped.pipe(replace(searchStr, replaceStr));
    }
    return piped.pipe(gulp.dest(webroot + '/css/'));
});
gulp.task('css_ticket', ['css_ticket_content'], function () {
    return gulp.src('webroot/css/ticket.css')
        .pipe(header(getBanner('ticket.css', webroot + '/css/')))
        .pipe(gulp.dest(webroot + '/css/'));
});

gulp.task('watch', ['css_public', 'js_public', 'css_admin', 'js_admin', 'css_ticket'], function () {
    // Public
    gulp.watch('webroot/css/public/*.css', ['css_public']);
    gulp.watch('webroot/js/public/*.js', ['js_public']);

    // Admin
    gulp.watch('webroot/css/admin/*.css', ['css_admin']);
    gulp.watch('webroot/js/admin/*.js', ['js_admin']);

    // Ticket
    gulp.watch('webroot/css/pdf/ticket.css', ['css_ticket']);

    // Common
    gulp.watch('webroot/css/common/*.css', ['css_public', 'css_admin']);
    gulp.watch('webroot/js/common/*.js', ['js_public', 'js_admin']);
});