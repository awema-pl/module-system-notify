<template>

    <!-- stack items -->

    <transition-group
        v-if="stackDir"
        tag="ul"
        name="notify"
        class="system-notify-container"
        :class="['is-' + name, 'dir-' + stackDir, {'has-children': stackArr.length}]"
        aria-live="polite"
        aria-relevant="additions"
    >
        <li
            v-for="item in stackArr"
            class="system-notify-container__item"
            :key="item.id"
        >
            <slot v-bind="item" :remove="() => remove(stackArr[0].id)">
                <system-notify
                    :notify="item"
                    @close="remove(item.id)"
                ></system-notify>
            </slot>
        </li>
    </transition-group>

    <!-- single item -->
    <div v-else
        class="system-notify-container"
        :class="['is-' + name, {'has-children': stackArr.length}]"
        aria-live="polite"
        aria-relevant="additions"
    >
        <slot v-bind="stackArr[0]" :remove="() => remove(stackArr[0].id)">
            <transition name="notify" mode="out-in">
                <system-notify :key="stackArr[0].id"
                    v-if="stackArr[0]"
                    :notify="stackArr[0]"
                    @close="remove(stackArr[0].id)"
                ></system-notify>
            </transition>
        </slot>
    </div>

</template>


<script>
import config from '../js/modules/config'
import systemNotify from './system-notify.vue'

let _notifyId = 0

export default {

    name: 'system-notify-container',


    components: { systemNotify },


    props: {

        name: {
            type: String,
            required: true
        },

        stack: {
            type: [String, Boolean],
            default: 'bottom'
        },

        config: Object,

        notify: [Array, Object]
    },


    data() {
        return {
            stackArr: []
        }
    },


    computed: {

        stackDir() {

            switch ( this.stack ) {
                case 'top':
                    return 'top'
                    break;
                case 'false':
                case false:
                    return false
                    break;
                default:
                    return 'bottom'
                    break;
            }
        }
    },


    // watch: {

    //     'stackArr.length' : function(length, oldLength){
    //         if ( length && ! oldLength ) {
    //             AWEMA.emit(`notify::${this.name}:full`)
    //         }
    //         if ( ! length ) {
    //             AWEMA.emit(`notify::${this.name}:empty`)
    //         }
    //     }
    // },


    methods: {

        add(item) {
            try {
                if ( this.stackDir === false ) {
                    // remove timeout
                    if ( this.stackArr.length ) {
                        clearTimeout(this.stackArr[0]._timeout)
                    }
                    // quickly replace all stackArr
                    this.stackArr = [ item ]
                } else {
                    this.stackArr[ this.stackDir === 'top' ? 'unshift' : 'push' ](item)
                }

                if ( item.timeout && typeof item.timeout === 'number' ) {
                    item._timeout = setTimeout(() => { this.remove(item.id) }, item.timeout)
                }
            } catch(e) {
                if ( AWEMA_CONFIG.dev ) console.log(e)
            }
        },

        remove(id) {

            if ( typeof id === 'undefined' ) return

            let i = this.stackArr.findIndex( item => item.id === id )

            if ( i > -1 ) {
                clearTimeout(this.stackArr[i]._timeout)
                this.stackArr.splice(i, 1)
                return true
            }

            return false
        },

        _createNotify(data) {
            _notifyId += 1

            return Object.assign({}, this._config, this.config, data, { id: _notifyId, container: this.name })
        },

        _showHandler(event) {
            let item = this._createNotify(event.detail)
            this.add(item)
            return item.id
        },

        _hideHandler(event) {
            return this.remove(event.detail)
        }
    },


    beforeMount() {
        this._config = Object.assign(config, AWEMA_CONFIG.notify)
    },


    mounted() {
        AWEMA.on(`notify::${this.name}:show`, this._showHandler)
        AWEMA.on(`notify::${this.name}:hide`, this._hideHandler)

        // initial
        if ( this.notify ) {
            let _notifies = Array.isArray(this.notify) ? this.notify.slice() : [Object.assign({}, this.notify)]
            _notifies.forEach( notify => {
                notify = this._createNotify(notify)
                this.add(notify)
            })
        }
    },


    beforeDestroy() {
        AWEMA.off(`notify::${this.name}:show`, this._showHandler)
        AWEMA.off(`notify::${this.name}:hide`, this._hideHandler)
    }
}
</script>
