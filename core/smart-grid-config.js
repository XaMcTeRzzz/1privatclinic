var smartGridConfig = require('smart-grid');

/* It's principal settings in smart grid project */
var settings = {
    filename: 'smart-grid', /* default smart-grid */
    outputStyle: 'scss', /* less || scss || sass || styl */
    offset: '30px', /* gutter width px || % || rem */
    mobileFirst: true, /* mobileFirst ? 'min-width' : 'max-width' */
    container: {
        maxWidth: '1455px', /* max-width оn very large screen */
        fields: '15px' /* side fields */
    },
    breakPoints: {
        lg: {
            width: '1200px', /* -> @media (max-width: 1100px) */
        },
        md: {
            width: '992px',
        },
        sm: {
            width: '768px',
            fields: '30px' /* set fields only if you want to change container.fields */
        },
        xs: {
            width: '576px'
        },
        xxs: {
            width: '360px'
        }
    }
};

smartGridConfig('./scss/utils', settings);