/**
 * Work on watch editing files.
 */


'use strict';


const {dest, series, src, watch} = require('gulp');


/**
 * Cleanup target folder.
 */
async function EditingCleanTarget(cb) {
    const path = require('path');
    const del = require('del');

    let targetPath = getEditingPathArg();
    let copyAll = getEditingCopyAllArg();

    if (copyAll === true && targetPath !== false) {
        console.log('Clearing target ' + targetPath.replace(/[\\]/g, '/') + '/**');
        await del([targetPath.replace(/[\\]/g, '/') + '/**'], {force: true});
    } else {
        console.log('Skipping cleanup target folder.');
    }

    await Promise.resolve();
}// EditingCleanTarget


/**
 * Copy all theme files (PHP, CSS, JS, ...) to target path.
 */
function copyAllToTarget(cb) {
    let targetPath = getEditingPathArg();
    let copyAll = getEditingCopyAllArg();

    if (copyAll === true && targetPath !== false) {
        const mergeStream =   require('merge-stream');
        console.log('Copying all theme files to target.');

        return mergeStream(
            src([
                './*.css',
                './*.php',
                './*.png',
                './*.txt',
            ])
                .pipe(dest(targetPath + '/')),
            src('./assets/**')
                .pipe(dest(targetPath + '/assets')),
            src('./inc/**')
                .pipe(dest(targetPath + '/inc')),
            src('./languages/**')
                .pipe(dest(targetPath + '/languages')),
            src('./template-parts/**')
                .pipe(dest(targetPath + '/template-parts')),
        );
    } else {
        console.log('Skipping copy all theme files.');
    }

    cb();
}// copyAllToTarget


/**
 * Copy changed files.
 * 
 * @link https://stackoverflow.com/questions/30067942/how-to-copy-multiple-files-and-keep-the-folder-structure-with-gulp Copy multiple folders original source code.
 * @link https://stackoverflow.com/a/24010523/128761 Watch only changed files.
 */
function copyChanged(cb) {
    const print = require('gulp-print').default;
    const cache = require('gulp-cached');

    let targetPath = getEditingPathArg();

    if (targetPath !== false) {
        return src([
            './*.css',
            './*.php',
            './*.png',
            './*.txt',
            './assets/**/*.*',
            './inc/**/*.*',
            './languages/**/*.*',
            './template-parts/**/*.*'
        ], {base: './'})
            .pipe(cache('changedThemeFiles'))
            .pipe(print())
            .pipe(dest(targetPath + '/'));
    } else {
        const err = new Error('Unable to copy, the target path is not exists.');
        console.error(err.message);
        process.exit(1);
    }

    cb();
}// EditingCleanTarget


/**
 * Get editing `--copy-all` command option.
 * 
 * @returns bool Return `true` if argument specify, `false` for otherwise.
 */
function getEditingCopyAllArg() {
    const argv = require('yargs').argv;

    if (argv['copy-all'] === true) {
        return true;
    }

    return false;
}// getEditingCopyAllArg


/**
 * Get editing `--target xxx` command option.
 * 
 * @returns string|false Return path without trailing slash if exists, return `false` if not exists or not specify.
 */
function getEditingPathArg() {
    const argv = require('yargs').argv;
    const fs = require('fs');
    const path = require('path');

    if (typeof(argv.target) !== 'undefined' && (argv.target).trim() !== '') {
        let targetPath = (argv.target).trim();
        targetPath = path.normalize(targetPath);
        targetPath = targetPath.replace('*', '');// remove any glob * pattern.
        targetPath = targetPath.replace(/[\/\\]$/, '');// remove trailing slash.

        if (fs.existsSync(targetPath)) {
            return targetPath;
        }
    }

    return false;
}// getEditingPathArg


/**
 * Run copy all when there are command options `--target "xxx/xxx"` and `--copy-all`.
 */
exports.copyAllFiles = series(
    EditingCleanTarget,
    copyAllToTarget
);


exports.watch = function() {
    console.log('Start watching...');
    console.log('The files will be copied on the first run, after this it will be copy only changed files.');
    watch(
        [
            './*.css',
            './*.php',
            './*.png',
            './*.txt',
            './assets/**/*.*',
            './inc/**/*.*',
            './languages/**/*.*',
            './template-parts/**/*.*'
        ],
        {ignoreInitial: false},
        series(
            copyChanged
        )
    );
};