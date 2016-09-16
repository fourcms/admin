
const SHIFT = 16;


export default {
    created() {
        $('body').off('keydown.shift').on('keydown.shift', e => {
            if (e.keyCode == SHIFT) {
                $('body').addClass('shift');
            }
        });
        $('body').off('keyup.shift').on('keyup.shift', e => {
            if (e.keyCode == SHIFT) {
                $('body').removeClass('shift');
            }
        });
    },
    beforeDestroy() {
        $('body').off('keydown.shift').off('keyup.shift');
    },
};
