import _ from 'helpers/fp'

export default {
    methods: {
        cani(permission) {
            if (this.$root.user) {
                return Boolean(_.find(_.propSatisfies(_.glob(permission), 'name'), this.$root.user.permissions));
            }

            return false;
        },
    },
};
