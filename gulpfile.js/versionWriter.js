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
 * Backup file before start write versions.
 * 
 * @param {type} cb
 * @returns {unresolved}
 */
function backup(cb) {
    let date = new Date();
    let timeStampInMs = date.getFullYear() + ('0' + (date.getMonth() + 1)).slice(-2) + ('0' + date.getDate()).slice(-2)
        + '_' + ('0' + date.getHours()).slice(-2) + ('0' + date.getMinutes()).slice(-2) + ('0' + date.getSeconds()).slice(-2)
        + '_' + date.getMilliseconds();

    return src('./inc/classes/BootstrapBasic4.php')
        .pipe(rename('BootstrapBasic4.backup' + timeStampInMs + '.php'))
        .pipe(dest('.backup/inc/classes/'));
}// backup


/**
 * Get regular expression pattern.
 * 
 * @param {string} handleName
 * @returns {string}
 */
function getRegexPattern(handleName) {
    return '([\'"]' + handleName + '[\'"])'// group1, [quote or double quote]handleName[quote or double quote]
        + '(\\s*,\\s*'// start group2 space*,space*
            + '[\\w\\(\\)\\.\\s\\\/\']*\\s*,\\s*'// [asset URL.]space*,space*
            + '[\\w\\(\\)\\.\\s\\\/\']*\\s*,\\s*'// [dependency array]space*,space*
        + '[\'"])'// end group2 [quote or double quote]
        + '([\\d\\w\\(\\)\\.\\-]+)'// group 3 version number
        + '([\'"])'// group 4 [quote or double quote]
        ;
}// getRegexPattern


/**
 * Get this theme version number from style.css.
 * 
 * @return {String}
 */
function getThemeVersion() {
    let styleCss = fs.readFileSync('./style.css', {'encoding': 'utf-8'});
    let versionRegexp = styleCss.match(/(?<version>version)\s?:(\s)?(?<versionNumber>.+)/i);
    let versionNumber = (typeof(versionRegexp.groups) !== 'undefined' && typeof(versionRegexp.groups.versionNumber) !== 'undefined' ? versionRegexp.groups.versionNumber : undefined);
    styleCss = undefined;

    return versionNumber;
}// getThemeVersion


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

    let tasks = [];
    tasks[0] = src('./inc/classes/BootstrapBasic4.php');

    // write packages version. ------------------------------------------------
    if (typeof(bootstrapVersion) !== 'undefined' || typeof(fontawesomeVersion) !== 'undefined') {
        if (typeof(bootstrapVersion) !== 'undefined') {
            bootstrapVersion = bootstrapVersion.replace(/['\^\~\@']/g, '');
            console.log('writing bootstrap version ' + bootstrapVersion);

            let regExp = new RegExp(getRegexPattern('bootstrap4'), 'gi');
            console.log(regExp);
            tasks[0].pipe(replace(regExp, '$1$2' + bootstrapVersion + '$4'));

            let regExp2 = new RegExp(getRegexPattern('bootstrap4\-bundle'), 'gi');
            console.log(regExp2);
            tasks[0].pipe(replace(regExp2, '$1$2' + bootstrapVersion + '$4'));
        }

        if (typeof(fontawesomeVersion) !== 'undefined') {
            fontawesomeVersion = fontawesomeVersion.replace(/['\^\~\@']/g, '');
            console.log('writing font awesome version ' + fontawesomeVersion);

            let regExp = new RegExp(getRegexPattern('bootstrap\-basic4\-font-awesome5'), 'gi');
            console.log(regExp);
            tasks[0].pipe(replace(regExp, '$1$2' + fontawesomeVersion + '$4'));
        }
    }
    // end write packages version. -------------------------------------------

    // write theme version. ----------------------------------------------------
    let themeVersion = getThemeVersion();
    if (themeVersion && typeof(themeVersion) !== 'undefined') {
        console.log('writing theme version ' + themeVersion);
        let regExp = new RegExp(getRegexPattern('bootstrap\-basic4\-wp\-main'), 'gi');
        console.log(regExp);
        tasks[0].pipe(replace(regExp, '$1$2' + themeVersion + '$4'));

        let regExp2 = new RegExp(getRegexPattern('bootstrap\-basic4\-main'), 'gi');
        console.log(regExp2);
        tasks[0].pipe(replace(regExp2, '$1$2' + themeVersion + '$4'));
    }
    // end write theme version. -----------------------------------------------

    tasks[0].pipe(dest('./inc/classes'));

    return mergeStream(tasks);
}// writePackagesVersion


exports.writeVersions = series(
    prepareDirs,
    backup,
    writePackagesVersion
);