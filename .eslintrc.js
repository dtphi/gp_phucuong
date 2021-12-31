
// https://eslint.vuejs.org/rules/no-side-effects-in-computed-properties.html
module.exports = {
    root: true,
    "env": {
        "es2021": true,
        "browser": true,
        "commonjs": true,
        "node": true
    },
    "extends": [
        "plugin:vue/essential",
        //"plugin:prettier/recommended",
        "eslint:recommended"
    ],
    "globals": {
        "process": true,
        "ion": true,
        "trans": true,
        "axios": true,
        "PropTypes": true,
        "Echo": true,
        "moment": true,
        "_": true,
        "$": true,
        "MM": true,
        "Item": true,
        "Status": true,
        "replace": true
    },
    "parserOptions": {
        "ecmaVersion": 13,
        "sourceType": "module"
    },
    "plugins": [
        "vue"
    ],
    "rules": {
        "indent": [
            "error",
            2
        ],
        "linebreak-style": [
            "error",
            "windows"
        ],
        "quotes": [
            "error",
            "single"
        ],
        "semi": [
            "error",
            "never"
        ],
        "space-in-parens": ["error", "never"],
        "space-before-function-paren": ["error", "never"],
        "space-before-blocks": ["error", { "functions": "always", "keywords": "always", "classes": "always" }],
        "computed-property-spacing": ["error", "never"],
        "comma-spacing": ["error", { "before": false, "after": true }],
        "comma-style": ["error", "last"],
        "comma-dangle": ["error", {"functions": "never", "objects": "always", "imports": "always"}],
        "newline-before-return": 2, // 0 = off, 1 = warn, 2 = error
        "object-curly-spacing": ["error", "always"], //  Rule 'space-in-brackets' was removed and replaced by: object-curly-spacing, array-bracket-spacing, computed-property-spacing  space-in-brackets
    }
};
// 1. Hàm, Computed component: Định nghĩa prefix `_` cộng tên hàm, ex: _{ten_ham}(), _{ten_computed}()
// 2. Hàm store: Định nghĩa trong /stores/*.js map vào component this[{ten_ham_map_action}]()
// 3. Tên module store, tên hàm, tên mutation, api path: Định nghĩa trong store/types. 
// 4. Biến tĩnh, text component: Định nghĩa trong đối tượng setting truy cập sử dụng this.$options.setting[ten_bien]
// 5. Global event bus: Định nghĩa trong api/utils/event-bus.js