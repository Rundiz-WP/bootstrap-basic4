/**
 * Bundler based.
 * 
 * For use with concat/minify CSS, JS.
 */


'use strict';


import {Buffer} from 'node:buffer';
import ConcatSM from 'concat-with-sourcemaps';
import fs from 'node:fs';
import fsPromise from 'node:fs/promises';
import path from 'node:path';


export default class BasedBundler {


    /**
     * @type {Buffer} The concatenated files content (Buffer).
     */
    _content;


    /**
     * @type {string} The destination file name only.
     */
    _destinationFile;


    /**
     * @type {string} The source map contents of concatenated files (string).
     */
    _sourceMapContent;


    /**
     * @type {boolean} Mark as processed such as `concat()`, `modify()` or not. Result will be `true` if it is already runned.
     */
    _processed = false;


    /**
     * Append source map comment.
     * 
     * @param {string} filename Destination file name. The map will be create based on this name but append .map extension.
     */
    appendSourceMapComment(filename) {
        if (typeof(filename) !== 'string') {
            throw new Error('The argument `filename` must be string.');
        }

        const fileExt = path.extname(filename).toLowerCase().replace(/^./, '');
        const jsExts = ['js', 'mjs'];
        const cssExts = ['css'];
        let sourceMapComment = '\n';
        // grab only file name because otherwise the mapping URL folder/style.css will becomes folder/style.css.map
        // we need only style.css.map
        filename = path.basename(filename);

        if (jsExts.includes(fileExt) === true) {
            // if destination file is JS.
            sourceMapComment += '//# sourceMappingURL=' + filename + '.map';
        } else if (cssExts.includes(fileExt) === true) {
            // if destination file is CSS.
            sourceMapComment += '/*# sourceMappingURL=' + filename + '.map */';
        } else {
            console.warn('    Unknown extension for ' + filename);
        }

        if (typeof(this._content) === 'object') {
            this._content = Buffer.concat([this._content, Buffer.from(sourceMapComment)]);
        }
    }// appendSourceMapComment


    /**
     * Prepend header to destination asset.
     * 
     * @param {string} text The header text.
     */
    header(text) {
        if (typeof(text) !== 'string') {
            throw new Error('The `text` argument must be string.');
        }

        if (this._processed !== true) {
            throw new Error('Unable to call `header()` without calling `concat()` method before.');
        }

        const ConcatObj = new ConcatSM(true, this._destinationFile);
        // add header
        ConcatObj.add(null, Buffer.from(text));
        // add current content
        ConcatObj.add(this._destinationFile, this._content, this._sourceMapContent);

        this._content = ConcatObj.content;
        this._sourceMapContent = ConcatObj.sourceMap;
    }// header


    /**
     * Check if selected folder exists, if it is not then create for it.
     * 
     * @protected This method was called from `writeFile()`.
     * @param {string} fullPath The folder full path.
     */
    _prepareFolderIfNotExists(fullPath) {
        if (!fs.existsSync(fullPath)) {
            fs.mkdirSync(fullPath, {
                recursive: true,
            });
        }
    }// prepareFolderIfNotExists


    /**
     * Write minified files to a single file.
     * 
     * Maybe write source map depend on options on class constructor.
     * 
     * @param {string} destinationPath The destination path. Relative from this main repository folder.
     * @returns {Promise} Return `Promise` object with object that contain `file` and `sourceMap` keys.
     */
    writeFile(destinationPath) {
        if (!destinationPath || typeof(destinationPath) !== 'string') {
            throw new Error('The argument `destinationPath` must be string.');
        }

        if (this._processed !== true) {
            throw new Error('Unable to call `writeFile()` without calling `minify()` method before.');
        }

        if (this.options.sourceMap !== false) {
            this.appendSourceMapComment(this._destinationFile);
        }

        const destFullPath = path.resolve(REPO_DIR, destinationPath, this._destinationFile);
        this._prepareFolderIfNotExists(path.dirname(destFullPath));

        return fsPromise.writeFile(destFullPath, this._content)
        .then(() => {
            if (this.options.sourceMap === false) {
                return Promise.resolve();
            }

            return this.writeSourceMap(destFullPath, this._sourceMapContent);
        })
        .then((sourceMapFullPath) => {
            let result = {
                file: destFullPath,
            }
            if (this.options.sourceMap !== false && sourceMapFullPath) {
                result.sourceMap = sourceMapFullPath;
            }
            return Promise.resolve(result);
        });
    }// writeFile


    /**
     * Write source map content and append source map comment to asset file.
     * 
     * @param {string} assetFullPath Full path to the asset file. Example `'/var/www/public/assets/css/style.css'`.
     * @param {string} sourceMapContents The source map contents.
     * @returns {Promise} Return `Promise` object with full path to source map file.
     */
    writeSourceMap(assetFullPath, sourceMapContents) {
        if (typeof(assetFullPath) !== 'string') {
            throw new Error('The argument `assetFullPath` must be string.');
        }

        if (typeof(sourceMapContents) !== 'string') {
            throw new Error('The argument `sourceMapContents` must be string.');
        }

        return fsPromise.writeFile(assetFullPath + '.map', sourceMapContents)
        .then(() => {
            return Promise.resolve(assetFullPath + '.map');
        });
    }// writeSourceMap


}