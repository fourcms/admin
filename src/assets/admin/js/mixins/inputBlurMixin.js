
const ESC = 27;

export default {
    created() {
        $('body').off('keyup.esc').on('keyup.esc', e => {
            if ((e.target.tagName === 'INPUT'|| e.target.tagName === 'TEXTAREA') && e.keyCode === ESC) {
                e.target.blur();
            }
        });
    },
    beforeDestroy() {
        $('body').off('keyup.esc');
    },
};
