<template>
    <div class="input-group">
        <input :type="visible ? 'text' : 'password'" class="form-control" v-model="value">
        <div class="input-group-addon" @click="visible = ! visible">
            <i
                class="fa"
                :class="{
                    'fa-eye-slash': ! visible,
                    'fa-eye': visible
                }"
            ></i>
        </div>
    </div>
</template>

<script>
    /**
     * @name passwordInput
     * @component password-input
     * @props
     *     value
     */
    export default {
        props: {
            value: {
                required: true,
            },
        },
        data() {
            return {
                visible: false,
            };
        },
    };
</script>
