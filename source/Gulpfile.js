const fs = require('fs');
const request = require('request');
const prefix = require('gulp-autoprefixer');
const { src, dest, parallel, watch, series, task } = require('gulp');
const concat = require('gulp-concat');
const babel = require('gulp-babel');
const terser = require('gulp-terser');
const minify = require('gulp-clean-css');
const rename = require('gulp-rename');
const order = require('gulp-order');
const sass = require('gulp-sass')(require('sass'));
const sassGlob = require('gulp-sass-glob');
const sourcemaps = require('gulp-sourcemaps');

// Assets
const fontsInput = './webfonts/*.*';
const fontsOutput = '../assets/webfonts';
const imagesInput = './img/*.*';
const imagesOutput = '../assets/img';

// Styles
const cssInput = './scss/style.scss';
const cssOutput = '../assets/css';
const adminCssInput = './admin/style.css';
const adminCssOutput = '../assets/admin';

// Scripts
const jsTableInput = './js/tinymce/table.min.js';
const jsPluginInput = './js/tinymce/strl-buttons.js';
const jsVendorInput = './js/vendor/*.*';
const jsNoCacheInput = './js/nocache/*.*';
const jsNoCacheOutput = '../assets/js/nocache';
const jsBackendInput = './js/backend/*.js';
const jsInput = ['./js/*.*', '../blocks*/**/*.js'];
const jsOutput = '../assets/js';

const sassOptions = {
	errLogToConsole: true,
	outputStyle: 'expanded'
};

const autoprefixerOptions = {};

function scssAdmin() {
	return src(adminCssInput)
		.pipe(rename('admin-style.min.css'))
		.pipe(sourcemaps.write('/'))
		.pipe(dest(adminCssOutput));
}

function scss() {
	let datestamp = Date.now();

	fs.readdir(cssOutput, (error, files) => {
		if (!error) {
			for (var i = 0, len = files.length; i < len; i++) {
				if (!files[i].match('style.min.css')) {
					fs.unlink(cssOutput + '/' + files[i], function () { });
				}
			}
		}
	});

	return src(cssInput)
		.pipe(sassGlob())
		.pipe(sourcemaps.init())
		.pipe(sass(sassOptions).on('error', sass.logError))
		.pipe(minify())
		.pipe(prefix())
		.pipe(rename('style.min.css'))
		.pipe(dest(cssOutput))
		.pipe(rename('style-' + datestamp + '.css'))
		.pipe(sourcemaps.write('/'))
		.pipe(dest(cssOutput));
}

function js() {
	let datestamp = Date.now();
	const regex = /scripts-[0-9]+.js/g;

	fs.readdir(jsOutput, (error, files) => {
		if (!error) {
			for (var i = 0, len = files.length; i < len; i++) {
				if (files[i].match(regex)) {
					fs.unlink(jsOutput + '/' + files[i], function () { });
				}
			}
		}
	});

	return src(jsInput)
		.pipe(concat('scripts.min.js'))
		.pipe(babel())
		.pipe(terser())
		.pipe(dest(jsOutput))
		.pipe(rename('scripts-' + datestamp + '.js'))
		.pipe(dest(jsOutput));
}

function jsnocache() {
	return src( jsNoCacheInput )
		.pipe(order([
			'*.*'
		]))
		.pipe( concat( 'nocache.min.js' ) )
		.pipe( terser() )
		.pipe( dest( jsNoCacheOutput ) );
}

function jsStrlButtons() {
	return src(jsPluginInput)
		.pipe(concat('strl-buttons.min.js'))
		.pipe(babel())
		.pipe(terser())
		.pipe(dest(jsOutput));
}

function jsbackend() {
	return src(jsBackendInput)
		.pipe(concat('backend.min.js'))
		.pipe(babel())
		.pipe(terser())
		.pipe(dest(jsOutput));
}

function jstable() {
	return src(jsTableInput)
		.pipe(rename('table.min.js'))
		.pipe(terser())
		.pipe(dest(jsOutput));
}

function jsvendor() {
	return src(jsVendorInput)
		.pipe(order([
			'__jquery.3.5.0.min.js',
			'featherlight.js',
			'featherlight.gallery.js',
			'jquery.waypoints.min.js',
			'*.*'
		]))
		.pipe(concat('vendor.min.js'))
		.pipe(terser())
		.pipe(dest(jsOutput));
}

function images() {
	return src(imagesInput)
		.pipe(dest(imagesOutput));
}

function fonts() {
	return src(fontsInput)
		.pipe(dest(fontsOutput));
}

exports.scssAdmin = scssAdmin;
exports.scss = scss;
exports.fonts = fonts;
exports.js = js;
exports.jsplugin = jsStrlButtons;
exports.jsbackend = jsbackend;
exports.jstable = jstable;
exports.jsvendor = jsvendor;
exports.jsnocache = jsnocache;
exports.images = images;
exports["b-default"] = parallel(scss, fonts, js, jsnocache, jsStrlButtons, jsbackend, jstable, jsvendor, images);
exports["a-watch"] = function () {
	watch(imagesInput, function (file) {
		if (file.event === 'unlink') {
			fs.unlink(file.path.replace('/source/', '/assets/'));
			series(task('images'))();
		} else {
			series(task('images'))();
		}
		return Promise.resolve();
	});

	watch(jsTableInput, function (file) {
		if (file.event === 'unlink') {
			fs.unlink(file.path.replace('/source/', '/assets/'));
			series(task('table'))();
		} else {
			series(task('table'))();
		}
		return Promise.resolve();
	});

	watch(jsVendorInput, function (file) {
		if (file.event === 'unlink') {
			fs.unlink(jsVendorOutput + '/vendor.min.js');
			series(task('jsvendor'))();
		} else {
			series(task('jsvendor'))();
		}
		return Promise.resolve();
	});

	watch( jsNoCacheInput, file => {
		if ( file.event === 'unlink' ) {
			fs.unlink( jsOutput + '/nocache.min.js' );
			series(task( 'jsnocache' ))();
		} else {
			series(task( 'jsnocache' ))();
		}
		return Promise.resolve('Done');
	});

	watch(jsBackendInput, function (file) {
		if (file.event === 'unlink') {
			fs.unlink(jsBackendOutput + '/backend.min.js');
			series(task('jsbackend'))();
		} else {
			series(task('jsbackend'))();
		}
		return Promise.resolve();
	});

	watch(jsPluginInput, function (file) {
		if (file.event === 'unlink') {
			fs.unlink(jsPluginOutput + '/plugin.min.js');
			series(task('jsplugin'))();
		} else {
			series(task('jsplugin'))();
		}
		return Promise.resolve();
	});

	watch(jsInput, function (file) {
		if (file.event === 'unlink') {
			fs.unlink(jsOutput + '/scripts.min.js');
			series(task('js'))();
		} else {
			series(task('js'))();
		}
		return Promise.resolve();
	});

	watch('./scss/**/*.*', function (file) {
		if (file.event === 'unlink') {
			fs.unlink(cssOutput + '/style.min.css', () => console.log(file.path + ' deleted'));
			series(task('scss'))();
		} else {
			series(task('scss'), task('flushcache'))();
		}
		return Promise.resolve();
	});

	watch('./../blocks*/**/*.scss', function (file) {
		if (file.event === 'unlink') {
			fs.unlink(cssOutput + '/style.min.css', () => console.log(file.path + ' deleted'));
			series(task('scss'))();
		} else {
			series(task('scss'), task('flushcache'))();
		}
		return Promise.resolve();
	});

	watch(fontsInput, function (file) {
		if (file.event === 'unlink') {
			fs.unlink(file.path.replace('/source/', '/assets/'));
			series(task('fonts'))();
		} else {
			series(task('fonts'))();
		}
		return Promise.resolve();
	});
};
