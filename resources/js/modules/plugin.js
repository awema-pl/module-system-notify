import systemNotifyContainer from '../../vue/system-notify-container.vue'

export function install(Vue) {

    if (this.installed) return
    this.installed = true

    Vue.component('system-notify-container', systemNotifyContainer)
}

export default {
    installed: false,
    install
}

export function awemaInit() {

    AWEMA._watchedNames.push('system-notify-container')

    // default container
    let container = document.querySelector('system-notify-container[name="default"]')
    if ( ! container ) {
        container = document.createElement('system-notify-container')
        container.setAttribute('name', 'default')
        container.className = 'position-bottom-right'
        document.body.appendChild(container)
    }

    // redefine default method
    AWEMA.notify = function(payload) {

        let config,
            container = 'default'

        if ( typeof payload === 'string') {
            config = { message: payload }
        } else {

            config = payload

            if ( payload.container ) {
                container = payload.container
            }
        }

        AWEMA.emit(`notify::${container}:show`, config)
    }
}
