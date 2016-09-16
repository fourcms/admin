<template>
    <div
        v-el:modal
        class="modal fade"
        :data-backdrop="allowClose ? 'true' : 'static'"
        :data-keyboard="allowClose ? 'true' : 'false'"
    >
        <div
            class="modal-dialog"
            :class="{
                 'modal-lg': size=='lg',
                 'modal-sm': size=='sm'
            }"
            v-if="visible"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <button
                        v-if="allowClose"
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h4 class="modal-title text-center">{{ title }}</h4>
                </div>
                <slot></slot>
            </div>
        </div>
    </div>
</template>
<script>
    /**
     * @name modal
     * @component modal
     * @props
     *     [title]: 'untitled'
     *     [visible]: false
     *     [size]: null
     *     [allow-close]: true
     * @events
     *     show
     *     hide
     */
    export default {
        props: {
            title: {
                default: 'untitled',
            },
            visible: {
                default: false,
            },
            size: {
                default: null,
            },
            allowClose: {
                default: true,
            },
        },
        methods: {
            show() {
                this.visible = true;
            },
            hide() {
                this.visible = false;
            },
            toggle() {
                this.visible = ! this.visible;
            },
        },
        ready() {
            $(this.$els.modal).on('show.bs.modal', e => {
                this.visible = true;
                this.$emit('show');
            });
            $(this.$els.modal).on('hide.bs.modal', e => {
                this.visible = false
                this.$emit('hide');
            });
        },
        watch: {
            visible(value, oldValue) {
                $(this.$els.modal).modal(this.visible ? 'show' : 'hide');
            },
        },
    };
</script>
