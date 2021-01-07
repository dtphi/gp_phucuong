<template>
    <div v-show="(isMobile && !showRoomsList) || !isMobile || singleRoom" class="col-messages">
        <div class="room-header app-border-b">
            <div class="room-wrapper py-2">
                <div v-if="!singleRoom"
                     class="svg-button toggle-button"
                     :class="{ 'rotate-icon': !showRoomsList }"
                     @click="$emit('toggleRoomsList')">
                    <svg-icon name="toggle"></svg-icon>
                </div>

                <div class="info-wrapper" :class="{ 'item-clickable': roomInfo }" @click="$emit('roomInfo', room)">
                    <div v-if="room.avatar"
                         class="room-avatar"
                         :style="{ 'background-image': `url('${room.avatar}')` }"></div>

                    <div class="text-ellipsis">
                        <div class="room-name text-ellipsis">{{ room.roomName }}</div>
                        <div v-if="typingUsers" class="room-info text-ellipsis">
                            {{ typingUsers }} {{ textMessages.IS_TYPING }}
                        </div>
                        <div v-else class="room-info text-ellipsis">
                            {{ userStatus }}
                        </div>
                    </div>
                </div>

                <div class="func-btn">
                    <b-dropdown v-if="viewer === 'store'" right class="white-btn-custom mr-2 font-weight-bold">
                        <template #button-content>
                            <i class="fas fa-user-tie"></i>
                            <span>担当者</span>
                        </template>
                        <template v-if="sale">
                            <b-dropdown-text>
                                <b @click="toggleClass" style="cursor: pointer;">担当者</b>
                                <span @click="toggleClass">{{ sale.full_name }}</span>
                            </b-dropdown-text>
                            <b-dropdown-text>
                                <b @click="toggleClass" style="cursor: pointer;">フリガナ</b>
                                <span @click="toggleClass">{{ sale.full_name_kana }}</span>
                            </b-dropdown-text>
                            <b-dropdown-text>
                                <b>TEL</b>
                                <span><a :href="'tel:' + sale.phone_number" >{{ sale.phone_number }}</a></span>
                            </b-dropdown-text>
                        </template>
                    </b-dropdown>

                    <b-dropdown v-if="viewer === 'sale'" right class="white-btn-custom mr-2 font-weight-bold">
                        <template #button-content>
                            <i class="fas fa-user-tie"></i>
                            <span>販売店</span>
                        </template>
                        <template v-if="room.store">
                            <b-dropdown-text>
                                <b>販売店コード</b>
                                <span>{{ room.store.code }}</span>
                            </b-dropdown-text>
                            <b-dropdown-text v-if="room.store.rep_full_name">
                                <b @click="toggleClass" style="cursor: pointer;">代表者名</b>
                                <span @click="toggleClass">{{ room.store.rep_full_name }}</span>
                            </b-dropdown-text>
                            <b-dropdown-text v-if="room.store.rep_full_name_kana">
                                <b @click="toggleClass" style="cursor: pointer;">フリガナ</b>
                                <span @click="toggleClass">{{ room.store.rep_full_name_kana }}</span>
                            </b-dropdown-text>
                            <b-dropdown-text>
                                <b>電話番号</b>
                                <span><a :href="'tel:' + room.store.phone_number" >{{ room.store.phone_number }}</a></span>
                            </b-dropdown-text>
                            <b-dropdown-text v-if="room.store.fax_number">
                                <b>FAX</b>
                                <span><a :href="'tel:' + room.store.fax_number" >{{ room.store.fax_number }}</a></span>
                            </b-dropdown-text>
                            <b-dropdown-text v-if="room.store.main_email">
                                <b @click="toggleClass" style="cursor: pointer;">メールアドレス</b>
                                <span @click="toggleClass"><a :href="'mailto:' + room.store.main_email" >{{ room.store.main_email }}</a></span>
                            </b-dropdown-text>
                            <b-dropdown-text>
                                <b @click="toggleClass" style="cursor: pointer;">住所</b>
                                <span @click="toggleClass">{{ room.store.address }}</span>
                            </b-dropdown-text>
                        </template>
                    </b-dropdown>

                    <button class="btn white-btn-custom mr-2 mb-sm-0 font-weight-bold" :disabled="isLoading || loadingMessages" @click="onRefresh">
                        <i class="fas fa-sync-alt"></i>
                        <span>更新</span>
                    </button>

                    <button class="btn white-btn-custom mb-sm-0 font-weight-bold" :class="{ active: search.isSearch }" @click="onCancel(!search.isSearch)">
                        <i class="fas fa-search"></i>
                        <span>検索</span>
                    </button>
                </div>
            </div>

            <div v-if="viewer === 'admin'" class="room-nav">
                <nav class="navbar navbar-expand-lg navbar-light message-nav py-0">
                    <ul class="navbar-nav mr-auto font-weight-bold w-100">
                        <li class="nav-item">
                            <a class="nav-link text-grey01 pl-0">販売店コード: {{ store.code }}</a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link text-grey01">|</a>
                        </li>
                        <li>
                            <b-dropdown id="dropdown-text" text="もっと見る">
                                <b-dropdown-text>
                                    <b>販売店コード</b>
                                    <span>{{ store.code }}</span>
                                </b-dropdown-text>
                                <b-dropdown-text v-if="store.rep_full_name">
                                    <b @click="toggleClass" style="cursor: pointer;">代表者名</b>
                                    <span @click="toggleClass">{{ store.rep_full_name }}</span>
                                </b-dropdown-text>
                                <b-dropdown-text v-if="store.rep_full_name_kana">
                                    <b @click="toggleClass" style="cursor: pointer;">フリガナ</b>
                                    <span @click="toggleClass">{{ store.rep_full_name_kana }}</span>
                                </b-dropdown-text>
                                <b-dropdown-text>
                                    <b>電話番号</b>
                                    <span><a :href="'tel:' + store.phone_number" >{{ store.phone_number }}</a></span>
                                </b-dropdown-text>
                                <b-dropdown-text v-if="store.fax_number">
                                    <b>FAX</b>
                                    <span><a :href="'tel:' + store.fax_number" >{{ store.fax_number }}</a></span>
                                </b-dropdown-text>
                                <b-dropdown-text v-if="store.main_email">
                                    <b @click="toggleClass" style="cursor: pointer;">メールアドレス</b>
                                    <span @click="toggleClass"><a :href="'mailto:' + store.main_email" >{{ store.main_email }}</a></span>
                                </b-dropdown-text>
                                <b-dropdown-text>
                                    <b @click="toggleClass" style="cursor: pointer;">住所</b>
                                    <span @click="toggleClass">{{ store.address }}</span>
                                </b-dropdown-text>
                            </b-dropdown>
                        </li>
                    </ul>
                </nav>

                <div v-if="menuActions.length" class="svg-button room-options" @click="menuOpened = !menuOpened">
                    <svg-icon name="menu"></svg-icon>
                </div>

                <transition v-if="menuActions.length" name="slide-left">
                    <div v-if="menuOpened" v-click-outside="closeMenu" class="menu-options">
                        <div class="menu-list">
                            <div v-for="action in menuActions" :key="action.name">
                                <div class="menu-item" @click="menuActionHandler(action)">
                                    {{ action.title }}
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>

            <div v-if="search.isSearch" class="col-lg-11 col-xl-10 py-2 m-auto">
                <div class="row mx-2 border rouded msg-search">
                    <span class="col-1 p-0 msg-search-icon">
                        <i class="fas fa-search"></i>
                    </span>

                    <input type="text"
                           v-model="search.content"
                           class="form-control col-10 col-sm-11 col-lg-6 col-xl-7 border-0 outline-none box-shadow-none"
                           @keydown.enter="onSearch" />
                    <div class="col-12 d-lg-none border-top"></div>
                    <div class="msg-search-option col-12 col-lg-5 col-xl-4 text-grey border-lg-left d-flex justify-content-end pl-0">
                        <div><span>{{ search.current }}</span>/<span>{{ search.total }}</span></div>
                        <div>
                            <a href="javascript:void(0);" class="px-1" v-bind:class="getClassPrev" @click="onPrev">
                                <i class="fas fa-chevron-up"></i>
                            </a>
                            <a href="javascript:void(0);" class="px-1" v-bind:class="getClassNext" @click="onNext">
                                <i class="fas fa-chevron-down"></i>
                            </a>
                        </div>
                        <div><a href="javascript:void(0);" class="text-grey01" @click="onCancel(true)">キャンセル</a></div>
                    </div>
                </div>
            </div>
        </div>

        <div ref="scrollContainer"
             class="container-scroll"
             :class="{ 'admin-container-scroll': viewer === 'admin', active: search.isSearch }">
            <loader :show="loadingMessages"></loader>

            <div class="messages-container">
                <div :class="{ 'messages-hidden': loadingMessages }">
                    <transition name="fade-message">
                        <div v-if="showNoMessages" class="text-started">
                            {{ textMessages.MESSAGES_EMPTY }}
                        </div>
                        <div v-if="showMessagesStarted" class="text-started">
                            {{ textMessages.CONVERSATION_STARTED }} {{ messages[0].date }}
                        </div>
                    </transition>

                    <transition name="fade-message">
                        <infinite-loading ref="infiniteLoading"
                                          direction="top"
                                          spinner="spiral"
                                          @infinite="infiniteHandler">
                            <div slot="spinner">
                                <loader :infinite="true" :show="true"></loader>
                            </div>
                            <div slot="no-results"></div>
                            <div slot="no-more"></div>
                        </infinite-loading>
                    </transition>

                    <transition-group name="fade-message">
                        <div v-for="(message, i) in messages" :key="message._id">
                            <message :current-user-id="currentUserId"
                                     :edited-message="editedMessage"
                                     :emojis-list="emojisList"
                                     :filter-key="search.content"
                                     :hide-options="hideOptions"
                                     :index="i"
                                     :message="message"
                                     :message-actions="messageActions"
                                     :messages="messages"
                                     :new-messages="newMessages"
                                     :room-footer-ref="$refs.roomFooter"
                                     :room-users="room.users"
                                     :show-new-messages-divider="showNewMessagesDivider"
                                     :show-reaction-emojis="showReactionEmojis"
                                     :text-formatting="textFormatting"
                                     :text-messages="textMessages"
                                     :viewer="viewer"
                                     @addNewMessage="addNewMessage"
                                     @hideOptions="hideOptions = $event"
                                     @messageActionHandler="messageActionHandler"
                                     @openFile="openFile"
                                     @sendMessageReaction="sendMessageReaction"></message>
                        </div>
                    </transition-group>
                </div>
            </div>
        </div>

        <div v-if="!loadingMessages">
            <transition name="bounce">
                <div v-if="scrollIcon" class="icon-scroll" @click="scrollToBottom">
                    <svg-icon name="dropdown" param="scroll"></svg-icon>
                </div>
            </transition>
        </div>

        <div ref="roomFooter" v-if="Object.keys(room).length && viewer !== 'admin'" class="room-footer">
            <transition name="slide-up">
                <div v-if="messageReply" class="reply-container">
                    <div class="reply-box">
                        <template v-if="messageReply.images.length" v-for="(image, i) in messageReply.images">
                            <img class="image-reply" :src="image.url" :key="i" />
                        </template>
                        <div class="reply-info">
                            <div class="reply-username">{{ messageReply.username }}</div>
                            <div class="reply-content">{{ messageReply.content }}</div>
                        </div>
                    </div>

                    <div class="icon-reply">
                        <div class="svg-button" @click="resetMessage">
                            <svg-icon name="close-outline"></svg-icon>
                        </div>
                    </div>
                </div>
            </transition>

            <div class="box-footer">
                <div v-if="showFixedPhraseArea" class="fixed-phrase-container">
                    <p @click="sendFixedPhrase('ありがとうございます。')">ありがとうございます。</p>
                    <p @click="sendFixedPhrase('メッセージ確認致しました。')">メッセージ確認致しました。</p>
                    <p @click="sendFixedPhrase('メッセージの件、了解致しました。')">メッセージの件、了解致しました。</p>
                    <p @click="sendFixedPhrase('後ほどご連絡致します。')">後ほどご連絡致します。</p>
                    <p @click="sendFixedPhrase('明日、ご連絡致します。')">明日、ご連絡致します。</p>
                </div>

                <div v-if="imageFiles.length" class="image-container">
                    <div v-for="(image, i) in imageFiles" :key="i">
                        <div class="svg-button icon-image" @click="removeImage(i)">
                            <svg-icon name="close" param="image"></svg-icon>
                        </div>
                        <div class="image-file">
                            <img :src="image.url" />
                        </div>
                    </div>
                    <b-button v-if="imageFiles.length < 10" @click="launchImagesPicker(true)">+</b-button>
                </div>

                <div class="box-footer-row" :class="{ 'long_btn': showFixedPhrase && viewer === 'sale' }">
                    <div v-if="file" class="file-container" :class="{ 'file-container-edit': editedMessage._id }">
                        <div class="icon-file">
                            <svg-icon name="file"></svg-icon>
                        </div>
                        <div class="file-message">{{ message }}</div>
                        <div class="svg-button icon-remove" @click="resetMessage(null, true)">
                            <svg-icon name="close"></svg-icon>
                        </div>
                    </div>
                    <textarea ref="roomTextarea"
                              v-else
                              v-model="message"
                              maxlength="200"
                              :placeholder="textMessages.TYPE_MESSAGE"
                              :class="{ 'textarea-outline': editedMessage._id, 'disabled': file }"
                              @input="onChangeInput"
                              @keydown.esc="resetMessage"></textarea>

                    <div class="icon-textarea">
                        <div v-if="editedMessage._id" class="svg-button" @click="resetMessage">
                            <svg-icon name="close-outline"></svg-icon>
                        </div>

                        <emoji-picker v-if="showEmojis && (!file || imageFiles.length)"
                                      :emoji-opened="emojiOpened"
                                      :position-top="true"
                                      @addEmoji="addEmoji"
                                      @openEmoji="emojiOpened = $event"></emoji-picker>

                        <div v-if="showFixedPhrase && viewer === 'sale'" class="svg-button" :class="{ 'disabled': !enableFixedPhraseInput }" @click="launchFixedPhraseInput">
                            <svg-icon name="phrase" :param="!enableFixedPhraseInput ? 'disabled' : ''"></svg-icon>
                        </div>

                        <div v-if="showImages" class="svg-button" :class="{ 'disabled': !enableImagesInput }" @click="launchImagesPicker(false)">
                            <svg-icon name="image" :param="!enableImagesInput ? 'disabled' : ''"></svg-icon>
                        </div>

                        <form>
                            <input ref="images"
                                   type="file"
                                   accept="image/*"
                                   multiple
                                   style="display: none;"
                                   @change="onImagesChange($event.target.files)" />
                        </form>

                        <div v-if="showFile" class="svg-button" :class="{ 'disabled': !enableFileInput }" @click="launchFilePicker">
                            <svg-icon name="file" :param="!enableFileInput ? 'disabled' : ''"></svg-icon>
                        </div>

                        <form>
                            <input ref="file"
                                   type="file"
                                   accept=".pdf"
                                   style="display: none;"
                                   @change="onFileChange($event.target.files)" />
                        </form>

                        <div class="svg-button" :class="{ 'send-disabled': inputDisabled }" @click="sendMessage">
                            <svg-icon name="send" :param="inputDisabled ? 'disabled' : ''"></svg-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ModalAlert :title="modals.alert.title" :message="modals.alert.message"></ModalAlert>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    import vClickOutside from 'v-click-outside';
    import emojis from 'vue-emoji-picker/src/emojis';
    import InfiniteLoading from 'vue-infinite-loading';
    import ModalAlert from '../../modals/ModalAlert';
    import EmojiPicker from './EmojiPicker';
    import Loader from './Loader';
    import Message from './Message';
    import SvgIcon from './SvgIcon';

    const { detectIE } = require('../utils/ieDetection');
    const { detectMobile } = require('../utils/mobileDetection');
    const { messagesValid } = require('../utils/roomValidation');

    export default {
        name: 'room',
        components: {
            InfiniteLoading,
            ModalAlert,
            EmojiPicker,
            Loader,
            Message,
            SvgIcon
        },
        directives: {
            clickOutside: vClickOutside.directive
        },
        props: {
            currentUserId: {
                type: [ String, Number ],
                required: true
            },
            isMobile: {
                type: Boolean,
                required: true
            },
            loadingRooms: {
                type: Boolean,
                required: true
            },
            menuActions: {
                type: Array,
                required: true
            },
            messageActions: {
                type: Array,
                required: true
            },
            roomId: {
                type: [ String, Number ],
                required: true
            },
            roomInfo: { type: Function },
            roomMessage: { type: String },
            rooms: {
                type: Array,
                required: true
            },
            sale: {
                default: () => ({}),
                type: Object
            },
            showEmojis: {
                type: Boolean,
                required: true
            },
            showFile: {
                type: Boolean,
                required: true
            },
            showFixedPhrase: {
                type: Boolean,
                required: true
            },
            showImages: {
                type: Boolean,
                required: true
            },
            showNewMessagesDivider: {
                type: Boolean,
                required: true
            },
            showReactionEmojis: {
                type: Boolean,
                required: true
            },
            showRoomsList: {
                type: Boolean,
                required: true
            },
            singleRoom: {
                type: Boolean,
                required: true
            },
            store: {
                default: () => ({}),
                type: Object
            },
            textFormatting: {
                type: Boolean,
                required: true
            },
            textMessages: {
                type: Object,
                required: true
            },
            viewer: {
                default: 'sale',
                type: String
            }
        },
        data() {
            return {
                editedMessage: {},
                emojisList: {},
                emojiOpened: false,
                enableFileInput: true,
                enableFixedPhraseInput: true,
                enableImagesInput: true,
                file: null,
                hideOptions: true,
                imageFiles: [],
                infiniteState: null,
                isAddMoreImage: false,
                loadingMessages: false,
                message: '',
                messages: [],
                menuOpened: false,
                messageReply: null,
                modals: {
                    alert: {
                        title: '',
                        message: ''
                    }
                },
                newMessages: [],
                scrollIcon: false,
                search: {
                    content: '',
                    current: 0,
                    difference: 0,
                    isSearch: false,
                    searchedMessages: [],
                    total: 0
                },
                showFixedPhraseArea: false,
                scrollEndTid: null
            };
        },
        mounted() {
            this.newMessages = [];

            this.$refs.scrollContainer.addEventListener('scroll', e => {
                this.hideOptions = true;

                setTimeout(() => {
                    if (!e.target) {
                        return;
                    }
                    this.scrollIcon = e.target.scrollHeight > 500 && e.target.scrollHeight - e.target.scrollTop > 1000;
                }, 200);
            });

            const emojisTable = Object.keys(emojis).map(key => emojis[key]);

            this.emojisList = Object.assign({}, ...emojisTable);
        },
        watch: {
            loadingMessages(val) {
                if (!val) {
                    this.focusTextarea(true);
                }
            },
            messages(newVal, oldVal) {
                newVal.forEach(message => {
                    if (!messagesValid(message)) {
                        throw 'Messages object is not valid! Must contain _id[String, Number], content[String, Number] and sender_id[String, Number]';
                    }
                });

                if (this.search.isSearch && this.search.content !== '') {
                    setTimeout(() => {
                        this.search.searchedMessages = $(this.$refs.scrollContainer).find('div.message-box .search-target');
                        this.search.total = this.search.searchedMessages.length;
                        this.search.current = this.search.total - this.search.difference;

                        if (this.search.current < 1) {
                            this.search.current = 0;
                        }
                        this.search.searchedMessages.addClass('highlight').removeClass('current');

                        const target = this.search.searchedMessages[this.search.current - 1];

                        $(target).addClass('current');
                    }, 500);
                }
            },
            room(newVal, oldVal) {
                if (newVal.roomId && newVal.roomId !== oldVal.roomId) {
                    this.loadingMessages = true;
                    this.scrollIcon = false;

                    this.resetMessage(true);
                    this.onCancel(false);

                    if (this.roomMessage) {
                        this.message = this.roomMessage;

                        setTimeout(() => this.onChangeInput(), 0);
                    }
                    this.loadingMessages = true;
                    this.messages = [];
                    this.$nextTick(() => {
                        this.$refs.infiniteLoading.stateChanger.reset();
                    });
                }
            },
            'search.content'(newVal, oldVal) {
                if (newVal === '') {
                    this.onCancel(true);
                }
            }
        },
        computed: {
            inputDisabled() {
                return this.isMessageEmpty() || this.checkImagesSize();
            },
            room() {
                return this.rooms.find(room => room.roomId === this.roomId) || {};
            },
            showMessagesStarted() {
                return this.messages.length;
            },
            showNoMessages() {
                return this.room.roomId && !this.messages.length && !this.loadingMessages && !this.loadingRooms;
            },
            typingUsers() {
                if (!this.room.typingUsers || !this.room.typingUsers.length) {
                    return;
                }
                const typingUsers = this.room.users.filter(user => {
                    if (user._id === this.currentUserId) {
                        return;
                    }
                    if (this.room.typingUsers.indexOf(user._id) === -1) {
                        return;
                    }
                    if (user.status && user.status.state === 'offline') {
                        return;
                    }
                    return true;
                });
                return typingUsers.map(user => user.username).join(', ');
            },
            userStatus() {
                if (!this.room.users || this.room.users.length !== 2) {
                    return;
                }
                const user = this.room.users.find(u => u._id !== this.currentUserId);

                if (!user.status) {
                    return;
                }
                let text = '';

                if (user.status.state === 'online') {
                    text = this.textMessages.IS_ONLINE;
                } else if (user.status.last_changed) {
                    text = this.textMessages.LAST_SEEN + user.status.last_changed;
                }
                return text;
            },
            getClassPrev() {
                const condition = 1 < this.search.current && this.search.current <= this.search.total;

                return {
                    'text-grey': condition,
                    'text-grey01': !condition
                };
            },
            getClassNext() {
                const condition = this.search.current === this.search.total;

                return {
                    'text-grey': !condition,
                    'text-grey01': condition
                };
            }
        },
        methods: {
            ...mapActions('admin.messages', { adminGetMessages: 'getMessages' }),
            ...mapActions('representative.auth', { saleCheckDeleted: 'checkDeleted' }),
            ...mapActions('representative.messages', {
                saleGetMessages: 'getMessages',
                saleMarkSeen: 'markSeen',
                saleCountUnread: 'countUnread'
            }),
            ...mapActions('store.auth', { storeCheckDeleted: 'checkDeleted' }),
            ...mapActions('store.messages', {
                storeGetMessages: 'getMessages',
                storeMarkSeen: 'markSeen',
                storeCountUnread: 'countUnread'
            }),
            addEmoji(emoji) {
                this.message += emoji.icon;

                this.focusTextarea(true);
            },
            addNewMessage(message) {
                this.newMessages.push(message);
            },
            checkImagesSize() {
                let totalSize = 0;

                for (let image of this.imageFiles) {
                    totalSize += image.image.size;
                }
                return this.convertToMB(totalSize) > 10;
            },
            closeMenu() {
                this.menuOpened = false;
            },
            editMessage(message) {
                this.resetMessage();

                this.editedMessage = { ...message };
                this.file = message.file;
                this.imageFiles = message.images;
                this.message = message.content;

                setTimeout(() => this.resizeTextarea(), 0);
            },
            focusTextarea(disableMobileFocus) {
                if (detectMobile() && disableMobileFocus) {
                    return;
                }
                if (!this.$refs['roomTextarea']) {
                    return;
                }
                this.$refs['roomTextarea'].focus();
            },
            isImageCheck(file) {
                if (!file) {
                    return;
                }
                const imageTypes = [
                    'image/apng',
                    'image/bmp',
                    'image/gif',
                    'image/jpg',
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/svg+xml',
                    'image/tiff',
                    'image/webp',
                    'image/x-icon'
                ];
                const { type } = file;

                return imageTypes.some(t => type.toLowerCase().includes(t));
            },
            isMessageEmpty() {
                return !this.file && !this.imageFiles.length && !this.message.trim();
            },
            launchFixedPhraseInput() {
                if (!this.enableFileInput || !this.enableImagesInput) {
                    return false;
                }
                this.showFixedPhraseArea = !this.showFixedPhraseArea
            },
            launchFilePicker() {
                if (!this.enableFileInput) {
                    return false;
                }
                if (detectIE()) {
                    $(this.$refs.file).closest('form').trigger('reset');
                } else {
                    this.$refs.file.value = '';
                }
                this.$refs.file.click();
            },
            launchImagesPicker(isAddMore) {
                if (!this.enableImagesInput && !isAddMore) {
                    return false;
                }
                this.isAddMoreImage = isAddMore;

                if (detectIE()) {
                    $(this.$refs.images).closest('form').trigger('reset');
                } else {
                    this.$refs.images.value = '';
                }
                this.$refs.images.click();
            },
            async infiniteHandler(infiniteState) {
                this.infiniteState = infiniteState;
                this.loadingMessages = true;

                this.fetchMessages();
            },
            menuActionHandler(action) {
                this.closeMenu();

                this.$emit('menuActionHandler', action);
            },
            messageActionHandler({ action, message }) {
                switch (action.name) {
                    case 'replyMessage':
                        return this.replyMessage(message);
                    case 'editMessage':
                        return this.editMessage(message);
                    case 'deleteMessage':
                        return this.$emit('deleteMessage', message._id);
                    default:
                        return this.$emit('messageActionHandler', {
                            action,
                            message
                        });
                }
            },
            onChangeInput() {
                this.resizeTextarea();

                this.$emit('typingMessage', this.message);
            },
            async onFileChange(files) {
                this.resetImagesFile();

                const file = files[0];

                if (files.length !== 1 || file.type !== 'application/pdf') {
                    this.modals.alert = {
                        title: 'エラー',
                        message: '送信できるファイルはPDFファイルのみです。'
                    };
                    this.$bvModal.show('modal-alert');

                    return false;
                }
                if (this.convertToMB(file.size) > 10) {
                    this.modals.alert = {
                        title: 'エラー',
                        message: 'サイズが大きすぎます。一度に送信できるファイルサイズは最大10MBです。'
                    };
                    this.$bvModal.show('modal-alert');

                    return false;
                }
                this.file = {
                    file,
                    name: file.name
                };
                this.message = file.name;
                this.enableFileInput = false;
                this.enableFixedPhraseInput = false;
                this.enableImagesInput = false;
                this.showFixedPhraseArea = false;
            },
            async onImagesChange(images) {
                if (!this.isAddMoreImage) {
                    this.resetImagesFile();
                }
                this.showFixedPhraseArea = false;
                let isError = false;

                if (images.length > 10 || this.imageFiles.length + images.length > 10) {
                    this.modals.alert = {
                        title: 'エラー',
                        message: '一度に送信できる画像枚数は最大10枚です。'
                    };
                    this.$bvModal.show('modal-alert');

                    return false;
                }
                for (let image of images) {
                    if (this.isImageCheck({ type: image.type })) {
                        const imageURL = URL.createObjectURL(image);

                        this.imageFiles.push({
                            image,
                            url: imageURL
                        });
                    } else {
                        isError = true;
                        break;
                    }
                }
                if (isError) {
                    this.modals.alert = {
                        title: 'エラー',
                        message: '画像を選択してください。'
                    };
                    this.$bvModal.show('modal-alert');

                    return false;
                }
                this.enableFixedPhraseInput = false;
                this.enableImagesInput = false;

                if (this.checkImagesSize()) {
                    this.modals.alert = {
                        title: 'エラー',
                        message: 'サイズが大きすぎます。一度に送信できる画像サイズは合わせて最大10MBです。'
                    };
                    this.$bvModal.show('modal-alert');

                    return false;
                }
            },
            async onRefresh() {
                const currentUserId = this.currentUserId.toString();
                let status = 200;

                switch (this.viewer) {
                    case 'sale':
                        status = await this.saleCheckDeleted(currentUserId.replace('sale-', ''));
                        break;
                    case 'store':
                        status = await this.storeCheckDeleted(currentUserId.replace('store-', ''));
                        break;
                }
                switch (true) {
                    case status === 200:
                        this.$emit('fetchRooms');
                        break;
                    case status === 410 && this.viewer === 'sale':
                        this.modals.alert = {
                            title: 'アカウント削除',
                            message: 'この営業担当者は既に削除されています。'
                        };
                        this.$bvModal.show('modal-alert');
                        break;
                    case status === 410 && this.viewer === 'store':
                        this.modals.alert = {
                            title: 'アカウント削除',
                            message: 'この販売店は既に削除されています。'
                        };
                        this.$bvModal.show('modal-alert');
                        break;
                }
            },
            openFile({ message, action, image }) {
                this.$emit('openFile', {
                    action,
                    message,
                    image
                });
            },
            removeImage(index) {
                this.imageFiles.splice(index, 1);

                if (!this.imageFiles.length) {
                    this.resetImagesFile();
                }
            },
            replyMessage(message) {
                this.resetMessage();

                this.messageReply = message;
            },
            resetImagesFile() {
                this.editedMessage.file = null;
                this.file = null;
                this.imageFiles = [];
                this.enableFileInput = true;
                this.enableFixedPhraseInput = true;
                this.enableImagesInput = true;
                this.showFixedPhraseArea = false;

                this.focusTextarea();
            },
            resetMessage(disableMobileFocus = null, editFile = null) {
                this.$emit('typingMessage', null);

                if (editFile) {
                    this.file = null;
                    this.imageFiles = [];
                    this.message = '';
                    this.enableFileInput = true;
                    this.enableFixedPhraseInput = true;
                    this.enableImagesInput = true;
                    this.showFixedPhraseArea = false;

                    return;
                }
                this.resetTextareaSize();

                this.editedMessage = {};
                this.emojiOpened = false;
                this.file = null;
                this.imageFiles = [];
                this.message = '';
                this.messageReply = null;
                this.enableFileInput = true;
                this.enableFixedPhraseInput = true;
                this.enableImagesInput = true;
                this.showFixedPhraseArea = false;

                setTimeout(() => this.focusTextarea(disableMobileFocus), 0);
            },
            resetTextareaSize() {
                if (!this.$refs['roomTextarea']) {
                    return;
                }
                this.$refs['roomTextarea'].style.height = '20px';
            },
            resizeTextarea() {
                const el = this.$refs['roomTextarea'];

                if (!el) {
                    return;
                }
                const padding = window.getComputedStyle(el, null).getPropertyValue('padding-top').replace('px', '');

                el.style.height = 0;
                el.style.height = el.scrollHeight - padding * 2 + 'px';
            },
            scrollToBottom() {
                const element = this.$refs.scrollContainer;
                element.scrollTop = element.scrollHeight;
            },
            sendFixedPhrase(phrase) {
                this.$emit('sendMessage', {
                    content: phrase,
                    file: this.file,
                    images: this.imageFiles,
                    replyMessage: this.messageReply
                });
                this.resetMessage(true);
            },
            sendMessage() {
                if (!this.file && !this.imageFiles.length && !this.message.trim() || this.isMessageEmpty() || this.checkImagesSize()) {
                    return;
                }

                if (this.editedMessage._id) {
                    if (this.editedMessage.content !== this.message || this.file) {
                        this.$emit('editMessage', {
                            file: this.file,
                            images: this.imageFiles,
                            messageId: this.editedMessage._id,
                            newContent: this.message,
                            replyMessage: this.messageReply
                        });
                    }
                } else {
                    this.$emit('sendMessage', {
                        content: this.message,
                        file: this.file,
                        images: this.imageFiles,
                        replyMessage: this.messageReply
                    });
                }
                this.resetMessage(true);
            },
            sendMessageReaction(messageReaction) {
                this.$emit('sendMessageReaction', messageReaction);
            },
            onSearch() {
                if (!this.search.content) {
                    this.onCancel(true);

                    return false;
                }
                setTimeout(() => {
                    this.search.searchedMessages = $(this.$refs.scrollContainer).find('div.message-box .search-target');
                    this.search.current = this.search.total = this.search.searchedMessages.length;

                    if (this.search.total > 0) {
                        this.search.searchedMessages.addClass('highlight').removeClass('current');

                        const target = this.search.searchedMessages[this.search.total - 1];

                        $(target).addClass('current');
                        $(this.$refs.scrollContainer).find('div.message-box span.search-target.highlight.current')[0].scrollIntoView();

                        this.search.difference = 0;
                    }
                }, 1000);
            },
            onPrev() {
                if (this.search.current > 1) {
                    $(this.$refs.scrollContainer).find('div.message-box .search-target').removeClass('current');

                    const target = this.search.searchedMessages[(--this.search.current) - 1];

                    $(target).addClass('current');
                    $(this.$refs.scrollContainer).find('div.message-box span.search-target.highlight.current')[0].scrollIntoView();

                    this.search.difference = this.search.total - this.search.current;
                }
            },
            onNext() {
                if (this.search.current < this.search.total) {
                    $(this.$refs.scrollContainer).find('div.message-box .search-target').removeClass('current');

                    const target = this.search.searchedMessages[(++this.search.current) - 1];

                    $(target).addClass('current');
                    $(this.$refs.scrollContainer).find('div.message-box span.search-target.highlight.current')[0].scrollIntoView();

                    this.search.difference = this.search.total - this.search.current;
                }
            },
            onCancel(isSearch) {
                this.search.content = '';
                this.search.current = 0;
                this.search.difference = 0;
                this.search.isSearch = isSearch;
                this.search.searchedMessages = [];
                this.search.total = 0;
            },
            toggleClass(event) {
                const target = $(event.target);

                if (target.is('b')) {
                    const span =target.next('span');

                    if (span.find('a').length) {
                        span.find('a').toggleClass('active');
                    } else {
                        span.toggleClass('active');
                    }
                } else {
                    target.toggleClass('active');
                }
            },
            async fetchMessages() {
                if (!this.room.storeId) {
                    return false;
                }
                let response = null;
                const data = {
                    id: this.room.storeId,
                    page: this.messages.length / 20 + 1
                };
                switch (this.viewer) {
                    case 'admin':
                        data.viewer = 'admin';
                        response = await this.adminGetMessages(this.serialize(data));

                        if (response.status === 404) {
                            return this.$router.push({ name: 'admin.stores.list' });
                        }
                        break;
                    case 'sale':
                        response = await this.saleGetMessages(this.serialize(data));

                        if (response.status === 404) {
                            return this.$router.push({ name: 'representative.menu.main.menu' });
                        }
                        break;
                    default:
                        response = await this.storeGetMessages(this.serialize(data));

                        if (response.status === 404) {
                            return this.$router.push({ name: 'store.menu.main.menu' });
                        }
                        break;
                }
                this.loadingMessages = false;

                if (response.messages.length === 0) {
                    this.infiniteState.complete();
                } else {
                    this.infiniteState.loaded();
                }
                response.messages.forEach(message => {
                    const formattedMessage = this.formatMessage(this.room, message);
                    this.messages.unshift(formattedMessage);

                    if (this.viewer !== 'admin') {
                        setTimeout(() => {
                            this.markMessagesSeen(this.room, message);
                        }, 2000);
                    }
                });
                this.infiniteState = null;
            },
            formatMessage(room, message) {
                const senderUser = room.users.find(user => message.sender_id === user._id);

                return {
                    ...message,
                    ...{
                        _id: message.id,
                        username: senderUser ? senderUser.username : null
                    }
                };
            },
            async markMessagesSeen(room, message) {
                if (message.sender_id !== this.currentUserId && !message.seen) {
                    if (this.viewer === 'sale') {
                        await this.saleMarkSeen({ id: message.id });

                        const data = {
                            representativeId: this.currentUserId.toString().replace('sale-', ''),
                            senderType: 2
                        };
                        await this.saleCountUnread(this.serialize(data));
                    } else {
                        await this.storeMarkSeen({ id: message.id });

                        const data = {
                            storeId: this.currentUserId.toString().replace('store-', ''),
                            senderType: 1
                        };
                        await this.storeCountUnread(this.serialize(data));
                    }
                    room.unreadCount = 0;
                }
            },
        }
    };
</script>

<style lang="scss" scoped>
    .col-messages {
        position: relative;
        height: 100%;
        flex: 1;
        overflow: hidden;
        display: flex;
        flex-flow: column;
    }

    .room-header {
        position: absolute;
        display: flex;
        align-items: center;
        height: 64px;
        width: 100%;
        z-index: 10;
        margin-right: 1px;
        background: var(--chat-header-bg-color);
        border-top-right-radius: var(--chat-container-border-radius);
    }

    .room-wrapper {
        display: flex;
        align-items: center;
        min-width: 0;
        height: 100%;
        width: 100%;
        padding: 0 16px;
    }

    .info-wrapper {
        display: flex;
        align-items: center;
        min-width: 0;
        width: 100%;
        height: 100%;
    }

    .toggle-button {
        margin-right: 15px;

        svg {
            height: 26px;
            width: 26px;
        }
    }

    .rotate-icon {
        transform: rotate(180deg) !important;
    }

    .room-name {
        font-size: 17px;
        font-weight: 500;
        line-height: 22px;
        color: var(--chat-header-color-name);
    }

    .room-info {
        font-size: 13px;
        line-height: 18px;
        color: var(--chat-header-color-info);
    }

    .room-options {
        margin-left: auto;
    }

    .container-scroll {
        background: var(--chat-content-bg-color);
        flex: 1;
        overflow-y: scroll;
        margin-right: 1px;
        margin-top: 60px;
        -webkit-overflow-scrolling: touch;
    }

    .messages-container {
        padding: 0 5px 5px;
    }

    .text-started {
        font-size: 14px;
        color: var(--chat-message-color-started);
        font-style: italic;
        text-align: center;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    .icon-scroll {
        position: absolute;
        bottom: 80px;
        right: 20px;
        padding: 8px;
        background: var(--chat-bg-scroll-icon);
        border-radius: 50%;
        box-shadow: 0 1px 1px -1px rgba(0, 0, 0, 0.2), 0 1px 1px 0 rgba(0, 0, 0, 0.14),
        0 1px 2px 0 rgba(0, 0, 0, 0.12);
        display: flex;
        cursor: pointer;
        z-index: 10;

        svg {
            height: 25px;
            width: 25px;
        }
    }

    .room-footer {
        width: calc(100% - 1px);
        border-bottom-right-radius: 4px;
        z-index: 10;
    }

    .box-footer {
        display: flex;
        position: relative;
        background: var(--chat-footer-bg-color);
        padding: 10px 8px 10px;
    }

    .reply-container {
        display: flex;
        padding: 10px 10px 0 10px;
        background: var(--chat-content-bg-color);
        align-items: center;
        max-width: 100%;

        .reply-box {
            width: 100%;
            overflow: hidden;
            background: var(--chat-footer-bg-color-reply);
            border-radius: 4px;
            padding: 8px 10px;
            display: flex;
        }

        .reply-info {
            overflow: hidden;
        }

        .reply-username {
            color: var(--chat-message-color-reply-username);
            font-size: 12px;
            line-height: 15px;
            margin-bottom: 2px;
        }

        .reply-content {
            font-size: 12px;
            color: var(--chat-message-color-reply-content);
        }

        .icon-reply {
            margin-left: 10px;

            svg {
                height: 20px;
                width: 20px;
            }
        }

        .image-reply {
            max-height: 100px;
            margin-right: 10px;
        }
    }

    textarea {
        height: 20px;
        width: 100%;
        line-height: 20px;
        overflow: hidden;
        outline: 0;
        resize: none;
        border-radius: 20px;
        padding: 12px 16px;
        box-sizing: content-box;
        font-size: 16px;
        background: var(--chat-bg-color-input);
        color: var(--chat-color);
        caret-color: var(--chat-color-caret);
        border: var(--chat-border-style-input);

        &::placeholder {
            color: var(--chat-color-placeholder);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }

    .textarea-outline {
        border: 1px solid var(--chat-border-color-input-selected);
        box-shadow: inset 0px 0px 0px 1px var(--chat-border-color-input-selected);
    }

    .icon-textarea {
        display: flex;
        margin: 12px 0 0 5px;

        svg,
        .wrapper {
            margin: 0 7px;
        }
    }

    .image-container {
        position: absolute;
        max-width: 25%;
        left: 16px;
        top: 18px;
    }

    .image-file {
        display: flex;
        justify-content: center;
        flex-direction: column;
        min-height: 30px;

        img {
            border-radius: 15px;
            width: 100%;
            max-width: 150px;
            max-height: 100%;
        }
    }

    .icon-image {
        position: absolute;
        top: 6px;
        left: 6px;
        z-index: 10;

        svg {
            height: 20px;
            width: 20px;
            border-radius: 50%;
        }

        &:before {
            content: ' ';
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            z-index: -1;
        }
    }

    .file-container {
        display: flex;
        align-items: center;
        width: calc(100% - 75px);
        height: 20px;
        padding: 12px 0;
        box-sizing: content-box;
        background: var(--chat-bg-color-input);
        border: var(--chat-border-style-input);
        border-radius: 20px;
    }

    .file-container-edit {
        width: calc(100% - 109px);
    }

    .file-message {
        max-width: calc(100% - 75px);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .icon-file {
        display: flex;
        margin: 0 8px 0 15px;
    }

    .icon-remove {
        margin-left: 8px;

        svg {
            height: 18px;
            width: 18px;
        }
    }

    .send-disabled,
    .send-disabled svg {
        cursor: none !important;
        pointer-events: none !important;
        transform: none !important;
    }

    .messages-hidden {
        opacity: 0;
    }

    @media only screen and (max-width: 768px) {
        .room-header {
            height: 50px;

            .room-wrapper {
                padding: 0 10px;
            }

            .room-name {
                font-size: 16px;
                line-height: 22px;
            }

            .room-info {
                font-size: 12px;
                line-height: 16px;
            }

            .room-avatar {
                height: 37px;
                width: 37px;
                min-height: 37px;
                min-width: 37px;
            }
        }

        .container-scroll {
            margin-top: 50px;
        }

        .box-footer {
            border-top: var(--chat-border-style-input);
            padding: 7px 2px 7px 7px;
        }

        .text-started {
            margin-top: 20px;
        }

        textarea {
            padding: 7px;
            line-height: 18px;

            &::placeholder {
                color: transparent;
            }
        }

        .icon-textarea {
            margin: 6px 0 0 5px;

            svg,
            .wrapper {
                margin: 0 5px;
            }
        }

        .image-container {
            top: 10px;
            left: 10px;
        }

        .image-file img {
            transform: scale(0.97);
        }

        .room-footer {
            width: 100%;
        }

        .file-container {
            padding: 7px 0;

            .icon-file {
                margin-left: 10px;
            }
        }

        .reply-container {
            padding: 5px 8px;
        }

        .icon-scroll {
            bottom: 70px;
        }
    }
</style>
