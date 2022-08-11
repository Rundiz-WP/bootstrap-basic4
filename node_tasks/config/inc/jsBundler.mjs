/**
 * Copy, minify, create source map for JS.
 */


'use strict';


// import this app's useful class.
import FS from "../../Libraries/FS.mjs";
import Concat from "../../Libraries/Concat.mjs";
import MinJS from '../../Libraries/MinJS.mjs';


export default class JsBundler {


    /**
     * Run bundler/minifier
     * 
     * @param {Object} Object Accept object.
     * @param {string} Object.sourcePath Full source path.
     * @param {string} Object.destPath Full destination path.
     * @param {string} Object.relativeName Relative source file name from the source pattern. Example: 'assets/js-src/rdta'
     * @param {string} Object.headerString Header string.
     * @param {string} Object.destJSFolder Destination folder. Related from repository's folder.
     * @param {boolean} Object.echoOut Write out result or not. Set to `true` to write it out (default is true), `false` to not write out.
     * @returns {Promise} Return Promise object.
     */
    static async run({sourcePath, destPath, relativeName, headerString, destJSFolder, echoOut = true} = {}) {
        // copy file to destination.
        FS.copyFileDir(
            sourcePath,
            destPath
        );
        if (echoOut === true) {
            console.log('    Copied js to: ' + destPath);
        }
        
        // apply header to file.
        const concat = new Concat({
            sourceFiles: destPath,
            options: {
                sourceMap: false,
            }
        });
        await concat.concat(relativeName);
        await concat.header(headerString);
        await concat.writeFile(destJSFolder);

        // then minify the destination.
        const minJS = new MinJS({
            sourceFiles: destPath,
            options: {
                format: {
                    comments: 'some',
                },
                sourceMap: true,
            }
        });
        await minJS.minify(relativeName.replace('.js', '.min.js'));
        await minJS.writeFile(destJSFolder)
        .then((result) => {
            if (echoOut === true) {
                console.log('    Minified js: ' + result.file);
                if (result.sourceMap) {
                    console.log('    Minified js source map: ' + result.sourceMap);
                }
            }
            return Promise.resolve();
        });

        return Promise.resolve();
    }// run


}