/**
 * Main Gulp file (gulefile.js).
 */


'use strict';


const {series} = require('gulp');
const copyNodeModules = require('./copyNodeModules');
const versionWriter = require('./versionWriter');
const editing = require('./editing');


/**
 * Cleanup Bootstrap files.
 */
async function clean(cb) {
    const del = require('del');

    // delete CSS files.
    await del(['assets/css/bootstrap-*.*']);
    await del(['assets/css/bootstrap.css*']);
    await del(['assets/css/bootstrap.min.css*']);

    // delete JS files.
    await del(['assets/js/bootstrap.bundle*']);
    await del(['assets/js/bootstrap.js*']);
    await del(['assets/js/bootstrap.min.js*']);

    // delete fontawesome
    await del(['assets/fontawesome/']);

    return await Promise.all([prepareDirs(cb)]);
}// clean


/**
 * Prepare folders.
 */
function prepareDirs(cb) {
    const fs = require('fs');
    const folders = [
        '.backup',
        'assets/fontawesome',
    ];

    folders.forEach(dir => {
        if(!fs.existsSync(dir)) {
            fs.mkdirSync(dir);  
        }   
    });

    cb();
}// prepareDirs


exports.default = series(
    clean,
    copyNodeModules.copyNodeModules,
);


exports.writeVersions = series(
    versionWriter.writeVersions
);


exports.editing = series(
    editing.copyAllFiles,
    editing.watch
);