<template>
    <section class="rcms-chat-view">
        <transition-group id="messages" tag="div" class="rcms-messages" name="fade">
            <div v-for="message in messages"
                     :key="message.content + message.created_at"
                     class="rcms-message"
                     :class="messageClass(message)"
                     data-toggle="tooltip"
                     :title="'Received on ' + message.created_at">
                <span v-if="previousMessage(message).author !== message.author" class="rcms-author">{{ message.author }}</span>
                <p class="rcms-content">{{ message.content }}</p>
            </div>
        </transition-group>
        <div class="rcms-chat-input-wrapper">
            <div id="message" contenteditable="true" class="rcms-chat-input"></div>
            <a v-on:click="sendMessage" type="submit" class="rcms-send-message fa fa-paper-plane" aria-hidden="true"></a>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                messages: [],
            }
        },
        computed: {
            messageLimit() {
                let height = this.messagesView.clientHeight;
                let messageHeight = 55;
                return Math.round(height / messageHeight);
            },
            currentUser() {
                return this.$store.getters['userManagement/currentUserLogin'];
            },
            messagesView() {
                return document.getElementById('messages');
            },
            messageInput() {
                return document.getElementById('message')
            }
        },
        methods: {
            getMessages: function () {
                axios({
                    method: 'get',
                    url: '/api/chat/' + this.messages.length + '/' + this.messageLimit,
                }).then(response => {
                    this.messages = response.data.messages.reverse().concat(this.messages);
                    setTimeout((object, currentMax) => {
                        object.scrollTo(object.messagesView.scrollTopMax - currentMax);
                    }, 100, this, this.messagesView.scrollTopMax);
                }).catch(error => {
                    console.log(error);
                })
            },
            sendMessage: function () {
                axios({
                    method: 'post',
                    url: '/api/chat',
                    data: {
                        author: this.currentUser,
                        content: this.messageInput.innerText
                    }
                }).then(response => {
                    this.scrollToNew();
                    this.messageInput.innerText = ''
                }).catch(error => {
                    console.log(error);
                })
            },
            previousMessage(currentMessage) {
                let index = this.messages.indexOf(currentMessage) - 1;
                if (index < 0)
                    return {};
                return this.messages[index];
            },
            messageClass(currentMessage) {
                let cssClass = (this.previousMessage(currentMessage).author === currentMessage.author ? 'no-space ' : '')
                cssClass += (this.currentUser === currentMessage.author ? 'rcms-left' : 'rcms-right');
                return cssClass;
            },
            scrollToNew() {
                this.messagesView.scrollTop = this.messagesView.scrollTopMax;
            },
            scrollTo(number) {
                this.messagesView.scrollTop = number;
            }
        },
        created() {
            let pusher = this.$store.getters['main/pusher'];
            let handler = (object) => {
                return (data) => {
                    let messages = Array(data.message);
                    object.messages = object.messages.concat(messages);
                }
            };
            let channel = pusher.subscribe('chat-channel');
            channel.bind('message-sent-event', handler(this));
        },
        mounted() {
            this.getMessages();

            let keyHandler = (object) => {
                return function (event) {
                    if (event.defaultPrevented)
                        return;

                    if (event.key === 'Enter') {
                        object.sendMessage();
                        object.message = '';
                        event.preventDefault();
                    }
                }
            };
            let scrollHandler = (object) => {
                let timeout;
                return function (event) {
                    if (event.defaultPrevented)
                        return;

                    if (event.currentTarget.scrollTop <= 2) {
                        clearTimeout(timeout);
                        timeout = setTimeout(function (object) {
                            object.getMessages();
                        }, 100, object);
                    }
                    if (event.currentTarget.scrollTop >= 50)
                        clearTimeout(timeout);
                }
            };
            document.getElementById('message').addEventListener("keydown", keyHandler(this), true);
            this.messagesView.addEventListener("scroll", scrollHandler(this), true);
        }
    }
</script>