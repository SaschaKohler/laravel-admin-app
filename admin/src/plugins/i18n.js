import i18n from '@/i18n';

/**
 * Date format
 */

['en', 'de'].forEach((locale) => {
    i18n.setDateTimeFormat(locale, {
        short: {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
        },
        long: {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            weekday: 'long',
        },
        time: {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
        },
    });
});

/**
 * Number format
 */
i18n.setNumberFormat('en', {
    currency: {
        style: 'currency',
        currency: 'USD',
    },
});
i18n.setNumberFormat('de', {
    currency: {
        style: 'currency',
        currency: 'EUR',
    },
});
