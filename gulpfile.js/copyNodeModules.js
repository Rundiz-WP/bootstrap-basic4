/**
 * Copy files from **node_modules** to **assets** folders.
 */


'use strict';


const {dest, parallel, series, src} = require('gulp');
const print = require('gulp-print').default;


/**
 * Copy Bootstrap CSS & JS files and including license.
 */
function copyBootstrap4(cb) {
    const rename = require('gulp-rename');
    const mergeStream =   require('merge-stream');

    return mergeStream(
        src('node_modules/bootstrap/dist/**')
            .pipe(print())
            .pipe(dest('assets/')),
        src('node_modules/bootstrap/LICENSE')
            .pipe(print())
            .pipe(rename('bootstrap-license.txt'))
            .pipe(dest('assets/')),
    );
}// copyBootstrap4


/**
 * Copy FontAwesome.
 */
function copyFontAwesome(cb) {
    const rename = require('gulp-rename');
    const mergeStream =   require('merge-stream');

    // node_modules/@fortawesome/fontawesome-free/
    return mergeStream(
        src('node_modules/@fortawesome/fontawesome-free/css/**')
            .pipe(print())
            .pipe(dest('assets/fontawesome/css/')),
        src('node_modules/@fortawesome/fontawesome-free/js/**')
            .pipe(print())
            .pipe(dest('assets/fontawesome/js/')),
        src('node_modules/@fortawesome/fontawesome-free/sprites/**')
            .pipe(print())
            .pipe(dest('assets/fontawesome/sprites/')),
        src('node_modules/@fortawesome/fontawesome-free/svgs/**')
            .pipe(print())
            .pipe(dest('assets/fontawesome/svgs/')),
        src('node_modules/@fortawesome/fontawesome-free/webfonts/**')
            .pipe(print())
            .pipe(dest('assets/fontawesome/webfonts/')),
        src('node_modules/@fortawesome/fontawesome-free/LICENSE.txt')
            .pipe(print())
            .pipe(dest('assets/fontawesome/')),
    );
}// copyFontAwesome


exports.copyNodeModules = series(
    parallel(
        copyBootstrap4,
        copyFontAwesome
    )
);