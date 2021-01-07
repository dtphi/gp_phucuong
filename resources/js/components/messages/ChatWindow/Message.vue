<template>
    <div>
        <div v-if="showDate" class="card-date">
            {{ message.date }}
        </div>

        <div v-if="message.sender_type === 3" class="charger-name">
            {{ message.content }}
        </div>

        <div v-if="isNewMessage" class="line-new">
            {{ textMessages.NEW_MESSAGES }}
        </div>

        <div v-if="message.sender_type !== 3"
             class="message-box"
             :class="{ 'offset-current': checkCurrent() }">
            <div class="message-container" :class="{ 'message-container-offset': messageOffset }">
                <div v-if="message.showUsername" class="text-username" :class="{ 'username-reply': !message.deleted && message.replyMessage }">
                    <span>{{ message.username }}</span>
                </div>

                <div ref="imageRef"
                     class="message-card"
                     :class="{
                         'message-current': checkCurrent(),
                         'message-deleted': message.deleted,
                         'message-highlight': isMessageHover(message)
                     }"
                     :key="(message.createdAt + message.updatedAt)"
                     @mouseleave="onLeaveMessage"
                     @mouseover="onHoverMessage(message)">
                    <div v-if="!message.deleted && message.replyMessage" class="reply-message">
                        <div class="reply-username">{{ replyUsername }}</div>

                        <div v-if="message.replyMessage.images.length" class="image-reply-container">
                            <template v-for="(image, i) in message.replyMessage.images">
                                <div class="message-image message-image-reply" :style="{ 'background-image': `url('${image.url}')` }" :key="i"></div>
                            </template>
                        </div>

                        <div class="reply-content" v-html="highlight(message.replyMessage.content, filterKey)"></div>
                    </div>

                    <div v-if="message.deleted" :key="message.deletedAt">
                        <svg-icon class="icon-deleted" name="deleted"></svg-icon>
                        <span>{{ textMessages.MESSAGE_DELETED }}</span>
                    </div>

                    <div v-else-if="!message.file && !message.images.length">
                        <format-message :content="this.message.content" :filter-key="filterKey" :text-formatting="textFormatting"></format-message>
                    </div>

                    <div v-else-if="message.images.length" class="image-container">
                        <loader :show="isImageLoading" :style="{ top: `${imageResponsive.loaderTop}px` }"></loader>

                        <template v-for="(image, i) in message.images">
                            <div class="message-image"
                                 :class="{ 'image-loading': isImageLoading && checkCurrent() }"
                                 :style="{
                                    'background-image': `url('${image.url}')`,
                                    'max-height': `${imageResponsive.maxHeight}px`
                                 }"
                                 :key="i">
                                <transition name="fade-image">
                                    <div v-if="imageHover && !isImageLoading" class="image-buttons">
                                        <div class="svg-button button-view" @click.stop="openFile('preview', image)">
                                            <svg-icon name="eye"></svg-icon>
                                        </div>

                                        <div class="svg-button button-download" @click.stop="openFile('download', image)">
                                            <svg-icon name="document"></svg-icon>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </template>

                        <format-message :content="this.message.content" :filter-key="filterKey" :text-formatting="textFormatting"></format-message>
                    </div>

                    <div v-else class="file-message">
                        <div class="svg-button icon-file" @click.stop="openFile('download-pdf')">
                            <svg-icon name="document"></svg-icon>
                        </div>
                        <span v-html="highlight(message.content, filterKey)"></span>
                    </div>

                    <div class="text-timestamp">
                        <div v-if="message.edited && !message.deleted" class="icon-edited">
                            <svg-icon name="pencil"></svg-icon>
                        </div>
                        <span>{{ message.timestamp }}</span>
                        <span v-if="isMessageSeen">
                            <svg-icon class="icon-check" name="checkmark"></svg-icon>
                        </span>
                    </div>

                    <div class="options-container"
                         :class="{ 'options-image': message.images.length && !message.replyMessage }"
                         :style="{ width: filteredMessageActions.length && showReactionEmojis ? '70px' : '45px' }">
                        <transition-group name="slide-left">
                            <div v-if="isMessageActions || isMessageReactions"
                                 class="blur-container"
                                 key="1"
                                 :class="{ 'options-me': checkCurrent() }"></div>

                            <div ref="actionIcon"
                                 v-if="isMessageActions"
                                 class="svg-button message-options"
                                 key="2"
                                 @click="openOptions">
                                <svg-icon name="dropdown" param="message"></svg-icon>
                            </div>

                            <emoji-picker v-if="isMessageReactions"
                                          v-click-outside="closeEmoji"
                                          class="message-reactions"
                                          key="3"
                                          :emoji-opened="emojiOpened"
                                          :emoji-reaction="true"
                                          :position-right="checkCurrent()"
                                          :room-footer-ref="roomFooterRef"
                                          :style="{ right: isMessageActions ? '30px' : '5px' }"
                                          @addEmoji="sendMessageReaction"
                                          @openEmoji="openEmoji"></emoji-picker>
                        </transition-group>
                    </div>

                    <transition v-if="filteredMessageActions.length" :name="checkCurrent() ? 'slide-left' : 'slide-right'">
                        <div ref="menuOptions"
                             v-if="optionsOpened"
                             v-click-outside="closeOptions"
                             class="menu-options"
                             :class="{ 'menu-left': !checkCurrent() }"
                             :style="{ top: `${menuOptionsTop}px` }">
                            <div class="menu-list">
                                <div v-for="action in filteredMessageActions" :key="action.name">
                                    <div class="menu-item" @click="messageActionHandler(action)">
                                        {{ action.title }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>

                <transition-group v-if="!message.deleted" name="slide-left">
                    <button v-show="reaction.length"
                            v-for="(reaction, key) in message.reactions"
                            class="button-reaction"
                            :class="{ 'reaction-me': reaction.indexOf(currentUserId) !== -1 }"
                            :key="key + 0"
                            :style="{ float: checkCurrent() ? 'right' : 'left' }"
                            @click="sendMessageReaction({ name: key }, reaction)">
                        {{ getEmojiByName(key) }}<span>{{ reaction.length }}</span>
                    </button>
                </transition-group>
            </div>
        </div>
    </div>
</template>

<script>
    import vClickOutside from 'v-click-outside';
    import EmojiPicker from './EmojiPicker';
    import FormatMessage from './FormatMessage';
    import Loader from './Loader';
    import SvgIcon from './SvgIcon';

    export default {
        name: 'message',
        components: {
            EmojiPicker,
            FormatMessage,
            Loader,
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
            editedMessage: {
                type: Object,
                required: true
            },
            emojisList: {
                type: Object,
                required: true
            },
            filterKey: {
                default: '',
                type: String
            },
            hideOptions: {
                type: Boolean,
                required: true
            },
            index: {
                type: Number,
                required: true
            },
            message: {
                type: Object,
                required: true
            },
            messageActions: {
                type: Array,
                required: true
            },
            messages: {
                type: Array,
                required: true
            },
            newMessages: { type: Array },
            roomFooterRef: { type: HTMLDivElement },
            roomUsers: {
                default: () => [],
                type: Array
            },
            showNewMessagesDivider: {
                type: Boolean,
                required: true
            },
            showReactionEmojis: {
                type: Boolean,
                required: true
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
                emojiOpened: false,
                hoverMessageId: null,
                imageHover: false,
                imageLoading: false,
                imageResponsive: '',
                menuOptionsTop: 0,
                messageHover: false,
                messageReaction: '',
                newMessage: {},
                optionsClosing: false,
                optionsOpened: false
            };
        },
        watch: {
            emojiOpened(val) {
                if (val) {
                    this.optionsOpened = false;
                }
            },
            hideOptions(val) {
                if (val) {
                    this.closeEmoji();
                    this.closeOptions();
                }
            },
            message: {
                handler() {
                    this.checkImgLoad();
                },
                immediate: true
            },
            newMessages(val) {
                if (!val.length || !this.showNewMessagesDivider) {
                    return;
                }
                this.newMessage = val.reduce((res, obj) => obj.index < res.index ? obj : res);
            }
        },
        mounted() {
            if (this.message.sender_type !== 3) {
                if (!this.message.seen && !this.checkCurrent()) {
                    this.$emit('addNewMessage', {
                        _id: this.message._id,
                        index: this.index
                    });
                }
                this.imageResponsive = {
                    loaderTop: this.$refs.imageRef.clientWidth / 2,
                    maxHeight: this.$refs.imageRef.clientWidth - 18
                };
            }
        },
        computed: {
            filteredMessageActions() {
                return this.checkCurrent() ? this.messageActions : this.messageActions.filter(message => !message.onlyMe);
            },
            isImageLoading() {
                for (let image of this.message.images) {
                    let imageLoading = image.url.indexOf('blob:http') !== -1;

                    if (imageLoading === true) {
                        return true;
                    }
                }
                return this.imageLoading;
            },
            isMessageActions() {
                return this.filteredMessageActions.length && this.messageHover && !this.message.deleted && !this.message.disable_actions;
            },
            isMessageReactions() {
                return this.showReactionEmojis && this.messageHover && !this.message.deleted && !this.message.disable_reactions;
            },
            isMessageSeen() {
                return this.checkCurrent() && this.message.seen && !this.message.deleted;
            },
            isNewMessage() {
                const condition = !this.checkCurrent() && !this.message.seen && this.message.sender_type !== 3 && this.viewer !== 'admin';

                return condition && (!$('.line-new').length || this.newMessage._id === this.message._id);
            },
            messageOffset() {
                return this.index > 0 && this.message.sender_id !== this.messages[this.index - 1].sender_id;
            },
            replyUsername() {
                const { sender_id } = this.message.replyMessage;
                const replyUser = this.roomUsers.find(user => user._id === sender_id);

                return replyUser ? replyUser.username : '';
            },
            showDate() {
                return this.index > 0 && this.message.date !== this.messages[this.index - 1].date;
            }
        },
        methods: {
            canEditMessage() {
                return !this.message.deleted;
            },
            checkCurrent() {
                const type = this.currentUserId.slice(0, this.currentUserId.indexOf('-'));

                return this.message.sender_id.startsWith(type);
            },
            checkImgLoad() {
                for (let _image of this.message.images) {
                    this.imageLoading = true;

                    const image = new Image();
                    image.src = _image.url;
                    image.addEventListener('load', () => (this.imageLoading = false));
                }
            },
            closeEmoji() {
                this.emojiOpened = false;

                if (this.hoverMessageId !== this.message._id) {
                    this.messageHover = false;
                }
            },
            closeOptions() {
                this.optionsOpened = false;
                this.optionsClosing = true;

                setTimeout(() => (this.optionsClosing = false), 100);

                if (this.hoverMessageId !== this.message._id) {
                    this.messageHover = false;
                }
            },
            getEmojiByName(emojiName) {
                return this.emojisList[emojiName];
            },
            isMessageHover() {
                return this.editedMessage._id === this.message._id || this.hoverMessageId === this.message._id;
            },
            messageActionHandler(action) {
                this.closeOptions();

                this.messageHover = false;
                this.hoverMessageId = null;

                setTimeout(() => {
                    this.$emit('messageActionHandler', {
                        action,
                        message: this.message
                    });
                }, 300);
            },
            onHoverMessage() {
                this.imageHover = true;
                this.messageHover = true;

                if (this.canEditMessage()) {
                    this.hoverMessageId = this.message._id;
                }
            },
            onLeaveMessage() {
                this.imageHover = false;

                if (!this.optionsOpened && !this.emojiOpened) {
                    this.messageHover = false;
                }
                this.hoverMessageId = null;
            },
            openEmoji() {
                this.emojiOpened = !this.emojiOpened;

                this.$emit('hideOptions', false);
            },
            openFile(action, image = null) {
                this.$emit('openFile', {
                    action,
                    message: this.message,
                    image
                });
            },
            openOptions() {
                if (this.optionsClosing) {
                    return;
                }
                this.optionsOpened = !this.optionsOpened;

                if (!this.optionsOpened) {
                    return;
                }
                this.$emit('hideOptions', false);

                setTimeout(() => {
                    if (!this.roomFooterRef || !this.$refs.menuOptions || !this.$refs.actionIcon) {
                        return;
                    }
                    const actionIconTop = this.$refs.actionIcon.getBoundingClientRect().top;
                    const menuOptionsTop = this.$refs.menuOptions.getBoundingClientRect().height;
                    const roomFooterTop = this.roomFooterRef.getBoundingClientRect().top;

                    const optionsTopPosition = roomFooterTop - actionIconTop > menuOptionsTop + 50;

                    if (optionsTopPosition) {
                        this.menuOptionsTop = 30;
                    } else {
                        this.menuOptionsTop = -menuOptionsTop;
                    }
                }, 0);
            },
            sendMessageReaction(emoji, reaction) {
                this.$emit('sendMessageReaction', {
                    messageId: this.message._id,
                    reaction: emoji,
                    remove: reaction && reaction.indexOf(this.currentUserId) !== -1
                });
                this.closeEmoji();

                this.messageHover = false;
            }
        }
    };
</script>

<style lang="scss" scoped>
    .fs13 {
        font-size: 13px !important;
    }
    .card-date {
        border-radius: 4px;
        max-width: 150px;
        text-align: center;
        margin: 10px auto;
        font-size: 12px;
        text-transform: uppercase;
        padding: 4px;
        color: var(--chat-message-color-date);
        background: var(--chat-message-bg-color-date);
        display: block;
        overflow-wrap: break-word;
        position: relative;
        white-space: normal;
        box-shadow: 0 1px 1px -1px rgba(0, 0, 0, 0.1),
        0 1px 1px -1px rgba(0, 0, 0, 0.11), 0 1px 2px -1px rgba(0, 0, 0, 0.11);
    }

    .line-new {
        color: var(--chat-message-color-new-messages);
        position: relative;
        text-align: center;
        font-size: 13px;
        padding: 10px 0;
    }

    .line-new:after,
    .line-new:before {
        border-top: 1px solid var(--chat-message-color-new-messages);
        content: '';
        left: 0;
        position: absolute;
        top: 50%;
        width: calc(50% - 60px);
    }

    .line-new:before {
        left: auto;
        right: 0;
    }

    .message-box {
        display: flex;
        flex: 0 0 50%;
        max-width: 50%;
        justify-content: flex-start;
        line-height: 1.4;
    }

    .message-container {
        position: relative;
        padding: 2px 10px;
        align-items: end;
        min-width: 100px;
        box-sizing: content-box;
    }

    .message-container-offset {
        margin-top: 10px;
    }

    .offset-current {
        margin-left: 50%;
        justify-content: flex-end;
    }

    .message-card {
        background: var(--chat-message-bg-color);
        color: var(--chat-message-color);
        border-radius: 8px;
        font-size: 14px;
        padding: 6px 9px 3px;
        white-space: pre-wrap;
        max-width: 100%;
        -webkit-transition-property: box-shadow, opacity;
        transition-property: box-shadow, opacity;
        transition: box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1);
        will-change: box-shadow;
        box-shadow: 0 1px 1px -1px rgba(0, 0, 0, 0.1),
        0 1px 1px -1px rgba(0, 0, 0, 0.11), 0 1px 2px -1px rgba(0, 0, 0, 0.11);
    }

    .message-highlight {
        box-shadow: 0 1px 2px -1px rgba(0, 0, 0, 0.1),
        0 1px 2px -1px rgba(0, 0, 0, 0.11), 0 1px 5px -1px rgba(0, 0, 0, 0.11);
    }

    .message-current {
        background: var(--chat-message-bg-color-me) !important;
    }

    .message-deleted {
        color: var(--chat-message-color-deleted) !important;
        font-size: 13px !important;
        font-style: italic !important;
        background: var(--chat-message-bg-color-deleted) !important;
    }

    .icon-deleted {
        height: 14px;
        width: 14px;
        vertical-align: middle;
        margin: -2px 2px 0 0;
        fill: var(--chat-message-color-deleted);
    }

    .image-container {
        width: 250px;
        max-width: 100%;
    }

    .image-reply-container {
        width: 70px;
    }

    .message-image {
        position: relative;
        background-color: var(--chat-message-bg-color-image) !important;
        background-size: cover !important;
        background-position: center center !important;
        background-repeat: no-repeat !important;
        height: 250px;
        width: 250px;
        max-width: 100%;
        border-radius: 4px;
        margin: 4px auto 5px;
        transition: 0.4s filter linear;
    }

    .message-image-reply {
        height: 70px;
        width: 70px;
        margin: 4px auto 3px;
    }

    .image-loading {
        filter: blur(3px);
    }

    .reply-message {
        background: var(--chat-message-bg-color-reply);
        border-radius: 4px;
        margin: -1px -5px 8px;
        padding: 8px 10px;

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
    }

    .text-username {
        font-size: 13px;
        color: var(--chat-message-color-username);
        margin-bottom: 2px;
    }

    .username-reply {
        margin-bottom: 5px;
    }

    .text-timestamp {
        font-size: 10px;
        color: var(--chat-message-color-timestamp);
        text-align: right;
    }

    .file-message {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        margin-top: 3px;

        span {
            max-width: 100%;
        }

        .icon-file svg {
            margin-right: 5px;
        }
    }

    .icon-edited {
        -webkit-box-align: center;
        align-items: center;
        display: -webkit-inline-box;
        display: inline-flex;
        justify-content: center;
        letter-spacing: normal;
        line-height: 1;
        text-indent: 0;
        vertical-align: middle;
        margin: 0 4px 2px;

        svg {
            height: 12px;
            width: 12px;
        }
    }

    .options-container {
        position: absolute;
        top: 2px;
        right: 10px;
        height: 40px;
        width: 70px;
        overflow: hidden;
        z-index: 1;
        border-top-right-radius: 8px;
    }

    .blur-container {
        position: absolute;
        height: 100%;
        width: 100%;
        left: 8px;
        bottom: 10px;
        filter: blur(3px);
        border-bottom-left-radius: 8px;
    }

    .options-image .blur-container {
        background: rgba(255, 255, 255, 0.6);
        border-bottom-left-radius: 15px;
    }

    .image-buttons {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 4px;
        background: linear-gradient(
                to bottom,
                rgba(0, 0, 0, 0) 55%,
                rgba(0, 0, 0, 0.02) 60%,
                rgba(0, 0, 0, 0.05) 65%,
                rgba(0, 0, 0, 0.1) 70%,
                rgba(0, 0, 0, 0.2) 75%,
                rgba(0, 0, 0, 0.3) 80%,
                rgba(0, 0, 0, 0.5) 85%,
                rgba(0, 0, 0, 0.6) 90%,
                rgba(0, 0, 0, 0.7) 95%,
                rgba(0, 0, 0, 0.8) 100%
        );

        svg {
            height: 26px;
            width: 26px;
        }

        .button-view,
        .button-download {
            position: absolute;
            bottom: 6px;
            left: 7px;
        }

        :first-child {
            left: 40px;
        }

        .button-view {
            max-width: 18px;
            bottom: 8px;
        }
    }

    .message-options {
        background: var(--chat-icon-bg-dropdown-message);
        border-radius: 50%;
        position: absolute;
        top: 7px;
        right: 7px;

        svg {
            height: 24px;
            width: 24px;
            padding: 5px;
            margin: -5px;
        }
    }

    .message-reactions {
        position: absolute;
        top: 6px;
        right: 30px;
    }

    .menu-options {
        right: 15px;
    }

    .menu-left {
        right: -118px;
    }

    .icon-check {
        height: 14px;
        width: 14px;
        vertical-align: middle;
        margin: -3px -3px 0 3px;
    }

    .button-reaction {
        display: inline-flex;
        align-items: center;
        border: var(--chat-message-border-style-reaction);
        outline: none;
        background: var(--chat-message-bg-color-reaction);
        border-radius: 4px;
        margin: 4px 2px 0;
        transition: 0.3s;
        padding: 0 5px;
        font-size: 18px;
        line-height: 23px;

        span {
            font-size: 11px;
            font-weight: 500;
            min-width: 7px;
            color: var(--chat-message-color-reaction-counter);
        }

        &:hover {
            border: var(--chat-message-border-style-reaction-hover);
            background: var(--chat-message-bg-color-reaction-hover);
            cursor: pointer;
        }
    }

    .reaction-me {
        border: var(--chat-message-border-style-reaction-me);
        background: var(--chat-message-bg-color-reaction-me);

        span {
            color: var(--chat-message-color-reaction-counter-me);
        }

        &:hover {
            border: var(--chat-message-border-style-reaction-hover-me);
            background: var(--chat-message-bg-color-reaction-hover-me);
        }
    }

    @media only screen and (max-width: 768px) {
        .message-container {
            padding: 2px 3px 1px;
        }

        .message-container-offset {
            margin-top: 10px;
        }

        .message-box {
            flex: 0 0 80%;
            max-width: 80%;
        }
        .offset-current {
            margin-left: 20%;
        }

        .options-container {
            right: 3px;
        }

        .menu-left {
            right: -50px;
        }
    }
</style>
