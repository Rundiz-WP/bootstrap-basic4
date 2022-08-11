/**
 * Minify CSS.
 */


'use strict';


import CleanCSS from "clean-css";
import fs from 'node:fs';
import fsPromise from 'node:fs/promises';
import path from 'node:path';
// import class that extends from.
import BasedBundler from './BasedBundler.mjs';


export default class MinCSS extends BasedBundler {


    /**
     * @type {boolean} Mark as run `minify()` or not. Result will be `true` if it is already runned.
     */
    #minified = false;


    /**
     * @type {Object} Clean-css options. See https://www.npmjs.com/package/clean-css
     */
    options = {};

    
    /**
     * @type {string[]} The source files array.
     */
    sourceFiles = [];


    /**
     * Class constructor.
     * 
     * @link https://www.npmjs.com/package/clean-css This class is depend on clean-css package.
     * @param {Object} Object Accept arguments
     * @param {string|string[]} Object.sourceFiles The source files. Relative from this repository folder.
     * @param {CleanCSS.Options} Object.options Accept options
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
            level: {
                1: {
                    specialComments: 0
                }
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
     * Minify CSS file.
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
                sourceFilesObj[sourceFile] = {
                    styles: sourceContent.toString(),
                };
                let inputSourcemap = '';
                if (fs.existsSync(sourceFullPath + '.map')) {
                    inputSourcemap = JSON.parse(await fsPromise.readFile(sourceFullPath + '.map'));
                    sourceFilesObj[sourceFile]['sourceMap'] = inputSourcemap;// set to `sourceMap` property.
                }
            }
        }// endfor;

        const cleanCss = new CleanCSS(this.options);
        const MinifyObj = cleanCss.minify(sourceFilesObj);

        this._content = new Buffer.from(MinifyObj.styles);
        this._sourceMapContent = (MinifyObj?.sourceMap ? MinifyObj.sourceMap.toString() : '');
        this._processed = true;
    }// minify


}