<template>
    <modal v-ref:modal title="მალსახმობები" size="lg">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-6">
                    <table class="table table-kbd">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    ყველგან
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-right">
                                    <kbd>tab</kbd>
                                </td>
                                <td>
                                    შემდეგი ველი
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>esc</kbd>
                                </td>
                                <td>
                                    ველიდან ფოკუსის მოცილება
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>enter</kbd>
                                </td>
                                <td>
                                    შენახვა / გაგზავნა
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>u</kbd>
                                </td>
                                <td>
                                    გაუქმება
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table class="table table-kbd">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    სტუდენტები
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-right">
                                    <kbd>/</kbd>
                                </td>
                                <td>
                                    ძიება
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>
                                        <span class="fa fa-arrow-down"></span>
                                    </kbd>
                                </td>
                                <td>
                                    შემდეგი სტუდენტი
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>
                                        <span class="fa fa-arrow-up"></span>
                                    </kbd>
                                </td>
                                <td>
                                    წინა სტუდენტი
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>
                                        enter
                                    </kbd>
                                </td>
                                <td>
                                    სტუდენტის არჩევა
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>1</kbd>,
                                    <kbd>2</kbd>,
                                    <kbd>3</kbd> ...
                                </td>
                                <td>
                                    ფაკულტეტის არჩევა
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>o</kbd>
                                </td>
                                <td>
                                    ოპერაციები
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>c</kbd>
                                </td>
                                <td>
                                    ხელშეკრულების მონაცემები
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>f</kbd>
                                </td>
                                <td>
                                    კორექტირება
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>e</kbd>
                                </td>
                                <td>
                                    კონტრაქტის რედაქტირება
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <kbd>i</kbd>
                                </td>
                                <td>
                                    სტუდნეტის ინფოს გახსნა / დახურვა
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </modal>
</template>
<script>
    import hotKeyMixin from 'mixins/hotKeyMixin';

    /**
     * @name hotkeysModal
     * @component hotkeys-modal
     */
    export default {
        mixins: [
            hotKeyMixin(function(e) {
                const FORWARD_SLASH = 191

                if (e.keyCode === FORWARD_SLASH && e.shiftKey) {
                    this.$refs.modal.toggle();
                }
            }),
        ],
    };
</script>
