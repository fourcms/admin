<template>
    <modal
        :title="t('authorization')"
        :allow-close="false"
        v-ref:modal
    >
        <form class="form-horizontal" @submit="submit">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-4 control-label">{{ t('email') }}</label>
                    <div class="col-md-6">
                        <input v-el:email type="email" class="form-control" name="email" v-model="email" autocomplete="username">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">{{ t('password') }}</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password" v-model="password" autocomplete="current-password">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    type="submit"
                    class="btn btn-primary caps"
                    :class="{
                         disabled: submitting || ! submitable
                    }"
                >
                    {{ t('login') }}
                    <i v-show="submitting" class="fa fa-circle-o-notch fa-spin"></i>
                </button>
            </div>
        </form>
    </modal>
</template>
<script>
    import defered from 'helpers/defered';
    import bubble from 'helpers/bubble';
    import {loading} from 'decorators/submit';
    import auth from 'helpers/auth';

    /**
     * @name loginModal
     * @component login-modal
     */
    export default {
        data() {
            return {
                email: '',
                password: '',
                deferedLogin: null,
            };
        },
        computed: {
            submitable() {
                return (this.email && this.password);
            },
        },
        methods: {
            async login() {
                this.$refs.modal.show();

                if ( ! this.deferedLogin) {
                    this.deferedLogin = defered();

                    setTimeout(() => this.$els.email.focus(), 200);
                }

                return this.deferedLogin.promise;
            },
            async submit(e) {
                e.preventDefault();
                if (this.submitable) {
                    loading(this, 'submitting', false, async () => {
                        try {
                            let user = auth.login(this.email, this.password);
                            this.deferedLogin.resolve(user);
                            this.deferedLogin = null;
                            this.$refs.modal.hide();
                        } catch (err) {
                            bubble.danger(this.t('authorization'), this.t('these_credentials_do_not_match_our_records'));
                        }
                    });
                }
            },
        },
    };
</script>
