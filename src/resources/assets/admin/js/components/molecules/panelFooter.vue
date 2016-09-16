<template>
    <div class="panel-footer panel-footer-btn-group">
        <loading size="sm" :status="status">
            <div class="pull-right">
                <slot></slot>
            </div>
        </loading>
    </div>
</template>
<script>
    /**
     * @name panelFooter
     * @component panel-footer
     * @props
     *     status
     */
    export default {
        props: {
            status: {
                required: true,
            },
        },
    };
</script>
