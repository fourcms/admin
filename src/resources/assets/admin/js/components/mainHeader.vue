<template>
    <header class="main-header">
        <page url="@params.lang/admin" class="logo">
            <span class="logo-mini"></span>
            <span class="logo-lg"><b>FOUR</b></span>
        </page>
        <nav class="navbar navbar-static-top" role="navigation">
            <a v-if="user" href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">{{ t('toggle_navigation') }}</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="user user-menu">
                        <a :href="'/' + params.lang" target="_blank">
                            <i class="fa fa-external-link"></i>
                            {{ t('go_to_site') }}
                        </a>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            {{ t(params.lang) }}
                        </a>
                        <ul class="dropdown-menu">
                            <li v-for="lang in langs" :class="{active: lang == params.lang}">
                                <page :url="changeLanguage($root.context.path, lang)">{{ t(lang) }}</page>
                            </li>
                        </ul>
                    </li>
                    <li v-if="user" class="dropdown user user-menu" :class="{active: 'userProfile' == $root.currentPage}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <img :src="user.avatar" class="user-image" />
                            <span class="hidden-xs">
                                {{ user.firstname }} {{ user.lastname }}
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img :src="user.avatar" class="img-circle" />
                                <p><strong>{{ user.firstname }} {{ user.lastname }}</strong></p>
                                <p>
                                     {{ user.role.display_name }}
                                    <small>
                                        {{ t('member_since') }} <from-now :value="user.created_at"></from-now>
                                    </small>
                                </p>
                            </li>
                            <!-- <li class="user-body"></li> -->
                            <li class="user-footer flex justify-content--space-between clearfix--remove">
                                <a href="#" class="btn btn-default btn-flat">
                                    {{ t('profile') }}
                                </a>
                                <a @click="logout()" class="btn btn-default btn-flat">
                                    {{ t('logout') }}
                                </a>
                            </li>
                            <li class="user-footer flex" v-if="user.loginasData">
                                <a @click="logoutAs()" class="btn btn-default btn-flat flex-grow">
                                    {{ t('back_to', user.loginasData.firstname + ' ' + user.loginasData.lastname) }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>
<script>
    import {langs} from 'helpers/app';
    import auth from 'helpers/auth';

    /**
     * @name mainHeader
     * @component main-header
     */
    export default {
        data() {
            return {
                active: null,
                langs,
            };
        },
        computed: {
            user() {
                return this.$root.user;
            },
        },
        methods: {
            async logout() {
                auth.logout();
            },
            async logoutAs() {
                await auth.logoutAs();
            },
            changeLanguage(path, lang) {
                return `/${lang}/${path.slice(3)}`;
            },
        },
    };
</script>
