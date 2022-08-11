/**
 * Watcher task.
 * 
 * config.json example:
 ```
    "watch": {
        "watcher": [
            "config/watchJS.mjs",
            "config/watchSCSS.mjs"
        ]
    }
```
 */


'use strict';


import fs from 'node:fs';
import path from 'node:path';
import url from 'node:url';
// import this app's useful class.
import FS from "../../../Libraries/FS.mjs";
import NtConfig from "../../../Libraries/NtConfig.mjs";
import TextStyles from "../../../Libraries/TextStyles.mjs";


export const watcher = class Watcher {


    /**
     * Class constructor.
     * 
     * @param {Object} argv The CLI arguments.
     */
    constructor(argv = {}) {
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
    }// constructor


    /**
     * Watch selected source and copy/bundle[/and maybe minify] to assets folder.
     */
    async watch() {
        console.log(TextStyles.taskHeader('Watch asset files changes.'));

        const watchObj = NtConfig.getValue('watch');
        const watcherObj = (watchObj?.watcher ?? []);

        for (const watcherFile of watcherObj) {
            const fullPathWatcherFile = path.resolve(NODETASKS_DIR, watcherFile);
            if (!fs.existsSync(fullPathWatcherFile)) {
                console.warn('  ' + TextStyles.txtWarning('The file ' + fullPathWatcherFile + ' is not exists.'));
                continue;
            }

            const {default: watcherClass} = await import(url.pathToFileURL(fullPathWatcherFile));
            const watcherClassObj = new watcherClass(this.argv);
            watcherClassObj.run();
        }
    }// watch


}