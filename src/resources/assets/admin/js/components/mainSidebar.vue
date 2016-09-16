<template>
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li
                    v-for="item in items"
                    :class="{
                        active: item.isActive,
                        open: item.items.length && item.isActive,
                        treeview: item.items.length,
                    }"
                >
                    <page :url="item.url" :reset-search="true">
                        <i class="fa" :class="['fa-' + item.icon]" v-if="item.icon"></i>
                        <span>{{ item.name }}</span>
                        <i class="fa fa-angle-left pull-right" v-if="item.items.length"></i>
                    </page>
                    <ul v-if="item.items.length" class="treeview-menu">
                        <li
                            v-for="i in item.items"
                            :class="{active: i.isActive}"
                        >
                            <page :url="i.url">
                                {{ i.name }}
                            </page>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>
</template>
<script>
    import _ from 'helpers/fp';
    import navigationProvider from 'providers/navigationProvider';
    import Vue from 'vue';
    import {pageName, urlToHref} from 'helpers/url';

    /**
     * @name mainSidebar
     * @component main-sidebar
     */
    export default {
        data() {
            return {
                active: null,
            };
        },
        mixins: [
            navigationProvider.mixin('items'),
        ],
        watch: {
            $context: {
                handler() {
                    this.setActiveClass();
                },
                immediate: true,
                deep: true,
            },
            $user: {
                async handler() {
                    navigationProvider.reset();
                    let items = await navigationProvider.get();
                    Vue.set(this, 'items', items);
                    this.setActiveClass();
                },
                immediate: true,
                deep: true,
            },
        },
        methods: {
            async setActiveClass() {
                for (const item of this.items) {
                    if (item.url && `/${this.$context.path}`.startsWith(await urlToHref(item.url))) {
                        Vue.set(item, 'isActive', true);
                    } else {
                        Vue.set(item, 'isActive', false);
                    }
                    if (item.items) {
                        for (let subItem of item.items) {
                            if (subItem.url && `/${this.$context.path}`.startsWith(await urlToHref(subItem.url))) {
                                Vue.set(item, 'isActive', true);
                                Vue.set(subItem, 'isActive', true);
                            } else {
                                Vue.set(subItem, 'isActive', false);
                            }
                        }
                    }
                }
            },
        },
    };
</script>
