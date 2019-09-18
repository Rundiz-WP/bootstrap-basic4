/**
 * Version writer.
 * 
 * Write the updated packages version and theme version to the files.
 */


'use strict';


const {dest, series, src} = require('gulp');
const rename = require('gulp-rename');
const fs = require('fs');
const mergeStream =   require('merge-stream');


/**
 * Prepare folders for backup.
 */
function prepareDirs(cb) {
    const folders = [
        '.backup',
        '.backup/inc',
        '.backup/inc/classes',
    ];

    folders.forEach(dir => {
        if(!fs.existsSync(dir)) {
            fs.mkdirSync(dir);  
        }   
    });

    cb();
}// prepareDirs


/**
 * Write packages version to PHP file.
 */
function writePackagesVersion(cb) {
    const replace = require('gulp-replace');

    let packageJson = JSON.parse(fs.readFileSync('./package.json'));
    let packageDependencies = (typeof(packageJson.dependencies) !== 'undefined' ? packageJson.dependencies : {});
    let bootstrapVersion = packageDependencies.bootstrap;
    let fontawesomeVersion = packageDependencies['@fortawesome/fontawesome-free'];
    packageJson = undefined;

    if (typeof(bootstrapVersion) !== 'undefined' || typeof(fontawesomeVersion) !== 'undefined') {
        let tasks = [];

        // make backup
        let date = new Date();
        let timeStampInMs = date.getFullYear() + ('0' + (date.getMonth() + 1)).slice(-2) + ('0' + date.getDate()).slice(-2)
            + '_' + ('0' + date.getHours()).slice(-2) + ('0' + date.getMinutes()).slice(-2) + ('0' + date.getSeconds()).slice(-2)
            + '_' + date.getMilliseconds();
        tasks[0] = src('./inc/classes/BootstrapBasic4.php')
            .pipe(rename('BootstrapBasic4.beforeWritePackagesVersion' + timeStampInMs + '.php'))
            .pipe(dest('.backup/inc/classes/'));

        if (typeof(bootstrapVersion) !== 'undefined') {
            bootstrapVersion = bootstrapVersion.replace(/['\^\~\@']/g, '');
            tasks[1] = src('./inc/classes/BootstrapBasic4.php')
                .pipe(replace(/(['|"]bootstrap4['|"])(.+)(\d\.\d\.\d)/i, '$1$2' + bootstrapVersion))
                .pipe(replace(/(['|"]bootstrap4-bundle['|"])(.+)(\d\.\d\.\d)/i, '$1$2' + bootstrapVersion))
                .pipe(dest('./inc/classes/'));
        }

        if (typeof(fontawesomeVersion) !== 'undefined') {
            fontawesomeVersion = fontawesomeVersion.replace(/['\^\~\@']/g, '');
            tasks[2] = src('./inc/classes/BootstrapBasic4.php')
                .pipe(replace(/(['|"]bootstrap-basic4-font-awesome5['|"])(.+)(\d\.\d\.\d)/i, '$1$2' + fontawesomeVersion))
                .pipe(dest('./inc/classes/'));
        }

        return mergeStream(tasks);
    }

    packageDependencies = undefined;
    bootstrapVersion = undefined;
    fontawesomeVersion = undefined;

    cb();
}// writePackagesVersion


/**
 * Write theme version number to PHP file.
 */
function writeThemeVersion(cb) {
    const replace = require('gulp-replace');

    let styleCss = fs.readFileSync('./style.css', {'encoding': 'utf-8'});
    let versionRegexp = styleCss.match(/(?<version>version)\s?:(\s)?(?<versionNumber>.+)/i);
    let versionNumber = (typeof(versionRegexp.groups) !== 'undefined' && typeof(versionRegexp.groups.versionNumber) !== 'undefined' ? versionRegexp.groups.versionNumber : undefined);
    styleCss = undefined;

    if (typeof(versionNumber) != 'undefined') {
        let tasks = [];

        // make backup
        let date = new Date();
        let timeStampInMs = date.getFullYear() + ('0' + (date.getMonth() + 1)).slice(-2) + ('0' + date.getDate()).slice(-2)
            + '_' + ('0' + date.getHours()).slice(-2) + ('0' + date.getMinutes()).slice(-2) + ('0' + date.getSeconds()).slice(-2)
            + '_' + date.getMilliseconds();
        tasks[0] = src('./inc/classes/BootstrapBasic4.php')
            .pipe(rename('BootstrapBasic4.beforeWriteThemeVersion' + timeStampInMs + '.php'))
            .pipe(dest('.backup/inc/classes/'));

        tasks[1] = src('./inc/classes/BootstrapBasic4.php')
                .pipe(replace(/(['|"]bootstrap-basic4-wp-main['|"])(.+)(\d\.\d\.\d)/, '$1$2' + versionNumber))
                .pipe(replace(/(['|"]bootstrap-basic4-main['|"])(.+)(\d\.\d\.\d)/ig, '$1$2' + versionNumber))
                .pipe(dest('./inc/classes/'));

        return mergeStream(tasks);
    }

    versionRegexp = undefined;
    versionNumber = undefined;

    cb();
}// writeThemeVersion


exports.writeVersions = series(
    prepareDirs,
    writePackagesVersion,
    writeThemeVersion
);