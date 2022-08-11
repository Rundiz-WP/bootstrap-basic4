/**
 * Text style predefined.
 */


 'use strict';


 import clc from 'cli-color';
 import NtConfig from './NtConfig.mjs';
 
 
 /**
  * CLI color.
  * 
  * @link https://www.npmjs.com/package/cli-color Document.
  */
 export default class TextStyles {
 
 
     /**
      * Class constructor.
      */
     constructor() {
         this.maxWidthTrim = 30;
     }
 
 
     /**
      * Get `clc` object.
      * 
      * @returns {clc} Return clc object.
      */
     static clcInstance() {
         return clc;
     }// clcInstance
 
 
     /**
      * Return styled of program command header.
      * 
      * @param {String} command The command header text.
      * @return {String}
      */
     static commandHeader(command) {
         let thisClass = new this();
         command = thisClass.fillText(command, ' ');
 
         return clc.blue.bgWhite.bold(command);
     }// commandHeader
 
 
     /**
      * Fill text with a character to max allowed width (screen width - max width trim).
      * 
      * @param {string} text The original text.
      * @param {string} fill A text character to fill.
      * @return {string}
      */
     fillText(text, fill = '-') {
         const winWidth = clc.windowSize.width;
         const maxWidth = (winWidth - this.maxWidthTrim);
         const textWidth = clc.getStrippedLength(text);
 
         if (maxWidth > textWidth) {
             for (let i = 1; i <= (maxWidth - textWidth); i++) {
                 text += fill;
             }// endfor;
         }
 
         return text;
     }// fillText
 
 
     /**
      * Return program header.
      * 
      * @returns {String}
      */
     static programHeader() {
         let headerText = ' Assets source development: ' + NtConfig.getValue('moduleName') + ' ';
         let thisClass = new this();
         headerText = thisClass.fillText(headerText, ' ');
 
         return clc.white.bgXterm(2).bold(headerText);
     }// programHeader
 
 
     /**
      * Return styled of task header. Task header is in method/function of each task.
      * 
      * This will be style text with fill dash (-).
      * 
      * @param {string} task The task header text.
      * @return {string}
      */
     static taskHeader(task) {
         let thisClass = new this();
         task = thisClass.fillText(task);
 
         return task;
     }// taskHeader
 
 
     /**
      * Return styled of error message.
      * 
      * @param {string} text The error message.
      */
      static txtError(text) {
         return clc.red(text);
     }// txtError
 
 
     /**
      * Return styled of info message.
      * 
      * @param {string} text The info message.
      */
     static txtInfo(text) {
         return clc.cyan(text);
     }// txtInfo
 
 
     /**
      * Return styled of success message.
      * 
      * @param {string} text The success message.
      */
     static txtSuccess(text) {
         return clc.green(text);
     }// txtSuccess
 
 
     /**
      * Return styled of warning message.
      * 
      * @param {string} text The warning message.
      */
      static txtWarning(text) {
         return clc.yellow(text);
     }// txtWarning
 
 
 }