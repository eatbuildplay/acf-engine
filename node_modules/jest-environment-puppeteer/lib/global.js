"use strict";

exports.__esModule = true;
exports.setup = setup;
exports.teardown = teardown;

var _jestDevServer = require("jest-dev-server");

var _chalk = _interopRequireDefault(require("chalk"));

var _readConfig = require("./readConfig");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/* eslint-disable no-console */
let browser;
let didAlreadyRunInWatchMode = false;

async function setup(jestConfig = {}) {
  const config = await (0, _readConfig.readConfig)();
  const puppeteer = (0, _readConfig.getPuppeteer)(config);

  if (config.connect) {
    browser = await puppeteer.connect(config.connect);
  } else {
    browser = await puppeteer.launch(config.launch);
  }

  process.env.PUPPETEER_WS_ENDPOINT = browser.wsEndpoint(); // If we are in watch mode, - only setupServer() once.

  if (jestConfig.watch || jestConfig.watchAll) {
    if (didAlreadyRunInWatchMode) return;
    didAlreadyRunInWatchMode = true;
  }

  if (config.server) {
    try {
      await (0, _jestDevServer.setup)(config.server);
    } catch (error) {
      if (error.code === _jestDevServer.ERROR_TIMEOUT) {
        console.log('');
        console.error(_chalk.default.red(error.message));
        console.error(_chalk.default.blue(`\n☝️ You can set "server.launchTimeout" in jest-puppeteer.config.js`));
        process.exit(1);
      }

      if (error.code === _jestDevServer.ERROR_NO_COMMAND) {
        console.log('');
        console.error(_chalk.default.red(error.message));
        console.error(_chalk.default.blue(`\n☝️ You must set "server.command" in jest-puppeteer.config.js`));
        process.exit(1);
      }

      throw error;
    }
  }
}

async function teardown(jestConfig = {}) {
  const config = await (0, _readConfig.readConfig)();

  if (config.connect) {
    await browser.disconnect();
  } else {
    await browser.close();
  }

  if (!jestConfig.watch && !jestConfig.watchAll) {
    await (0, _jestDevServer.teardown)();
  }
}