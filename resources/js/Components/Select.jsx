/**
 * Format dropdown data as select field options.
 *
 * @param {Array.<object|string>} data - The data to be formatted as dropdown options.
 * @param {string} [labelKey='value'] - The key used for the label in the dropdown options.
 * @param {string} [valueKey='id'] - The key used for the value in the dropdown options.
 * @returns {Array.<object>} The formatted dropdown options.
 */
export const dropdownOption = (data, labelKey = 'value', valueKey = 'id') => {
    if (!data?.length) return [];

    return data.map((item) => {
        if (typeof item === 'string') {
            return {
                label: item.toUpperCase().replace(/_/g, ' '),
                value: item,
            };
        }

        return {
            label: item[labelKey].toUpperCase().replace(/_/g, ' '),
            value: typeof item[valueKey] === 'number' ? item[valueKey].toString() : item[valueKey],
        };
    });
};
