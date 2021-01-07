<template>
    <div :class="{ 'text-ellipsis': singleLine }">
        <div v-if="textFormatting" :class="{ 'text-ellipsis': singleLine }">
            <template v-for="(message, i) in linkifiedMessage">
                <template v-if="checkType(message, 'url')">
                    <a :href="message.href"
                       target="_blank"
                       :class="{
                           'text-bold': checkType(message, 'bold'),
                           'text-ellipsis': singleLine,
                           'text-inline-code': !singleLine && checkType(message, 'inline-code'),
                           'text-italic': checkType(message, 'italic'),
                           'text-multiline-code': !singleLine && checkType(message, 'multiline-code'),
                           'text-strike': checkType(message, 'strike'),
                           'text-underline': checkType(message, 'underline')
                       }"
                       v-html="highlight(message.value, filterKey)"
                       :key="i"></a>
                </template>

                <template v-else>
                    <span v-if="deleted" :class="{ 'text-deleted': deleted }" :key="i">
                        <svg-icon class="icon-deleted" name="deleted"></svg-icon> {{ message.value }}
                    </span>
                    <span v-else
                          :class="{
                                'text-bold': checkType(message, 'bold'),
                               'text-ellipsis': singleLine,
                               'text-inline-code': !singleLine && checkType(message, 'inline-code'),
                               'text-italic': checkType(message, 'italic'),
                               'text-multiline-code': !singleLine && checkType(message, 'multiline-code'),
                               'text-strike': checkType(message, 'strike'),
                               'text-underline': checkType(message, 'underline')
                          }"
                          v-html="highlight(message.value, filterKey)"
                          :key="i"></span>
                </template>
            </template>
        </div>

        <div v-else v-html="highlight(content, filterKey)"></div>
    </div>
</template>

<script>
    import SvgIcon from './SvgIcon';
    import formatString from '../utils/formatString';

    export default {
        name: 'format-message',
        components: {
            SvgIcon
        },
        props: {
            content: {
                type: [ String, Number ],
                required: true
            },
            deleted: {
                default: false,
                type: Boolean
            },
            filterKey: {
                default: '',
                type: String
            },
            formatLinks: {
                default: true,
                type: Boolean
            },
            singleLine: {
                default: false,
                type: Boolean
            },
            textFormatting: {
                default: true,
                type: Boolean
            }
        },
        computed: {
            linkifiedMessage() {
                return formatString(this.content, this.formatLinks);
            }
        },
        methods: {
            checkType(message, type) {
                return message.types.indexOf(type) !== -1;
            }
        }
    };
</script>

<style lang="scss" scoped>
    .text-deleted {
        font-style: italic;
    }

    .icon-deleted {
        height: 14px;
        width: 14px;
        vertical-align: middle;
        margin: -3px 1px 0 0;
        fill: var(--chat-room-color-message);
    }

    .text-ellipsis {
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
