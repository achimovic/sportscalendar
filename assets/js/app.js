require('../scss/app.scss');
const $ = require('jquery');
global.$ = global.jQuery = $;

// bootstrap
require('bootstrap/js/dist/collapse');
require('bootstrap/js/dist/modal');

// icons
import { library, dom } from '@fortawesome/fontawesome-svg-core'
import { faSearch } from '@fortawesome/free-solid-svg-icons'

library.add({ faSearch })
dom.watch()

global.bootbox = require('bootbox')
require ('./custom')
