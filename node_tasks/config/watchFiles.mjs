/**
 * Watch assets/js-src/rdta folder.
 */


'use strict';


import {deleteAsync} from 'del';
import path from 'node:path';
// import this app's useful class.
import FS from "../Libraries/FS.mjs";
import NtConfig from '../Libraries/ntConfig.mjs';
// import sub class.
import JsBundler from './inc/jsBundler.mjs';


/**
 * @type {String} destFolder Destination folder. Mirror to js-src.
 */
const destFolder = 'assets/js/rdta';


const relativeSrc = 'assets/js-src/rdta';


export default class WatchJS {


    /**
     * Class constructor.
     * 
     * @param {Object} argv The CLI arguments.
     */
    constructor(argv) {
        /**
         * @type {Object} The command line argument.
         */
        this.argv = {};
        if (typeof(argv) === 'object') {
            this.argv = {
                ...this.argv,
                ...argv,
            }
        }

        /**
         * @type {string} Destination that was set from CLI `--destination` argument.
         */
        this.destination = argv.destination;

        /**
         * @type {string|string[]} The glob patterns to watch files.
         */
        this.globPatterns = [];
    }// constructor


    get destFolder() {
        return destFolder;
    }// destFolder


    get relativeSrc() {
        return relativeSrc;
    }// relativeSrc


    /**
     * Apply changes to destination.
     * 
     * @link https://www.npmjs.com/package/del The dependent Node package.
     * @async
     * @private This method was called from `watch()`.
     * @param {string} event The watcher events. See https://github.com/paulmillr/chokidar#methods--events
     * @param {string} file The changed file.
     */
    async #applyChanges(event, file) {
        let command;
        const fileRelative = path.relative(this.relativeSrc, file);

        if (event.toLowerCase().indexOf('unlink') !== -1) {
            // if matched unlink (file), unlinkDir (folder)
            command = 'delete';
        } else {
            // if matched add, addDir, change
            command = null;
        }

        if (command === 'delete') {
            // if command is delete (file and folder).
            const destFullPath = path.resolve(this.destination, file);
            const deleteResult = await deleteAsync(destFullPath, {force: true});
            for (const item of deleteResult) {
                console.log('    - Deleted: ' + item);
            };
        }
        
        if (command !== 'delete') {
            // else, it is copy command.
            const sourceFullPath = path.resolve(REPO_DIR, file);
            const destFullPath = path.resolve(this.destination, file);
            FS.copyFileDir(sourceFullPath, destFullPath);
            console.log('    >> Applied to ' + destFullPath);
        }// endif;

        return Promise.resolve();
    }// applyChanges


    /**
     * Display file changed.
     * 
     * @private This method was called from `run()`.
     * @param {string} event The watcher events. See https://github.com/paulmillr/chokidar#methods--events
     * @param {string} file The changed file.
     * @param {string} source The source folder full path.
     */
    #displayFileChanged(event, file, source) {
        console.log('  File changed (' + event + '): ' + path.resolve(source, file));
    }// displayFileChanged


    /**
     * Run watch
     */
    run() {
        // get patterns from `copier` config.json property.
        const watchObj = NtConfig.getValue('watch', {});
        if (!watchObj?.copier?.targets || Object.keys(watchObj.copier.targets).length <= 0) {
            // if config has no .watch.copier.targets property.
            return Promise.resolve();
        }
        const copyTargets = watchObj.copier.targets;
        // set this class's property `globPatterns` from `copier` config.json property.
        copyTargets.forEach((item) => {
            if (item.patterns) {
                this.globPatterns.push(...item.patterns);
            }
        });

        const watcher = FS.watch(
            this.globPatterns, 
            {
                awaitWriteFinish: {
                    stabilityThreshold: 800,
                    pollInterval: 100
                },
                cwd: REPO_DIR,
            }
        );

        watcher.on('all', async (event, file, stats) => {
            await this.#displayFileChanged(event, file, REPO_DIR);
            await this.#applyChanges(event, file);
            console.log('  Finish task for file changed (' + event + ').');
        });
    }// run


}