<template>
    <ChatWindow viewer="admin"
                :current-user-id="currentUserId"
                :height="height"
                :loading-rooms="loadingRooms"
                :message-actions="[]"
                :rooms="rooms"
                :show-add-room="false"
                :show-emojis="false"
                :show-reaction-emojis="false"
                :single-room="true"
                :store="store"
                @fetchRooms="fetchRooms"></ChatWindow>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import ChatWindow from '../../messages/ChatWindow/ChatWindow';

    export default {
        name: 'StoresShowMessage',
        components: {
            ChatWindow
        },
        data() {
            return {
                currentUserId: '',
                height: '0px',
                loadingRooms: true,
                rooms: [],
                userId: 0
            };
        },
        computed: {
            ...mapGetters('admin.auth', [ 'admin' ]),
            ...mapGetters('admin.stores', [ 'store', 'employee' ])
        },
        mounted() {
            this.userId = this.$route.params.id;
            this.height = this.calculateHeight();
            this.loadCurrentUserId();
            this.fetchRooms();
        },
        destroyed() {
            this.resetRooms();
        },
        methods: {
            ...mapActions('admin.messages', [ 'getStore', 'getMessage' ]),
            ...mapActions('admin.stores', [ 'show' ]),
            async loadCurrentUserId() {
                const status = await this.show(this.userId);

                if (status === 404) {
                    return this.$router.push({ name: 'admin.stores.list' });
                }
                if (this.employee) {
                    this.currentUserId = 'sale-' + this.employee.id;
                } else {
                    this.currentUserId = 'system-0';
                }
            },
            resetRooms() {
                this.loadingRooms = true;
                this.rooms = [];
            },
            async fetchRooms() {
                this.resetRooms();

                const response = await this.getStore(this.userId);

                if (response.status === 404) {
                    return this.$router.push({ name: 'admin.stores.list' });
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
            }
        }
    };
</script>

<style scoped>

</style>