/**
 * yargs command: build.
 * 
 * Tasks for this command:
 * 1. Delete assets folders.
 * 2. Copy Node packages.
 */


'use strict';


// import this app's useful class.
import TextStyles from '../Libraries/TextStyles.mjs';
// import tasks for this command.
import {deleter} from './Tasks/Build/deleter.mjs';
import {npCopier} from './Tasks/Build/npCopier.mjs';


export const command = 'build';
export const describe = 'Build asset files such as CSS, JS.';
export const builder = (yargs) => {
    
};
export const handler = async (argv) => {
    console.log(TextStyles.programHeader());
    console.log(TextStyles.commandHeader(' Command: ' + argv._ + ' '));

    // 1. Delete assets folders.
    await deleter.clean(argv);
    // 2. Copy Node packages.
    await npCopier.copy(argv);

    console.log(TextStyles.txtSuccess(TextStyles.taskHeader('End command.')));
};