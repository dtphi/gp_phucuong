<template>
    <div>
        <ChatWindow :current-user-id="currentUserId"
                    :height="height"
                    :loading-rooms="loadingRooms"
                    :message-actions="messageActions"
                    :rooms="rooms"
                    :show-add-room="false"
                    :show-emojis="false"
                    :show-reaction-emojis="false"
                    @deleteMessage="deleteMessage"
                    @editMessage="editMessage"
                    @fetchRooms="fetchRooms"
                    @messageActionHandler="messageActionHandler"
                    @sendMessage="sendMessage"></ChatWindow>

        <ModalShowSubEmails :id="modal.id" :options="modal.emails"></ModalShowSubEmails>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import ChatWindow from '../../messages/ChatWindow/ChatWindow';
    import ModalShowSubEmails from '../../modals/ModalShowSubEmails';

    export default {
        name: 'ChatMessages',
        components: {
            ChatWindow,
            ModalShowSubEmails
        },
        data() {
            return {
                currentUserId: '',
                height: '0px',
                loadingRooms: true,
                messageActions: [
                    {
                        name: 'sendSubEmail',
                        title: '転送'
                    }
                ],
                modal: {
                    emails: [],
                    id: 0
                },
                rooms: [],
                userId: 0
            };
        },
        computed: {
            ...mapGetters('representative.auth', [ 'representative' ]),
            ...mapGetters('representative.messages', [ 'unread' ])
        },
        mounted() {
            this.currentUserId = 'sale-' + this.representative.id;
            this.userId = this.representative.id;
            this.height = this.calculateHeight();
            this.fetchRooms();
        },
        destroyed() {
            this.resetRooms();
        },
        methods: {
            ...mapActions('representative.auth', [ 'refreshRepresentativeInfo' ]),
            ...mapActions('representative.messages', [ 'getStores', 'getMessage', 'create', 'update', 'delete' ]),
            resetRooms() {
                this.loadingRooms = true;
                this.rooms = [];
            },
            async fetchRooms() {
                this.resetRooms();

                const response = await this.getStores(this.userId);

                if (response.status === 404) {
                    return this.$router.push({ name: 'representative.menu.main.menu' });
                }
                this.rooms = response.stores;
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
                    senderType: 2,
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
                    //     if (messageIndex === -1 || messageIndex === this.messages.length - 1) {
                    //         room.lastMessage = this.formatLastMessage(response.message);
                    //     }
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
                    const _data = {
                        id: messageId,
                        storeId: room.storeId
                    };
                    const response = await this.getMessage(this.serialize(_data));

                    if (response.status === 200) {
                        await this.fetchRooms();
                        // const formattedMessage = this.formatMessage(room, response.message);
                        // const messageIndex = this.messages.findIndex(m => m._id === response.message.id);
                        //
                        // if (messageIndex === -1 || messageIndex === this.messages.length - 1) {
                        //     room.lastMessage = this.formatLastMessage(response.message);
                        // }
                        // if (messageIndex === -1) {
                        //     this.messages = this.messages.concat([ formattedMessage ]);
                        // } else {
                        //     this.$set(this.messages, messageIndex, formattedMessage);
                        // }
                    }
                }
            },
            async messageActionHandler({ roomId, action, message }) {
                if (action.name === 'sendSubEmail') {
                    await this.refreshRepresentativeInfo();

                    this.modal.emails = [
                        this.representative.sub_email1,
                        this.representative.sub_email2,
                        this.representative.sub_email3,
                        this.representative.sub_email4
                    ].filter(email => email !== null);
                    this.modal.id = message.id;

                    this.$bvModal.show('modal-show-sub-emails');
                }
            }
        }
    };
</script>

<style scoped>

</style>