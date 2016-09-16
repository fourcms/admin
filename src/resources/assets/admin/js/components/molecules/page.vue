<template>
    <a
        :href="href"
        @click="click"
        class="pointer"
        :target="target"
    >
        <slot></slot>
    </a>
</template>
<script>
    import {urlTarget, urlToHref, goToUrl} from 'helpers/url';

    /**
     * @name page
     * @component page
     * @props
     *     url
     */
    export default {
        props: {
            url: {
                default: null,
                coerce(url) {
                    return url || '';
                },
            },
            resetSearch: {
                default: false,
            },
        },
        data() {
            return {
                href: null,
            };
        },
        watch: {
            '[url, params]': {
                async handler() {
                    this.href = await urlToHref(this.url, this.resetSearch);
                },
                immediate: true,
                deep: true,
            },
        },
        methods: {
            async click(e) {
                if (this.url == null) return;
                if (e.ctrlKey || e.which === 2) return;
                e.preventDefault();
                if (this.url) {
                    await goToUrl(this.url, this.resetSearch);
                }
            },
        },
        computed: {
            target() {
                return urlTarget(this.url);
            },
        },
    };
</script>
