<template>
    <textarea v-el:tinymce v-model="value"></textarea>
</template>

<script>
    import textInput from 'components/inputs/basicInputs/textInput';

    /**
     * @name tinymceInput
     * @component tinymce-input
     * @props
     *     value
     */
    export default {
        mixins: [textInput],
        ready() {
            tinyMCE.init({
                mode: 'exact',
                elements: [this.$els.tinymce],
                setup: ed => {
                    ed.on('change', e => {
                        this.value = ed.getContent();
                    });
                },
                theme: 'modern',
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
            });
        },
    };
</script>
