<template>
    <ChatWindow viewer="store"
                :current-user-id="currentUserId"
                :height="height"
                :loading-rooms="loadingRooms"
                :message-actions="[]"
                :rooms="rooms"
                :sale="employee"
                :show-add-room="false"
                :show-emojis="false"
                :show-reaction-emojis="false"
                :single-room="true"
                @deleteMessage="deleteMessage"
                @editMessage="editMessage"
                @fetchRooms="fetchRooms"
                @sendMessage="sendMessage"></ChatWindow>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import ChatWindow from '../../messages/ChatWindow/ChatWindow';

    export default {
        name: 'ChatMessages',
        components: {
            ChatWindow
        },
        data() {
            return {
                currentUserId: '',
                employee: null,
                height: '0px',
                loadingRooms: true,
                rooms: [],
                userId: 0
            };
        },
        computed: {
            ...mapGetters('store.auth', [ 'store' ]),
            ...mapGetters('store.messages', [ 'unread' ])
        },
        mounted() {
            this.currentUserId = 'store-' + this.store.id;
            this.userId = this.store.id;
            this.height = this.calculateHeight();
            this.loadEmployee();
            this.fetchRooms();
        },
        destroyed() {
            this.resetRooms();
        },
        methods: {
            ...mapActions('store.messages', [ 'getEmployee', 'getStore', 'getMessage', 'create', 'update', 'delete' ]),
            async loadEmployee() {
                const response = await this.getEmployee(this.store.sale_rep_id);

                if (response.status === 404) {
                    return this.$router.push({ name: 'store.menu.main.menu' });
                }
                this.employee = response.employee;
            },
            resetRooms() {
                this.loadingRooms = true;
                this.rooms = [];
            },
            async fetchRooms() {
                this.resetRooms();

                const response = await this.getStore(this.userId);

                if (response.status === 404) {
                    return this.$router.push({ name: 'store.menu.main.menu' });
                }
                this.rooms = [ response.store ];
                this.rooms.forEach(room => {
                    room.lastMessage = this.formatLastMessage(room.lastMessage);
                });
                this.loadingRooms = false;
            },
            formatLastMessage(message) {
                let content = message.content;

                if (message.file) {
                    content = message.file.name;
                }
                return {
                    ...message,
                    ...{
                        content,
                        new: message.sender_id !== this.currentUserId && !message.seen,
                        seen: message.sender_id === this.currentUserId ? message.seen : null
                    }
                };
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
            async sendMessage({ content, roomId, file, images, replyMessage }) {
                const data = new FormData();
                const room = this.rooms.find(room => room.roomId === roomId);
                const json = {
                    content,
                    senderId: this.userId,
                    senderType: 1,
                    storeId: room.storeId
                };

                if (file) {
                    json.fileName = file.name;
                    data.append('file', file.file);
                }
                if (images) {
                    for (let image of images) {
                        data.append('images[]', image.image);
                    }
                }
                if (replyMessage) {
                    json.replyMessage = {
                        _id: replyMessage._id,
                        content: replyMessage.content,
                        sender_id: replyMessage.sender_id
                    };

                    if (replyMessage.file) {
                        json.replyMessage.file = replyMessage.file;
                    }
                    if (replyMessage.image) {
                        json.replyMessage.image = replyMessage.image;
                    }
                }
                data.append('data', JSON.stringify(json));

                const status = await this.create(data);

                if (status === 200) {
                    await this.fetchRooms();
                }
            },
            async editMessage({ messageId, newContent, roomId, file, images }) {
                const data = new FormData();
                const room = this.rooms.find(room => room.roomId === roomId);
                const json = {
                    id: messageId,
                    content: newContent,
                    storeId: room.storeId
                };

                if (file) {
                    json.fileName = file.name;
                    data.append('file', file.file);
                }
                if (images) {
                    for (let image of images) {
                        data.append('images[]', image.image);
                    }
                }
                data.append('data', JSON.stringify(json));

                const status = await this.update(data);

                if (status === 200) {
                    await this.fetchRooms();
                    // const _data = {
                    //     id: messageId,
                    //     storeId: room.storeId
                    // };
                    // const response = await this.getMessage(this.serialize(_data));
                    //
                    // if (response.status === 200) {
                    //     const formattedMessage = this.formatMessage(room, response.message);
                    //     const messageIndex = this.messages.findIndex(m => m._id === response.message.id);
                    //
                    //     if (messageIndex === -1) {
                    //         if (this.messages.length > 0) {
                    //             const lastMessage = this.messages[this.messages.length - 1];
                    //
                    //             if (lastMessage['sender_id'] === formattedMessage['sender_id']) {
                    //                 formattedMessage['showUsername'] = false;
                    //             }
                    //         }
                    //         this.messages = this.messages.concat([ formattedMessage ]);
                    //     } else {
                    //         formattedMessage['showUsername'] = this.messages[messageIndex]['showUsername'];
                    //
                    //         this.$set(this.messages, messageIndex, formattedMessage);
                    //     }
                    // }
                }
            },
            async deleteMessage({ messageId, roomId }) {
                const room = this.rooms.find(room => room.roomId === roomId);
                const status = await this.delete(messageId);

                if (status === 200) {
                    await this.fetchRooms();
                    // const _data = {
                    //     id: messageId,
                    //     storeId: room.storeId
                    // };
                    // const response = await this.getMessage(this.serialize(_data));
                    //
                    // if (response.status === 200) {
                    //     const formattedMessage = this.formatMessage(room, response.message);
                    //     const messageIndex = this.messages.findIndex(m => m._id === response.message.id);
                    //
                    //     if (messageIndex === -1) {
                    //         this.messages = this.messages.concat([ formattedMessage ]);
                    //     } else {
                    //         this.$set(this.messages, messageIndex, formattedMessage);
                    //     }
                    // }
                }
            }
        }
    };
</script>

<style scoped>

</style>