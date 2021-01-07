// ADMIN AUTH
export const API_ADMIN_AUTH_LOGIN = 'admin/auth/login';
export const API_ADMIN_AUTH_REFRESH = 'admin/auth/refresh';
export const API_ADMIN_AUTH_ADMIN = 'admin/auth/admin';
export const API_ADMIN_AUTH_LOGOUT = 'admin/auth/logout';

// ADMIN SALES REPRESENTATIVES
export const API_ADMIN_REPRESENTATIVES_LIST = 'admin/sales-representatives';
export const API_ADMIN_REPRESENTATIVES_CREATE = 'admin/sales-representatives/create';
export const API_ADMIN_REPRESENTATIVES_CHECK_DELETED = 'admin/sales-representatives/check-deleted';
export const API_ADMIN_REPRESENTATIVES_CHECK_VALIDATED = 'admin/sales-representatives/check-validated';
export const API_ADMIN_REPRESENTATIVES_SHOW = 'admin/sales-representatives/show';
export const API_ADMIN_REPRESENTATIVES_UPDATE = 'admin/sales-representatives/update';
export const API_ADMIN_REPRESENTATIVES_RESET_PASSWORD = 'admin/sales-representatives/reset-password';
export const API_ADMIN_REPRESENTATIVES_DELETE = 'admin/sales-representatives/delete';

// ADMIN STORES
export const API_ADMIN_STORES_LIST = 'admin/stores';
export const API_ADMIN_STORES_GET_EMPLOYEE = 'admin/stores/get-employee';
export const API_ADMIN_STORES_CREATE = 'admin/stores/create';
export const API_ADMIN_STORES_CHECK_DELETED = 'admin/stores/check-deleted';
export const API_ADMIN_STORES_CHECK_VALIDATED = 'admin/stores/check-validated';
export const API_ADMIN_STORES_SHOW = 'admin/stores/show';
export const API_ADMIN_STORES_UPDATE = 'admin/stores/update';
export const API_ADMIN_STORES_UPDATE_LAST_LOGGED_IN = 'admin/stores/update-last-logged-in';
export const API_ADMIN_STORES_CANCEL_RESET_PASSWORD = 'admin/stores/cancel-reset-password';
export const API_ADMIN_STORES_RESET_PASSWORD = 'admin/stores/reset-password';
export const API_ADMIN_STORES_DELETE = 'admin/stores/delete';

// ADMIN MESSAGES
export const API_ADMIN_MESSAGES_GET_STORE = 'admin/messages/get-store';
export const API_ADMIN_MESSAGES_GET_MESSAGE = 'admin/messages/get-message';
export const API_ADMIN_MESSAGES_GET_MESSAGES = 'admin/messages/get-messages';


// SALE REPRESENTATIVE AUTH
export const API_REPRESENTATIVE_AUTH_LOGIN = 'representative/auth/login';
export const API_REPRESENTATIVE_AUTH_REFRESH = 'representative/auth/refresh';
export const API_REPRESENTATIVE_AUTH_REPRESENTATIVE = 'representative/auth/representative';
export const API_REPRESENTATIVE_AUTH_CHECK_DELETED = 'representative/auth/check-deleted';
export const API_REPRESENTATIVE_AUTH_LOGOUT = 'representative/auth/logout';
export const API_REPRESENTATIVE_AUTH_RESET_PASSWORD = 'representative/auth/reset-password';

// SALE REPRESENTATIVE SETTING
export const API_REPRESENTATIVE_SETTING_CHANGE_PASSWORD = 'representative/setting/change-password';
export const API_REPRESENTATIVE_SETTING_CHANGE_EMAIL = 'representative/setting/change-email';

// SALE REPRESENTATIVE MESSAGES
export const API_REPRESENTATIVE_MESSAGES_GET_STORES = 'representative/messages/get-stores';
export const API_REPRESENTATIVE_MESSAGES_GET_MESSAGE = 'representative/messages/get-message';
export const API_REPRESENTATIVE_MESSAGES_GET_MESSAGES = 'representative/messages/get-messages';
export const API_REPRESENTATIVE_MESSAGES_COUNT_UNREAD = 'representative/messages/count-unread';
export const API_REPRESENTATIVE_MESSAGES_MARK_SEEN = 'representative/messages/mark-seen';
export const API_REPRESENTATIVE_MESSAGES_SEND_MESSAGE = 'representative/messages/send-message';
export const API_REPRESENTATIVE_MESSAGES_EDIT_MESSAGE = 'representative/messages/edit-message';
export const API_REPRESENTATIVE_MESSAGES_SEND_TO_SUB_EMAILS = 'representative/messages/send-to-sub-emails';
export const API_REPRESENTATIVE_MESSAGES_DELETE_MESSAGE = 'representative/messages/delete-message';


// STORE AUTH
export const API_STORE_AUTH_LOGIN = 'store/auth/login';
export const API_STORE_AUTH_REFRESH = 'store/auth/refresh';
export const API_STORE_AUTH_STORE = 'store/auth/user';
export const API_STORE_AUTH_CHECK_DELETED = 'store/auth/check-deleted';
export const API_STORE_AUTH_LOGOUT = 'store/auth/logout';
export const API_STORE_AUTH_RESET_PASSWORD = 'store/auth/reset-password';

// STORE SETTING
export const API_STORE_SETTING_CHANGE_PASSWORD = 'store/setting/change-password';
export const API_STORE_SETTING_CHANGE_EMAIL = 'store/setting/change-email';

// STORE MESSAGES
export const API_STORE_MESSAGES_GET_EMPLOYEE = 'store/messages/get-employee';
export const API_STORE_MESSAGES_GET_STORE = 'store/messages/get-store';
export const API_STORE_MESSAGES_GET_MESSAGE = 'store/messages/get-message';
export const API_STORE_MESSAGES_GET_MESSAGES = 'store/messages/get-messages';
export const API_STORE_MESSAGES_COUNT_UNREAD = 'store/messages/count-unread';
export const API_STORE_MESSAGES_MARK_SEEN = 'store/messages/mark-seen';
export const API_STORE_MESSAGES_SEND_MESSAGE = 'store/messages/send-message';
export const API_STORE_MESSAGES_EDIT_MESSAGE = 'store/messages/edit-message';
export const API_STORE_MESSAGES_DELETE_MESSAGE = 'store/messages/delete-message';

// STORE CATALOG
export const API_STORE_GET_CATALOG_LIST = 'store/catalog/get-list';

// STORE PURCHASE HISTORY
export const API_STORE_PURCHASE_HISTORY_LIST = 'store/purchase-history';
export const API_STORE_PURCHASE_HISTORY_DETAIL = 'store/purchase-history/show';
export const API_STORE_PURCHASE_HISTORY_REORDER = 'store/purchase-history/reorder'