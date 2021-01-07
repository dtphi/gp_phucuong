const unorm = require('unorm');

const { detectIE } = require('./ieDetection');

export default (items, prop, val) => {
    if (!val || val === '') {
        return items;
    }
    return items.filter(v => {
        if (detectIE()) {
            return (unorm.nfd(v[prop].toLowerCase())
                         .replace(/[\u0300-\u036f]/g, '')
                         .indexOf(unorm.nfd(val.toLowerCase()).replace(/[\u0300-\u036f]/g, '')) > -1);
        }
        return (v[prop].toLowerCase()
                       .normalize('NFD')
                       .replace(/[\u0300-\u036f]/g, '')
                       .indexOf(val.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '')) > -1);
    });
}
