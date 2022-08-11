/**
 * Minify JS.
 */


'use strict';


import {Buffer} from 'node:buffer';
import fs from 'node:fs';
import fsPromise from 'node:fs/promises';
import {minify} from 'terser';
import path from 'node:path';
// import this app's useful class.
import TextStyles from './TextStyles.mjs';
// import class that extends from.
import BasedBundler from './BasedBundler.mjs';


export default class MinifyJS extends BasedBundler {


    /**
     * @type {Object} Terser options. See https://www.npmjs.com/package/terser#user-content-minify-options
     */
    options = {};

    
    /**
     * @type {string[]} The source files array.
     */
    sourceFiles = [];


    /**
     * Class constructor.
     * 
     * @link https://www.npmjs.com/package/terser This class is depend on terser package.
     * @param {Object} Object Accept arguments
     * @param {string|string[]} Object.sourceFiles The source files. Relative from this repository folder.
     * @param {Object} Object.options Terser options. See https://www.npmjs.com/package/terser#user-content-minify-options
     * @param {boolean|*} Object.sourceMap Source map options.
     */
    constructor({sourceFiles, options = {}} = {}) {
        super();

        if (sourceFiles) {
            if (!Array.isArray(sourceFiles)) {
                sourceFiles = [sourceFiles];
            }
            this.sourceFiles = sourceFiles;
        } else {
            throw new Error('The `sourceFiles` argument is required.');
        }

        const defaults = {
            format: {
                comments: false,
            },
            sourceMap: false,
        };
        if (typeof(options) === 'object') {
            this.options = {
                ...defaults,
                ...options
            };
        }
    }// constructor


    /**
     * Minify JS file.
     * 
     * @async This method is asynchronous, it must call with `await` to hold processed and then go to next method.
     * @param {string} destinationFile The destination file name only, no path.
     * @return {Promise} Return Promise object with full path to destination file.
     */
    async minify(destinationFile) {
        if (typeof(destinationFile) !== 'string') {
            throw new Error('The argument `destinationFile` must be string.');
        }

        if (typeof(destinationFile) === 'string') {
            this._destinationFile = destinationFile;
        }

        // sequence loop to set file's contents to object by order.
        let sourceFilesObj = {};
        for (const sourceFile of this.sourceFiles) {
            const sourceFullPath = path.resolve(REPO_DIR, sourceFile);
            if (!fs.existsSync(sourceFullPath)) {
                console.warn('    ' + TextStyles.txtWarning('Warning: ' + sourceFullPath + ' is not found.'));
            } else {
                let sourceContent = await fsPromise.readFile(sourceFullPath);
                sourceFilesObj[sourceFile] = sourceContent.toString();
            }
        }

        const MinifyObj = await minify(sourceFilesObj, this.options);

        this._content = new Buffer.from(MinifyObj.code);
        this._sourceMapContent = (MinifyObj?.map ? MinifyObj.map.toString() : '');
        this._processed = true;
    }// minify


}