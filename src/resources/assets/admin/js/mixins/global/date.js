import moment from 'moment';

export default {
    methods: {
        date(date, format='DD.MM.YYYY') {
            return date && moment(date).format(format);
        },
        dateTime(date, format='YYYY-MM-DD HH:mm:ss') {
            return date && moment(date).format(format);
        },
        humanDate(date, format='dddd, D MMMM YYYY') {
            return date && moment(date).format(format);
        },
        humanDateTime(date, format='dddd, D MMMM YYYY - HH:mm:ss') {
            return date && moment(date).format(format);
        },
        fromNow(date) {
            return date && moment(date).fromNow();
        },
    },
};
