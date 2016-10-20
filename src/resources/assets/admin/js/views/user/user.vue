<template>
    <not-found v-if="itemNotFound"></not-found>
    <div v-else class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-users"></i> {{ t('users') }}</h1>
        </section>
        <section class="content">
            <loading :status="itemLoaded">
                <form @submit="submit($event)">
                    <div class="box">
                        <div class="box-header">
                            <page :url="params.lang + '/admin/user'" class="btn btn-link btn-sm"><i class="fa fa-long-arrow-left"></i></page>
                            {{ item.fullname }}
                        </div>
                        <div class="box-body">
                            <label class="form-group">
                                <span class="control-label">{{ t('firstname') }}</span>
                                <text-input
                                    :value.sync="item.firstname"
                                ></text-input>
                            </label>
                            <label class="form-group">
                                <span class="control-label">{{ t('lastname') }}</span>
                                <text-input
                                    :value.sync="item.lastname"
                                ></text-input>
                            </label>
                            <label class="form-group">
                                <span class="control-label">{{ t('email') }}</span>
                                <text-input
                                    :value.sync="item.email"
                                ></text-input>
                            </label>
                            <label class="form-group">
                                <span class="control-label">{{ t('mobile_phone') }}</span>
                                <text-input
                                    :value.sync="item.mobile_phone"
                                ></text-input>
                            </label>
                            <label class="form-group">
                                <span class="control-label">{{ t('address') }}</span>
                                <text-input
                                    :value.sync="item.address"
                                ></text-input>
                            </label>
                            <label class="form-group">
                                <span class="control-label">{{ t('password') }}</span>
                                <password-input
                                    :value.sync="item.password"
                                ></password-input>
                            </label>
                            <label class="form-group">
                                <span class="control-label">{{ t('password_confirmation') }}</span>
                                <password-input
                                    :value.sync="item.password_confirmation"
                                ></password-input>
                            </label>
                            <label class="form-group">
                                <span class="control-label">{{ t('status') }}</span>
                                <user-status-input
                                    :value.sync="item.status"
                                ></user-status-input>
                            </label>
                            <label class="form-group">
                                <span class="control-label">{{ t('role') }}</span>
                                <role-input
                                    :value.sync="item.role_id"
                                ></role-input>
                            </label>
                        </div>
                        <box-footer :status="!submitting" class="text-right">
                            <button type="button" class="btn btn-default" @click="resetItem()">{{ t('discard') }}</button>
                            <button type="submit" class="btn btn-primary">{{ t('save') }}</button>
                        </box-footer>
                    </div>
                </form>
            </loading>
        </section>
    </div>
</template>
<script>
    import repository from 'repositories/userRepository';
    import {loading} from 'decorators/submit';
    import dontLeave from 'helpers/dontLeave';

    /**
     * @name user
     * @component user
     */
    export default {
        data() {
            return {
                item: null,
                itemLoaded: false,
                itemNotFound: false,
                create: false,
                submitting: false,
            };
        },
        watch: {
            'params.id': {
                async handler() {
                    const haveItemId = Boolean(this.params.id);
                    const haveItem = Boolean(this.item);

                    if (haveItemId && ( ! haveItem || ( this.item.id != this.params.id ) ) ) {
                        this.getItem();
                    }
                },
                immediate: true,
                deep: true,
            },
            'params.create': {
                async handler() {
                    if (this.params.create) {
                        this.create = true;

                        this.getNewItem();
                    } else {
                        this.create = false;
                    }
                },
                immediate: true,
                deep: true,
            },
            'item': {
                async handler(newValue, oldValue) {
                    if (oldValue && newValue.id == oldValue.id) {
                        dontLeave.hold();
                    }
                },
                immediate: false,
                deep: true,
            },
        },
        methods: {
            async resetItem() {
                await loading(this, 'submitting', false, async () => {
                    return this.item = await (this.create ? repository.newItem() : repository.item(this.params.id));
                });
                dontLeave.release();
            },
            async getNewItem() {
                await loading(this, 'itemLoaded', true, async () => {
                    return this.item = await repository.newItem();
                });
                dontLeave.release();
            },
            async getItem() {
                try {
                    this.itemNotFound = false;
                    await loading(this, 'itemLoaded', true, async () => {
                        return this.item = await repository.item(this.params.id);
                    });
                } catch (xhr) {
                    this.itemNotFound = true;
                }
                dontLeave.release();
            },
            async submit(e) {
                e.preventDefault();
                try {
                    await loading(this, 'submitting', false, async () => {
                        this.item = await (this.create ? repository.create(this.item) : repository.update(this.item));

                        // this needs to be changed (but works for now)
                        setTimeout(() => dontLeave.release(), 200);

                        if (this.create) {
                            this.page(`${this.params.lang}/admin/user/${this.item.id}`);
                        }

                        return this.item;
                    });

                } catch (err) {
                    this.submitting = false;
                }
            },
        },
    };
</script>
