/**
 * yargs command: watch.
 * 
 * Tasks for this command:
 * 1. Clean destination folder.
 * 2. Copy files to destination.
 * 3. Start watching.
 */


'use strict';


// import this app's useful class.
import TextStyles from '../Libraries/TextStyles.mjs';
// import tasks for this command.
import {copier} from './Tasks/Watch/copier.mjs';
import {deleter} from './Tasks/Watch/deleter.mjs';
import {watcher} from './Tasks/Watch/watcher.mjs';


export const command = 'watch';
export const describe = 'Watch asset files such as CSS, JS, changed and apply to destination.';
export const builder = (yargs) => {
    return yargs.options({
        'destination': {
            alias: 'd',
            demandOption: true,
            describe: 'The full path to theme folder in the WordPress installation. For example: \"/var/www/wp-content/themes/mytheme\"',
            type: 'string',
        },
        'noclean': {
            demandOption: false,
            describe: 'Set this option to skip clean destination and then copy files to destination.',
            type: 'boolean'
        }
    })
    .example('$0 watch --destination="/var/www/wp-content/themes/mytheme"')
    .example('$0 watch --destination="/var/www/wp-content/themes/mytheme" --noclean')
    ;// end .options;
};
export const handler = async (argv) => {
    console.log(TextStyles.programHeader());
    console.log(TextStyles.commandHeader(' Command: ' + argv._ + ' '));

    if (!argv.noclean) {
        // 1. Clean up destination folder (where it is theme folder in WordPress installation).
        await deleter.clean(argv);
        // 2. Copy files to destination.
        await copier.copyFiles(argv);
    }
    // 3. Start watching.
    const watcherObj = new watcher(argv);
    watcherObj.watch();
};