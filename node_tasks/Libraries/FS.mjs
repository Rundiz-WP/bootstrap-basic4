/**
 * File system class.
 */


'use strict';


import chokidar from 'chokidar';
import fs from 'node:fs';
import path from 'node:path';
import {globby} from 'globby';


export default class FS {


    /**
     * Copy file and folder.
     * 
     * This method does not work recursive. It cannot copy folder contents recursively.
     * 
     * This is for fix when using Node's `fs.cp()` with parallel call that cause can't mkdir errors some time.  
     * It is also preserve timestamp on a file.
     * 
     * @param {string} source Full path of source file/folder.
     * @param {string} destination Full path of destination file/folder.
     * @returns {Promise} Return Promise object.
     */
    static copyFileDir(source, destination) {
        if (!fs.existsSync(source)) {
            // if source file is not exists, do nothing to prevent errors.
            return Promise.resolve();
        }

        const sourceStat = fs.statSync(source);

        if (sourceStat.isDirectory()) {
            // if this source is folder, use mkdir NOT copy file.
            fs.mkdirSync(destination, {
                recursive: true,
            });
        } else {
            // if this source is file, use copy file.
            if (!fs.existsSync(path.dirname(destination))) {
                // if parent folder of this file is not exists, create one.
                fs.mkdirSync(path.dirname(destination), {
                    recursive: true,
                });
            }

            fs.copyFileSync(source, destination);

            // preserve timestamp to its original.
            if (sourceStat.atime && sourceStat.mtime) {
                fs.utimesSync(destination, sourceStat.atime, sourceStat.mtime);
            }
        }

        return Promise.resolve();
    }// copyFileDir


    /**
     * Perform asynchronous glob search.
     * 
     * @link https://www.npmjs.com/package/globby globby document.
     * @link https://github.com/mrmlnc/fast-glob fast glob document.
     * @async
     * @param {string[]} pattern Pattern to be matched.
     * @param {object} options The node package 'fast-glob' options. Set to empty object to use default options.
     * @return {Promise<GlobEntry[]>} Return Promise object with array result.
     */
    static async glob(pattern, options = {}) {
        if (typeof(pattern) !== 'string' && typeof(pattern) !== 'object') {
            throw new Error('The pattern argument must be string or array.');
        }

        if (typeof(options) !== 'object') {
            throw new Error('The options argument must be object.');
        }

        let defaults = {
            absolute: true,
            baseNameMatch: false,
            dot: true,
            onlyDirectories: false,
            onlyFiles: false,
        };
        options = {
            ...defaults,
            ...options
        };

        const result = await globby(pattern, options);
        return result;
    }// glob

    
    /**
     * Check if source and destination is the exactly same.
     * 
     * If source is folder and both source and destination are exists it will be return `true`.  
     * It won't check for the same folder name because both full path was built from different based location.  
     * 
     * The same file and folder name must be checked before calling this.
     * 
     * @param {string} sourcePath Full path to source file.
     * @param {string} destPath Full path to destination file.
     * @returns {boolean} Return `true` if it is the exactly same file. Return `false` for otherwise.
     */
    static isExactSame(sourcePath, destPath) {
        if (fs.existsSync(sourcePath) && fs.existsSync(destPath)) {
            // if both source and destination files (or folders) are exists.
            // check for the same size and modify time.
            const sourceStat = fs.statSync(sourcePath);
            const destStat = fs.statSync(destPath);

            if (sourceStat.isDirectory()) {
                // if it is folder.
                // mark as the same.
                return true;
            } else {
                // if it is file.
                if (
                    sourceStat.size === destStat.size &&
                    sourceStat.mtime.getTime() === destStat.mtime.getTime()
                ) {
                    // if file size and last modified time is same.
                    // read their content.
                    const sourceContent = fs.readFileSync(sourcePath);
                    const destContent = fs.readFileSync(destPath);

                    if (sourceContent.equals(destContent)) {
                        // if contents are exactly same.
                        return true;
                    }

                    // come to this means files size and time are same but contents are not.
                    // this doesn't means they are exactly same file.
                }
            }
        }

        return false;
    }// isExactSame


    /**
     * Perform watching files changes.
     * 
     * @link https://github.com/paulmillr/chokidar chokidar document.
     * @param {string[]} pattern Pattern to be matched.
     * @param {object} options The node package 'chokidar' options. Set to empty object to use default options.
     * @returns {chokidar.FSWatcher} Return chokidar `chokidar.FSWatcher` object.
     */
    static watch(pattern, options = {}) {
        if (typeof(pattern) !== 'string' && typeof(pattern) !== 'object') {
            throw new Error('The pattern argument must be string or array.');
        }

        if (typeof(options) !== 'object') {
            throw new Error('The options argument must be object.');
        }

        let defaults = {
            ignoreInitial: true,
            persistent: true,
        };
        options = {
            ...defaults,
            ...options
        }

        return chokidar.watch(
            pattern,
            options
        );
    }// watch


}