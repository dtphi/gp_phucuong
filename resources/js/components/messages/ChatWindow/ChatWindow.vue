<template>
    <div class="card-window" :style="[{ height }, cssVars]">
        <div class="chat-container">
            <rooms-list v-if="!singleRoom"
                        :current-user-id="currentUserId"
                        :is-mobile="isMobile"
                        :loading-rooms="loadingRooms"
                        :room="room"
                        :rooms="rooms"
                        :show-add-room="showAddRoom"
                        :show-rooms-list="showRoomsList"
                        :text-formatting="textFormatting"
                        :text-messages="t"
                        @addRoom="addRoom"
                        @fetchRoom="fetchRoom">
                <template v-slot:rooms-header>
                    <slot name="rooms-header"></slot>
                </template>
            </rooms-list>

            <room :current-user-id="currentUserId"
                  :is-mobile="isMobile"
                  :loading-rooms="loadingRooms"
                  :menu-actions="menuActions"
                  :message-actions="messageActions"
                  :room-id="room.roomId || ''"
                  :room-info="$listeners.roomInfo"
                  :room-message="roomMessage"
                  :rooms="rooms"
                  :sale="sale"
                  :show-emojis="showEmojis"
                  :show-file="showFile"
                  :show-fixed-phrase="showFixedPhrase"
                  :show-images="showImages"
                  :show-new-messages-divider="showNewMessagesDivider"
                  :show-reaction-emojis="showReactionEmojis"
                  :show-rooms-list="showRoomsList"
                  :single-room="singleRoom"
                  :store="store"
                  :text-formatting="textFormatting"
                  :text-messages="t"
                  :viewer="viewer"
                  @deleteMessage="deleteMessage"
                  @editMessage="editMessage"
                  @fetchRooms="fetchRooms"
                  @menuActionHandler="menuActionHandler"
                  @messageActionHandler="messageActionHandler"
                  @openFile="openFile"
                  @roomInfo="roomInfo"
                  @sendMessage="sendMessage"
                  @sendMessageReaction="sendMessageReaction"
                  @toggleRoomsList="toggleRoomsList"
                  @typingMessage="typingMessage"></room>
        </div>
    </div>
</template>

<script>
    import Room from './Room';
    import RoomsList from './RoomsList';
    import locales from '../locales';
    import { defaultThemeStyles, cssThemeVars } from '../themes';

    const { roomsValid, partcipantsValid } = require('../utils/roomValidation');

    export default {
        name: 'chat-container',
        components: {
            Room,
            RoomsList
        },
        props: {
            currentUserId: {
                default: '',
                type: [ String, Number ]
            },
            height: {
                default: '600px',
                type: String
            },
            loadingRooms: {
                default: false,
                type: Boolean
            },
            menuActions: {
                default: () => [],
                type: Array
            },
            messageActions: {
                default: () => [
                    {
                        name: 'replyMessage',
                        title: 'Reply'
                    },
                    {
                        name: 'editMessage',
                        title: 'Edit Message',
                        onlyMe: true
                    },
                    {
                        name: 'deleteMessage',
                        title: 'Delete Message',
                        onlyMe: true
                    }
                ],
                type: Array
            },
            newMessage: {
                default: null,
                type: Object
            },
            responsiveBreakpoint: {
                default: 900,
                type: Number
            },
            roomId: {
                default: null,
                type: [ String, Number ]
            },
            roomMessage: {
                default: '',
                type: String
            },
            rooms: {
                default: () => [],
                type: Array
            },
            sale: {
                default: () => ({}),
                type: Object
            },
            showAddRoom: {
                default: true,
                type: Boolean
            },
            showEmojis: {
                default: true,
                type: Boolean
            },
            showFile: {
                default: true,
                type: Boolean
            },
            showFixedPhrase: {
                default: true,
                type: Boolean
            },
            showImages: {
                default: true,
                type: Boolean
            },
            showNewMessagesDivider: {
                default: true,
                type: Boolean
            },
            showReactionEmojis: {
                default: true,
                type: Boolean
            },
            singleRoom: {
                default: false,
                type: Boolean
            },
            store: {
                default: () => ({}),
                type: Object
            },
            styles: {
                default: () => ({}),
                type: Object
            },
            textFormatting: {
                default: true,
                type: Boolean
            },
            textMessages: {
                default: null,
                type: Object
            },
            theme: {
                default: 'light',
                type: String
            },
            viewer: {
                default: 'sale',
                type: String
            }
        },
        data() {
            return {
                isMobile: false,
                room: {},
                showRoomsList: true
            };
        },
        watch: {
            newMessage(val) {
                this.$set(this.messages, val.index, val.message);
            },
            room(val) {
                if (!val) {
                    return;
                }

                if (Object.entries(val).length === 0) {
                    return;
                }

                if (!roomsValid(val)) {
                    throw 'Rooms object is not valid! Must contain roomId[String, Number], roomName[String] and users[Array]';
                }

                val.users.forEach(user => {
                    if (!partcipantsValid(user)) {
                        throw 'Participants object is not valid! Must contain _id[String, Number] and username[String]';
                    }
                });
            },
            roomId: {
                handler(val) {
                    if (val && !this.loadingRooms && this.rooms.length) {
                        const room = this.rooms.find(r => r.roomId === val);

                        this.fetchRoom({ room });
                    }
                },
                immediate: true
            },
            rooms: {
                handler(newVal, oldVal) {
                    if (newVal[0] && (!oldVal || newVal.length !== oldVal.length)) {
                        if (this.roomId) {
                            const room = newVal.find(r => r.roomId === this.roomId);

                            this.fetchRoom({ room });
                        } else if ((this.isMobile && !this.showRoomsList) || !this.isMobile || this.singleRoom) {
                            this.fetchRoom({ room: this.rooms[0] });
                        } else {
                            this.showRoomsList = true;
                        }
                    }
                },
                immediate: true
            }
        },
        created() {
            this.updateResponsive();

            window.addEventListener('resize', ev => {
                if (ev.isTrusted) {
                    this.updateResponsive();
                }
            });
        },
        computed: {
            cssVars() {
                const defaultStyles = defaultThemeStyles[this.theme];
                const customStyles = {};

                Object.keys(defaultStyles).map(key => {
                    customStyles[key] = {
                        ...defaultStyles[key],
                        ...(this.styles[key] || {})
                    };
                });
                return cssThemeVars(customStyles);
            },
            t() {
                return {
                    ...locales,
                    ...this.textMessages
                };
            }
        },
        methods: {
            addRoom() {
                this.$emit('addRoom');
            },
            deleteMessage(messageId) {
                this.$emit('deleteMessage', {
                    messageId,
                    roomId: this.room.roomId
                });
            },
            editMessage(message) {
                this.$emit('editMessage', {
                    ...message,
                    roomId: this.room.roomId
                });
            },
            fetchRoom({ room }) {
                this.room = room;

                if (this.isMobile) {
                    this.showRoomsList = false;
                }
            },
            fetchRooms() {
                this.$emit('fetchRooms');
            },
            menuActionHandler(ev) {
                this.$emit('menuActionHandler', {
                    action: ev,
                    roomId: this.room.roomId
                });
            },
            messageActionHandler(ev) {
                this.$emit('messageActionHandler', {
                    ...ev,
                    roomId: this.room.roomId
                });
            },
            openFile({ message, action, image }) {
                // this.$emit('openFile', {
                //     action,
                //     message
                // });
                if (action === 'download') {
                    FileSaver.saveAs(image.url, image.name);
                } else if (action === 'download-pdf') {
                    window.open(message.file.url, '_blank');
                } else {
                    window.open(image.url, '_blank');
                }
                return false;
            },
            roomInfo() {
                this.$emit('roomInfo', this.room);
            },
            sendMessage(message) {
                this.$emit('sendMessage', {
                    ...message,
                    roomId: this.room.roomId
                });
            },
            sendMessageReaction(messageReaction) {
                this.$emit('sendMessageReaction', {
                    ...messageReaction,
                    roomId: this.room.roomId
                });
            },
            toggleRoomsList() {
                this.showRoomsList = !this.showRoomsList;

                if (this.isMobile) {
                    this.room = {};
                }
            },
            typingMessage(message) {
                this.$emit('typingMessage', {
                    message,
                    roomId: this.room.roomId
                });
            },
            updateResponsive() {
                this.isMobile = window.innerWidth < this.responsiveBreakpoint;
            }
        }
    };
</script>

<style lang="scss">
    @import '../styles/index.scss';

    * {
        font-family: inherit;
    }

    a {
        color: #0d579c;
    }

    .card-window {
        width: 100%;
        display: block;
        max-width: 100%;
        background: var(--chat-content-bg-color);
        color: var(--chat-color);
        overflow-wrap: break-word;
        position: relative;
        white-space: normal;
        border: var(--chat-container-border);
        border-radius: var(--chat-container-border-radius);
        box-shadow: var(--chat-container-box-shadow);
    }

    .chat-container {
        height: 100%;
        display: flex;

        input {
            min-width: 10px;
        }

        textarea,
        input[type='text'],
        input[type='search'] {
            -webkit-appearance: none;
        }
    }
</style>
