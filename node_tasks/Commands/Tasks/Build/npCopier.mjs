/**
 * Node packages copier task.
 * 
 * config.json example:
 ```
    "copyNodePackages": [
        {
            "patterns": "node_modules/datatables.net-dt/images/**",
            "destination": "assets/vendor/datatables.net/images"
        },
        {
            "patterns": "node_modules/@fortawesome/fontawesome-free/LICENSE.txt",
            "rename": "fontawesome-license.txt", // <-- this is optional.
            "destination": "assets/vendor/"
        }
    ]
```
 */


'use strict';


import path from 'node:path';
// import this app's useful class.
import FS from '../../../Libraries/FS.mjs';
import NtConfig from '../../../Libraries/NtConfig.mjs';
import TextStyles from '../../../Libraries/TextStyles.mjs';


export const npCopier = class NpCopier {


    /**
     * Check required properties in each `copyNodePackages` value.
     * 
     * @param {Object} copyNodePackage The object of each `copyNodePackages` value.
     */
    static #checkRequiredProperties(copyNodePackage) {
        if (typeof(copyNodePackage?.patterns) === 'undefined') {
            console.error('  ' + TextStyles.txtError('The property `patterns` is required in each `copyNodePackages` value.'));
            process.exit(1);
        }

        if (typeof(copyNodePackage?.destination) === 'undefined') {
            console.error('  ' + TextStyles.txtError('The property `destination` is required in each `copyNodePackages` value.'));
            process.exit(1);
        }
    }// checkRequiredProperties


    /**
     * Copy Node packages that are "ready to use" to destinations.
     * 
     * This method can be run in parallel.
     * 
     * @async
     * @link https://stackoverflow.com/a/38641281/128761 Natural sort original source code.
     * @link https://stackoverflow.com/a/37576787/128761 Parallel promise.
     * @param {Object} argv The CLI arguments.
     * @return {Promise} Return `Promise` object.
     */
    static async copy(argv) {
        const cpObj = NtConfig.getValue('copyNodePackages', {});

        if (!cpObj || typeof(cpObj) !== 'object' || Object.keys(cpObj).length <= 0) {
            // if config has no `copyNodePackages` property.
            return Promise.resolve();
        }

        console.log(TextStyles.taskHeader('Copy Node packages to destinations.'));

        const collator = new Intl.Collator(undefined, {numeric: true, sensitivity: 'base'});
        let totalWarns = 0;

        let allTasks = new Promise(async (resolve, reject) => {
            await Promise.all(cpObj.map(async (item) => {
                // check for required properties.
                this.#checkRequiredProperties(item);

                let filesResult = await FS.glob(
                    item.patterns, {
                        absolute: false,
                        cwd: REPO_DIR,
                    }
                );

                if (typeof(filesResult) === 'object' && filesResult.length > 0) {
                    // get most parent of file result base on the same patterns.
                    let fileResultParent = await this.#getResultParent(item);

                    // sort result.
                    filesResult = filesResult.sort(collator.compare);

                    // loop copy.
                    await Promise.all(filesResult.map(async (eachFile) => {
                        this.#doCopy(item, eachFile, fileResultParent);
                    }));// end Promise.all
                } else {
                    totalWarns++;
                    console.log('  ' + TextStyles.txtWarning('Patterns "' + item.patterns + '": Result not found.'));
                }
            }))// end Promise.all
            .then(() => {
                resolve();
            });
        });// end new Promise;

        return allTasks
        .then(() => {
            if (totalWarns > 0) {
                console.log('  ' + TextStyles.txtWarning('There are total ' + totalWarns + ' warning, please read the result.'));
            }

            console.log('End copy Node packages to destination.');
            return Promise.resolve();
        });
    }// copy


    /**
     * Do copy file and folder to destination.
     * 
     * @param {Object} item Each `copyNodePackages` property.
     * @param {string} eachFile Each file name (and folder) from the search (glob) result.
     * @param {string} fileResultParent File result's parent path that have got from `#getResultParent()`.
     */
    static #doCopy(item, eachFile, fileResultParent) {
        const relativeName = path.relative(fileResultParent, eachFile);
        const sourcePath = path.resolve(REPO_DIR, eachFile);
        const destPath = path.resolve(REPO_DIR, item.destination, (item.rename ?? relativeName));

        FS.copyFileDir(
            sourcePath,
            destPath
        )
        .then(() => {
            console.log('  Patterns: ', item.patterns);
            console.log('    >> ' + sourcePath);
            console.log('      Copied to -> ' + destPath);
        });// end promise;
    }// doCopy


    /**
     * Get result's parent for use in replace and find only relative result from the patterns.
     * 
     * Example: patterns are 'assets-src/css/**'  
     * The result of files can be 'assets-src/css/folder/style.css'  
     * The result that will be return is 'folder'.
     * 
     * @async
     * @param {Object} item Each `copyNodePackages` property.
     * @returns {string} Return retrieved parent of this pattern.
     */
    static async #getResultParent(item) {
        const filesResult1lv = await FS.glob(
            item.patterns,
            {
                absolute: false,
                cwd: REPO_DIR,
                deep: 1,
            }
        );

        let fileResultParent = '';
        for (let eachFile in filesResult1lv) {
            fileResultParent = path.dirname(filesResult1lv[eachFile]);
            break;
        }

        return fileResultParent;
    }// getResultParent


}