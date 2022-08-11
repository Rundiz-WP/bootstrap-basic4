/**
 * Concatenating files (CSS, JS, text files).
 */


'use strict';


import {Buffer} from 'node:buffer';
import CleanCSS from "clean-css";
import ConcatSM from 'concat-with-sourcemaps';
import fs from 'node:fs';
import fsPromise from 'node:fs/promises';
import {minify as MinJS} from 'terser';
import path from 'node:path';
// import this app's useful class.
import TextStyles from './TextStyles.mjs';
// import class that extends from.
import BasedBundler from './BasedBundler.mjs';


/**
 * Concatenating class.
 * 
 * @link https://www.npmjs.com/package/concat-with-sourcemaps depend on concat-with-sourcemaps package.
 */
export default class Concat extends BasedBundler {


    /**
     * @type {string} The string that should separate files. Default is `'\n'`.
     */
    separator = '\n';

    
    /**
     * @type {string[]} The source files array.
     */
    sourceFiles = [];

    
    /**
     * @type {boolean} Generate source map if `true`, default is `false`.
     */
    sourceMap = false;


    /**
     * Class constructor.
     * 
     * @param {Object} Object Accept arguments
     * @param {string|string[]} Object.sourceFiles The source files. Relative from this repository folder.
     * @param {Object} Object.options The options.
     * @param {boolean} Object.options.sourceMap Generate source map if `true`. Default is `false`.
     * @param {string} Object.options.separator The string that should separate files. Default is `'\n'`.
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

        if (options.sourceMap && true === options.sourceMap) {
            this.sourceMap = options.sourceMap;
        }

        if (typeof(options.separator) === 'string') {
            this.separator = options.separator;
        }
    }// constructor


    /**
     * Clean or beautify CSS.
     * 
     * @link https://www.npmjs.com/package/clean-css This class is depend on clean-css package.
     * @param {CleanCSS.Options} options The `CleanCSS` (clean-css) options.
     */
    cleanCSS(options = {}) {
        if (typeof(options) !== 'object') {
            throw new Error('The argument `options` must be object.');
        }

        if (this._processed !== true) {
            throw new Error('Unable to call `cleanCSS()` without calling `concat()` method before.');
        }

        const defaults = {
            format: 'beautify',
            sourceMap: this.sourceMap,
        }
        options = {
            ...defaults,
            ...options,
        }

        let inputSourcemap = '';

        if (options.sourceMap === true) {
            inputSourcemap = JSON.parse(this._sourceMapContent);
        }

        const cleanCss = new CleanCSS(options);
        const output = cleanCss.minify(this._content.toString(), inputSourcemap);

        this._content = new Buffer.from(output.styles);
        if (this.sourceMap === true) {
            this._sourceMapContent = output.sourceMap.toString();
        }
    }// cleanCSS


    /**
     * Clean or beautify JS.
     * 
     * @link https://www.npmjs.com/package/terser This class is depend on terser package.
     * @param {Object} options Terser options. See https://www.npmjs.com/package/terser#user-content-minify-options
     */
    async cleanJS(options = {}) {
        if (typeof(options) !== 'object') {
            throw new Error('The argument `options` must be object.');
        }

        if (this._processed !== true) {
            throw new Error('Unable to call `cleanJS()` without calling `concat()` method before.');
        }

        let inputSourcemap = false;
        if (this.sourceMap === true) {
            inputSourcemap = {
                filename: this._destinationFile,// for set `"file": "dest.xx"` in .map file.
                content: this._sourceMapContent,
            };
        }

        const defaults = {
            compress: false,
            format: {
                braces: true,
                keep_numbers: true,
                keep_quoted_props: true,
                semicolons: true,
            },
            keep_classnames: true,
            keep_fnames: true,
            mangle: false,
            sourceMap: inputSourcemap,
        }
        options = {
            ...defaults,
            ...options,
        }

        const minJS = await MinJS(this._content.toString(), options);

        this._content = new Buffer.from(minJS.code);
        if (this.sourceMap === true) {
            this._sourceMapContent = (minJS?.map ? minJS.map.toString() : '');
        }
    }// cleanJS


    /**
     * Concatenating files.
     * 
     * @async This method is asynchronous, it must call with `await` to hold processed and then go to next method.
     * @param {string} destinationFile The destination file name only, no path.
     */
    async concat(destinationFile) {
        if (typeof(destinationFile) !== 'string') {
            throw new Error('The argument `destinaitonFIle` must be string.');
        }

        if (typeof(destinationFile) === 'string') {
            this._destinationFile = destinationFile;
        }

        const ConcatObj = new ConcatSM(this.sourceMap, destinationFile, this.separator);

        // sequence loop to add files by order.
        for (const sourceFile of this.sourceFiles) {
            const sourceFullPath = path.resolve(REPO_DIR, sourceFile);
            if (!fs.existsSync(sourceFullPath)) {
                console.warn('    ' + TextStyles.txtWarning('Warning: ' + sourceFullPath + ' is not found.'));
            } else {
                const sourceContent = await fsPromise.readFile(sourceFullPath);
                let inputSourcemap = undefined;
                if (this.sourceMap === true && fs.existsSync(sourceFullPath + '.map')) {
                    inputSourcemap = JSON.parse(await fsPromise.readFile(sourceFullPath + '.map'));
                }
                ConcatObj.add(sourceFile, sourceContent, inputSourcemap);
            }
        }// endfor;

        this._content = ConcatObj.content;
        this._sourceMapContent = ConcatObj.sourceMap;
        this._processed = true;
    }// concat
    

    /**
     * Write concatenated files to a single file.
     * 
     * Maybe write source map depend on options on class constructor.
     * 
     * @param {string} destinationPath The destination path. Relative from this repository folder.
     * @returns {Promise} Return `Promise` object with object that contain `file` and `sourceMap` keys.
     */
    writeFile(destinationPath) {
        if (!destinationPath || typeof(destinationPath) !== 'string') {
            throw new Error('The argument `destinationPath` must be string.');
        }

        if (this._processed !== true) {
            throw new Error('Unable to call `writeFile()` without calling `concat()` method before.');
        }

        if (this.sourceMap === true) {
            this.appendSourceMapComment(this._destinationFile);
        }

        const destFullPath = path.resolve(REPO_DIR, destinationPath, this._destinationFile);
        this._prepareFolderIfNotExists(path.dirname(destFullPath));

        return fsPromise.writeFile(destFullPath, this._content)
        .then(() => {
            if (this.sourceMap !== true) {
                return Promise.resolve();
            }

            return this.writeSourceMap(destFullPath, this._sourceMapContent);
        })
        .then((sourceMapFullPath) => {
            let result = {
                file: destFullPath,
            }
            if (this.sourceMap === true && sourceMapFullPath) {
                result.sourceMap = sourceMapFullPath;
            }
            return Promise.resolve(result);
        });
    }// writeFile


}