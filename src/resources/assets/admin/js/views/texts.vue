<template>
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-globe"></i> {{ t('texts') }}</h1>
            <!-- <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol> -->
        </section>
        <section class="content">
            <div class="nav-tabs-custom">
                <text-scope-input :value.sync="texts.params.scope"></text-scope-input>

                <div class="tab-content">
                    <div class="active tab-pane">
                        <div class="box box-default collapsed-box">
                            <div class="box-header with-border flex">
                                <text-input
                                    :value.sync="texts.params.search"
                                    :placeholder="t('search')"
                                    debounce="500"
                                    class="box-title-input"
                                ></text-input>
                                <div class="box-tools flex">
                                    <button type="button" class="btn btn-box-tool" :title="t('reset_search')" @click="texts.resetParams()">
                                        <i class="fa fa-eraser"></i>
                                    </button>
                                    <!--
                                    <button type="button" class="btn btn-box-tool" :title="t('expand_search_options')" data-widget="collapse">
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                     -->
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">

                                </div>
                            </div>
                        </div>
                        <loading :status="texts.loaded || texts.data">
                            <div class="box">
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th @click="sortBy('key')" class="pointer nowrap">
                                                    {{ t('key') }}
                                                    &nbsp;
                                                    <sort-icon
                                                        field="key"
                                                        :sort-by="texts.params.sortBy"
                                                        :sort-order="texts.params.sortOrder"
                                                    ></sort-icon>
                                                </th>
                                                <th v-for="lang in config.langs">
                                                    {{ t(lang) }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="items in texts.data" track-by="$index">
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $key }}</td>
                                                    <template v-for="lang in config.langs">
                                                        <td width="50%">
                                                            <div class="has-feedback">
                                                                <auto-grow-text-input
                                                                    :value.sync="items[lang].value"
                                                                    @input="change(items[lang])"
                                                                    @blur="update(items[lang])"
                                                                    @keyup.enter="update(items[lang])"
                                                                    class="input-xs"
                                                                ></auto-grow-text-input>
                                                                <i
                                                                    class="fa fa-ellipsis-h form-control-feedback clickable texts--open-in-popup"
                                                                    @click="openInPopup(items[lang])"
                                                                    v-if="hasPopup(items[lang])"
                                                                ></i>
                                                                <i
                                                                    v-show="items[lang].changed || items[lang].submitting"
                                                                    :class="{
                                                                        'fa-exclamation-triangle text-warning': items[lang].changed && ! items[lang].submitting,
                                                                        'fa-circle-o-notch fa-spin': items[lang].submitting && ! items[lang].changed,
                                                                    }"
                                                                    class="fa form-control-feedback"
                                                                ></i>
                                                            </div>
                                                        </td>
                                                    </template>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </loading>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <modal size="lg" :title="openItem.key" v-ref:popup>
        <div class="modal-body">
            <template v-if="openItem">
                <tinymce-input :value.sync="openItem.value" style="height: 500px"></tinymce-input>
            </template>
        </div>
        <div class="modal-footer">
            <button class="btn btn-default" @click="popupCancel">{{ t('cancel') }}</button>
            <button class="btn btn-primary" @click="popupSave">{{ t('save') }}</button>
        </div>
    </modal>
</template>
<script>
    import _ from 'helpers/fp';
    import Vue from 'vue';
    import sweetAlert from 'helpers/sweetAlert';
    import repository from 'repositories/textRepository';
    import {loading} from 'decorators/submit';

    /**
     * @name texts
     * @component texts
     */
    export default {
        created() {
            repository.list('texts', this);
        },
        data() {
            return {
                openItem: {},
            };
        },
        methods: {
            sortBy(field) {
                const values = ['', 'desc', 'asc'];
                this.texts.params.sortOrder = this.texts.params.sortBy == field ? _.nth(values.indexOf(this.texts.params.sortOrder) - 1, values) : 'asc';
                this.texts.params.sortBy = this.texts.params.sortOrder != '' ? field : '';
            },
            async update(item) {
                if (item.changed) {
                    try {
                        await loading(item, 'submitting', false, async () => {
                            const updatedItem = await repository.update(item);
                            this.texts.data[updatedItem.key][updatedItem.lang] = updatedItem;
                        });
                    } catch (err) {
                        console.error(err);
                        item.submitting = false;
                    }
                }
            },
            async change(item) {
                item.changed = true;
            },
            async openInPopup(item) {
                this.openItem = _.clone(item);

                this.$refs.popup.show();
            },
            popupCancel() {
                this.$refs.popup.hide();
            },
            popupSave() {
                this.texts.data[this.openItem.key][this.openItem.lang].value = this.openItem.value;

                this.openItem.changed = true;

                this.update(this.openItem);

                this.$refs.popup.hide();
            },
            hasPopup(item) {
                return item.key.endsWith('_html');
            },
            // async remove(item) {
            //     if (await sweetAlert(this.t('confirm_remove_text'))) {
            //         const index = this.texts.data.indexOf(item);
            //         const deletedItem = await textRepository.remove(item);
            //         this.texts.data.$set(index, deletedItem);
            //     }
            // },
            // async restore(item) {
            //     const index = this.texts.data.indexOf(item);
            //     const restoredItem = await textRepository.restore(item);
            //     this.texts.data.$set(index, restoredItem);
            // }
        },
    };
</script>
