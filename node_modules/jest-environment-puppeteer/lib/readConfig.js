"use strict";

exports.__esModule = true;
exports.readConfig = readConfig;
exports.getPuppeteer = getPuppeteer;

var _fs = _interopRequireDefault(require("fs"));

var _path = _interopRequireDefault(require("path"));

var _util = require("util");

var _cwd = _interopRequireDefault(require("cwd"));

var _mergeDeep = _interopRequireDefault(require("merge-deep"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

const exists = (0, _util.promisify)(_fs.default.exists);
const DEFAULT_CONFIG = {
  launch: {},
  browser: 'chromium',
  browserContext: 'default',
  exitOnPageError: true
};
const DEFAULT_CONFIG_CI = (0, _mergeDeep.default)(DEFAULT_CONFIG, {
  launch: {
    args: ['--no-sandbox', '--disable-setuid-sandbox', '--disable-background-timer-throttling', '--disable-backgrounding-occluded-windows', '--disable-renderer-backgrounding']
  }
});

async function readConfig() {
  const defaultConfig = process.env.CI === 'true' ? DEFAULT_CONFIG_CI : DEFAULT_CONFIG;
  const hasCustomConfigPath = !!process.env.JEST_PUPPETEER_CONFIG;
  const configPath = process.env.JEST_PUPPETEER_CONFIG || 'jest-puppeteer.config.js';

  const absConfigPath = _path.default.resolve((0, _cwd.default)(), configPath);

  const configExists = await exists(absConfigPath);

  if (hasCustomConfigPath && !configExists) {
    throw new Error(`Error: Can't find a root directory while resolving a config file path.\nProvided path to resolve: ${configPath}`);
  }

  if (!hasCustomConfigPath && !configExists) {
    return defaultConfig;
  } // eslint-disable-next-line global-require, import/no-dynamic-require


  const localConfig = await require(absConfigPath);
  return (0, _mergeDeep.default)({}, defaultConfig, localConfig);
}

function getPuppeteer(config) {
  switch (config.browser.toLowerCase()) {
    case 'chromium':
      // eslint-disable-next-line global-require, import/no-dynamic-require, import/no-extraneous-dependencies
      return require('puppeteer');

    case 'firefox':
      // eslint-disable-next-line global-require, import/no-dynamic-require, import/no-extraneous-dependencies
      return require('puppeteer-firefox');

    default:
      throw new Error(`Error: "browser" config option is given an unsupported value: ${browser}`);
  }
}