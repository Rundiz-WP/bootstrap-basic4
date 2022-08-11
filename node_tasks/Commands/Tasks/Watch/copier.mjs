/**
 * Copier task.
 * 
 * Copy this repository's files to destination.
 * 
 * config.json example:
 ```
    "watch": {
        "copier": {
            "targets": [
                {
                    "patterns": ["./*.css", "./*.js"]
                },
                {
                    "patterns": ["./*.php"]
                }
            ]
        }
    }
```
 */


'use strict';


import path from 'node:path';
// import this app's useful class.
import FS from '../../../Libraries/FS.mjs';
import NtConfig from '../../../Libraries/NtConfig.mjs';
import TextStyles from '../../../Libraries/TextStyles.mjs';


export const copier = class Copier {


    /**
     * @type {string} Destination full path.
     */
    destinationPath = '';


    /**
     * Do copy file and folder to destination.
     * 
     * @param {Object} item Each `watch.copier.targets` property.
     * @param {string} eachFile Each file name (and folder) from the search (glob) result.
     */
    #doCopy(item, eachFile) {
        const sourcePath = path.resolve(REPO_DIR, eachFile);
        const destPath = path.resolve(this.destinationPath, eachFile);

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
    async #getResultParent(item) {
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


    /**
     * Copy files to destination.
     * 
     * @param {Object} argv The CLI arguments.
     */
    static copyFiles(argv) {
        const thisClass = new this();

        let destinationPath = path.resolve(argv.destination);
        destinationPath = destinationPath.replaceAll('\\', '/');
        destinationPath = destinationPath.replace(/[\"\']$/, '');
        thisClass.destinationPath = destinationPath;

        const watchObj = NtConfig.getValue('watch', {});
        if (!watchObj?.copier?.targets || Object.keys(watchObj.copier.targets).length <= 0) {
            // if config has no .watch.copier.targets property.
            return Promise.resolve();
        }
        const copyTargets = watchObj.copier.targets;

        console.log(TextStyles.taskHeader('Copy files to destination.'));

        const collator = new Intl.Collator(undefined, {numeric: true, sensitivity: 'base'});
        let totalWarns = 0;

        let allTasks = new Promise(async (resolve, reject) => {
            await Promise.all(copyTargets.map(async (item) => {
                let filesResult = await FS.glob(
                    item.patterns, {
                        absolute: false,
                        cwd: REPO_DIR,
                    }
                );
                
                if (typeof(filesResult) === 'object' && filesResult.length > 0) {
                    // sort result.
                    filesResult = filesResult.sort(collator.compare);

                    // loop copy.
                    await Promise.all(filesResult.map(async (eachFile) => {
                        thisClass.#doCopy(item, eachFile);
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

            console.log('End copy files to destination.');
            return Promise.resolve();
        });
    }// copyFiles


}