<template>
    <div class="box-footer box-footer-btn-group">
        <loading size="sm" :status="status">
            <div class="pull-right">
                <slot></slot>
            </div>
        </loading>
    </div>
</template>
<script>
    /**
     * @name boxFooter
     * @component box-footer
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
