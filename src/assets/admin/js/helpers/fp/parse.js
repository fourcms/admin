
export const parse = (json, defaultValue={}) => {
    try {
        return JSON.parse(json);
    } catch (err) {
        return defaultValue;
    }
}
