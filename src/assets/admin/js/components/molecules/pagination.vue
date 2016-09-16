<template>
    <ul class="pagination clearfix">
        <li v-for="item in pages" :class="['pointer', item.class, {active: item.active, disabled: ! item.active && item.disabled}]">
            <a @click="setPage(item)" :title="item.icon ? item.text : ''" class="cursor--pointer">
                <template v-if="item.icon">
                    <i :class="['fa', item.icon]"></i>
                </template>
                <template v-else>
                    {{ item.text }}
                </template>
            </a>
        </li>
    </ul>
</template>
<script>

    /**
     * @name pagination
     * @component pagination
     * @props
     *     total
     *     page
     *     limit
     */
    export default {
        props: {
            total: {
                required: true,
                type: Number,
            },
            currentPage: {
                required: true,
            },
            limit: {
                required: true,
            },
            scrollTop: {
                default: true,
            },
            scrollTo: {
                default: 'html, body',
            },
            scrollOffset: {
                default: 0,
            },
            links: {
                default: 8,
            },
            url: {
                default: null,
            },
        },
        methods: {
            setPage(item) {
                if (this.url) {
                    if (this.url.includes('%page')) {
                        location = this.url.replace('%page', item.page);
                    } else {
                        location = `${this.url}/${item.page}`;
                    }
                } else {
                    this.currentPage = item.page;

                    if (this.scrollTop) {
                        $('html, body').animate({
                            scrollTop: $(this.scrollTo).offset().top + this.scrollOffset,
                        });
                    }
                }
            },
        },
        computed: {
            pages() {
                const numPages = Math.ceil(this.total / this.limit);
                const pages = [];

                if (numPages <= 1) {
                    return pages;
                }

                let start, end;

                if (numPages <= this.links) {
                    start = 1;
                    end = numPages;
                } else {
                    start = this.currentPage - Math.floor(this.links / 2);
                    end = this.currentPage + Math.floor(this.links / 2);

                    if (start < 1) {
                        start = 1;
                        end = this.links;
                    }

                    if (end > numPages) {
                        start -= (end - numPages);
                        end = numPages;
                    }
                }

                if (numPages > this.links) {
                    pages.push({
                        text: this.t('first_page'),
                        icon: 'fa-angle-double-left',
                        disabled: this.currentPage == 1,
                        active: false,
                        page: 1,
                        class: 'pagination--first-page',
                    });
                }

                pages.push({
                    text: this.t('previous_page'),
                    icon: 'fa-angle-left',
                    disabled: this.currentPage == 1,
                    active: false,
                    page: this.currentPage - 1,
                    class: 'pagination--prev-page',
                });

                for (let i = start; i <= end; i++) {
                    pages.push({
                        text: i,
                        disabled: this.currentPage == i,
                        active: this.currentPage == i,
                        page: i,
                        class: 'pagination--page',
                    });
                }

                pages.push({
                    text: this.t('next_page'),
                    icon: 'fa-angle-right',
                    disabled: this.currentPage == numPages,
                    active: false,
                    page: this.currentPage + 1,
                    class: 'pagination--next-page',
                });

                if (numPages > this.links) {
                    pages.push({
                        text: this.t('last_page'),
                        icon: 'fa-angle-double-right',
                        disabled: this.currentPage == numPages,
                        active: false,
                        page: numPages,
                        class: 'pagination--next-page',
                    });
                }
                return pages;
            },
        },
    };
</script>
