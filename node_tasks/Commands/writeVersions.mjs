/**
 * yargs command: yargs command: writeVersions.
 * 
 * Tasks for this command:
 * 1. Write down all Node packages version to enqueued assets in PHP file.
 */


'use strict';


// import this app's useful class.
import TextStyles from '../Libraries/TextStyles.mjs';
import NtConfig from '../Libraries/NtConfig.mjs';
// import tasks for this command.
import {versionWriter} from "./Tasks/versionWriter.mjs";


export const command = 'writeVersions';
export const describe = 'Write down all Node packages version to enqueued assets in PHP file.';

export const handler = async (argv) => {
    const writeVersionsCfg = NtConfig.getValue('writeVersions', []);
    if (typeof(writeVersionsCfg) !== 'object' || !Array.isArray(writeVersionsCfg) || writeVersionsCfg.length <= 0) {
        // if config was set to not writeVersions.
        return Promise.resolve();
    }

    console.log(TextStyles.programHeader());
    console.log(TextStyles.commandHeader(' Command: ' + argv._ + ' '));

    await versionWriter.init(argv);

    console.log(TextStyles.txtSuccess(TextStyles.taskHeader('End command.')));
};