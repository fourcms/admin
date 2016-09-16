
const ENTER = 13;
const FOCUSABLES_SELECTORS = ['button:visible', ':input:visible', '[tabindex]:visible'];

function focusNextFocusable() {
    var focusables = $(FOCUSABLES_SELECTORS.join(', '));
    var index = focusables.index(document.activeElement) + 1;
    if (index >= focusables.length) {
        throw `Out of focusables`;
    }
    focusables.eq(index).focus();
}

export default {
    created() {
        $('body').off('keydown.enter').on('keydown.enter', e => {
            if (e.keyCode === ENTER) {
                if ($(e.target).is(FOCUSABLES_SELECTORS.join(':not(a, button, [input-enter-tab-off]), '))) {
                    e.preventDefault();
                    try {
                        focusNextFocusable();
                    } catch (err) {
                        e.target.blur();
                    }
                }
            }
        });
    },
    beforeDestroy() {
        $('body').off('keydown.enter');
    },
};
