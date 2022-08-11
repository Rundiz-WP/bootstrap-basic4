/**
 * Deleter task.
 */


'use strict';


import {deleteAsync} from 'del';
import path from 'node:path';
// import this app's useful class.
import NtConfig from '../../../Libraries/NtConfig.mjs';
import TextStyles from '../../../Libraries/TextStyles.mjs';


export const deleter = class Deleter {


    /**
     * Check for valid WordPress destination.
     * 
     * This will be throw the error.
     * 
     * @param {string} destinationPath The destination path.
     */
    #checkValidWPDestination(destinationPath) {
        const wpContent = path.dirname(path.dirname(destinationPath));
        if ('wp-content' !== path.basename(wpContent)) {
            throw new Error('The destination path is incorrect. It must be inside WordPress installation folder. Example: "/var/www/wp-content/themes/mytheme".');
        }
    }// checkValidWPDestination


    /**
     * Clean destination folder in the CLI '--destination' argument.
     * 
     * @link https://www.npmjs.com/package/del The dependent Node package.
     * @async
     * @param {Object} argv The CLI arguments.
     */
    static async clean(argv) {
        const thisClass = new this();
        console.log(TextStyles.taskHeader('Clean destination.'));

        let destinationPath = path.resolve(argv.destination);
        destinationPath = destinationPath.replaceAll('\\', '/');
        destinationPath = destinationPath.replace(/[\"\']$/, '');

        try {
            thisClass.#checkValidWPDestination(destinationPath);
        } catch (ex) {
            console.error('  ' + TextStyles.txtError(ex.message));
            process.exit(1);
        }

        console.log('  Deleting ' + destinationPath + '/**');
        const deleteResult = await deleteAsync(destinationPath + '/**', {
            force: true
        });
        deleteResult.forEach((item) => {
            console.log('    - Deleted: ' + item.replaceAll(/\\/g, '/'));
        });// end forEach;
        if (deleteResult.length <= 0) {
            console.log('    Target is not exists, skipping.');
        }
        console.log('End clean destination.');
    }// clean


}