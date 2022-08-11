/**
 * yargs command: expr.
 * 
 * For experiments, tests only.
 */


'use strict';


// import this app's useful class.
import TextStyles from '../Libraries/TextStyles.mjs';


export const command = 'expr';
export const describe = 'For experiments, tests.';
export const handler = async (argv) => {
    console.log(TextStyles.programHeader());
    console.log(TextStyles.commandHeader(' Command: ' + argv._ + ' '));

    // do something awesome?
};