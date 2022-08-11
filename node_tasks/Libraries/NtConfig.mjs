/**
 * Node tasks Configuration class.
 */


'use strict';


import fs from 'node:fs';
import path from 'node:path';


export default class NtConfig {


    /**
     * Get value of selected property name.
     * 
     * @param {mixed} propertyName The config.json property name.
     * @param {string} defaults Default value if not found.
     * @returns {mixed}
     */
    static getValue(propertyName, defaults = '') {
        const configJSON = this.loadConfigJSON();

        if (typeof(configJSON) === 'object' && typeof(configJSON[propertyName]) !== 'undefined') {
            return configJSON[propertyName];
        }
        return defaults;
    }// getValue


    /**
     * Load config.json into object.
     * 
     * @returns {Object} Return JSON object of config.json file.
     */
    static loadConfigJSON() {
        const configJSONFile = path.resolve(NODETASKS_DIR, './config/config.json');
        return JSON.parse(fs.readFileSync(configJSONFile));
    }// loadConfigJSON

    
}