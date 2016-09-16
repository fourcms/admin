<template>
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-users"></i> {{ t('users') }}</h1>
        </section>
        <section class="content">
            <div class="box box-default collapsed-box">
                <div class="box-header with-border flex">
                    <text-input
                        :value.sync="users.params.search"
                        :placeholder="t('search')"
                        debounce="500"
                        class="box-title-input"
                    ></text-input>
                    <div class="box-tools flex">
                        <button type="button" class="btn btn-box-tool" :title="t('reset_search')" @click="users.resetParams()">
                            <i class="fa fa-eraser"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" :title="t('expand_search_options')" data-widget="collapse">
                            <i class="fa fa-angle-down"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-group">
                                <span class="control-label">{{ t('status') }}</span>
                                <user-status-input
                                    :value.sync="users.params.status"
                                    has-empty-value="true"
                                ></user-status-input>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <label class="form-group">
                                <span class="control-label">{{ t('role') }}</span>
                                <role-input
                                    :value.sync="users.params.role_id"
                                    has-empty-value="true"
                                ></role-input>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <label class="form-group">
                                <span class="control-label">{{ t('trashed') }}</span>
                                <checkbox-input
                                    :value.sync="users.params.trashed"
                                ></checkbox-input>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <loading :status="users.loaded || users.data">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>
                                        <page
                                            class="btn btn-default btn-xs"
                                            :title="t('add')"
                                            :url="params.lang + '/admin/user/create'"
                                            v-if="cani('user.create')"
                                        >
                                            <i class="fa fa-plus"></i>
                                        </page>
                                    </th>
                                    <th @click="sortBy('fullname')" class="pointer nowrap">
                                        {{ t('fullname') }}
                                        <sort-icon field="fullname" :sort-by="users.params.sortBy" :sort-order="users.params.sortOrder"></sort-icon>
                                    </th>
                                    <th @click="sortBy('email')" class="pointer">
                                        {{ t('email') }}
                                        <sort-icon field="email" :sort-by="users.params.sortBy" :sort-order="users.params.sortOrder"></sort-icon>
                                    </th>
                                    <th @click="sortBy('role')" class="pointer">
                                        {{ t('role') }}
                                        <sort-icon field="role" :sort-by="users.params.sortBy" :sort-order="users.params.sortOrder"></sort-icon>
                                    </th>
                                    <th @click="sortBy('created_at')" class="pointer">
                                        {{ t('created_at') }}
                                        <sort-icon field="created_at" :sort-by="users.params.sortBy" :sort-order="users.params.sortOrder"></sort-icon>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(index, item) in users.data" track-by="id">
                                    <tr :class="{del: item.deleted_at}">
                                        <td>{{ ((users.params.page - 1) * users.params.perPage) + (index + 1) }}</td>
                                        <td class="nowrap">
                                            <template v-if="$user.id != item.id">
                                                <template v-if=" ! item.deleted_at">
                                                    <page
                                                        :url="users.url + '/' + item.id"
                                                        class="btn btn-default btn-xs"
                                                        :title="t('edit')"
                                                        v-if="cani('user.update')"
                                                    >
                                                        <i class="fa fa-pencil"></i>
                                                    </page>
                                                    <button
                                                        @click="remove(item)"
                                                        class="btn btn-default btn-xs"
                                                        :title="t('remove')"
                                                        v-if="cani('user.delete')"
                                                    >
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <button
                                                        @click="loginAs(item)"
                                                        class="btn btn-default btn-xs"
                                                        :title="t('login_as')"
                                                        v-if="cani('user.loginas') && ! $user.loginasData"
                                                    >
                                                        <i class="fa fa-sign-in"></i>
                                                    </button>
                                                </template>
                                                <template v-else>
                                                    <button @click="restore(item)" class="btn btn-default btn-xs" :title="t('restore')">
                                                        <i class="fa fa-magic"></i>
                                                    </button>
                                                </template>
                                            </template>
                                        </td>
                                        <td>{{ item.fullname }}</td>
                                        <td>{{ item.email }}</td>
                                        <td>{{ item.role.display_name }}</td>
                                        <td>
                                            <from-now :value="item.created_at"></from-now>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        <div class="form-inline pull-left">
                            <div class="form-group">
                                <label>{{ t('item_per_page') }}</label>
                                <select-input :value.sync="users.params.perPage" :options="[15, 20, 30]" class="input-sm"></select-input>
                            </div>
                        </div>
                        <pagination
                            class="pagination-sm no-margin pull-right"
                            :total.sync="users.total"
                            :current-page.sync="users.params.page"
                            :limit.sync="users.params.perPage"
                        ></pagination>
                    </div>
                </div>
            </loading>
        </section>
    </div>
</template>
<script>
    import _ from 'helpers/fp';
    import sweetAlert from 'helpers/sweetAlert';
    import auth from 'helpers/auth';
    import userRepository from 'repositories/userRepository';

    /**
     * @name users
     * @component users
     */
    export default {
        created() {
            userRepository.list('users', this);
        },
        methods: {
            sortBy(field) {
                const values = ['', 'desc', 'asc'];
                this.users.params.sortOrder = this.users.params.sortBy == field ? _.nth(values.indexOf(this.users.params.sortOrder) - 1, values) : 'asc';
                this.users.params.sortBy = this.users.params.sortOrder != '' ? field : '';
            },
            async loginAs(user) {
                await auth.loginAs(user.id);
            },
            async remove(item) {
                if (await sweetAlert(this.t('confirm_remove_user'))) {
                    const index = this.users.data.indexOf(item);
                    const deletedItem = await userRepository.remove(item);
                    this.users.data.$set(index, deletedItem);
                }
            },
            async restore(item) {
                const index = this.users.data.indexOf(item);
                const restoredItem = await userRepository.restore(item);
                this.users.data.$set(index, restoredItem);
            },
        },
    };
</script>
