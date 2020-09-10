import { name, version } from '../../package.json'
import plugin, { awemaInit } from './modules/plugin'
import lang from './modules/lang'

const awemaPlugin = {

    name, version,

    // modules: {
    // },

    install() {
        AWEMA.lang = lang
        Vue.use(plugin)
        awemaInit()
    }
}

if (window && ('AWEMA' in window)) {
    AWEMA.use(awemaPlugin)
} else {
    let s = '__awema_plugins_stack__'
    window[s] = window[s] || []
    window[s].push(awemaPlugin)
}