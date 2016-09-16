<template>
    <div class="login-box">
        <div class="login-logo"><b>FOUR</b></div>
        <div class="login-box-body">
            <p class="login-box-msg">{{ t('authorization') }}</p>
            <form @submit="submit">
                <div class="form-group has-feedback">
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        v-model="email"
                        autocomplete="username"
                        :placeholder="t('email')"
                        v-focus-auto
                    >
                    <i class="fa fa-email form-control-feedback"></i>
                </div>
                <div class="form-group has-feedback">
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        v-model="password"
                        autocomplete="current-password"
                        :placeholder="t('password')"
                    >
                    <i class="fa fa-password form-control-feedback"></i>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <button
                                type="submit"
                                class="btn btn-primary btn-block btn-flat"
                                :class="{
                                     disabled: submitting || ! submitable
                                }"
                            >
                                {{ t('login') }}
                                <i v-show="submitting" class="fa fa-circle-o-notch fa-spin"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import bubble from 'helpers/bubble';
    import {loading} from 'decorators/submit';
    import auth from 'helpers/auth';

    /**
     * @name login
     * @component login
     */
    export default {
        data() {
            return {
                email: '',
                password: '',
            };
        },
        computed: {
            submitable() {
                return (this.email && this.password);
            },
        },
        methods: {
            async submit(e) {
                e.preventDefault();
                if ( ! this.submitable) return;

                await loading(this, 'submitting', false, async () => {
                    await auth.login(this.email, this.password);
                    auth.redirectFromLogin();
                });
            },
        },
    };
</script>
