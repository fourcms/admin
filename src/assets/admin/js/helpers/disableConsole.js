const debug = JSON.parse(document.querySelector('[name="app:debug"]').content);
if (! debug) {
    window.console.log = () => false;
    window.console.warn = () => false;
    window.console.error = () => false;
    window.console.table = () => false;
}
