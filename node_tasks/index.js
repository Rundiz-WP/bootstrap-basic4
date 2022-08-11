/**
 * Node tasks for:
 *   Build (clear assets folders, copy/bundle/minify Node packages).
 *   Watch (Clean destination, copy all to destination, then watch files changed and apply to destination).
 *   Write versions (write Node package's versions to enqueued assets in PHP file).
 * 
 * @license http://opensource.org/licenses/MIT MIT
 */


'use strict';


import {fileURLToPath} from 'node:url';
import path from 'node:path';
// yargs. -------------------------------------
import yargs from 'yargs/yargs';
import {hideBin} from 'yargs/helpers';
const yargv = yargs(hideBin(process.argv));
// yargs. -------------------------------------
// import this app's useful class.
import NtConfig from './Libraries/ntConfig.mjs';
// import main entry of all commands.
import {commands} from './Commands/index.mjs';


const __filename = fileURLToPath(import.meta.url);
// define full path to this repository main folder.
global.REPO_DIR = path.dirname(path.dirname(__filename));
// define full path to this node_tasks folder.
global.NODETASKS_DIR = path.dirname(__filename);


yargv
.command(commands)
.demandCommand()
.help()
.argv
;