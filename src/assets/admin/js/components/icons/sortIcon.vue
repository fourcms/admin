<template>
    <i
        :style="{
            visibility: sortBy == field ? 'visible' : 'hidden',
            width: '14px'
        }"
        class="fa"
        :class="{
            'fa-sort-asc': sortOrder == 'asc',
            'fa-sort-desc': sortOrder == 'desc',
        }"
    ></i>
</template>
<script>
    /**
     * @name sortIcon
     * @component sort-icon
     * @props
     *     field
     *     sort-by
     *     sort-order
     */
    export default {
        props: {
            field: {
                required: true,
            },
            sortBy: {
                required: true,
            },
            sortOrder: {
                required: true,
            },
        },
    };
</script>
